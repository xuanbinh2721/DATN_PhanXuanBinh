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
    }
