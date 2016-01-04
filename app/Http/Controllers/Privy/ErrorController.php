<?php

namespace App\Http\Controllers\Privy;

use Illuminate\Http\Request;

use App\Http\Requests;

class ErrorController extends AdminController
{
    public function getNotAuthorized()
    {
        return view('errors.403');
    }
}
