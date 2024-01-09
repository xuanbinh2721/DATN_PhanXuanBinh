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
use App\Models\TimeFrame;
use App\Models\BookingDetail;

use Carbon\Carbon;

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

    public function getBooking($id)
    {
        $sportTypes = SportType::all();
        $field = Field::find($id);
        $bookings = BookingDetail::where('field_id', $id)->get();
        return view('field.booking.index',compact('field','sportTypes','bookings'));
    }
    
    public function acceptBooking(Request $request,$id)
    {
        $booking = BookingDetail::findOrFail($id);
        $booking-> status = '1';
        $booking->save();
        return redirect()->route('getbooking.index', $booking->field_id)->with('success', 'Xác nhận đơn đặt sân thành công!');
    }
    public function refuseBooking(Request $request,$id)
    {
        $booking = BookingDetail::findOrFail($id);
        $booking-> status = '2';
        $booking->save();
        return redirect()->route('getbooking.index', $booking->field_id)->with('success', 'Hủy đơn đặt sân thành công!');
    }


    public function getTime($id)
    {
        $sportTypes = SportType::all();
        $field = Field::find($id);
        $timeFrames = TimeFrame::where('field_id', $id)->get();
        return view('field.schedules.schedule',compact('field','sportTypes','timeFrames'));
    }

    public function addTimeFrame(Request $request,$id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);
        // Kiểm tra xem có khung giờ trùng lặp không
        $existingTimeFrame = TimeFrame::where([
            'field_id' => $id,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'date' => $request->input('date'), 
        ])->first();
    
        // Nếu có khung giờ trùng lặp, trả về thông báo lỗi
        if ($existingTimeFrame) {
            return redirect()->route('field.schedule',$id)->with('error', 'Khung giờ đã tồn tại!');
        }

        // Nếu không có khung giờ trùng lặp, tạo một bản ghi mới trong CSDL
        $newTimeFrame = new TimeFrame([
            'field_id' => $id,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'date' => $request->input('date'),
            'price' => $request->input('price'),
        ]);
        $newTimeFrame->save();
        
        // Chuyển hướng hoặc thực hiện các hành động khác sau khi tạo xong
        return redirect()->route('field.schedule',$id)->with('status', 'add-time-frame');
    }
    
    public function updateTimeFrame(Request $request, $id)
    {
        $request->validate([
            'start_time1' => 'required',
            'end_time1' => 'required',
            'date1' => 'required|date',
            'price1' => 'required|numeric|min:0',
        ]);
        
        $timeFrame = TimeFrame::find($id);
        // Kiểm tra xem thời gian đã tồn tại hay chưa
        $existingTimeFrame = TimeFrame::where([
            'start_time' => $request->input('start_time1'),
            'end_time' => $request->input('end_time1'),
            'date' => $request->input('date1'),
        ])->where('id', '!=', $id)->first();
    
        // Nếu có khung giờ trùng lặp, trả về thông báo lỗi
        if ($existingTimeFrame) {
            return redirect()->route('field.schedule', $timeFrame->field_id)->with('error', 'Khung giờ đã tồn tại!');
        }

        // Nếu không có khung giờ trùng lặp, cập nhật thông tin trong CSDL

        if ($timeFrame) {
            // Nếu tìm thấy bản ghi, thực hiện các thao tác
            $timeFrame->date = $request->input('date1');
            $timeFrame->start_time = $request->input('start_time1');
            $timeFrame->end_time = $request->input('end_time1');
            $timeFrame->price = $request->input('price1');
            $timeFrame->save();
            
            // Chuyển hướng hoặc thực hiện các hành động khác sau khi cập nhật xong
            return redirect()->route('field.schedule', $timeFrame->field_id)->with('success', 'Cập nhật khung giờ thành công!');
        }
    
        // Trường hợp không tìm thấy bản ghi
        return redirect()->route('field.schedule', $timeFrame->field_id)->with('error', 'Không tìm thấy khung giờ cần cập nhật!');
    }
    
    public function changeLock(Request $request,$id)
    {
        $timeFrame = TimeFrame::findOrFail($id);

        if($timeFrame->status =='0'){
            $timeFrame-> status = '1';
            $timeFrame->save();
            return redirect()->route('field.schedule', $timeFrame->field_id)->with('success', 'Cập nhật khung giờ thành công!');
        }
        if($timeFrame->status =='1'){
            $timeFrame-> status = '0';
            $timeFrame->save();
            return redirect()->route('field.schedule', $timeFrame->field_id)->with('success', 'Cập nhật khung giờ thành công!');
        }
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
    public function changeStatus(Request $request,$id)
    {
        $field = Field::findOrFail($id);

        if($field->status =='0'){
            $field-> status = '1';
            $field->save();
            return redirect()->route('field.index')->with('success', 'Cập nhật trạng thái sân thành công!');
        }
        if($field->status =='1'){
            $field-> status = '0';
            $field->save();
            return redirect()->route('field.index')->with('success', 'Cập nhật trạng thái sân thành công!');
        }
    }



}
