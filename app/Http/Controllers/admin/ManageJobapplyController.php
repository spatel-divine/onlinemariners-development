<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\User;

class ManageJobapplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = Session::get('userid');
        $users = User::where('id', '=', $userid)->first();
        $jobapplyList =  DB::table('jobs_apply')
                        ->join('candidates','candidates.id','=','jobs_apply.candidate_id')
                        ->join('employer','employer.id','=','jobs_apply.employer_id')
                        ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                        ->join('postjob-wages','postjob-wages.id','=','jobs_apply.postwage_id')                    
                        ->select('jobs_apply.*','employer.name as employer_name','employer.email','employer.company_name','employer.contact_person','employer.mobile_number'  ,'postjob.job_title' ,'postjob.app_deadline','postjob.vassel_type' , 'postjob-wages.wages','candidates.name as candidate_name', 'candidates.nationality', 'candidates.availablefrom', 'candidates.phone_number' , 'candidates.experience_years', 'candidates.experience_months')
                        ->orderBy('jobs_apply.id', 'DESC')
                        ->get();

        return view('admin.jobapply.jobapplylisting')->with(['jobapplyList' => $jobapplyList, 'user' => $users]);
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
