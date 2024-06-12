<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Client;
use App\Models\Project;
use App\Models\SelldoUser;
use App\Utils\Util;
use Illuminate\Http\Request;

class SelldoUserController extends Controller
{

    protected $util;

    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    public function index()
    {
        $selldouser = SelldoUser::all();
        return view('admin.selldo_user.index', compact('selldouser'));
    }
    public function store(Request $request)
    {
        $selldouser = new SelldoUser();
        $selldouser->name = $request->name;
        $selldouser->representative_name = $request->representative_name;
        $selldouser->email = $request->email;
        $selldouser->password = $request->password;
        $selldouser->user_type = $request->user_type;
        $selldouser->contact_number_1 = $request->contact_number_1;
        $selldouser->contact_number_2 = $request->contact_number_2;
        $selldouser->sell_do_user_id = $request->sell_do_user_id;
        $selldouser->sell_do_team_id = $request->sell_do_team_id;
        $selldouser->sell_do_department = $request->sell_do_department;
        $selldouser->agency_id = $request->agency_id;
        $selldouser->ref_num = $this->util->generateselldoRefNum($selldouser);

        $selldouser->save();
        return redirect()->route('admin.selldoUser.index')->with('success', 'Form created successfully');
    }
    public function create()
    {
        $projects = Project::all();
        $selldouser = SelldoUser::all();
        $agencies = Agency::all();
        $clients = Client::all();
        return view('admin.selldo_user.create', compact('selldouser', 'agencies', 'clients', 'projects'));
    }

    public function edit(SelldoUser $selldousers)
    {
        $selldouser=SelldoUser::all();
        return view('admin.selldo_user.edit', compact('selldouser'));
    }
}
