<?php

namespace Tests\Feature\Translation;

use App\Modules\Translation\Exceptions\DuplicateTranslationNamespaceException;
use App\Modules\Translation\Exceptions\InvalidTranslationException;
use App\Modules\Translation\Exceptions\UnknownTranslationNamespaceException;
use App\Modules\Translation\Services\TranslationNamespaceRegistry;
use App\Modules\Translation\Services\TranslationResolver;
use Tests\TestCase;

class TranslationResolverTest extends TestCase
{
    public function test_it_resolves_requested_locale_then_fallback_locale(): void
    {
        $resolver = $this->resolver([
            'en' => ['auth.login' => 'Log in'],
            'tr' => ['auth.login' => 'Giris yap'],
        ]);

        $this->assertSame('Giris yap', $resolver->get('auth.login', 'tr', 'en'));
        $this->assertSame('Log in', $resolver->get('auth.login', 'de', 'en'));
    }

    public function test_missing_keys_render_visible_marker_without_switching_namespace(): void
    {
        $resolver = $this->resolver(['en' => ['auth.login' => 'Log in']]);

        $this->assertSame('[missing:tr:auth.register]', $resolver->get('auth.register', 'tr', 'en'));
    }

    public function test_namespaces_are_registered_and_duplicates_fail(): void
    {
        $registry = new TranslationNamespaceRegistry();
        $registry->register('auth', 'Auth');

        $this->assertSame('Auth', $registry->owner('auth'));

        $this->expectException(DuplicateTranslationNamespaceException::class);

        $registry->register('auth', 'Other');
    }

    public function test_unknown_namespace_fails(): void
    {
        $this->expectException(UnknownTranslationNamespaceException::class);

        $this->resolver(['en' => ['auth.login' => 'Log in']])->get('mailboxes.create', 'en', 'en');
    }

    public function test_placeholders_must_match_and_are_escaped(): void
    {
        $resolver = $this->resolver(['en' => ['auth.greeting' => 'Hello :name']]);

        $this->assertSame('Hello &lt;Admin&gt;', $resolver->get('auth.greeting', 'en', 'en', [
            'name' => '<Admin>',
        ]));

        $this->expectException(InvalidTranslationException::class);

        $resolver->get('auth.greeting', 'en', 'en');
    }

    public function test_raw_html_translations_are_rejected(): void
    {
        $this->expectException(InvalidTranslationException::class);

        $this->resolver(['en' => ['auth.login' => '<strong>Log in</strong>']])->get('auth.login', 'en', 'en');
    }

    public function test_namespace_registry_enforces_key_discipline(): void
    {
        $this->expectException(UnknownTranslationNamespaceException::class);

        $this->resolver(['en' => ['auth' => 'Bad key']])->get('auth', 'en', 'en');
    }

    /**
     * @param array<string, array<string, string>> $lines
     */
    private function resolver(array $lines): TranslationResolver
    {
        $registry = new TranslationNamespaceRegistry();
        $registry->register('auth', 'Auth');

        return new TranslationResolver($registry, $lines);
    }
}
