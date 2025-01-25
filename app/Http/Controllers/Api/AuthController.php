<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ], [
                'name.required' => 'Nama harus diisi',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter'
            ]);
    
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ],
                'message' => 'User berhasil didaftarkan'
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mendaftarkan user: ' . $e->getMessage()
            ], 400);
        }
    }
    
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password harus diisi'
            ]);
    
            $user = User::where('email', $validated['email'])->first();
    
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email tidak terdaftar'
                ], 401);
            }
    
            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah'
                ], 401);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ],
                'message' => 'Login berhasil'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat login: ' . $e->getMessage()
            ], 400);
        }
    }
}