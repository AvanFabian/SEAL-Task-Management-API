<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class UserController extends Controller
{
    use AuthorizesRequests; 
    // fungsi index digunakan untuk mengambil semua data user
    public function index()
    {
        $users = User::all();
        return response()->json(['status' => 'success', 'data' => $users]);
    }

    // fungsi store digunakan untuk membuat data user baru
    public function show(User $user)
    {
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    // fungsi update digunakan untuk mengubah data user
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);  // Tambahkan authorization check
    
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6',
        ]);
    
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
    
        $user->update($validated);
    
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    // fungsi destroy digunakan untuk menghapus data user
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);  // Tambahkan authorization check
        
        try {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'User berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 400);
        }
    }

    // fungsi uploadAvatar digunakan untuk mengunggah avatar user
    public function uploadAvatar(Request $request, User $user)
    {
        try {
            // Tambahkan authorization check
            $this->authorize('uploadAvatar', $user);
    
            $request->validate([
                'avatar' => 'required|image|max:2048'
            ], [
                'avatar.required' => 'File avatar harus diupload',
                'avatar.image' => 'File harus berupa gambar',
                'avatar.max' => 'Ukuran file tidak boleh lebih dari 2MB'
            ]);
    
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
    
            $path = $request->file('avatar')->store('avatars');
            $user->update(['avatar' => $path]);
    
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'Avatar berhasil diupload'
            ]);
    
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah avatar user ini'
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupload avatar: ' . $e->getMessage()
            ], 400);
        }
    }
}