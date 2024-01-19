<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeFrame;
use App\Models\Field;
use App\Models\BookingDetail;
use App\Models\SportType;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
class BookingController extends Controller
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

    public function index()
    {
        // Lấy danh sách các đơn đặt sân từ cơ sở dữ liệu
        $bookingList = BookingDetail::where('user_id', auth()->user()->id)->get();
        $sportTypes = SportType::all();
         // Kiểm tra và xử lý đơn đặt sân chờ xác nhận
        foreach ($bookingList as $booking) {
            if ($booking->status === '0') {
                $timeFrame = TimeFrame::find($booking->time_frame_id);

                // Kiểm tra xem thời gian đặt đã quá thời gian hiện tại hay chưa
                $bookingTime = Carbon::parse($timeFrame->date . ' ' . $timeFrame->start_time);
                if ($bookingTime->isPast()) {
                    // Đặt trạng thái của đơn đặt thành 'Đã hủy' 
                    $booking->update(['status' => '2']);
                    // $timeFrame->update(['status'=>'0']);
                }
            }
        }
        // Trả về view với danh sách đặt sân
        return view('booking.index', compact('bookingList','sportTypes'));
    }


    public function getTimeFrames(Request $request, $id)
    {
        $selectedDate = $request->input('date');

        // Thực hiện truy vấn để lấy danh sách khung giờ cho ngày và sân đã chọn
        $timeFrames = TimeFrame:: where('date', $selectedDate)
            ->where('field_id', $id)
            ->where('status', '=', '0')
            ->get();

        // Trả về danh sách khung giờ dưới dạng JSON
        return response()->json($timeFrames);
    }

    public function getPrice(Request $request, $id)
    {
        $selectedDate = request('date');
        $selectedTimeFrame = request('timeFrame');
    
        $timeFrameInfo = TimeFrame::where('field_id', $id)
            ->where('date', $selectedDate)
            ->where('id', $selectedTimeFrame)
            ->first();
    
        return response()->json(['price' => $timeFrameInfo ? $timeFrameInfo->price : 0]);
    }


    public function getBookingDetailById($id)
    {
        $bookingDetail = BookingDetail::where('id',$id)
            ->where('user_id',auth()->user()->id) 
            ->first();

        if (!$bookingDetail) {
            return redirect()->route('home');
        }
        $sportTypes = SportType::all();
        $field = Field::where('id',$bookingDetail->field_id)->first();
        $timeFrame = TimeFrame::where('id',$bookingDetail->time_frame_id)->first();

        return view('booking.bookingdetail', compact('bookingDetail','field','timeFrame','sportTypes'));
    }

    public function cancelBooking($id)
    {
        $bookingDetail = BookingDetail::findOrFail($id);
        $bookingDetail->status = '2';
        $bookingDetail->save();
        return redirect()->route('booking.detail',$id)->with('success', 'Hủy đặt sân thành công');
    }


    public function store(Request $request,$id)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'date' => 'required|date',
            'time_frame' => 'required',
            'price' => 'required|numeric',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:0,1,2',
        ]);

        $selectedTimeFrame = $request->input('time_frame');

        $timeFrame = TimeFrame::findOrFail($selectedTimeFrame);
        if ($timeFrame->status == '1') {
            return redirect()->back()->with('error', 'Khung giờ này đã bị đặt.');
        }
        
        // Kiểm tra xem đã có đơn đặt trong cùng khung giờ chưa
        $existingBooking = BookingDetail::where('field_id', $id)
            ->where('status', '!=', '2') // Đơn đặt không bị hủy
            ->get();
        
        foreach ($existingBooking as $booking) {
            $bookingTimeFrame = TimeFrame::find($booking->time_frame_id);
            // Kiểm tra trùng lặp dựa trên date, start_time
            if (
                $bookingTimeFrame->date == $timeFrame->date &&
                $bookingTimeFrame->start_time == $timeFrame->start_time 
            ) {
                return redirect()->back()->with('error', 'Không thể đặt sân trong khung giờ đã có đơn đặt khác.');
            }
        }
        

        $newBooking = new BookingDetail([
            'field_id' => $id,
            'user_id' => auth()->user()->id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date' => $request->input('date'),
            'time_frame_id' => $selectedTimeFrame,
            'price' => $request->input('price'),
            'note' => $request->input('note'),
            'payment_method' => $request->input('payment_method'),
        ]);

        $newBooking->save();

        return redirect()->route('booking.detail',$newBooking->id)->with('success', 'Đặt sân thành công!');

    }
    
}
