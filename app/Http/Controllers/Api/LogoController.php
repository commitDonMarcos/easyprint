<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'No image provided.'], 400);
        }

        $file = $request->file('image');
        $path = $file->store('logos', env('FILESYSTEM_DISK', 'public'));

        $url = Storage::disk(env('FILESYSTEM_DISK', 'public'))->url($path);

        return response()->json([
            'message' => 'Logo uploaded successfully.',
            'url' => $url,
            'path' => $path,
        ], 201);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $disk = env('FILESYSTEM_DISK', 'public');
        
        if (Storage::disk($disk)->exists($request->path)) {
            Storage::disk($disk)->delete($request->path);
        }

        return response()->json(['message' => 'Logo deleted successfully.']);
    }
}
