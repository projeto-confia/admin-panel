<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordCreationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function create(Request $request, int $userId): View
    {
        $user = User::findOrFail($userId);
        if (!empty($user->password)) {
            abort(403);
        }
        return view('pages.auth.create-password', compact('request', 'user'));
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return RedirectResponse
     */
    public function store(Request $request, int $userId): RedirectResponse
    {
        $rules = [
            'password' => ['required', 'confirmed', 'min:7'],
            'password_confirmation ' => [],
        ];

        $messages = [
            'password.required' => 'O campo senha é requerido',
            'password.min' => 'O campo senha deve ter no mínimo 7 caracteres',
            'password.confirmed' => 'O campo Senha não possui o mesmo valor que o campo Confirmação da senha',
        ];

        $request->validate($rules, $messages);

        User::find($userId)->update([
            'id' => $userId,
            'password' => Hash::make($request->password),
        ]);

        Auth::logout();
        return redirect(route('login'));
    }
}
