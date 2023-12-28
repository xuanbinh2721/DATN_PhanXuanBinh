<?php

namespace App\Http\Controllers;

use App\Models\SportType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SportTypeController extends Controller
{
    //
    public function index()
    {
        $sportTypes = SportType::all();

        return view('sport_types.index', compact('sportTypes'));
    }
}
