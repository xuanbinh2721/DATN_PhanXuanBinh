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
    public function getFieldDetailById($id)
    {
        // Lấy thông tin của tỉnh/thành phố và loại thể thao để hiển thị
        $provinces = Province::all();
        $sportTypes = SportType::all();

        // Lấy thông tin chi tiết của sân dựa trên ID
        $fields = Field::with(['sportType', 'prices', 'ward', 'district', 'province'])
            ->findOrFail($id);

        // Kiểm tra xem sân có tồn tại không
        if (!$fields) {
            abort(404); // Nếu không tìm thấy sân, hiển thị trang 404
        }

        // Trả về view với dữ liệu cần thiết
        return view('field.detail', compact('fields', 'provinces', 'sportTypes'));
    }
}
