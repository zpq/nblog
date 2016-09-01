<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function __construct() {

    }

    public function profile() {
        return "user profile";
    }
}
