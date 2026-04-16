<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;

class LandingMediaController extends Controller
{
    public function video(): BinaryFileResponse
    {
        $meta = SiteSetting::landingVideoMeta();
        $path = $meta['path'];

        if (!$path) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            abort(404);
        }

        $mime = $meta['mime'] ?? $disk->mimeType($path) ?? 'video/mp4';
        $fullPath = $disk->path($path);

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
