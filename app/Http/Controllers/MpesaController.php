<?php

namespace App\Http\Controllers;

use Mpesa;
use Illuminate\Http\Request;

class MpesaController extends Controller
{

    public function index()
    {
        $registerUrlsResponse=Mpesa::c2bRegisterUrls();

        $simulateResponse=Mpesa::simulateC2B(100, "254708374149", "Testing");

        dd($simulateResponse);
    }
}
