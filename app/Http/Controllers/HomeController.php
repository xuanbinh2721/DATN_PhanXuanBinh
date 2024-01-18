<?php

namespace App\Http\Controllers;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\SportType;
use App\Models\Field;
use App\Models\FieldImage;


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
        $fields = Field::where('status', 'LIKE', '0')->get();
        return view('home', compact('fields','provinces', 'sportTypes'));
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



    public function search(Request $request)
    {
        $provinces = Province::all();
        $sportTypes = SportType::all();
    
        // Lấy giá trị từ form
        $keyword = $request->input('search');
        $sportType = $request->input('sporttype');
        $province = $request->input('province');
        $district = $request->input('district');
        $ward = $request->input('ward');
    
        // Tạo truy vấn tìm kiếm
        $query = Field::query();
    
        // Thêm bộ lọc
        if ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%');
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
        $results = $query->where('status', '0')->get();
    
        // Nếu không có bất kỳ điều kiện nào được áp dụng, lấy tất cả
        if (empty($keyword) && empty($sportType) && empty($province) && empty($district) && empty($ward)) {
            $results = Field::where('status', '0')->get();
        }
    
        return view('searchresults', compact('results', 'sportTypes', 'provinces'));
    }
    
    



    public function getFieldDetailById($id)
    {
        // Lấy thông tin của tỉnh/thành phố và loại thể thao để hiển thị
        $provinces = Province::all();
        $sportTypes = SportType::all();
    
        // Lấy thông tin chi tiết của sân dựa trên ID
        $fields = Field::with(['sportType', 'timeFrames', 'ward', 'district', 'province'])
            ->findOrFail($id);
    
        // Lấy danh sách các ngày có khung giờ trống
        $availableDates = $fields->timeFrames->where('status','=','0')->groupBy('date')->keys()->sort();

    
        // Trả về view với dữ liệu cần thiết
        return view('field.detail', compact('fields', 'provinces', 'sportTypes', 'availableDates'));
    }
    




}
