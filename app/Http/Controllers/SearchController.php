<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\SportType;
use App\Models\Province;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Lấy các tham số từ biểu mẫu
        $provinces = Province::all();
        $sportTypes= SportType::all();
        $keyword = request()->input('search');
        $sportType = request()->input('sporttype');
        $province = request()->input('province');
        $district = request()->input('district');
        $ward = request()->input('ward');
        // Tạo truy vấn tìm kiếm
        $query = Field::query();

        // Thêm bộ lọc
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($sportType) {
            $query->where('sport_type_id', $sportType);
        }

        if ($province) {
            $query->where('province_id', $province);
        }

        if ($district) {
            $query->where('district_id', $district);
        }
        if ($ward) {
            $query->where('ward_id', $ward);
        }
        
        // Lấy kết quả
        $results = $query->get();

        if(!$keyword&&!$sportType&&!$province){
            $results= Field::all();
        }
        //   dd($results);
        return view('searchresults', compact('results','sportTypes','provinces'));
    }
    
}
