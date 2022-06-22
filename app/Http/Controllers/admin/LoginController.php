<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\User;
use DB;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }

    /* Admin Login */
    public function login(Request $request)
    {
        
        $users = User::where('name', '=', 'Super Admin')->first();
        // echo '<pre>';
        // print_r($users->password);
        // exit;
        $username = $request->input('username');
        $password = $request->input('password');

        // echo '<br>'.$username.' '.$password.'<br>';
        // var_dump(Hash::check($password, $users->password));
        // exit;
        if(!Hash::check($password, $users->password)){
            return redirect()->route('adminlogin')->with('error', 'Invalid password');
        }

        if(($username != '') && ($password != '')){
            // $password = 
            if(($username == 'Super Admin') && (Hash::check($password, $users->password))){
                Session::put('userid' , $users->id);
                $candidateCount = DB::table('candidates')->where('candidate_status',1)->count();
                $employerCount = DB::table('employer')->where('profile_status',1)->count();
                $dt =Carbon::now();
                $today = $dt->toDateString();
                $totalJobpostCount = DB::table('postjob')->count();
                $totalJobApplyCount = DB::table('jobs_apply')->count();
                                    // ->where('app_deadline', '>=' ,  $today)
                                    // ->count();
                return redirect()->route('admin.dashboard');
                // return view('admin.dashboard')->with([ 
                //     'user' => $users,
                //     'candidateCount' => $candidateCount,
                //     'employerCount' => $employerCount,
                //     'totalJobpostCount' => $totalJobpostCount,
                //     'totalJobApplyCount' => $totalJobApplyCount
                // ]);
            }
        }else if(($username == 'Super Admin') && (!Hash::check($password, $users->password))){
            return redirect()->route('adminlogin')->with('error', 'Please enter valid password.');
        }else if(($username != 'Super Admin') && (Hash::check($password, $users->password))){
            return redirect()->route('adminlogin')->with('error', 'Please enter valid User Name.');
        }else{
            return redirect()->route('adminlogin')->with('error', 'Invalid User Name and password.');
        }
    }

    public function adminLogout(Request $request)
    {
        Session::forget('userid');
        Session::flush();
        return redirect()->route('adminlogin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
