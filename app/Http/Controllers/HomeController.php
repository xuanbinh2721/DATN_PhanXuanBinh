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
        // Lấy các tham số từ biểu mẫu
        $provinces = Province::all();
        $sportTypes = SportType::all();
    
        // Lấy giá trị từ biểu mẫu
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
        // Trả về view với dữ liệu cần thiết
        return view('field.detail', compact('fields', 'provinces', 'sportTypes'));
    }




    public function registerField()
    {
        $provinces = Province::all();
        $sportTypes = SportType::all();
        return view('/registerfield', compact('provinces', 'sportTypes'));
    }

    public function addField(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:12',
            'description' => 'required|string|max:255',
            'sporttype' => 'required|exists:sporttypes,id',
            'province' => 'required|exists:provinces,id',
            'district' => 'required|exists:districts,id',
            'ward' => 'required|exists:wards,id',
            'address' => 'required|string|max:255',
        ]);

        $ownerId = $request-> user()->id;

        $request->user()->update(['user_type' => '1']);
        // Lưu thông tin sân vào bảng Field
        $field = new Field([
            'owner_id' => $ownerId,
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'description' => $request->input('description'),
            'sport_type_id' => $request->input('sporttype'),
            'province_id' => $request->input('province'),
            'district_id' => $request->input('district'),
            'ward_id' => $request->input('ward'),
            'address' => $request->input('address'),
        ]);
        $field->save();

        // Lưu các ảnh vào bảng FieldImage
        foreach ($request->file('images') as $image) {
            $path = $image->store('field_images', 'public');
            $fieldImage = new FieldImage([
                'field_id' => $field->id,
                'image_name' => $path,
            ]);
            $fieldImage->save();
        }


        // Chuyển hướng hoặc trả về thông báo thành công tùy thuộc vào yêu cầu của bạn
        return redirect()->route('field.index')->with('success', 'Đăng ký sân thành công!');
    }
}
