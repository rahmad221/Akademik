<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    function index()
    {
        return view('master.siswa.index');
    }
}
