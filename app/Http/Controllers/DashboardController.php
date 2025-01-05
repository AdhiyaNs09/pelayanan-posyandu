<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $role = session('role');
        // dd($role);
        $data=[
            'title' => 'Dashboard'
        ];
        return view('dashboard.index', compact('data'));
    }
}
