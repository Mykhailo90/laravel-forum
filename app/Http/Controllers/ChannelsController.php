<?php

namespace App\Http\Controllers;

class ChannelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//   public function index($channel)
//   {
//
//   }
}
