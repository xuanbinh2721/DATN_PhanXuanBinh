<?php
namespace App\Http\Controllers;

use App\Http\Requests\FieldUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Field;
use App\Models\FieldImage;
use App\Models\SportType;


class FieldController extends Controller
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
        $sportTypes = SportType::all();
        $fields = Field::where('owner_id', auth()->id())->get();

        // Lấy thông tin chi tiết và ảnh của sân đầu tiên
        $firstField = $fields->first();

        // Kiểm tra xem có sân nào không
        if ($firstField) {
            $images = FieldImage::where('field_id', $firstField->id)->get();
        } else {
            $images = collect(); // Nếu không có sân, sử dụng collection trống
        }

        return view('field.index', compact('fields', 'firstField', 'images','sportTypes'));

    }

    public function edit($id)
    {
        $field = Field::find($id);
        $sportTypes = SportType::all();
        $provinces = Province::all();
        $districts = District::where('province_id', $field->province_id)->get();
        $wards = Ward::where('district_id', $field->district_id)->get();
        return view('field.editfield', compact('field', 'sportTypes', 'provinces','districts','wards'));
    }
    public function update(FieldUpdateRequest $request, $id)
    {
        // Lấy thông tin sân cần cập nhật
        $field = Field::findOrFail($id);
    
        // Cập nhật thông tin sân
        $field->name = $request->input('name');
        $field->phone_number = $request->input('phone_number');
        $field->description = $request->input('description');
        $field->sport_type_id = $request->input('sporttype');
        $field->province_id = $request->input('province');
        $field->district_id = $request->input('district');
        $field->ward_id = $request->input('ward');
        $field->address = $request->input('address');
    // Lưu thông tin sân
        $field->save();

    // Cập nhật ảnh sân từ danh sách hiện có
        
    
    // Cập nhật ảnh mới từ form
    if ($request->has('selected_images')) {
        // Loại bỏ các ảnh không được chọn
        $selectedImageIds = $request->input('selected_images', []);
        $field->fieldImages()->whereNotIn('id', $selectedImageIds)->delete();
    }

    // Cập nhật ảnh mới từ form
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // Xử lý và lưu ảnh vào thư mục
            $path = $image->store('field_images', 'public');

            // Lưu đường dẫn ảnh vào trong cơ sở dữ liệu
            $fieldImage = new FieldImage(['image_name' => $path]);
            $field->fieldImages()->save($fieldImage);
        }
    }

    // Chuyển hướng về trang danh sách sân
        return redirect()->route('field.index')->with('success', 'Cập nhật thông tin sân thành công!');
    }
    public function changeOff(Request $request,$id)
    {
        $field = Field::findOrFail($id);
        $field-> status = '1';
        $field->save();
        return redirect()->route('field.index')->with('success', 'Cập nhật thông tin sân thành công!');
    }

    public function changeOn(Request $request,$id)
    {
        $field = Field::findOrFail($id);
        $field-> status = '0';
        $field->save();
        return redirect()->route('field.index')->with('success', 'Cập nhật thông tin sân thành công!');
    }
}
