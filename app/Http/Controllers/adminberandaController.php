<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminberandaController extends Controller
{
    public function index()
    {
        $pages='beranda';
        return view('admin.beranda',compact('pages'));
        // return view('admin.beranda');
    }
}
