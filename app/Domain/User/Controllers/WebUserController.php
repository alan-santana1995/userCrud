<?php

namespace App\Domain\User\Controllers;

use App\Http\Controllers\Controller;

class WebUserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function show(string $user)
    {
        return view('users.show')->with(
            compact('user')
        );
    }

    public function create()
    {
        return view('users.form');
    }

    public function edit(string $user)
    {
        return view('users.form')->with(
            compact('user')
        );
    }
}
