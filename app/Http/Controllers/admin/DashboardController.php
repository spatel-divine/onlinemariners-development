<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\User;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
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
        $candidateCount = DB::table('candidates')->where('candidate_status',1)->count();
        $employerCount = DB::table('employer')->where('profile_status',1)->count();
        $dt =Carbon::now();
        $today = $dt->toDateString();
        $totalJobpostCount = DB::table('postjob')->count();
        $totalJobApplyCount = DB::table('jobs_apply')->distinct('candidate_id')->count();

        // $latestTenPostjob = DB::table('postjob')->where('postjob_status',1)->orderBy('id','DESC')->limit(10)->get();
        $latestTenPostjob = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                ->select('employer.name','employer.company_name','employer.company_logo','postjob.*','postjob-wages.id as postwage_id','postjob-wages.rank_position','postjob-wages.wages')
                 // ->select( DB::raw("count(`postjob-wages`.`postjob_id`) as rankcount") )
                // ->groupBy('postjob-wages.id')
                // ->orderBy('id','DESC')
                ->where('postjob.postjob_status', 1)
                ->groupBy('postjob.id')
                ->orderBy('id','DESC')
                ->limit(10)                
                ->get();
        $latestFiveCandidate = DB::table('candidates')->where('candidate_status',1)->orderBy('id','DESC')->limit(5)->get()->toArray();
        // $latestFiveEmployer = (array)DB::table('employer')->where('profile_status',1)->orderBy('id','DESC')->limit(5)->get()->toArray();
        $latestFiveEmployer = (array)DB::table('employer')
            ->join('countries','countries.id','=','employer.country')
            ->select('employer.*', 'countries.name AS country')
            ->where('profile_status',1)->orderBy('employer.id','DESC')->limit(5)->get()->toArray();
        // echo gettype($latestFiveCandidate);
        //$array3 = array_merge_recursive($latestFiveCandidate, $latestFiveEmployer); //array_merge_recursive
        // echo "<pre>";
        // print_r($latestTenPostjob);
        // echo count($latestFiveCandidate);
        // print_r($latestFiveCandidate);

        $latestTenUsers = array_merge_recursive($latestFiveEmployer, $latestFiveCandidate); //array_merge_recursive
        // echo "<pre>";
        // print_r($latestTenUsers);
        // exit;
        // foreach ($latestFiveCandidate as $k=>$v) {
        //         $sub = [];
        //         $sub['name'] = $v;
        //         $latestTenUsers[] = $sub;
        // }
        // echo "<pre>";
        // print_r($latestTenUsers);
        // for ($i=0; $i < count($latestFiveCandidate); $i++) {
        //     // echo $i.'<br>';
            
            
        // }
        // echo "<pre>";
        // print_r($latestFiveCandidate);
        // // print_r($latestFiveEmployer);
        
        
        
        return view('admin.dashboard')->with([ 
                    'user' => $users,
                    'latestUsers' => $latestTenUsers,
                    'latestPostjobs' => $latestTenPostjob,
                    'candidateCount' => $candidateCount,
                    'employerCount' => $employerCount,
                    'totalJobpostCount' => $totalJobpostCount,
                    'totalJobApplyCount' => $totalJobApplyCount
                ]);
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

    /**
     * [enquiriesList show all customer enquiries]
     * @return [array] [list of all the enquiries]
     */
    public function enquiriesList(){
        $enquiries = DB::table('contactus')->get(); 
   
        
        return view('admin.enquiries')->with([ 
                    'enquiries' => $enquiries
                ]);
    }
}
