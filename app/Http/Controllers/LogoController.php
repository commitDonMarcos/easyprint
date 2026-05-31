<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $disk = env('FILESYSTEM_DISK', 'public');
            $path = $request->file('image')->store('logos', $disk);
            $url = Storage::disk($disk)->url($path);

            return response()->json([
                'url' => $url,
                'path' => $path
            ]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
