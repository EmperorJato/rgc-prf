<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }

    public function dashboard(){

        return view('super-admin.sa-dashboard');

    }

    public function pending(){

        return view('super-admin.sa-pending');

    }
    
    public function admins(){

        return view('super-admin.sa-admin');

    }

    public function users(){

        return view('super-admin.sa-user');

    }

}
