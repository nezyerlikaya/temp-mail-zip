<?php

namespace Tests\Feature\Uploads;

use App\Modules\Uploads\Enums\UploadVisibility;
use App\Modules\Uploads\Exceptions\InvalidUploadException;
use App\Modules\Uploads\Exceptions\UnknownUploadScopeException;
use App\Modules\Uploads\Services\FilenameSanitizer;
use App\Modules\Uploads\Services\UploadScopeRegistry;
use App\Modules\Uploads\Services\UploadValidator;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ScopedUploadCoreTest extends TestCase
{
    public function test_allowed_image_upload_returns_safe_metadata(): void
    {
        $metadata = (new UploadValidator())->validate(
            'avatar',
            $this->pngUpload('profile.png')
        );

        $this->assertSame('avatar', $metadata->scope);
        $this->assertSame('profile.png', $metadata->originalName);
        $this->assertSame('png', $metadata->extension);
        $this->assertSame('image/png', $metadata->mimeType);
        $this->assertSame(UploadVisibility::Private, $metadata->visibility);
        $this->assertStringStartsWith('uploads/avatar/', $metadata->relativePath);
        $this->assertStringNotContainsString('..', $metadata->relativePath);
        $this->assertStringNotContainsString('\\', $metadata->relativePath);
        $this->assertDoesNotMatchRegularExpression('/^[A-Za-z]:/', $metadata->relativePath);
        $this->assertSame(64, strlen($metadata->sha256));
        $this->assertSame(1, $metadata->width);
        $this->assertSame(1, $metadata->height);
    }

    public function test_rejected_file_validation_blocks_unsafe_extension(): void
    {
        $this->expectException(InvalidUploadException::class);

        (new UploadValidator())->validate(
            'avatar',
            UploadedFile::fake()->create('shell.php', 10, 'application/x-php')
        );
    }

    public function test_path_traversal_filename_is_rejected(): void
    {
        $this->expectException(InvalidUploadException::class);

        (new FilenameSanitizer())->sanitizeOriginalName('../avatar.jpg');
    }

    public function test_absolute_path_filename_is_rejected(): void
    {
        $this->expectException(InvalidUploadException::class);

        (new FilenameSanitizer())->sanitizeOriginalName('C:\\temp\\avatar.jpg');
    }

    public function test_dangerous_double_extension_is_rejected(): void
    {
        $this->expectException(InvalidUploadException::class);

        (new FilenameSanitizer())->sanitizeOriginalName('avatar.php.jpg');
    }

    public function test_unsafe_filenames_are_sanitized_for_metadata(): void
    {
        $sanitized = (new FilenameSanitizer())->sanitizeOriginalName('my profile photo!!.jpg');

        $this->assertSame('my-profile-photo.jpg', $sanitized);
    }

    public function test_public_and_private_visibility_are_explicit_per_scope(): void
    {
        $registry = new UploadScopeRegistry();

        $this->assertSame(UploadVisibility::Private, $registry->get('avatar')->visibility);
        $this->assertSame(UploadVisibility::Public, $registry->get('blog_media')->visibility);
    }

    public function test_unknown_scopes_fail_explicitly(): void
    {
        $this->expectException(UnknownUploadScopeException::class);

        (new UploadScopeRegistry())->get('marketplace_asset');
    }

    public function test_safe_metadata_does_not_expose_absolute_paths_or_binary_content(): void
    {
        $safe = (new UploadValidator())->validate(
            'blog_media',
            $this->pngUpload('hero.png')
        )->toSafeArray();

        $this->assertArrayHasKey('relative_path', $safe);
        $this->assertArrayNotHasKey('absolute_path', $safe);
        $this->assertArrayNotHasKey('contents', $safe);
        $this->assertArrayNotHasKey('exif', $safe);
        $this->assertStringStartsWith('uploads/blog-media/', $safe['relative_path']);
        $this->assertDoesNotMatchRegularExpression('/^[A-Za-z]:/', $safe['relative_path']);
    }

    private function pngUpload(string $name): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'upload-test-');
        file_put_contents($path, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII='
        ));

        return new UploadedFile($path, $name, 'image/png', null, true);
    }
}
