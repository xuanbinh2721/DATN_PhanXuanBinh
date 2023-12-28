<?php

namespace App\Http\Controllers;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\SportType;
use App\Models\Field;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provinces = Province::all();
        $sportTypes = SportType::all();
        $fields = Field::all();
        return view('home', compact('provinces', 'sportTypes'));
    }

    

    public function getDistricts($provinceId)
    {
        $districts = District::where('province_id', $provinceId)->get();
        return response()->json($districts);
    }

    public function getWards($districtId)
    {
        $wards = Ward::where('district_id', $districtId)->get();
        return response()->json($wards);
}
}
