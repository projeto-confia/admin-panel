<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::query()
            ->orderBy('is_admin', 'desc')
            ->orderBy('name')
            ->paginate()
            ->withQueryString();

        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $userData = $request->all();
        $user = User::create($userData);

        event(new Registered($user));

        return redirect(route('usuarios.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->merge([ 'is_admin' => (bool) $request->is_admin ])->all());
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->back();
    }

    public function block(User $user): RedirectResponse
    {
        $user->is_blocked = true;
        $user->save();

        return redirect()->back();
    }

    public function unblock(User $user): RedirectResponse
    {
        $user->is_blocked = false;
        $user->save();

        return redirect()->back();
    }
}
