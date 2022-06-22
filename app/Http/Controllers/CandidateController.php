<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;
use File;
use Carbon\Carbon;

class CandidateController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidate = Session::get('userEmail');
        if(!isset($candidate) || $candidate == ''){
            return view('signin');
        }
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


    public function candidateDashboard(){

        $email = Session::get('userEmail');
        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");
        $candidate_userid = DB::select("SELECT id,email,request_chat_id FROM users where email="."'".$email."' And usertype='candidate'");
        
        if(count($candidate_userid) > 0){
            $count1 = DB::table('conversations')->where('status', '=', '0')->where('to_id', '=', $candidate_userid[0]->id)->count();
            $count2 = DB::table('conversations')->where('status', '=', '0')->where('from_id', '=', $candidate_userid[0]->id)->count();           
            $conversationUnreadCount = (int)$count1+(int)$count2;
        }else{
            $conversationUnreadCount = 0;
        }
        

        if($profileimg[0]->email_verified_at == 0){
            return redirect()->route('verifying.load')->with('success', 'Candidate registered successfully.Please verify your email address by checking your inbox or spam folder.In case you did not receive mail then kindly contact to our online agent through chat.');
        }

        $job_apply_count = DB::table('jobs_apply')->where('candidate_id',$profileimg[0]->id)->count();
        $shortlist_count = DB::table('jobs_apply')->where('candidate_id',$profileimg[0]->id)->where('apply_status','2')->count();
        $interviewcall_count = DB::table('jobs_apply')->where('candidate_id',$profileimg[0]->id)->where('apply_status','3')->count();
        $job_count = ['job_count' => $job_apply_count];
        $pending_job = DB::table('jobs_apply')->where('candidate_id',$profileimg[0]->id)->whereIn('apply_status' ,['0','2','3','4'])->count();
        $profileCount = DB::select("SELECT count(*) As profileCount FROM candidate_profile_viewed where candidate_id="."'".$profileimg[0]->id."'");
        // print_r($profileCount[0]->profileCount);
        // exit;
        $profileViewCount = $profileCount[0]->profileCount;
        $appliedjobs = DB::table('jobs_apply')
                        ->join('employer','employer.id','=','jobs_apply.employer_id')
                        ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                        ->select('employer.name','employer.contact_person','postjob.job_title','postjob.app_deadline','postjob.country','jobs_apply.*')
                        ->where(['jobs_apply.candidate_id' => $profileimg[0]->id])
                        // ->orderBy('id','DESC')
                        // ->limit(6)
                        ->orderBy('jobs_apply.id', 'DESC')
                        ->get();

        $dt =Carbon::now();
        $today = $dt->toDateString();
        
        $totalJobPosted = DB::table('postjob')
                        ->join('employer','employer.id','=','postjob.employer_id')
                        ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                        ->select('postjob.job_title','postjob.app_deadline','postjob.country','postjob.country','employer.name','postjob-wages.*')
                        // ->where(['postjob-wages.employer_id' => $emp[0]->id])
                        ->where('postjob.app_deadline', '>=' ,  $today)
                        ->orderBy('id', 'DESC')
                        ->get();

        $allPostJobLists = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                // ->select('employer.company_name','employer.company_logo','postjob.*','postjob-wages.rank_position')
                 // ->select( DB::raw("count(`postjob-wages`.`postjob_id`) as rankcount") )
                // ->groupBy('postjob-wages.postjob_id')
                ->groupBy('employer.id')
                // ->orderBy('id','DESC')
                ->where('postjob.postjob_status', 1)                                
                // ->get()
                ->paginate(5,['employer.company_name','employer.company_logo','postjob.*','postjob-wages.rank_position', DB::raw("count(`postjob-wages`.`postjob_id`) as rankcount")]);
        // echo "<pre>";
        // print_r($totalJobPosted);
        // exit;
        return view('candidate.candidatedashboard', compact('profileimg', 'job_count', 'profileViewCount', 'pending_job','shortlist_count','interviewcall_count','appliedjobs', 'totalJobPosted','conversationUnreadCount', 'allPostJobLists'));
    }

    public function showcandidateProfile()
    {
        $email = Session::get('userEmail');
        //unread msg
        $candidate_userid = DB::select("SELECT * FROM users where email="."'".$email."' And usertype='candidate'");
        $count1 = DB::table('conversations')
                    ->where('status', '=', '0')
                    // ->where('from_id', '=', $candidate_userid[0]->id)
                    ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
        $count2 = DB::table('conversations')
                    ->where('status', '=', '0')
                    ->where('from_id', '=', $candidate_userid[0]->id)
                    // ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
                   
        $conversationUnreadCount = (int)$count1+(int)$count2; 
        //end of unread msg

        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");
        $countryList = DB::select('SELECT countryname FROM country ORDER BY countryname ASC');
        $candidateData = Candidate::where('email', $email)->first();
        // echo "<pre>";
        // print_r($candidateData->docs_uploaded);
        // exit;
        return view('candidate.editcandidate', compact('candidateData', 'profileimg', 'countryList', 'conversationUnreadCount'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $results = $request->input();
        $email = Session::get('userEmail');
        $candidate = Candidate::where('email', $email)->first();
        
        $messages = [
            'nationality.required'=> 'Nationality is required.', // custom message
            'phone_number.required'=> 'Phone number is required.', // custom message
            'profile_path.required'=> 'Profile image is required.', // custom message
            'dob.required'=> 'DOB is required.', // custom message
            'applied_for.required'=> 'Applied for is required.', // custom message
            'experience_years.required'=> 'Experience Years is required.', // custom message
            'experience_months.required'=> 'Experience Months is required.', // custom message
            'availablefrom.required'=> 'Available from is required.', // custom message
            'competency_certificate.required' => 'Competency Certificate is required.',
            'resume_file.required' => 'Resume file is required.',
            'last_vassel_served.required' => 'Last vessel served is required.',
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
            'regex' => ':attribute must be 10 digits long for example 1234567890',
            
        ];
        
        if(isset($results['update_candidate']) && $results['update_candidate']){
            $this->validate($request,[
            'country_code' => 'required',
            'phone_number' => 'required|integer|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'nationality' => 'required',
            'dob' => 'required|date',
            'applied_for' => 'required',
            'experience_years' => 'required|integer',
            'experience_months' => 'required|integer',
            'availablefrom' => 'required|date',
            'competency_certificate' => 'required',
            'last_vassel_served' => 'required',
            'resume_file' => 'mimes:pdf,doc,docx,jpg,JPG,jpeg,JPEG|max:5000',
            'profile_path' =>  'mimes:jpg,jpeg,png,svg|max:2048',
                ], $messages);    
        }else{
            $this->validate($request,[
            'country_code' => 'required',
            'phone_number' => 'required|integer|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'nationality' => 'required',
            'dob' => 'required|date',
            'applied_for' => 'required',
            'experience_years' => 'required|integer',
            'experience_months' => 'required|integer',
            'availablefrom' => 'required|date',
            'competency_certificate' => 'required',
            'last_vassel_served' => 'required',
            'resume_file' => 'required|mimes:pdf,doc,docx,jpg,JPG,jpeg,JPEG|max:5000',
            'profile_path' =>  'mimes:jpg,jpeg,png,svg|max:2048',
                ], $messages); 
        }
       
        //profile
        if($request->hasFile('profile_path')){
            $files=$request->file('profile_path');
            $path = public_path() . '/profile/';
            $profile_file = time().'.'.$request->file('profile_path')->getClientOriginalExtension();
            $files->move($path,$profile_file);
            $oldfile = url('/public/profile/'.$candidate['profile_path']);
            
            File::delete($path.$candidate['profile_path']);
        }else{
            $profile_file = $candidate['profile_path'];
        }
        //-----Resume----------
        if($filescv = $request->file('resume_file')){  
            $resume_file = time().'.'.$request->file('resume_file')->getClientOriginalExtension();
            $dpath = public_path().'/resume/';
            $request->file('resume_file')->move($dpath, $resume_file);
            File::delete($dpath.$candidate['resume_file']);
        }else{
            $resume_file = '';
        }

        foreach($results as $k=>$v){
            unset($results['_token']);
            unset($results['update_candidate']);
            if($k == 'phone_number'){
                $results['phone_number'] = $results['country_code'].'-'.$results['phone_number'];
                unset($results['country_code']);
            }
            if($k == 'landline_number'){
                $results['landline_number'] = $results['country_code_landline'].'-'.$results['landline_number'];
                unset($results['country_code_landline']);
            }
            if($k=='dob'){
                $dateInput = explode('/',$results['dob']);
                $dob = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $results[$k] = $dob;  
            }
            if($k == 'availablefrom'){
                $dateInput2 = explode('/',$results['availablefrom']);
                $availablefrom = $dateInput2[2].'-'.$dateInput2[0].'-'.$dateInput2[1];
                $results[$k] = $availablefrom;
            }
            $results['profile_path'] = $profile_file;

            if($resume_file && $resume_file!=''){
                $results['resume_file'] = $resume_file;
            }else{
                $results['resume_file'] = $candidate['resume_file'];
            }
            
            $results['candidate_status'] = "1";
        }
       
        $candidateProfileUpdate = DB::table('candidates')
            ->where('email', $email)
            ->update($results);
     
        if ($candidateProfileUpdate) {
            if($candidate->docs_uploaded == '0'){
                return redirect()->route('endorsment.docs')->with('Success', 'Next step is to update Document is update or not.');
            }else{
                return redirect()->route('cand.profile')->with('success', 'Candidate’s profile updated successfully.');
            }
            
        } else {

           
                return redirect()->route('cand.profile');
            
            //    return redirect()->route('cand.profile')->with('Error', 'Candidate’s profile not updated.');
            
            
        }
        
    }

    public function editCandidate(){
        $email = Session::get('userEmail');
        //unread msg
        $candidate_userid = DB::select("SELECT * FROM users where email="."'".$email."' And usertype='candidate'");
        $count1 = DB::table('conversations')
                    ->where('status', '=', '0')
                    // ->where('from_id', '=', $candidate_userid[0]->id)
                    ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
        $count2 = DB::table('conversations')
                    ->where('status', '=', '0')
                    ->where('from_id', '=', $candidate_userid[0]->id)
                    // ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
                   
        $conversationUnreadCount = (int)$count1+(int)$count2; 
        //end of unread msg

        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");
        $countryList = DB::select('SELECT countryname FROM country ORDER BY countryname ASC');
        $candidateData = Candidate::where('email', $email)->first();
        // echo "<pre>";
        // print_r($candidateData->docs_uploaded);
        // exit;
        return view('candidate.editcandidate', compact('candidateData', 'profileimg', 'countryList', 'conversationUnreadCount'));
    }   

    //candidate view applied job lists
    public function candidateJobApplyList(){
        $email = Session::get('userEmail');
        //unread msg
        $candidate_userid = DB::select("SELECT * FROM users where email="."'".$email."' And usertype='candidate'");
        $count1 = DB::table('conversations')
                    ->where('status', '=', '0')
                    // ->where('from_id', '=', $candidate_userid[0]->id)
                    ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
        $count2 = DB::table('conversations')
                    ->where('status', '=', '0')
                    ->where('from_id', '=', $candidate_userid[0]->id)
                    // ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
                   
        $conversationUnreadCount = (int)$count1+(int)$count2; 
        //end of unread msg  

        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");
        $candidate = DB::select("SELECT id FROM candidates where email="."'".$email."'");
        $job_apply = DB::select("SELECT * FROM jobs_apply where candidate_id="."'".$candidate[0]->id."'");
        // $job_apply_count = DB::select("SELECT * FROM jobs_apply where candidate_id="."'".$candidate[0]->id."'")->count();
        $job_apply_count = DB::table('jobs_apply')->where('candidate_id' , $candidate[0]->id)->count();
                
        if($job_apply_count > 0){
                $joblist = DB::table('jobs_apply')
                        ->join('employer','employer.id','=','jobs_apply.employer_id')
                        ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                        ->join('postjob-wages','postjob-wages.id','=','jobs_apply.postwage_id')                    
                        ->select('jobs_apply.id','employer.name','employer.email','employer.company_name','employer.contact_person','employer.mobile_number'  ,'postjob.job_title' ,'postjob.app_deadline','postjob.vassel_type' ,'postjob-wages.rank_position','jobs_apply.apply_status')
                        // ->where(['postjob.id' => $job_apply[0]->postjob_id])
                        ->where(['jobs_apply.candidate_id' => $candidate[0]->id])
                        ->orderBy('id', 'DESC')
                        // ->where(['postjob-wages.id' => $job_apply[0]->postwage_id])
                        ->get();    
        }else{
            $joblist = [];
        }
        
        // echo '<pre>';        
        // print_r($joblist);
        // exit;
        return view('candidate.jobAppliedListing', compact('profileimg', 'joblist', 'conversationUnreadCount'));
    }
    

    //profileViewByEmployer
    public function profileViewByEmployer(){

        $email = Session::get('userEmail');        
        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");
        $candidate = DB::select("SELECT id FROM candidates where email="."'".$email."'");

        //unread msg
        $candidate_userid = DB::select("SELECT id,email,request_chat_id FROM users where email="."'".$email."' And usertype='candidate'");
        $count1 = DB::table('conversations')
                    ->where('status', '=', '0')
                    // ->where('from_id', '=', $candidate_userid[0]->id)
                    ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
        $count2 = DB::table('conversations')
                    ->where('status', '=', '0')
                    ->where('from_id', '=', $candidate_userid[0]->id)
                    // ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
                   
        $conversationUnreadCount = (int)$count1+(int)$count2;
        $job_apply_count = DB::table('jobs_apply')->where('candidate_id' , $candidate[0]->id)->count();
        
        if($job_apply_count > 0){
            $joblist = DB::table('jobs_apply')
                ->join('employer','employer.id','=','jobs_apply.employer_id')
                ->join('postjob','postjob.id','=','jobs_apply.postjob_id')
                ->join('postjob-wages','postjob-wages.id','=','jobs_apply.postwage_id')                    
                ->select('jobs_apply.id','employer.name','employer.email','employer.company_name','employer.contact_person','employer.mobile_number'  ,'postjob.job_title' ,'postjob.app_deadline','postjob.vassel_type' ,'postjob-wages.rank_position','jobs_apply.apply_status')
                //->where(['postjob.id' => $job_apply[0]->postjob_id])
                ->where(['jobs_apply.candidate_id' => $candidate[0]->id])
                ->orderBy('id', 'DESC')
                //->where(['postjob-wages.id' => $job_apply[0]->postwage_id])
                ->get();
        }else{
            $joblist = [];
        }

        $employerList = DB::table('candidates')
            ->join('candidate_profile_viewed','candidates.id','=','candidate_profile_viewed.candidate_id')
            ->join('employer','employer.id','=','candidate_profile_viewed.employer_id')
            ->join('countries','countries.id','=','employer.country')
            ->join('cities','cities.id','=','employer.city')            
            ->select('employer.id','employer.name','employer.email','employer.company_name','employer.mobile_number','cities.name AS city','countries.name AS country')
            //->where(['postjob.id' => $job_apply[0]->postjob_id])
            ->where(['candidate_profile_viewed.candidate_id' => $candidate[0]->id])
            ->orderBy('id', 'DESC')
            //->where(['postjob-wages.id' => $job_apply[0]->postwage_id])
            ->get();
        if(isset($employerList[0]->id)){
            $postjobs = DB::select("SELECT id FROM postjob where employer_id=".$employerList[0]->id);    
        }else{
            $postjobs = [];
        }
        
        // echo "<pre>";
        // print_r($employerList);
        // print_r($postjob[0]->id);
        // exit;

        return view('candidate.profileviewedByEmployer', compact('profileimg', 'joblist', 'conversationUnreadCount', 'employerList', 'postjobs'));
    }
    
    //View Document Expiry date
    public function endorsementDocuments($request = ''){
        
        $email = Session::get('userEmail');
        $profileimg = DB::select("SELECT * FROM candidates where email="."'".$email."'");

        // endorsement
        $endors = DB::select("SELECT * FROM endorments_docs where candidate_id="."'".$profileimg[0]->id."'");        
        $is_endors_name_dec_chemical_disabled = (isset($endors[0]->is_endors_name_dec_chemical) && $endors[0]->is_endors_name_dec_chemical==1) ? '' : "disabled = 'true'";
        $is_endors_name_dec_gas_disabled = (isset($endors[0]->is_endors_name_dec_gas) && $endors[0]->is_endors_name_dec_gas==1) ? '' : "disabled = 'true'";
        $is_endors_name_dec_others_disabled = (isset($endors[0]->is_endors_name_dec_others) && $endors[0]->is_endors_name_dec_others==1) ? '' : "disabled = 'true'";
        $is_endors_name_dec_petroleum_disabled = (isset($endors[0]->is_endors_name_dec_petroleum) && $endors[0]->is_endors_name_dec_petroleum==1) ? '' : "disabled = 'true'";
        $is_endors_name_others_disabled = (isset($endors[0]->is_endors_name_others) && $endors[0]->is_endors_name_others==1) ? '' : "disabled = 'true'";

        //Travel Documents
        $travel = DB::select("SELECT * FROM travel_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_passport_disabled = (isset($travel[0]->is_passport) && $travel[0]->is_passport==1) ? '' : "disabled = 'true'";
        $is_Seamans_book_cdc_disabled = (isset($travel[0]->is_Seamans_book_cdc) && $travel[0]->is_Seamans_book_cdc==1) ? '' : "disabled = 'true'";
        $is_uk_work_permit_disabled = (isset($travel[0]->is_uk_work_permit) && $travel[0]->is_uk_work_permit==1) ? '' : "disabled = 'true'";
        $is_uk_visa_disabled = (isset($travel[0]->is_uk_visa) && $travel[0]->is_uk_visa==1) ? '' : "disabled = 'true'";
        $is_travel_others_disabled = (isset($travel[0]->is_travel_others) && $travel[0]->is_travel_others==1) ? '' : "disabled = 'true'";

        // Medical Documents
        $medical = DB::select("SELECT * FROM medical_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_drug_alcohol_blood_test_disabled = (isset($medical[0]->is_drug_alcohol_blood_test) && $medical[0]->is_drug_alcohol_blood_test==1) ? '' : "disabled = 'true'";
        $is_seafarers_medical_examination_disabled = (isset($medical[0]->is_seafarers_medical_examination) && $medical[0]->is_seafarers_medical_examination==1) ? '' : "disabled = 'true'";
        $is_ukooa_medical_fitness_disabled = (isset($medical[0]->is_ukooa_medical_fitness) && $medical[0]->is_ukooa_medical_fitness==1) ? '' : "disabled = 'true'";
        $is_yellow_fever_vaccination_disabled = (isset($medical[0]->is_yellow_fever_vaccination) && $medical[0]->is_yellow_fever_vaccination==1) ? '' : "disabled = 'true'";
        $is_medical_others_disabled = (isset($medical[0]->is_medical_others) && $medical[0]->is_medical_others==1) ? '' : "disabled = 'true'";

        // Skill and training Documents
        /*$skill = DB::select("SELECT * FROM skills_training_certificates where candidate_id="."'".$profileimg[0]->id."'");
        $is_arpa_disabled = (isset($skill[0]->is_arpa) && $skill[0]->is_arpa==1) ? '' : "disabled = 'true'";
        $is_bbsp_disabled = (isset($skill[0]->is_bbsp) && $skill[0]->is_bbsp==1) ? '' : "disabled = 'true'";
        $is_bl_disabled = (isset($skill[0]->is_bl) && $skill[0]->is_bl==1) ? '' : "disabled = 'true'";
        $is_btm_disabled = (isset($skill[0]->is_btm) && $skill[0]->is_btm==1) ? '' : "disabled = 'true'";
        $is_ctt_disabled = (isset($skill[0]->is_ctt) && $skill[0]->is_ctt==1) ? '' : "disabled = 'true'";
        $is_ccow_disabled = (isset($skill[0]->is_ccow) && $skill[0]->is_ccow==1) ? '' : "disabled = 'true'";
        $is_coc_disabled = (isset($skill[0]->is_coc) && $skill[0]->is_coc==1) ? '' : "disabled = 'true'";
        $is_induction_disabled = (isset($skill[0]->is_induction) && $skill[0]->is_induction==1) ? '' : "disabled = 'true'";
        $is_limited_disabled = (isset($skill[0]->is_limited) && $skill[0]->is_limited==1) ? '' : "disabled = 'true'";
        $is_simulator_disabled = (isset($skill[0]->is_simulator) && $skill[0]->is_simulator==1) ? '' : "disabled = 'true'";*/

        // Personal Documents
        $personal = DB::select("SELECT * FROM personal_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_driver_license_disabled = (isset($personal[0]->is_driver_license) && $personal[0]->is_driver_license==1) ? '' : "disabled = 'true'";
        $is_photograph_disabled = (isset($personal[0]->is_photograph) && $personal[0]->is_photograph==1) ? '' : "disabled = 'true'";
        $is_resume_disabled = (isset($personal[0]->is_resume) && $personal[0]->is_resume==1) ? '' : "disabled = 'true'";
        $is_personal_other_disabled = (isset($personal[0]->is_personal_other) && $personal[0]->is_personal_other==1) ? '' : "disabled = 'true'";

        // COC Documents
        $coc = DB::select("SELECT * FROM coc_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_officers_incharge_navigational_unlimited_disabled = (isset($coc[0]->is_officers_incharge_navigational_unlimited) && $coc[0]->is_officers_incharge_navigational_unlimited==1) ? '' : "disabled = 'true'";
        $is_master_unlimited_disabled = (isset($coc[0]->is_master_unlimited) && $coc[0]->is_master_unlimited==1) ? '' : "disabled = 'true'";
        $is_chief_mate_unlimited_disabled = (isset($coc[0]->is_chief_mate_unlimited) && $coc[0]->is_chief_mate_unlimited==1) ? '' : "disabled = 'true'";
        $is_masters_ships_lessthan_500gt_disabled = (isset($coc[0]->is_masters_ships_lessthan_500gt) && $coc[0]->is_masters_ships_lessthan_500gt==1) ? '' : "disabled = 'true'";
        $is_officers_charge_navigational_less_500_disabled = (isset($coc[0]->is_officers_charge_navigational_less_500) && $coc[0]->is_officers_charge_navigational_less_500==1) ? '' : "disabled = 'true'";
        $is_rating_forming_part_navigational_watch_disabled = (isset($coc[0]->is_rating_forming_part_navigational_watch) && $coc[0]->is_rating_forming_part_navigational_watch==1) ? '' : "disabled = 'true'";
        $is_able_seafarer_deck_disabled = (isset($coc[0]->is_able_seafarer_deck) && $coc[0]->is_able_seafarer_deck==1) ? '' : "disabled = 'true'";
        $is_officer_charge_engineering_watch_disabled = (isset($coc[0]->is_officer_charge_engineering_watch) && $coc[0]->is_officer_charge_engineering_watch==1) ? '' : "disabled = 'true'";
        $is_chief_engineer_officer_disabled = (isset($coc[0]->is_chief_engineer_officer) && $coc[0]->is_chief_engineer_officer==1) ? '' : "disabled = 'true'";
        $is_second_engineer_officer_disabled = (isset($coc[0]->is_second_engineer_officer) && $coc[0]->is_second_engineer_officer==1) ? '' : "disabled = 'true'";
        $is_rating_formingpart_engineering_watch_disabled = (isset($coc[0]->is_rating_formingpart_engineering_watch) && $coc[0]->is_rating_formingpart_engineering_watch==1) ? '' : "disabled = 'true'";
        $is_able_seafarer_engine_disabled = (isset($coc[0]->is_able_seafarer_engine) && $coc[0]->is_able_seafarer_engine==1) ? '' : "disabled = 'true'";
        $is_cef_second_eo_ships_750_3000_disabled = (isset($coc[0]->is_cef_second_eo_ships_750_3000) && $coc[0]->is_cef_second_eo_ships_750_3000==1) ? '' : "disabled = 'true'";
        $is_electro_technical_officer_disabled = (isset($coc[0]->is_electro_technical_officer) && $coc[0]->is_electro_technical_officer==1) ? '' : "disabled = 'true'";
        $is_cook_coc_disabled = (isset($coc[0]->is_cook_coc) && $coc[0]->is_cook_coc==1) ? '' : "disabled = 'true'";
        $is_gmdss_radio_operator_disabled = (isset($coc[0]->is_gmdss_radio_operator) && $coc[0]->is_gmdss_radio_operator==1) ? '' : "disabled = 'true'";


        // STCW Documents
        $stcw = DB::select("SELECT * FROM stcw_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_basic_training_chemical_tc_operations_disabled = (isset($stcw[0]->is_basic_training_chemical_tc_operations) && $stcw[0]->is_basic_training_chemical_tc_operations==1) ? '' : "disabled = 'true'";
        $is_advanced_tc_operations_disabled = (isset($stcw[0]->is_advanced_tc_operations) && $stcw[0]->is_advanced_tc_operations==1) ? '' : "disabled = 'true'";
        $is_advanced_chemical_tc_operations_disabled = (isset($stcw[0]->is_advanced_chemical_tc_operations) && $stcw[0]->is_advanced_chemical_tc_operations==1) ? '' : "disabled = 'true'";
        $is_bt_liquified_gas_tc_disabled = (isset($stcw[0]->is_bt_liquified_gas_tc) && $stcw[0]->is_bt_liquified_gas_tc==1) ? '' : "disabled = 'true'";
        $is_at_for_liquified_gas_tc_disabled = (isset($stcw[0]->is_at_for_liquified_gas_tc) && $stcw[0]->is_at_for_liquified_gas_tc==1) ? '' : "disabled = 'true'";
        $is_pst_disabled = (isset($stcw[0]->is_pst) && $stcw[0]->is_pst==1) ? '' : "disabled = 'true'";
        $is_fpff_disabled = (isset($stcw[0]->is_fpff) && $stcw[0]->is_fpff==1) ? '' : "disabled = 'true'";
        $is_efa_disabled = (isset($stcw[0]->is_efa) && $stcw[0]->is_efa==1) ? '' : "disabled = 'true'";
        $is_pssr_disabled = (isset($stcw[0]->is_pssr) && $stcw[0]->is_pssr==1) ? '' : "disabled = 'true'";
        $is_pscrb_disabled = (isset($stcw[0]->is_pscrb) && $stcw[0]->is_pscrb==1) ? '' : "disabled = 'true'";
        $is_aff_disabled = (isset($stcw[0]->is_aff) && $stcw[0]->is_aff==1) ? '' : "disabled = 'true'";
        $is_mfa_disabled = (isset($stcw[0]->is_mfa) && $stcw[0]->is_mfa==1) ? '' : "disabled = 'true'";
        $is_proficiency_in_medical_care_disabled = (isset($stcw[0]->is_proficiency_in_medical_care) && $stcw[0]->is_proficiency_in_medical_care==1) ? '' : "disabled = 'true'";
        $is_ship_security_officer_disabled = (isset($stcw[0]->is_ship_security_officer) && $stcw[0]->is_ship_security_officer==1) ? '' : "disabled = 'true'";
        $is_designated_security_duties_disabled = (isset($stcw[0]->is_designated_security_duties) && $stcw[0]->is_designated_security_duties==1) ? '' : "disabled = 'true'";
        

        // Offshore Documents
        /*$offshore = DB::select("SELECT * FROM offshore_certification_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_agt0_disabled = (isset($offshore[0]->is_agt0) && $offshore[0]->is_agt0==1) ? '' : "disabled = 'true'";
        $is_agt1_cbt_disabled = (isset($offshore[0]->is_agt1_cbt) && $offshore[0]->is_agt1_cbt==1) ? '' : "disabled = 'true'";
        $is_agt2_disabled = (isset($offshore[0]->is_agt2) && $offshore[0]->is_agt2==1) ? '' : "disabled = 'true'";
        $is_agt2_cbt_disabled = (isset($offshore[0]->is_agt2_cbt) && $offshore[0]->is_agt2_cbt==1) ? '' : "disabled = 'true'";
        $is_agt3_cbt_disabled = (isset($offshore[0]->is_agt3_cbt) && $offshore[0]->is_agt3_cbt==1) ? '' : "disabled = 'true'";
        $is_ama_errv_disabled = (isset($offshore[0]->is_ama_errv) && $offshore[0]->is_ama_errv==1) ? '' : "disabled = 'true'";
        $is_boat_disabled = (isset($offshore[0]->is_boat) && $offshore[0]->is_boat==1) ? '' : "disabled = 'true'";
        $is_boer_disabled = (isset($offshore[0]->is_boer) && $offshore[0]->is_boer==1) ? '' : "disabled = 'true'";
        $is_bosiet_ca_disabled = (isset($offshore[0]->is_bosiet_ca) && $offshore[0]->is_bosiet_ca==1) ? '' : "disabled = 'true'";
        $is_bosiet_disabled = (isset($offshore[0]->is_bosiet) && $offshore[0]->is_bosiet==1) ? '' : "disabled = 'true'";*/

        // YACHT Documents
        /*$yacht = DB::select("SELECT * FROM yacht_certification_docs where candidate_id="."'".$profileimg[0]->id."'");
        $is_advanced_powerboat_certificate_disabled = (isset($yacht[0]->is_advanced_powerboat_certificate) && $yacht[0]->is_advanced_powerboat_certificate==1) ? '' : "disabled = 'true'";
        $is_basic_sea_survival_certificate_disabled = (isset($yacht[0]->is_basic_sea_survival_certificate) && $yacht[0]->is_basic_sea_survival_certificate==1) ? '' : "disabled = 'true'";
        $is_csy_offshore_certificate_disabled = (isset($yacht[0]->is_csy_offshore_certificate) && $yacht[0]->is_csy_offshore_certificate==1) ? '' : "disabled = 'true'";
        $is_ds_certificate_competence_disabled = (isset($yacht[0]->is_ds_certificate_competence) && $yacht[0]->is_ds_certificate_competence==1) ? '' : "disabled = 'true'";
        $is_ds_shorebased_certificate_disabled = (isset($yacht[0]->is_ds_shorebased_certificate) && $yacht[0]->is_ds_shorebased_certificate==1) ? '' : "disabled = 'true'";
        $is_diesel_engine_disabled = (isset($yacht[0]->is_diesel_engine) && $yacht[0]->is_diesel_engine==1) ? '' : "disabled = 'true'";
        $is_diveboat_coxswain_disabled = (isset($yacht[0]->is_diveboat_coxswain) && $yacht[0]->is_diveboat_coxswain==1) ? '' : "disabled = 'true'";
        $is_diveboat_master_disabled = (isset($yacht[0]->is_diveboat_master) && $yacht[0]->is_diveboat_master==1) ? '' : "disabled = 'true'";
        $is_first_aid_disabled = (isset($yacht[0]->is_first_aid) && $yacht[0]->is_first_aid==1) ? '' : "disabled = 'true'";
        $is_international_pleasure_craft_certificatee_disabled = (isset($yacht[0]->is_international_pleasure_craft_certificatee) && $yacht[0]->is_international_pleasure_craft_certificatee==1) ? '' : "disabled = 'true'";*/
        
        $any_other_docs = DB::select("SELECT * FROM any_other_docs where candidate_id="."'".$profileimg[0]->id."' order by id asc");

        //$is_doc_name_disabled = (isset($any_other_docs[0]->is_doc_name) && $any_other_docs[0]->is_doc_name==1) ? '' : "disabled = 'true'";

        $return_tab = ['tab' => Session::get('return_tab') ];
        //unread msg
        $candidate_userid = DB::select("SELECT id,email,request_chat_id FROM users where email="."'".$email."' And usertype='candidate'");
        $count1 = DB::table('conversations')
                    ->where('status', '=', '0')
                    // ->where('from_id', '=', $candidate_userid[0]->id)
                    ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
        $count2 = DB::table('conversations')
                    ->where('status', '=', '0')
                    ->where('from_id', '=', $candidate_userid[0]->id)
                    // ->where('to_id', '=', $candidate_userid[0]->id)
                    ->count();
                   
        $conversationUnreadCount = (int)$count1+(int)$count2; 
        //end of unread msg
        return view('candidate.endorsementDocuments', compact(
            'profileimg', 
            'endors',
            'travel', 
            'medical',
            //'skill', 
            'personal',
            'coc',
            'stcw', 
            //'offshore',
            //'yacht',
            'any_other_docs',
            'return_tab',
            'conversationUnreadCount',

            //Endors docs
            'is_endors_name_dec_chemical_disabled',
            'is_endors_name_dec_gas_disabled',
            'is_endors_name_dec_others_disabled',
            'is_endors_name_dec_petroleum_disabled',
            'is_endors_name_others_disabled',

            //Travel docs
            'is_passport_disabled',
            'is_Seamans_book_cdc_disabled',
            'is_uk_work_permit_disabled',
            'is_uk_visa_disabled',
            'is_travel_others_disabled',

            //Medical docs
            'is_drug_alcohol_blood_test_disabled',
            'is_seafarers_medical_examination_disabled',
            'is_ukooa_medical_fitness_disabled',
            'is_yellow_fever_vaccination_disabled',
            'is_medical_others_disabled',

            //Skills & Training docs
            /*'is_arpa_disabled',
            'is_bbsp_disabled',
            'is_bl_disabled',
            'is_btm_disabled',
            'is_ctt_disabled',
            'is_ccow_disabled',
            'is_coc_disabled',
            'is_induction_disabled',
            'is_limited_disabled',
            'is_simulator_disabled',*/

            //Personal Docs
            'is_driver_license_disabled',
            'is_photograph_disabled',
            'is_resume_disabled',
            'is_personal_other_disabled',

            //coc related 
            'is_officers_incharge_navigational_unlimited_disabled',
            'is_master_unlimited_disabled',
            'is_chief_mate_unlimited_disabled',
            'is_masters_ships_lessthan_500gt_disabled',
            'is_officers_charge_navigational_less_500_disabled',
            'is_rating_forming_part_navigational_watch_disabled',
            'is_able_seafarer_deck_disabled',
            'is_officer_charge_engineering_watch_disabled',
            'is_chief_engineer_officer_disabled',
            'is_second_engineer_officer_disabled',
            'is_rating_formingpart_engineering_watch_disabled',
            'is_able_seafarer_engine_disabled',
            'is_cef_second_eo_ships_750_3000_disabled',
            'is_electro_technical_officer_disabled',
            'is_cook_coc_disabled',
            'is_gmdss_radio_operator_disabled',

            //STCW
            'is_basic_training_chemical_tc_operations_disabled',
            'is_advanced_tc_operations_disabled',
            'is_advanced_chemical_tc_operations_disabled',
            'is_bt_liquified_gas_tc_disabled',
            'is_at_for_liquified_gas_tc_disabled',
            'is_pst_disabled',
            'is_fpff_disabled',
            'is_efa_disabled',
            'is_pssr_disabled',
            'is_pscrb_disabled',
            'is_aff_disabled',
            'is_mfa_disabled',
            'is_proficiency_in_medical_care_disabled',
            'is_ship_security_officer_disabled',
            'is_designated_security_duties_disabled',
           

            //Offshore Docs
           /* 'is_agt0_disabled',
            'is_agt1_cbt_disabled',
            'is_agt2_disabled',
            'is_agt2_cbt_disabled',
            'is_agt3_cbt_disabled',
            'is_ama_errv_disabled',
            'is_boat_disabled',
            'is_boer_disabled',
            'is_bosiet_ca_disabled',
            'is_bosiet_disabled',*/

            //YACHT Docd
            /*'is_advanced_powerboat_certificate_disabled',
            'is_basic_sea_survival_certificate_disabled',
            'is_csy_offshore_certificate_disabled',
            'is_ds_certificate_competence_disabled',
            'is_ds_shorebased_certificate_disabled',
            'is_diesel_engine_disabled',
            'is_diveboat_coxswain_disabled',
            'is_diveboat_master_disabled',
            'is_first_aid_disabled',
            'is_international_pleasure_craft_certificatee_disabled',*/

            //Other Docs
            //'is_doc_name_disabled'
             ));

    }

    public function endorsDocsSubmit(Request $request){
        $endorments = $request->post();
     
        foreach ($endorments as $k=>$v) {
            unset($endorments['_token']);
            unset($endorments['endorse_table_length']);
            unset($endorments['endors_dec_chemical_require']);
            unset($endorments['endors_dec_gas_require']);
            unset($endorments['endors_dec_others_require']);
            unset($endorments['endors_dec_petroleum_require']);
            unset($endorments['endors_others_require']);

            if($k=='endors_dec_chemical_dt' && isset($endorments['endors_dec_chemical_dt'])){
                $dateInput = explode('/',$endorments['endors_dec_chemical_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $endorments[$k] = $dec_chemical;
            }
            if($k=='endors_dec_gas_dt' && isset($endorments['endors_dec_gas_dt'])){
                $dateInput = explode('/',$endorments['endors_dec_gas_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $endorments[$k] = $dec_gas;
            }
            if($k=='endors_dec_others_dt' && isset($endorments['endors_dec_others_dt'])){
                $dateInput = explode('/',$endorments['endors_dec_others_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $endorments[$k] = $dec_others;
            }

            if($k=='endors_dec_petroleum_dt' && isset($endorments['endors_dec_petroleum_dt'])){
                $dateInput = explode('/',$endorments['endors_dec_petroleum_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $endorments[$k] = $dec_petroleum;
            }

            if($k=='endors_others_dt' && isset($endorments['endors_others_dt'])){
                $dateInput = explode('/',$endorments['endors_others_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $endorments[$k] = $endors_others_dt;
            }
            $endorments['endorse_filled_docs'] = 1;
        }
        $candidate_id = $endorments['candidate_id'];        
        $endorseCount = DB::table('endorments_docs')
            ->select('*')
            ->where([
                'candidate_id'=> $candidate_id,                
                ])
            ->count();
            
        // echo "<pre>";
        // print_r($endorments);
        // exit;
        $delete = DB::table('endorments_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        
        $endorse = DB::table('endorments_docs')->insert($endorments);    
        
        if($endorse){
            Session::put('return_tab', 'endorse_tab');            
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s Endorsements details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in Endorsements details updated');
        }
    }
    //travel docs 
    public function travelDocsSubmit(Request $request){
        $travelDocs = $request->post();
         // echo "<pre>";
        // print_r($travelDocs);
        // exit;
        
        foreach ($travelDocs as $k=>$v) {
            unset($travelDocs['_token']);
            unset($travelDocs['traveldoc_table_length']);
            unset($travelDocs['passport_dt_require']);
            unset($travelDocs['Seamans_book_cdc_require']);
            unset($travelDocs['uk_work_permit_require']);
            unset($travelDocs['us_visa_require']);
            // unset($travelDocs['No4']);
            // unset($travelDocs['No5']);
            if($k=='passport_dt' && isset($travelDocs['passport_dt'])){
                $dateInput = explode('/',$travelDocs['passport_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $travelDocs[$k] = $dec_chemical;  
            }
            if($k=='Seamans_book_cdc_dt' && isset($travelDocs['Seamans_book_cdc_dt'])){
                $dateInput = explode('/',$travelDocs['Seamans_book_cdc_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $travelDocs[$k] = $dec_others;  
            }
            if($k=='uk_work_permit_dt' && isset($travelDocs['uk_work_permit_dt'])){
                $dateInput = explode('/',$travelDocs['uk_work_permit_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $travelDocs[$k] = $dec_gas;  
            }            

            if($k=='us_visa_dt' && isset($travelDocs['us_visa_dt'])){
                $dateInput = explode('/',$travelDocs['us_visa_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $travelDocs[$k] = $dec_petroleum;  
            }

            if($k=='others_dt' && isset($travelDocs['others_dt'])){
                $dateInput = explode('/',$travelDocs['others_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $travelDocs[$k] = $endors_others_dt;  
            }
            $travelDocs['travel_filled_docs'] = 1;  
            unset($travelDocs['clouds']);
        }
        $candidate_id = $travelDocs['candidate_id'];
        
        
        $travelCount = DB::table('travel_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        // var_dump($travelCount);
        // exit;

       // echo "<pre>";
       //  print_r($travelDocs);
       //  exit;
        
        // if($travelCount>0){
            $candidate_id = $travelDocs['candidate_id'];
            $delete = DB::table('travel_docs')->where(['candidate_id'=> $candidate_id])->delete();
        // }else{
            $travel_docs = DB::table('travel_docs')->insert($travelDocs);
        // }
        //  echo "<pre>";
        // print_r($travel_docs);
        // exit;
        if($travel_docs){
            Session::put('return_tab', 'travel_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s travel document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in travel document details updated');
        }
    }

    //medical docs 
    public function medicalDocsSubmit(Request $request){
        $medicalDocs = $request->post();
        // echo "<pre>";
        // print_r($medicalDocs);
        // exit;
        foreach ($medicalDocs as $k=>$v) {
            unset($medicalDocs['_token']);
            unset($medicalDocs['medicaldoc_table_length']);
            unset($medicalDocs['drug_alcoloh_test_require']);
            unset($medicalDocs['Seafarer_mediexa_require_require']);
            unset($medicalDocs['ukooa_medical_fitness_require']);
            unset($medicalDocs['yellow_fever_vaccination_require']);
            
            if($k=='drug_alcohol_blood_test_dt' && isset($medicalDocs['drug_alcohol_blood_test_dt'])){
                $dateInput = explode('/',$medicalDocs['drug_alcohol_blood_test_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $medicalDocs[$k] = $dec_chemical;  
            }
            if($k=='seafarers_medical_examination_dt' && isset($medicalDocs['seafarers_medical_examination_dt'])){
                $dateInput = explode('/',$medicalDocs['seafarers_medical_examination_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $medicalDocs[$k] = $dec_others;  
            }
            if($k=='ukooa_medical_fitness_dt' && isset($medicalDocs['ukooa_medical_fitness_dt'])){
                $dateInput = explode('/',$medicalDocs['ukooa_medical_fitness_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $medicalDocs[$k] = $dec_gas;  
            }            

            if($k=='yellow_fever_vaccination_dt' && isset($medicalDocs['yellow_fever_vaccination_dt'])){
                $dateInput = explode('/',$medicalDocs['yellow_fever_vaccination_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $medicalDocs[$k] = $dec_petroleum;  
            }

            if($k=='medical_others_dt' && isset($medicalDocs['medical_others_dt'])){
                $dateInput = explode('/',$medicalDocs['medical_others_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $medicalDocs[$k] = $endors_others_dt;  
            }
            $medicalDocs['medical_filled_docs'] = 1;
        }
        $candidate_id = $medicalDocs['candidate_id'];
        // echo "<pre>";
        // print_r($medicalDocs);
        // exit;
        $medicalCount = DB::table('medical_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        // var_dump($travelCount);
        // exit;

        // if($travelCount>0){
            $candidate_id = $medicalDocs['candidate_id'];
            $delete = DB::table('medical_docs')->where(['candidate_id'=> $candidate_id])->delete();
        // }else{
            $data[] = $medicalDocs;
            $medical_docs = DB::table('medical_docs')->insert($data);
        // }
        //  echo "<pre>";
        // print_r($travel_docs);
        // exit;
        if($medical_docs){
            Session::put('return_tab', 'medical_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s medical document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in medical document details updated');
        }
    }


    //skilTraining docs 
    public function skilTrainingDocsSubmit(Request $request){
        $skillDocss = $request->post();
        // echo "<pre>";
        // print_r($skillDocss);
        // exit;
        foreach ($skillDocss as $k=>$v) {
            unset($skillDocss['_token']);
            unset($skillDocss['skill_trainingdoc_table_length']);
            unset($skillDocss['arpa_require']);
            unset($skillDocss['behaviour_safety_process_require']);
            unset($skillDocss['boatmaster_license_require']);
            unset($skillDocss['bridge_team_management_require']);
            unset($skillDocss['chemical_tankertraining_require']);
            unset($skillDocss['cows_crudeoil_washing_require']);
            unset($skillDocss['crane_operator_certificate_require']);
            unset($skillDocss['dp_induction_require']);
            unset($skillDocss['dp_simulator_require']);
            unset($skillDocss['dp_limited_require']);
            
            
            if($k=='arpa_dt' && isset($skillDocss['arpa_dt'])){
                $dateInput = explode('/',$skillDocss['arpa_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $dec_chemical;  
            }
            if($k=='behaviour_safety_process_dt'  && isset($skillDocss['behaviour_safety_process_dt'])){
                $dateInput = explode('/',$skillDocss['behaviour_safety_process_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $dec_others;  
            }
            if($k=='boatmaster_license_dt'  && isset($skillDocss['boatmaster_license_dt'])){
                $dateInput = explode('/',$skillDocss['boatmaster_license_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $dec_gas;  
            }            

            if($k=='bridge_team_management_dt'  && isset($skillDocss['bridge_team_management_dt'])){
                $dateInput = explode('/',$skillDocss['bridge_team_management_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $dec_petroleum;  
            }

            if($k=='chemical_tankertraining_dt'  && isset($skillDocss['chemical_tankertraining_dt'])){
                $dateInput = explode('/',$skillDocss['chemical_tankertraining_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }

            if($k=='cows_crudeoil_washing_dt'  && isset($skillDocss['cows_crudeoil_washing_dt'])){
                $dateInput = explode('/',$skillDocss['cows_crudeoil_washing_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }

            if($k=='crane_operator_certificate_dt' && isset($skillDocss['crane_operator_certificate_dt'])){
                $dateInput = explode('/',$skillDocss['crane_operator_certificate_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }
            if($k=='dp_induction_dt'  && isset($skillDocss['dp_induction_dt'])){
                $dateInput = explode('/',$skillDocss['dp_induction_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }
            if($k=='dp_limited_dt' && isset($skillDocss['dp_limited_dt'])){
                $dateInput = explode('/',$skillDocss['dp_limited_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }
            if($k=='dp_simulator_dt' && isset($skillDocss['dp_simulator_dt'])){
                $dateInput = explode('/',$skillDocss['dp_simulator_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }
            if($k=='dp_full_dt' && isset($skillDocss['dp_full_dt'])){
                $dateInput = explode('/',$skillDocss['dp_full_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;  
            }
            if($k=='dp_maintenance_dt' && isset($skillDocss['dp_maintenance_dt'])){
                $dateInput = explode('/',$skillDocss['dp_maintenance_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $skillDocss[$k] = $endors_others_dt;
            }
            $skillDocss['skill_filled_docs'] = 1; 
        }
        $candidate_id = $skillDocss['candidate_id'];
        // echo "<pre>";
        // print_r($skillDocss);
        // exit;
        $skillCount = DB::table('skills_training_certificates')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        
        $candidate_id = $skillDocss['candidate_id'];
        $delete = DB::table('skills_training_certificates')->where(['candidate_id'=> $candidate_id])->delete();
        
        $data[] = $skillDocss;
        $skill_docs = DB::table('skills_training_certificates')->insert($data);
        
        if($skill_docs){
            Session::put('return_tab', 'skill_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s skills and training document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in skills and training document details updated');
        }
    }

    //personal docs 
    public function personalDocsSubmit(Request $request){
        $personal = $request->post();
        // echo "<pre>";
        // print_r($personal);
        // exit;
        foreach ($personal as $k=>$v) {
            unset($personal['_token']);            
            unset($personal['personaldoc_table_length']);
            unset($personal['driver_license_require']);
            unset($personal['photograph_require']);
            unset($personal['resume_require']);
            unset($personal['personal_other_docs_require']);
            
            
            if($k=='driver_license_dt' && isset($personal['driver_license_dt'])){
                $dateInput = explode('/',$personal['driver_license_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $personal[$k] = $dec_chemical;  
            }
            // else if(!isset($personal['driver_license_dt'])){
            //     $personal[$k] = null;
            // }
            if($k=='photograph_dt'  && isset($personal['photograph_dt'])){
                $dateInput = explode('/',$personal['photograph_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $personal[$k] = $dec_others;  
            }
            
            if($k=='resume_dt'  && isset($personal['resume_dt'])){
                $dateInput = explode('/',$personal['resume_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $personal[$k] = $dec_gas;  
            }
            
            if($k=='personal_other_docs_dt'  && isset($personal['personal_other_docs_dt'])){
                $dateInput = explode('/',$personal['personal_other_docs_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $personal[$k] = $dec_petroleum;
            }
            $personal['personal_filled_docs'] = 1;
        }
        $candidate_id = $personal['candidate_id'];
        // echo "Afetr null<pre>";
        // print_r($personal);
        // exit;
        $skillCount = DB::table('personal_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        
        $candidate_id = $personal['candidate_id'];
        $delete = DB::table('personal_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        $data[] = $personal;
        $personal_docs = DB::table('personal_docs')->insert($data);
        
        if($personal_docs){
            Session::put('return_tab', 'personal_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s Personal document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in Personal document details updated');
        }
    }

    //coc Data
    public function cocDocsSubmit(Request $request){
        $coc = $request->post();
        // echo "<pre>";
        // print_r($coc);
        // exit;
        foreach ($coc as $k=>$v) {
            unset($coc['_token']);            
            unset($coc['coc_doc_table_length']);
            unset($coc['officers_incharge_navigational_unlimited_require']);
            unset($coc['master_unlimited_require']);
            unset($coc['chief_mate_unlimited_require']);
            unset($coc['masters_ships_lessthan_500gt_require']);
            unset($coc['officers_charge_navigational_less_500_require']);
            unset($coc['rating_forming_part_navigational_watch_require']);
            unset($coc['able_seafarer_deck_require']);
            unset($coc['officer_charge_engineering_watch_require']);
            unset($coc['chief_engineer_officer_require']);
            unset($coc['second_engineer_officer_require']);

            if($k=='officers_incharge_navigational_unlimited_dt' && isset($coc['officers_incharge_navigational_unlimited_dt'])){
                $dateInput = explode('/',$coc['officers_incharge_navigational_unlimited_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_chemical;    
                 
            }else if($k=='master_unlimited_dt' && isset($coc['master_unlimited_dt'])){
                $dateInput = explode('/',$coc['master_unlimited_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_chemical;   
            }else if($k=='chief_mate_unlimited_dt' && isset($coc['master_unlimited_dt'])){
                $dateInput = explode('/',$coc['chief_mate_unlimited_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_others;  
            }else if($k=='masters_ships_lessthan_500gt_dt' && isset($coc['masters_ships_lessthan_500gt_dt'])){
                $dateInput = explode('/',$coc['masters_ships_lessthan_500gt_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_gas;  
            }else if($k=='officers_charge_navigational_less_500_dt' && isset($coc['officers_charge_navigational_less_500_dt'])){
                $dateInput = explode('/',$coc['officers_charge_navigational_less_500_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }else if($k=='rating_forming_part_navigational_watch_dt' && isset($coc['rating_forming_part_navigational_watch_dt'])){
                $dateInput = explode('/',$coc['rating_forming_part_navigational_watch_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }else if($k=='able_seafarer_deck_dt' && isset($coc['able_seafarer_deck_dt'])){
                $dateInput = explode('/',$coc['able_seafarer_deck_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }else if($k=='officer_charge_engineering_watch_dt' && isset($coc['officer_charge_engineering_watch_dt'])){
                $dateInput = explode('/',$coc['officer_charge_engineering_watch_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }else if($k=='chief_engineer_officer_dt' && isset($coc['chief_engineer_officer_dt'])){
                $dateInput = explode('/',$coc['chief_engineer_officer_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }else if($k=='second_engineer_officer_dt' && isset($coc['second_engineer_officer_dt'])){
                $dateInput = explode('/',$coc['second_engineer_officer_dt']);
                $dec_petroleum = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $coc[$k] = $dec_petroleum;  
            }

            $coc['coc_filled_docs'] = 1;  
        }

            // echo "<pre>";
            // print_r($coc);
            // exit;
        $candidate_id = $coc['candidate_id'];
        
        $skillCount = DB::table('coc_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        
        $candidate_id = $coc['candidate_id'];
        $delete = DB::table('coc_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        $data[] = $coc;
            // echo "<pre>";
            // print_r($data);
            // exit;
        $coc_docs = DB::table('coc_docs')->insert($coc);
        
        if($coc_docs){
            Session::put('return_tab', 'coc_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s COC certificate document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in COC certificate document details updated');
        }
    }


    //stcw docs 
    public function stcwDocsSubmit(Request $request){
        $stcw = $request->post();
        // echo "<pre>";
        // print_r($stcw);
        // exit;
        foreach ($stcw as $k=>$v) {
            unset($stcw['_token']);            
            unset($stcw['stcw_doc_table_length']);
            unset($stcw['basic_training_chemical_tc_operations_require']);
            unset($stcw['advanced_tc_operations_require']);
            unset($stcw['advanced_chemical_tc_operations_require']);
            unset($stcw['bt_liquified_gas_tc_require']);
            unset($stcw['at_for_liquified_gas_tc_require']);
            unset($stcw['safety_training_for_personnel_providing_ds_require']);
            unset($stcw['crisis_mgt_human_behaviour_training_require']);
            unset($stcw['crowd_mgt_training_require']);
            unset($stcw['passenger_cargo_passenger_cargo_hull_integrity_training_require']);
            unset($stcw['basic_safety_tc_require']);

            if($k=='basic_training_chemical_tc_operations_dt' && isset($stcw['basic_training_chemical_tc_operations_dt'])){
                $dateInput = explode('/',$stcw['basic_training_chemical_tc_operations_dt']);
                $data1 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data1;  
            }
            if($k=='advanced_tc_operations_dt' && isset($stcw['advanced_tc_operations_dt'])){
                $dateInput = explode('/',$stcw['advanced_tc_operations_dt']);
                $data2 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data2;  
            }
            
            if($k=='advanced_chemical_tc_operations_dt' && isset($stcw['advanced_chemical_tc_operations_dt'])){
                $dateInput = explode('/',$stcw['advanced_chemical_tc_operations_dt']);
                $data2 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data2;  
            }
            if($k=='bt_liquified_gas_tc_dt' && isset($stcw['bt_liquified_gas_tc_dt'])){
                $dateInput = explode('/',$stcw['bt_liquified_gas_tc_dt']);
                $data3 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data3;  
            }            

            if($k=='at_for_liquified_gas_tc_dt' && isset($stcw['at_for_liquified_gas_tc_dt'])){
                $dateInput = explode('/',$stcw['at_for_liquified_gas_tc_dt']);
                $data4 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data4;  
            }
            if($k=='crowd_mgt_training_dt' && isset($stcw['crowd_mgt_training_dt'])){
                $dateInput = explode('/',$stcw['crowd_mgt_training_dt']);
                $data5 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data5;  
            }

            if($k=='safety_training_for_personnel_providing_ds_dt' && isset($stcw['safety_training_for_personnel_providing_ds_dt'])){
                $dateInput = explode('/',$stcw['safety_training_for_personnel_providing_ds_dt']);
                $data5 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data5;  
            }
            
            if($k=='crisis_mgt_human_behaviour_training_dt' && isset($stcw['crisis_mgt_human_behaviour_training_dt'])){
                $dateInput = explode('/',$stcw['crisis_mgt_human_behaviour_training_dt']);
                $data6 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data6;  
            }

            if($k=='passenger_cargo_hull_integrity_training_dt' && isset($stcw['passenger_cargo_hull_integrity_training_dt'])){
                $dateInput = explode('/',$stcw['passenger_cargo_hull_integrity_training_dt']);
                $data7 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data7; 
            }
            if($k=='basic_safety_tc_dt' && isset($stcw['basic_safety_tc_dt'])){
                $dateInput = explode('/',$stcw['basic_safety_tc_dt']);
                $data8 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $stcw[$k] = $data8;  
            }
            $stcw['stcw_filled_docs'] = 1;
        }
        $candidate_id = $stcw['candidate_id'];
        // echo "<pre>";
        // print_r($stcw);
        // exit;
        $stcwCount = DB::table('stcw_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        
        $candidate_id = $stcw['candidate_id'];
        $delete = DB::table('stcw_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        $data[] = $stcw;
        $stcw_docs = DB::table('stcw_docs')->insert($data);
        $stcw_tab = ['stcw_tab' => 'stcw_tab'];
        if($stcw_docs){
            Session::put('return_tab', 'stcw_tab');
            return redirect()->route('endorsment.docs')->with(['success', 'Candidate’s skills and training document details updated.' ]);    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in skills and training document details updated');
        }
    }

    //offshore docs 
    public function OffshoreDocsSubmit(Request $request){
        $offshoreDocs = $request->post();
        // echo "<pre>";
        // print_r($offshoreDocs);
        // exit;
        foreach ($offshoreDocs as $k=>$v) {
            unset($offshoreDocs['_token']);
            unset($offshoreDocs['offshore_doc_table_length']);
            unset($offshoreDocs['agt0_dt_require']);
            unset($offshoreDocs['agtl1_cbt_require']);
            unset($offshoreDocs['agt2_require']);
            unset($offshoreDocs['agt2_cbt_require']);
            unset($offshoreDocs['agt3_cbt_require']);
            unset($offshoreDocs['ama_errv_crew_advanced_medical_aid_require']);
            unset($offshoreDocs['boat_travel_safely_by_boat_require']);
            unset($offshoreDocs['boer_basic_onshore_emergency_response_require']);
            unset($offshoreDocs['bosiet_with_ca_ebs_require']);
            unset($offshoreDocs['bosiet_require']);
            //  && isset($offshoreDocs[''])
            if($k=='agt0_dt' && isset($offshoreDocs['agt0_dt'])){
                $dateInput = explode('/',$offshoreDocs['agt0_dt']);
                $data1 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $data1;  
            }
            if($k=='agtl1_cbt_dt' && isset($offshoreDocs['agtl1_cbt_dt'])){
                $dateInput = explode('/',$offshoreDocs['agtl1_cbt_dt']);
                $data2 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $data2;  
            }
            if($k=='agt2_dt' && isset($offshoreDocs['agt2_dt'])){
                $dateInput = explode('/',$offshoreDocs['agt2_dt']);
                $data3 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $data3;  
            }            

            if($k=='agt2_cbt_dt' && isset($offshoreDocs['agt2_cbt_dt'])){
                $dateInput = explode('/',$offshoreDocs['agt2_cbt_dt']);
                $data4 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $data4;  
            }

            if($k=='agt3_cbt_dt'  && isset($offshoreDocs['agt3_cbt_dt'])){
                $dateInput = explode('/',$offshoreDocs['agt3_cbt_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            }
            if($k=='ama_errv_crew_advanced_medical_aid_dt'  && isset($offshoreDocs['ama_errv_crew_advanced_medical_aid_dt'])){
                $dateInput = explode('/',$offshoreDocs['ama_errv_crew_advanced_medical_aid_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            } 
            if($k=='boat_travel_safely_by_boat_dt'  && isset($offshoreDocs['boat_travel_safely_by_boat_dt'])){
                $dateInput = explode('/',$offshoreDocs['boat_travel_safely_by_boat_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            } 
            if($k=='boer_basic_onshore_emergency_response_dt'  && isset($offshoreDocs['boer_basic_onshore_emergency_response_dt'])){
                $dateInput = explode('/',$offshoreDocs['boer_basic_onshore_emergency_response_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            }
            if($k=='bosiet_with_ca_ebs_dt'  && isset($offshoreDocs['bosiet_with_ca_ebs_dt'])){
                $dateInput = explode('/',$offshoreDocs['bosiet_with_ca_ebs_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            }  
            if($k=='bosiet_dt'  && isset($offshoreDocs['bosiet_dt'])){
                $dateInput = explode('/',$offshoreDocs['bosiet_dt']);
                $endors_others_dt = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $offshoreDocs[$k] = $endors_others_dt;  
            }        
            $offshoreDocs['offshore_filled_docs'] = 1;
        }
        $candidate_id = $offshoreDocs['candidate_id'];
        // echo "<pre>";
        // print_r($offshoreDocs);
        // exit;
        $offshoreCount = DB::table('offshore_certification_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        $candidate_id = $offshoreDocs['candidate_id'];
        $delete = DB::table('offshore_certification_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        $data[] = $offshoreDocs;
        $offshore_docs = DB::table('offshore_certification_docs')->insert($data);
        
        if($offshore_docs){
            Session::put('return_tab', 'offshore_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s offshore document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in offshore document details updated');
        }
    }

    //Yacht docs 
    public function yachtDocsSubmit(Request $request){
        $yacht = $request->post();
        // echo "<pre>";
        // print_r($yacht);
        // exit;
        foreach ($yacht as $k=>$v) {
            unset($yacht['_token']);            
            unset($yacht['yacht_doc_table_length']);
            unset($yacht['advanced_powerboat_certificate_require']);
            unset($yacht['basic_sea_survival_certificate_require']);
            unset($yacht['csy_offshore_certificate_require']);
            unset($yacht['ds_certificate_competence_require']);
            unset($yacht['ds_shorebased_certificate_require']);
            unset($yacht['diesel_engine_require']);
            unset($yacht['diveboat_coxswain_require']);
            unset($yacht['diveboat_master_require']);
            unset($yacht['first_aid_require']);
            unset($yacht['international_pleasure_craft_certificate_require']);
            //&& isset($yacht[''])
            if($k=='advanced_powerboat_certificate_dt' && isset($yacht['advanced_powerboat_certificate_dt'])){                
                $dateInput = explode('/',$yacht['advanced_powerboat_certificate_dt']);
                $data1 = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];                
                $yacht[$k] = $data1;  
            }
            if($k=='basic_sea_survival_certificate_dt' && isset($yacht['basic_sea_survival_certificate_dt'])){
                $dateInput = explode('/',$yacht['basic_sea_survival_certificate_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $dec_others;  
            }
            if($k=='csy_offshore_certificate_dt' && isset($yacht['csy_offshore_certificate_dt'])){
                $dateInput = explode('/',$yacht['csy_offshore_certificate_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $dec_gas;  
            }            

            if($k=='ds_certificate_competence_dt' && isset($yacht['ds_certificate_competence_dt'])){
                $dateInput = explode('/',$yacht['ds_certificate_competence_dt']);
                $data = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $data;  
            }
            if($k=='ds_shorebased_certificate_dt' && isset($yacht['ds_shorebased_certificate_dt'])){
                $dateInput = explode('/',$yacht['ds_shorebased_certificate_dt']);
                $data = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $data;  
            }
            if($k=='diesel_engine_dt' && isset($yacht['diesel_engine_dt'])){
                $dateInput = explode('/',$yacht['diesel_engine_dt']);
                $dec_chemical = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $dec_chemical;  
            }
            if($k=='diveboat_coxswain_dt' && isset($yacht['diveboat_coxswain_dt'])){
                $dateInput = explode('/',$yacht['diveboat_coxswain_dt']);
                $dec_others = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $dec_others;  
            }
            if($k=='diveboat_master_dt' && isset($yacht['diveboat_master_dt'])){
                $dateInput = explode('/',$yacht['diveboat_master_dt']);
                $dec_gas = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $dec_gas;  
            }            

            if($k=='first_aid_dt' && isset($yacht['first_aid_dt'])){
                $dateInput = explode('/',$yacht['first_aid_dt']);
                $data = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $data;  
            }
            if($k=='international_pleasure_craft_certificate_dt' && 
                isset($yacht['international_pleasure_craft_certificate_dt']))
            {
                $dateInput = explode('/',$yacht['international_pleasure_craft_certificate_dt']);
                $data = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $yacht[$k] = $data;
            }
            $yacht['yatch_filled_docs'] = 1;
        }
        $candidate_id = $yacht['candidate_id'];
        // echo "<pre>";
        // print_r($yacht);
        // exit;
        $skillCount = DB::table('yacht_certification_docs')->select('*')->where(['candidate_id'=> $candidate_id])->count();
        
        $candidate_id = $yacht['candidate_id'];
        $delete = DB::table('yacht_certification_docs')->where(['candidate_id'=> $candidate_id])->delete();
        
        // $data[] = $yacht;
        $yacht_docs = DB::table('yacht_certification_docs')->insert($yacht);
        
        if($yacht_docs){

            DB::table('candidates')->where(['id'=> $candidate_id])->update([ 'docs_uploaded' => 1 ]);

            Session::put('return_tab', 'yacht_tab');
            return redirect()->route('endorsment.docs')->with('success', 'Candidate’s yacht document details updated.');    
        }else{
            return redirect()->route('endorsment.docs')->with('error', 'Error in yacht document details updated');
        }
    }

    
    //anyOther docs 
    public function anyOtherDocsSubmit(Request $request){
        $anyOtherDocs = $request->post();

        $counter_val = ($anyOtherDocs['counter_val'] && $anyOtherDocs['counter_val']!=0) ? $anyOtherDocs['counter_val'] : 1;
        $candidate_id = $anyOtherDocs['candidate_id'];
       
        if(!empty($anyOtherDocs)){
            unset($anyOtherDocs['_token']);
            unset($anyOtherDocs['counter_val']);

            $delete = DB::table('any_other_docs')->where(['candidate_id'=> $candidate_id])->delete();

            for ($i=1; $i <= $counter_val ; $i++) { 
               if(isset($anyOtherDocs['doc_name_'.$i]) && isset($anyOtherDocs['is_doc_name_'.$i])){
                    $otherDocs = array();
                    $otherDocs['candidate_id'] = $candidate_id;
                    $otherDocs['doc_name'] = $anyOtherDocs['doc_name_'.$i];
                    $otherDocs['is_doc_name'] = $anyOtherDocs['is_doc_name_'.$i];
                    $otherDocs['doc_name_status'] = (isset($anyOtherDocs['doc_name_status_'.$i])) ? $anyOtherDocs['doc_name_status_'.$i] : 'no';

                    $anyOther_docs = DB::table('any_other_docs')->insert($otherDocs);
                }                               
                
            }
        }
              
        Session::put('return_tab', 'any_other_tab');
        return redirect()->route('endorsment.docs')->with('success', 'Candidate’s Other document details updated.');    
       
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
