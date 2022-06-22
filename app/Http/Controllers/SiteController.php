<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\JobApply;
use App\Models\Candidate;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployerNotifyAppliedPostjob;
use Carbon\Carbon;
use Log;

class SiteController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/homepage';
    public function __construct()
    {
        $canidate = Session::get('userEmail');
        $employer = Session::get('employerEmail');
        $this->middleware('guest')->except('logout');
    }
    // $user = Session::get('userName';
    //     if(!$user){
    //         return View('');
    //     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $emp = DB::select("SELECT id,job_title,app_deadline,company_name  FROM employer where email="."'".$empEmail."'");
        // $joblists = DB::table('postjob')
        //                 ->join('employer','employer.id','=','postjob.employer_id')
        //                 ->select('employer.*','postjob.*')
        //                 ->orderBy('id','DESC')
        //                 ->limit(6)
        //                 ->get();
        $dt = Carbon::now();
        $today = $dt->toDateString();
        // echo $today;
        // exit;
       $joblists = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                // ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                ->select('employer.*','postjob.*')
                // ->orderBy('id','DESC')
                ->where('app_deadline', '>=', $today)
                ->where('postjob.postjob_status', 1)
                ->where('postjob.featured_job', 1)                
                ->limit(8)
                ->get();

        $itfJobs = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                // ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                ->select('employer.*','postjob.*')
                // ->orderBy('id','DESC')
                // ->where('app_deadline', '>=', $today)
                ->where('postjob.postjob_status', 1)
                ->where('postjob.itf_jobs', 1)                
                ->limit(8)
                ->get();

        $candidates = DB::select("SELECT * FROM `candidates` limit 3");

        // echo '123<pre>';
        // print_r($joblists);
        // exit;
        return view('homepage')->with(['joblists' => $joblists, 'candidates' => $candidates , 'itfJobs'=>$itfJobs]);
    }

    //show candidate detail view of post job
    public function jobDeatils($id)    
    {        
        $candidateEmail = Session::get('userEmail');
        $apply_status_current_status = '';

        if($candidateEmail && $candidateEmail!=''){
            $candidate_id = Candidate::where('email', $candidateEmail)
                ->pluck('id')->first();
            
            $apply_status_employee = DB::table('jobs_apply') 
                ->where(['candidate_id' => $candidate_id, 'postjob_id' => $id]) 
                ->pluck('apply_status')->first();
                
            switch ($apply_status_employee) {
                case 0:
                    $apply_status_current_status = 'Pending';
                    break;
                case 1:
                    $apply_status_current_status = 'Selected';
                    break;
                case 2:
                    $apply_status_current_status = 'Shortlisted';
                    break;
                case 3:
                    $apply_status_current_status = 'Called For Interview';
                    break;
                case 4:
                    $apply_status_current_status = 'Under Review';
                    break;
                case 5:
                    $apply_status_current_status = 'Rejected';
                    break;
            }    
        }

        $postjobs = DB::select("SELECT * FROM postjob where id=".$id);
        
        $wages = DB::select("SELECT * FROM `postjob-wages` where postjob_id=".$id);        
        // $emp = DB::select("SELECT * FROM `employer` where id=".$postjobs[0]->employer_id);
        $emp = DB::table('employer')                        
                ->join('countries','countries.id','=','employer.country')
                ->join('cities','cities.id','=','employer.city')
                ->select('employer.*' ,'countries.name as country', 'cities.name as city')
                ->where(['employer.id' => $postjobs[0]->employer_id])
                // ->orderBy('id','DESC')
                // ->limit(6)
                ->get();
                
        $wagelisting = DB::table('postjob')
                        ->join('employer','employer.id','=','postjob.employer_id')
                        ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                        ->select('employer.*','postjob.*','postjob-wages.*')
                        ->where(['postjob-wages.postjob_id' => $id])
                        ->orderBy('postjob-wages.id','DESC')
                        // ->limit(6)
                        ->get();
        //['countryList' => $countryList, 'profileimg' => $profileimg]
        return view('employer.jobListingView')->with(['postjobs' => $postjobs, 'wages' => $wages, 'emp' => $emp,'wagelisting' => $wagelisting, 'apply_status_current_status' => $apply_status_current_status]);
    }

    //candidate apply for the rank is 
    public function listRanks($postjob_id, $postwage_id = null){
        // echo $postjob_id.' '.$postwage_id;
        // exit;
        // echo 'candidate : '.Session::get('userEmail');
        // exit;
        if(Session::get('userEmail') == ''){
            //return redirect()->to('/signin')->with('error', 'Please login first to apply for the job.');
            return redirect()->route('signin.index')->with('error', 'Please login first to apply for the job');
        }
        

        $postwage_id = request()->segment(5);
        
        $wages = DB::select("SELECT * FROM `postjob-wages` where postjob_id=".$postjob_id);
        if(isset($wages[0]->employer_id)){
            $emp = DB::select("SELECT * FROM `employer` where id=".$wages[0]->employer_id);
            $email = session::get('userEmail');
            $candidate = DB::select("SELECT id FROM `candidates` where email="."'".$email."'");
            $candidate_id = $candidate[0]->id;
            

            $ranklists = DB::table('postjob-wages')
                        ->join('postjob','postjob.id','=','postjob-wages.postjob_id')
                        // ->join('jobs_apply','postjob.id','=','jobs_apply.postjob_id')
                        ->select('postjob.job_title','postjob-wages.*')
                        ->where(['postjob-wages.postjob_id' => $postjob_id])
                        // ->where(['jobs_apply.candidate_id' => $candidate_id])
                        ->get();

            $jobs_apply = DB::select("SELECT rank_position FROM `jobs_apply` where postjob_id=".$postjob_id." AND candidate_id=".$candidate_id);
            if($postwage_id){
                $rank = DB::select("SELECT rank_position FROM `postjob-wages` where postjob_id=".$postjob_id." AND id=".$postwage_id);
                // print_r($rank);
                // exit;            
                $add_cRank = ['choose_rank' => $rank[0]->rank_position]; 
                for($i=0;$i<count($ranklists);$i++){
                    if($ranklists[$i]->rank_position == $rank[0]->rank_position){
                        $ranklists[$i]->choose_rank = $add_cRank['choose_rank'];                    
                        // array_push($ranklists, $add_cRank);    
                    }
                }                    
            }
            // echo '<pre>';   
            // print_r($add_cRank);
            // print_r($ranklists);
            // exit; 

            $add =(object)['rank_position' => ''];        
            if(count($jobs_apply) > 0){
                
                for($i=0;$i<count($ranklists);$i++){                
                    if(!isset($jobs_apply[$i]) && (count($jobs_apply) != count($ranklists))){
                        $add = (object)['rank_position' => ''];
                        array_push($jobs_apply, $add);                    
                    }                
                }
                // print_r($add_cRank);


                for($i=0;$i<count($ranklists);$i++){   
                               
                    $ranklists[$i]->apply_rank = $jobs_apply[$i]->rank_position;                
                }    
            }
           
            $postion_apply = DB::select("SELECT rank_position FROM `jobs_apply` where postjob_id=".(int)$wages[0]->postjob_id." AND employer_id=".(int)$wages[0]->employer_id." AND candidate_id=".(int)$candidate_id."");
            
            return view('candidate.choosePostforApply')->with(['ranklists' => $ranklists, 'emp' => $emp, 'postion_apply' => $postion_apply]);
        } else {
            return redirect()->to('/job/browse/joblist');
        }
    }

    //save candidate application rank
    public function saveRank(Request $request){

        $email = Session::get('userEmail');
        // exit;
        $candidateData =  DB::select("SELECT id,name FROM candidates where email="."'".$email."'");
        // echo "<pre>";
        // print_r($candidateData);
        // exit;
        $this->validate($request,['rank_position' => 'required'], 
            ['required' => ':attribute is required.']);

        $employer_id = $request->post('employer_id');
        $postjob_id = $request->post('postjob_id');
        $postwage_id = $request->post('postwage_id');
        $rank_position = $request->post('rank_position');
        $candidate_id = $candidateData[0]->id;
        // exit;
        $data [] = [
            'candidate_id'=> $candidate_id,
            'employer_id' => $employer_id,
            'postjob_id' => $postjob_id,
            'postwage_id' => $postwage_id,
            'rank_position' => $rank_position,
            'apply_status' => 0,
        ];
        $JobApplyCount = 0;
        if(isset($postwage_id) && isset($postjob_id) && isset($postwage_id)){
            $JobApplyCount = JobApply::where('candidate_id', $candidate_id)
                                ->where('employer_id', $employer_id)
                                ->where('postjob_id', $postjob_id)
                                ->where('postwage_id', $postwage_id)
                                ->where('rank_position', $rank_position)
                                ->where('apply_status', 0)
                                ->count();    
        }
        
        // echo 'Apply:  '.$JobApplyCount;
        // exit;
        if($JobApplyCount == 0){
            $saveRank  = DB::table('jobs_apply')->insert($data);
            if($saveRank){
                $emp = DB::select("SELECT id,name,email FROM `employer` where id=".$employer_id);
                $data = ['name' => $emp[0]->name,'candidate_name' => $candidateData[0]->name,'rank_position' => $rank_position,];
                $employerEmail = $emp[0]->email;

                Log::info('SiteController -> Save Rank -> Send email to candidate', $data);

                Mail::to($employerEmail)->send(new EmployerNotifyAppliedPostjob($data));
            }   
            $msg = 'You have successfully applied for '.$rank_position;//;    
        }else{
            // readdir()turn route('cand.apply', ['postjob_id' => $postjob_id])->with(['error' => 'You have already apply for the job']);
            return redirect()->to('/candidate/apply/position/'.$postjob_id)->with(['error' => 'You have already applied for this job.']);
        }                       
        
        // exit;
        return redirect()->to('/postajob/details/'.$postjob_id)->with(['success' => $msg]);
        // return route('postjob.details', ['postjob_id' =>  $postjob_id])->with(['success' => $msg]);
    }

    //contact Us
    public function contactusView()
    {
        return view('contactus');
    }
    /* load Candidate Dashboard */
    // public function showcandidateDashboard()
    // {
    //     $countryList = DB::select('SELECT countryname FROM country ORDER BY countryname ASC');
    //     $email = Session::get('userEmail');

    //     $profileimg = DB::select("SELECT profile_path FROM candidates where email="."'".$email."'");
        
    //     // echo '<pre>';
    //     // print_r($countryList);
    //     // exit;
    //     return view('candidate.candidatedashboard')->with(['countryList' => $countryList, 'profileimg' => $profileimg]);    
    // }

    //save contact us inquiry 
    public function inquirySave(Request $request)
    {
        $results = $request->input();
        
        
        unset($results['_token']);
        // echo "<pre>";
        // print_r($results);
        // exit;
        $messages = [
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
        ];
        $this->validate($request,[
            'name' =>  'required|max:50',
            'email' => 'required|email|max:50',
            'phone_number' => 'required|integer|min:10',
            'subject' => 'required|max:100',
            'message' => 'required|max:500',
                ], $messages);

        $inquireSave = DB::table('contactus')->insert($results);
        if(isset($inquireSave)){
            return redirect()->route('contactus.load')->with([ 'success' => 'Inquiry saved successfully we will contact you back soon.']);    
        }else{
            return redirect()->route('contactus.load')->with(['Error', 'Error in inquire form fill All required detail']);    
        }
        
        
    }

    /* load send Email password view */
    public function emailEnterView()
    {        
       return view('emailResetPasswordlink');
    }

    /* send email for reset password link */
    public function sendEmailResetLink(Request $request){
        $email = $request->input('email');        
        echo '<pre>';
        print_r($email);
        exit;
    }

    
    public function aboutus()
    {
        return view('aboutus');   
    }

    //conversationAdd
    public function conversationAdd(Request $request)
    {
        $chatuserid = '';
        $candidateID = $request->input('candidateID');
        $employerID = $request->input('id');
        
        $candidateEmail = Session::get('userEmail');
        if($candidateEmail){
            $candidateData =  DB::select("SELECT id,name,candidate_chat_id FROM candidates where email="."'".$candidateEmail."'");    
            $chatuserid = $candidateData[0]->candidate_chat_id;
        }

 

        $empEmail = Session::get('employerEmail');
        if($empEmail){
            $emloyerData =  DB::select("SELECT id,name,employer_chat_id FROM employer where email="."'".$empEmail."'");
            $chatuserid = $emloyerData[0]->employer_chat_id;
        }
              
        $oneway = DB::table('conversations')
                    ->where('from_id', '=', $candidateID)
                    ->where('to_id', '=', $employerID)
                    ->count();

        $secondway = DB::table('conversations')
                    ->where('from_id', '=', $employerID)
                    ->where('to_id', '=', $candidateID)
                    ->count();
    
        if(($oneway == 0) && ($secondway == 0)){
            $totype = 'App\Models\Conversation';
            $msg = 'hi';
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d H:i:s', time());
            $created_at = $date;
            $updated_at = $created_at;
          
            $insert = DB::table('conversations')->insert([ 
                'from_id' => $employerID,
                'to_id' => $candidateID,
                'to_type' => $totype,
                'message' => $msg,
                'created_at' => $created_at,
                'updated_at' => $updated_at,            
            ]);
       
        }

        if($chatuserid){
            //http://chatingapp.onlinemariners.com/login?id=73
            $url = 'http://chatingapp.onlinemariners.com/login?id='.$chatuserid;
        }else{
            $url = 'https://onlinemariners.com/';
        }
        
        return redirect($url);
        
    }

    //knowledgeBase
    public function knowledgeBase()
    {
        return view('knowledgeBase');
    }

    //testimonialGridList    
    public function testimonialGridList()
    {
        return view('testimonial');   
    }

    //privacyPolicy
    public function privacyPolicy()
    {
        return view('privacyPolicy');   
    }
    
    //termsAndCondition
    public function termsAndCondition()
    {
        return view('termsAndCondition');   
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
