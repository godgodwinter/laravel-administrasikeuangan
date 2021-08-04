<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminberandaController extends Controller
{
    public function index()
    {
        // return view('beranda',compact('id'));
        return view('admin.beranda');
    }
}
