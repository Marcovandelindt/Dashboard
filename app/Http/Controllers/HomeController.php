<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Index action
     *
     * @returns View
     */
    public function index(): View
    {
        return view('home.index');
    }
}
