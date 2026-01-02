<?php

namespace App\Traits;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAttachments
{
    /**
     * Upload a single file.
     */
    public function uploadFile(UploadedFile $file): Attachment
    {
        $path = $file->storeAs(
            "uploads/" . now()->format('Y/m/d'),
            uniqid() .'.'. $file->extension()
        );

        return $this->attachments()->create([
            'user_id'   => 1,
            'name' 		=> $file->getClientOriginalName(),
            'path' 		=> $path,
            'size'      => $file->getSize(),
			'type'		=> $file->getClientMimeType(),
			'uploaded_at' => now(),
        ]);
    }

    /**
     * Upload multiple files.
     */
    public function uploadFiles(array $files): array
    {
        $attachments = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $attachments[] = $this->uploadFile($file);
            }
        }
        return $attachments;
    }

    /**
     * Delete a single attachment.
     */
    public function deleteAttachment(Attachment $attachment): bool
    {
        if ($attachment->path) {
            Storage::disk()->delete($attachment->path);
        }
        return $attachment->delete();
    }

    /**
     * Delete all attachments.
     */
    public function deleteAllAttachments(): void
    {
        foreach ($this->attachments as $attachment) {
            $this->deleteAttachment($attachment);
        }
    }

    /**
     * Polymorphic relation.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
