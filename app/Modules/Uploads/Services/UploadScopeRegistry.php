<?php

namespace App\Modules\Uploads\Services;

use App\Modules\Uploads\Data\UploadScope;
use App\Modules\Uploads\Enums\UploadVisibility;
use App\Modules\Uploads\Exceptions\UnknownUploadScopeException;

final class UploadScopeRegistry
{
    /**
     * @var array<string, UploadScope>
     */
    private array $scopes;

    public function __construct()
    {
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $mimes = ['image/jpeg', 'image/png', 'image/webp'];

        $this->scopes = [
            'avatar' => new UploadScope('avatar', 'Avatars', 'uploads/avatar', UploadVisibility::Private, 2_097_152, $extensions, $mimes, 2048, 2048),
            'media' => new UploadScope('media', 'Uploads', 'uploads/media', UploadVisibility::Public, 5_242_880, $extensions, $mimes, 4096, 4096),
            'contact_attachment' => new UploadScope('contact_attachment', 'Contact', 'uploads/contact-attachments', UploadVisibility::Private, 5_242_880, $extensions, $mimes, 4096, 4096),
            'knowledge_attachment' => new UploadScope('knowledge_attachment', 'Knowledge Base', 'uploads/knowledge-attachments', UploadVisibility::Private, 5_242_880, $extensions, $mimes, 4096, 4096),
            'blog_media' => new UploadScope('blog_media', 'Blog', 'uploads/blog-media', UploadVisibility::Public, 5_242_880, $extensions, $mimes, 4096, 4096),
            'message_attachment_metadata' => new UploadScope('message_attachment_metadata', 'Message Storage', 'uploads/message-attachment-metadata', UploadVisibility::Private, 5_242_880, $extensions, $mimes, 4096, 4096),
        ];
    }

    public function get(string $scope): UploadScope
    {
        return $this->scopes[$scope] ?? throw UnknownUploadScopeException::forScope($scope);
    }

    public function has(string $scope): bool
    {
        return isset($this->scopes[$scope]);
    }
}
