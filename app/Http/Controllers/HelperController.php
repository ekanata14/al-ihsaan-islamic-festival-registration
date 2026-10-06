<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    public function getImage($path)
    {
        $path = ltrim($path, '/');

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }
}
