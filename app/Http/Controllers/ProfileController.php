<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    
    /**
     * Update the user's profile information.
     */

    public function updateInfomation(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        $userData = $request->validated();
        
        // Kiểm tra xem có file ảnh avatar được gửi hay không
        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
    
        $this->updateEmailAndSendVerification($user, $request->email);
    
        // Cập nhật thông tin người dùng
        $user->fill($userData);
        $user->save();
        
        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }
    

    private function updateEmailAndSendVerification($user, $newEmail)
    {
        $oldEmail = $user->email;
    
        if ($oldEmail != $newEmail) {
            $user->update([
                'email_verified_at' => null
            ]);
            $user->sendEmailVerificationNotification();
        }
    }

}
