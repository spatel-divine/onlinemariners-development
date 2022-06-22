<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Employer;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmployerActionForJob;
use Response;
use Carbon\Carbon;
use Log;

class EmployerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $employer = Session::get('employerEmail');
        if(!isset($employer) || $employer == ''){
            return view('signin');
        }
        $dt = Carbon::today();
        $todaysDate = $dt->toDateString();
        $empImg = DB::select("SELECT id,pic_path,email_varified,profile_status,employer_chat_id  FROM employer where email="."'".$employer."'");

        
        $chatUserData = DB::select("SELECT *  FROM users where email="."'".$employer."' AND usertype='employer'");
        $count1 = DB::table('conversations')->where('status', '=', '0')->where('to_id', '=', $chatUserData[0]->id)->count();
        $count2 = DB::table('conversations')->where('status', '=', '0')->where('from_id', '=', $chatUserData[0]->id)->count();           
        $conversationUnreadCount = (int)$count1+(int)$count2;

        $ActivePostedCount = DB::select("SELECT count(*) AS postcount  FROM postjob where employer_id="."'".$empImg[0]->id."'"." AND postjob_status=1 AND app_deadline >=".$todaysDate);   
        
        $shortlist_cand_count = DB::table('jobs_apply')->where('employer_id' ,$empImg[0]->id)->where('apply_status','2')->count();
        
        $activedCandidateCount = DB::table('candidates')->where('candidate_status','1')->count();
        $dt =Carbon::now();
        $today = $dt->toDateString();
        $jobpostCount = DB::table('postjob')                        
                        ->where('employer_id', $empImg[0]->id)
                        ->where('app_deadline', '>=' ,  $today)
                        ->orderBy('id', 'DESC')
                        ->count();
        
        if($empImg[0]->email_varified == 0){
            return redirect()->route('verifying.load')->with('success', 'Employer registered successfully.Please verify your email address by checking your inbox or spam folder.In case you did not receive mail then kindly contact to our online agent through chat.');
        }
        $postJobByEmp = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                ->select('postjob.*','employer.name as employer_name','employer.company_name')
                ->where('employer_id', $empImg[0]->id)
                ->where('postjob.postjob_status', 1)
                ->orderBy('id', 'DESC')
                ->get();//->groupBy('postjob.id');//->paginate(15);        
        // echo "<pre>";
        // print_r($postJobByEmp);
        // exit;
        // $conversationUnreadCount = [ 'conversationUnreadCount' => $conversationUnreadCount];
        return view('employer.employerdashboard')->with(
            [                
                'empImg' => $empImg,
                'chatUserData' => $chatUserData,
                // 'jobPostedCount' => $job_posted_count,
                'ActivePostedCount' => $jobpostCount,
                'ShotlistedCandidateCount' => (int)$shortlist_cand_count,
                'activedCandidateCount' => $activedCandidateCount,
                'jobpostCount'=> $ActivePostedCount[0]->postcount,
                'postJobByEmp'=> $postJobByEmp,
                'conversationUnreadCount' => $conversationUnreadCount
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileCreate()
    {
        $empEmail = Session::get('employerEmail');
        $empImg = DB::select("SELECT id,pic_path,email_varified,profile_status FROM employer where email="."'".$empEmail."'");
        $employerData = Employer::where('email', $empEmail)->first();
        // $states = DB::select("SELECT id,name FROM states");
        // $countries = DB::select("SELECT id,name FROM countries");
		//unread msg 
    	$chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."' AND usertype='employer'");
        $count1 = DB::table('conversations')->where('status', '=', '0')->where('to_id', '=', $chatUserData[0]->id)->count();
        $count2 = DB::table('conversations')->where('status', '=', '0')->where('from_id', '=', $chatUserData[0]->id)->count();           
        $conversationUnreadCount = (int)$count1+(int)$count2;
         //state and country list
        $cities = DB::select("SELECT id,name FROM cities");
        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");
    
        return view('employer.employerprofile')->with([
            'empImg' => $empImg,
            'employerData' => $employerData,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        	'conversationUnreadCount' => $conversationUnreadCount
        ]);
    }

    public function editEmployer()
    {   
        $empEmail = Session::get('employerEmail');
        $empImg = DB::select("SELECT id,pic_path,email_varified,profile_status FROM employer where email="."'".$empEmail."'");
        $employerData = Employer::where('email', $empEmail)->first();
        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");
		//unread msg 
    	$chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."' AND usertype='employer'");
        $count1 = DB::table('conversations')->where('status', '=', '0')->where('to_id', '=', $chatUserData[0]->id)->count();
        $count2 = DB::table('conversations')->where('status', '=', '0')->where('from_id', '=', $chatUserData[0]->id)->count();           
        $conversationUnreadCount = (int)$count1+(int)$count2;
    
        return view('employer.updateEmployerProfile')->with([
            'empImg' => $empImg, 
            'employerData' => $employerData,
            'states' => $states,
            'countries' => $countries,
        	'conversationUnreadCount' => $conversationUnreadCount
        ]);
    }

    public function storeEmployer(Request $request){
        
        // echo '<pre>';
        // print_r($request->input());
        // exit;
        
        $messages = [
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
        ];
        if($request->input('edit_empprofile')){ //update profile validate
            $this->validate($request,[
            'employer_pic' =>  'mimes:jpg,jpeg,png,svg|max:2048',
            'company_name' => 'required|max:100',
            // 'contact_person' => 'required|max:50',
            'company_logo' => 'mimes:jpg,jpeg,png,svg|max:512',
            //'mobile_number' => 'integer|min:10',   
            'landline_number' => 'required|integer|min:10',            
            'street1' => 'required|max:500',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
                ], $messages);
        }else{
            $this->validate($request,[
            'employer_pic' =>  'mimes:jpg,jpeg,png,svg|max:2048',
            'company_name' => 'required|max:100',
            'company_logo' => 'required|mimes:jpg,jpeg,png,svg|max:512',
            'mobile_number' => 'integer|min:10',    
            'landline_number' => 'requiredinteger|min:10',          
            'street1' => 'required|max:500',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
                ], $messages);
        }
        
        $results = $request->input();
        $email = Session::get('employerEmail');
        $Employer = Employer::where('email', $email)->first();

        if($request->hasFile('pic_path')){
            $files=$request->file('pic_path');
            $path = public_path() . '/empProfile/';
            // $profile_file = $request->file('profile_pic')->getClientOriginalName();  //name
            $employer_pic = time().'.'.$request->file('pic_path')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('profile_pic')->getClientOriginalName();;
            $files->move($path,$employer_pic);
            $oldfile = url('/public/empProfile/'.$Employer['pic_path']);
            //delete old file
            File::delete($path.$Employer['pic_path']);
            // unset($oldfile);
        }else{
            $employer_pic = $Employer['pic_path'];
        }
        //-----company_logo----------
        if($fileslogo = $request->file('company_logo')){  
            $files=$request->file('company_logo');
            $path = public_path() . '/companyLogo/';
            // $profile_file = $request->file('profile_pic')->getClientOriginalName();  //name
            $company_logo = time().'.'.$request->file('company_logo')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('profile_pic')->getClientOriginalName();;
            $files->move($path,$company_logo);
            $oldfile = url('/public/companyLogo/'.$Employer['company_logo']);
            //delete old file
            File::delete($path.$Employer['company_logo']);
        }else{
            $company_logo = $Employer['company_logo'];
        }
                
        // $data = explode(",",$results['address']);
        // $count = count($data);        
        // $city = $data[$count-3];
        // $state = $data[$count-2];
        // $country = $data[$count-1];
        // echo '<pre>';
        // print_r($data);
        // exit;
        foreach($results as $k=>$v){

            unset($results['_token']);

            $results['pic_path'] = $employer_pic;
            $results['company_logo'] = $company_logo;
            $results['profile_status'] = 1;
            if($k == 'mobile_number'){
                $results['mobile_number'] = trim($v);
            }
            if($k == 'landline_number'){
                $results['landline_number'] = trim($v);
            }
            
            $results['created_at'] = date('Y-m-d H:i:s');
            $results['updated_at'] = date('Y-m-d H:i:s');
            $results[$k] = trim($v);

        }
        unset($results['edit_empprofile']);
        
        // echo '<pre>';
        // print_r($results);
        // exit;
        

        $EmployerProfileUpdate = DB::table('employer')
            ->where('email', $email)
            ->update($results);

        // echo '<br>Query Request ';
        // var_dump($EmployerProfileUpdate);
        // exit;
        
        $empImg = DB::select("SELECT id,pic_path,email_varified,profile_status FROM employer where email="."'".$email."'");
        
        if ($EmployerProfileUpdate) {
            Session::flash('success', 'Employer profile created successfully.');
            return redirect()->route('employer.profile')->with(['empImg' => $empImg]);
        } else {
            return redirect()->route('employer.profile')->with('Error', 'Employer profile not updated.');
        }
    }
    
    
    /* Upload Employer Profile Pic */
    public function profilepicupdate(Request $request)
    {
        $empEmail = Session::get('employerEmail');
        $employer = Employer::where('email', $empEmail)->first();
        $this->validate($request, [
            'pic_path' => 'image|mimes:jpeg,png,jpg,svg|max:500',
        ]);
        // echo $files = $request->file('pic_path');
        // exit;
        if($request->hasFile('pic_path')){
            $files=$request->file('pic_path');
            $path = public_path() . '/empProfile/';
            // $profile_file = $request->file('employer_pic')->getClientOriginalName();  //name
            $profile_file = time().'.'.$request->file('pic_path')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('employer_pic')->getClientOriginalName();;
            $files->move($path,$profile_file);
            $oldfile = url('/public/empProfile/'.$employer['pic_path']);
            $data = ['pic_path' => $profile_file];

            $imgUpdate = DB::table('employer')->where('email', $empEmail)->update($data);
            // var_dump($imgUpdate);
            //delete old file
            File::delete($path.$employer['pic_path']);
            // unset($oldfile);
        }else{
            $profile_file = $employer['pic_path'];
        }
        
        return redirect()->route('employer.dashboard');
    }


    //Employer Will shortlist candidate
    public function applyByCandidateList(){
        $empEmail = Session::get('employerEmail');
        
        $emp = DB::select("SELECT id,pic_path,email_varified,profile_status FROM employer where email="."'".$empEmail."'");
        
        $joblist = DB::table('jobs_apply')
                        ->join('candidates','candidates.id','=','jobs_apply.candidate_id')
                        ->join('employer','employer.id','=','jobs_apply.employer_id')
                        ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                        // ->join('postjob-wages','postjob-wages.id','=','jobs_apply.postwage_id')                    
                        ->select('jobs_apply.*','employer.name as employer_name','employer.email','employer.company_name','employer.contact_person','employer.mobile_number'  ,'postjob.job_title' ,'postjob.app_deadline','postjob.vassel_type' , 'candidates.name as candidate_name', 'candidates.nationality', 'candidates.availablefrom', 'candidates.phone_number' , 'candidates.experience_years', 'candidates.experience_months')
                        ->where(['jobs_apply.employer_id' => $emp[0]->id])
                        ->where('candidates.availability_status', '=' , 'Available')
                        ->orderBy('jobs_apply.id', 'DESC')                        
                        // ->where(['jobs_apply.candidate_id' => $candidate[0]->id])                        
                        ->get();
    	//unread msg 
    	$chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."' AND usertype='employer'");
        $count1 = DB::table('conversations')->where('status', '=', '0')->where('to_id', '=', $chatUserData[0]->id)->count();
        $count2 = DB::table('conversations')->where('status', '=', '0')->where('from_id', '=', $chatUserData[0]->id)->count();           
        $conversationUnreadCount = (int)$count1+(int)$count2;
        // echo "<pre>";
        // print_r($joblist);
        // exit;
        return view('employer.jobListApplyByCandidate')->with(['joblist' => $joblist, 'empImg' => $emp, 'conversationUnreadCount' => $conversationUnreadCount]);   
    }

    //change Application status by Employer
    public function changeApplicationStatusByEmp(Request $request){
        
        $job_apply_id = $request->post('job_apply_id');
        $apply_status = $request->post('apply_status');
        
        $jobApplied = DB::select("SELECT * FROM jobs_apply where id="."'".$job_apply_id."'");
        // $apply_status = explode(', ', $apply_status[0]);
        // echo "<pre>";
        // print_r($jobApplied);
        // exit;
        //prepare data for mail with status

        $dataStatus = [ 'apply_status' => $apply_status ];
        $updateStatus = DB::table('jobs_apply')
                        ->where('id', $job_apply_id)
                        ->update($dataStatus);
        if($updateStatus){
            $jobApplyData = DB::table('jobs_apply')
                    ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                    ->join('employer','employer.id','=','jobs_apply.employer_id')
                    ->join('candidates','candidates.id','=','jobs_apply.candidate_id')
                    ->select('postjob.job_title','employer.name as employer_name','candidates.name as candidate_name','candidates.email','jobs_apply.rank_position', 'jobs_apply.apply_status')
                    ->where(['jobs_apply.id' => $jobApplied[0]->id])
                    ->where(['postjob.id' => $jobApplied[0]->postjob_id])
                    ->where(['employer.id' => $jobApplied[0]->employer_id])
                    ->where(['candidates.id' => $jobApplied[0]->candidate_id])
                    ->get();
            // $data = [];
            
            foreach ($jobApplyData as $jobApplyData) {
                if($jobApplyData->apply_status == 0){
                    $jobApplyData->apply_status = 'Pendiing';
                }else if($jobApplyData->apply_status == 1){
                    $jobApplyData->apply_status = 'Selected';
                }else if($jobApplyData->apply_status == 2){
                    $jobApplyData->apply_status = 'Shortlisted';
                }else if($jobApplyData->apply_status == 3){
                    $jobApplyData->apply_status = 'Called For Interview';
                }else if($jobApplyData->apply_status == 4){
                    $jobApplyData->apply_status = 'Under Review';
                }else if($jobApplyData->apply_status == 5){
                    $jobApplyData->apply_status = 'Rejected';
                }
                // $data = $jobApplyData;
            }
            $data = [
                'job_title' => $jobApplyData->job_title,
                'candidate_name' => $jobApplyData->candidate_name,
                'email' => $jobApplyData->email,
                'employer_name' => $jobApplyData->employer_name,
                'rank_position' => $jobApplyData->rank_position,
                'apply_status' => $jobApplyData->apply_status,
            ];
            $candi_email = $data['email'];
          
            Log::info('Call EmployerController -> changeApplicationStatusByEmp -> Change candidate job status', $data);

            $mail = Mail::to($candi_email)->send(new EmployerActionForJob($data));
        }

        if($updateStatus){
            echo $apply_status;
        }else{
            echo '0';
        }
        
    }
    //show employer applied job candidate details
    public function viewCandidateDetails($id){
        // echo 'Candidate Details '.$id;
        // exit;     
        $empEmail = Session::get('employerEmail');
        if($empEmail){
            $canidate_id =$id;
            $emp = DB::select("SELECT id FROM employer where email="."'".$empEmail."'");
            $candidateProfile = DB::select("SELECT count(*) as profileCount FROM candidate_profile_viewed where candidate_id=".$canidate_id." AND employer_id=".$emp[0]->id);    
            $candidateProfileCount = $candidateProfile[0]->profileCount;
            // print_r($candidateProfileCount->profileCount);
            // exit;
            if($candidateProfileCount == 0 ){
                $data = [ 'candidate_id' => $canidate_id, 'employer_id' => $emp[0]->id];
                // echo '<pre>';
                // print_r($data);
                // exit;
                $EmployerProfileUpdate = DB::table('candidate_profile_viewed')->insert($data);
            }

        }
        

        $candidate = DB::select("SELECT * FROM candidates where id="."'".$id."'");

        $endorse = DB::select("SELECT * FROM endorments_docs where candidate_id="."'".$id."'");
        
        $travel = DB::select("SELECT * FROM travel_docs where candidate_id="."'".$id."'");
        $medical = DB::select("SELECT * FROM medical_docs where candidate_id="."'".$id."'");
        $skill_traing = DB::select("SELECT * FROM skills_training_certificates where candidate_id="."'".$id."'");
        $personal = DB::select("SELECT * FROM personal_docs where candidate_id="."'".$id."'");

        $coc = DB::select("SELECT * FROM coc_docs where candidate_id="."'".$id."'");
        $stcw = DB::select("SELECT * FROM stcw_docs where candidate_id="."'".$id."'");
        $offshore = DB::select("SELECT * FROM offshore_certification_docs where candidate_id="."'".$id."'");
        $others = DB::select("SELECT * FROM any_other_docs where candidate_id="."'".$id."' order by id asc");
        return view('employer.canidateDetailView')->with(
            [   'candidate' => $candidate,
                'endorse' => $endorse,
                'travel' => $travel,
                'medical' => $medical,
                'skill_traing' => $skill_traing,
                'personal' => $personal,                
                'coc' => $coc, 
                'stcw' => $stcw, 
                'offshore' => $offshore,
                'others' => $others,
                'is_endorsement' => 0,
                'is_travel' => 0,
                'is_medical' => 0,
                'is_skill_traing' => 0,
                'is_personal' => 0,
                'is_coc' => 0,
                'is_stcw' => 0,
                'is_offshore' => 0,
                'is_other' => 0
            ]
        );   
    }
    //show employer recently posted job detail(preview) view
     public function postjobDetailView($id){
        
        $empEmail = Session::get('employerEmail');
        $emp = DB::select("SELECT * FROM employer where email="."'".$empEmail."'");

        $postjob = DB::select("SELECT * FROM postjob where id="."'".$id."'");
        $wagelist = DB::table('postjob')
                        ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                        ->select('postjob.*','postjob-wages.*')
                        ->where(['postjob.id' => $id])
                        ->where(['postjob-wages.postjob_id' => $id])
                        ->get();
            // echo "<pre>";
            // print_r($wagelist);
            // exit;                        
            return view('employer.postjobDetailView')->with(['wagelist' => $wagelist, 'empImg' => $emp]);
        exit;
     }

    public function downloadResume($id)
    {   
        
        $candidateData = DB::select("SELECT id,resume_file FROM candidates where id=".$id);
        //print_r($candidateData);die;
        //$file= public_path(). "/resume/".$candidateData[0]->resume_file;
        //PDF file is stored under project/public/download/info.pdf
        
        $file= url('/public/resume/'.$candidateData[0]->resume_file);
        if($candidateData[0]->resume_file){
            $file= public_path(). "/resume/".$candidateData[0]->resume_file;    
        }else{
            return redirect()->route('cand.details')->with([ 'Error' => 'Resume not avilable.']);

        }

        $headers = array(
          'Content-Type: application/pdf',
        );
        // return response()->download($file);
        return response()->download($file, $candidateData[0]->resume_file, $headers);        
        // return redirect()->route('cand.details');        
    }


    /**
     * [viewCandidateGridList show list of all the available candidates]
     * @return view blade template with data
     */
    public function viewCandidateGridList(){
        $candidateList = DB::table('candidates')
                    ->where('candidate_status', '=' , 1)
                    ->where('candidates.availability_status', '=' , 'Available')
                    ->paginate(5);

        return view('employer.browseCandidateGridList')->with(['candidateList' => $candidateList]);
    }

    //
    public function profileCount($canidate_id){
        $employer = Session::get('employerEmail');
        $emp = DB::select("SELECT id FROM employer where email=".$employer);
        $empID = $emp[0]->id;
        $OldRecord = DB::select("SELECT * FROM candidate_profile_count where candidate_id=".$id." AND employer_id=".$empID)->count();
        
        if($OldRecord==0){
            $profile_count = DB::table('candidate_profile_count')
            ->where('email', $email)
            ->insert($results);    
        }
        
    }


    //Serch filter Candidate
    public function searchCandidate(Request $request)
    {
        $candidateName = $request->input('name');
        $rank_position = $request->input('rank_position');

        if($candidateName && $rank_position){
            $candidateList = DB::table('candidates')
                        ->where('candidate_status', '=' , 1)
                        ->where('name', $candidateName)
                        ->where('last_vassel_served', $rank_position)
                        ->paginate(15);    
        }else if($candidateName){
            $candidateList = DB::table('candidates')
                        ->where('candidate_status', '=' , 1)
                        ->where('name', '=' , $candidateName)
                        ->paginate(15);
        }else if($rank_position){
            // $candidateList = DB::table('candidates')
            //             ->where('candidate_status', '=' , 1)
            //             ->where('name', '=' , $candidateName)
            //             ->where('last_vassel_served', $rank_position)
            //             ->paginate(15);
        }
        // echo "<pre>";
        // print_r($candidateList);
        // exit;
        if(empty($candidateList)){
            $candidateList = ['error' , 'No  result found'];
        }
        
        return view('employer.browseCandidateGridList')->with(['candidateList' => $candidateList]);
    }

    //candidate filter for employer
    public function filterCanidate(Request $request)
    {   

        $data = $request->input();
        
        if(!isset($data['experience_years'])){
            $experience_years = 0;
        }
        if(!isset($data['rank_position'])){
            $rank_position = '';
        }
        if(isset($data['experience_years'])){
            if($data['experience_years'] == 'Choose Experience'){
                $experience_years = '';
            }else{
                $experience_years = trim($data['experience_years']);
            }            
        }
        if(isset($data['rank_position'])){
            if($data['rank_position'] == 'Choose Rank'){
                $rank_position = '';
            }else{
                $rank_position = trim($data['rank_position']);
            }
            
        }
              
        unset($data['_token']);
        if(empty($data)){
            return redirect()->route('cand.gridlist')->with('error', 'Please select atleast one search criteria ');
        }

        if($experience_years && $rank_position){            
            $candidateList = DB::table('candidates')
                        ->where('candidate_status', '=' , 1)
                        ->where('availability_status', '=' , 'Available')
                        ->where('experience_years', trim($experience_years))
                        ->where('applied_for', trim($rank_position))
                        ->paginate(5);    
        }else if($experience_years){            
            // echo gettype($experience_years);
            // $y = 2;            
            $candidateList = DB::table('candidates')
                        ->where('experience_years', '=', trim($experience_years))
                        ->where('availability_status', '=' , 'Available')
                        ->where('candidate_status', '=', 1)                    
                        ->paginate(5);
        }else if($rank_position){            
            $candidateList = DB::table('candidates')
                            ->where('candidate_status', '=', 1) 
                            ->where('availability_status', '=' , 'Available')
                            ->where('applied_for', trim($rank_position))
                            ->paginate(5);
            
        }else{
            $candidateList = DB::table('candidates')
                            ->where('candidate_status', '=' , 1)
                            ->where('availability_status', '=' , 'Available')
                            ->paginate(5);
        }

         //echo '<pre>';
        // print_r($candidateList);
         //exit;
         return view('employer.browseCandidateGridList')->with(
            [
               // 'success'=> 'Your serach results are as below',
               'candidateList' => $candidateList,
            ]);         
        
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
