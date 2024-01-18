<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SportType;

class AdminController extends Controller
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
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
        ]);
    
        return redirect()->route('admin.index')->with('success', 'Thêm tài khoản thành công');
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
    
        // Lấy tất cả dữ liệu từ request
        $userData = $request->all();
    
        // Kiểm tra và cập nhật xác nhận email
        $this->updateEmailAndSendVerification($user, $request->email);
        
        // Sử dụng hàm fill để cập nhật thông tin người dùng
        $user->fill($userData);
        
        // Lưu thay đổi
        $user->save();
        if($user->email_verified_at == null){
            $user->sendEmailVerificationNotification(); 
        }
        return redirect()->route('admin.index')->with('success', 'Sửa tài khoản thành công');
    }

    private function updateEmailAndSendVerification($user, $newEmail)
    {
        $oldEmail = $user->email;

        if ($oldEmail != $newEmail) {
            $user->update([
                'email_verified_at' => null
            ]);
        }
    }

    public function changeLockUser(Request $request,$id)
    {
        $user = User::findOrFail($id);

        if($user->status =='active'){
            $user-> status = 'inactive';
            $user->save();
            return redirect()->route('admin.index')->with('success', 'Khóa tài khoản thành công!');
        }
        if($user->status =='inactive'){
            $user-> status = 'active';
            $user->save();
            return redirect()->route('admin.index')->with('success', 'Mở khóa tài khoản thành công!');
        }
    }
    public function getSportType()
    {
        $sporttypes = SportType::all();
        return view('admin.sporttype', compact('sporttypes'));
    }

    public function addSportType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:sporttypes',
            'description' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        SportType::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
    
        return redirect()->route('sporttype.get')->with('success', 'Thêm loại thể thao thành công');
    }
    public function updateSportType(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:sporttypes,name,' . $id,
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sporttypes = SportType::findOrFail($id);
    
        // Lấy tất cả dữ liệu từ request
        $data = $request->all();
        
        // Sử dụng hàm fill để cập nhật thông tin 
        $sporttypes->fill($data);
        
        // Lưu thay đổi
        $sporttypes->save();

        return redirect()->route('sporttype.get')->with('success', 'Sửa loại thể thao thành công');
    }
    public function changeLockSportType(Request $request,$id)
    {
        $sporttypes = SportType::findOrFail($id);

        if($sporttypes->status =='0'){
            $sporttypes-> status = '1';
            $sporttypes->save();
            return redirect()->route('sporttype.get')->with('success', 'Khóa thành công!');
        }
        if($sporttypes->status =='1'){
            $sporttypes-> status = '0';
            $sporttypes->save();
            return redirect()->route('sporttype.get')->with('success', 'Mở khóa thành công!');
        }
    }
}
