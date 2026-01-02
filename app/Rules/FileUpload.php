<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class FileUpload implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //  Ensure it's a valid uploaded file
        if (!($value instanceof UploadedFile)) {
            $fail("The {$attribute} must be a valid uploaded file.");
            return;
        }

        // Check file size (max 10MB)
        $maxSizeKb = 10240; // 10 MB
        if ($value->getSize() / 1024 > $maxSizeKb) {
            $fail("The {$attribute} may not be greater than {$maxSizeKb} KB.");
            return;
        }

        $allowedDocs = ['pdf', 'doc', 'docx', 'xlsx'];
        $allowedImages = ['jpg', 'jpeg', 'png'];

        $ext = strtolower($value->getClientOriginalExtension());
        $mime = $value->getMimeType();
        $isImage = str_starts_with($mime, 'image/');

        if ($isImage) {
            // Check image extensions
            if (!in_array($ext, $allowedImages)) {
                $fail("The {$attribute} image must be a file of type: jpg, jpeg, png.");
                return;
            }
        } else {
            // Check document extensions
            if (!in_array($ext, $allowedDocs)) {
                $fail("The {$attribute} must be a document (pdf, doc, docx, xlsx) or an image (jpg, jpeg, png).");
                return;
            }
        }
    }
}
