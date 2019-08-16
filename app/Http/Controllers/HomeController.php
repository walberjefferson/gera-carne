<?php

namespace App\Http\Controllers;

use App\PDF\Carne;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $pdf = new Carne($request->all());
        $pdf->render();
    }
}
