<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        $adminPassword = config('app.admin_password');

        if (!$adminPassword || !Hash::check($validated['password'], $adminPassword)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $token = $request->user()?->createToken('admin-token') ?? 
                 \App\Models\User::factory()->create()->createToken('admin-token');

        return response()->json([
            'message' => 'Authenticated successfully.',
            'token' => $token->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();
        
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
