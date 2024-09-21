<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:30|unique:users,username,' . Auth::id(),
            'nombre' => 'nullable|string|max:60',
            'apellido' => 'nullable|string|max:60',
            'telefono' => 'nullable|integer',
            'direccion' => 'nullable|string|max:100',
            'email' => 'required|string|email|max:60|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|max:2048', 
        ]);

        $user = Auth::user();
        $user->username = $request->username;
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->email = $request->email;

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            
            if ($user->foto) {
                Storage::delete($user->foto);
            }
            
            $path = $request->foto->store('public/fotos');
            $user->foto = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
