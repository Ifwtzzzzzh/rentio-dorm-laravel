<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function check() {
        return view("pages.check-booking");
    }
}