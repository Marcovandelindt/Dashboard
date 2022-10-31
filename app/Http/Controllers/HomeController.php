<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller 
{
    /**
     * Return the home view 
     * 
     * @return View
     */   
    public function index(): View
    {
        $data = [
            'title' => 'Home',
        ];

        return view('home.index')->with($data);
    }
}