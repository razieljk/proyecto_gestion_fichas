<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol'      => ['required', 'in:instructor,aprendiz'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
        ]);

        // Crear perfil según rol
        if ($request->rol === 'instructor') {
            \App\Models\Instructor::create([
                'numdoc_instructor'    => 'pendiente',
                'nombres_instructor'   => $request->name,
                'apellidos_instructor' => '',
                'correo_instructor'    => $request->email,
                'users_id'             => $user->id,
            ]);
        } else {
            \App\Models\Aprendiz::create([
                'numdoc_aprendiz'    => 'pendiente',
                'nombres_aprendiz'   => $request->name,
                'apellidos_aprendiz' => '',
                'correo_aprendiz'    => $request->email,
                'users_id'           => $user->id,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        if ($user->rol === 'instructor') {
            return redirect()->route('instructor.dashboard');
        }

        return redirect()->route('aprendiz.dashboard');
    }
}
