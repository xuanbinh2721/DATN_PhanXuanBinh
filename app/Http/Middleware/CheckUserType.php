<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    public function handle($request, Closure $next, $allowedTypes)
    {
        $user = auth()->user();

        // Chuyển đổi chuỗi allowedTypes thành mảng để kiểm tra
        $allowedTypes = explode('|', $allowedTypes);

        if ($user && in_array($user->user_type, $allowedTypes)) {
            // Nếu user_type nằm trong danh sách được phép, tiếp tục request
            return $next($request);
        } else {
            // Nếu user_type không nằm trong danh sách được phép, chuyển hướng về trang chính
            return redirect('/');
        }
    }
}
