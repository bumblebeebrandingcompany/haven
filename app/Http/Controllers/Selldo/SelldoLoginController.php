<?php

namespace App\Http\Controllers\Selldo;

use App\Http\Controllers\Controller;
use App\Models\SelldoUser;
use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class SelldoLoginController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $util;

    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    /**
     * webhook coming during
     * form submission
     */
    public function login(Request $request)
    {
        return view('selldo.login');
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $save_credentials = true;
        $data = ['email' => $request->email, 'password' => $request->password];
        $password = $request->password;
        $user = SelldoUser::where('email', $request->email)->first();

        if ( auth('selldo')->attempt($data, $save_credentials)) {
            // toastr()->success('Login Successfully!');
            return redirect(route('selldo.home'));
        } else {
            return redirect()->back();
        }
    }
    public function logout(Request $request) {
        auth('selldo')->logout();

        $request->session()->flush();

        return  redirect()->route('selldo.login');
    }
}
