<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\SportType;
use App\Models\Field;
use App\Models\FieldImage;
use App\Models\Feedback;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
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
            'description' => 'required|string',
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

    public function addFeedback(Request $request,$id)
    {
        // Validate dữ liệu đầu vào từ form
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        // Lưu đánh giá vào bảng Feedback
        $feedback = new Feedback([
            'field_id' => $id,
            'user_id' => auth()->user()->id,
            'feedback' => $request->input('feedback'),
            'rate' => $request->input('rating'),
        ]);
        $feedback->save();


        // (Tùy chọn) Cập nhật logic của bạn để xử lý bất kỳ điều gì khác, như gửi email thông báo, vv.

        return redirect()->back()->with('success', 'Đánh giá đã được gửi thành công!');
    }
    public function updateFeedback(Request $request,$id)
    {
        // Validate dữ liệu đầu vào từ form
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'feedback' => 'nullable|string',
        ]);

        $feedback= Feedback::find($id);
        if($feedback){
            $feedback->feedback = $request->input('feedbackedit');
            $feedback->rate = $request->input('rating');
            $feedback->save();   
        }
        


        // (Tùy chọn) Cập nhật logic của bạn để xử lý bất kỳ điều gì khác, như gửi email thông báo, vv.

        return redirect()->back()->with('success', 'Đánh giá đã được sửa thành công!');
    }

    public function deleteFeedback(Request $request,$id)
    {
        $feedback= Feedback::find($id);
        if (!$feedback) {
            return redirect()->back()->with('error', 'Đánh giá không tồn tại!');
        }
    
        $comments = Comment::where('feedback_id', $id)->get();
    
        foreach ($comments as $comment) {
            $comment->status= '1';
            $comment->save();
        }
    
        $feedback->status = '1';
        $feedback->save();
        return redirect()->back()->with('success', 'Đánh giá đã được xóa thành công!');

    }


}
