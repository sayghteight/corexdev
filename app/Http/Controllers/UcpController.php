<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UcpController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('ucp.index', compact('user'));
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return view('ucp.profile', compact('user'));
    }

    public function security(Request $request)
    {
        $user = $request->user();
        return view('ucp.security', compact('user'));
    }
}
