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
        return view('field.index');
    }

    public function getFieldDetailById($id)
    {
        $fields = Field::find($id);

        if (!$fields) {
            // Xử lý trường hợp không tìm thấy sân
            abort(404);
        }

        return view('field.detail', compact('fields'));
    }

}
