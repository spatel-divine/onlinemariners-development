<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use App\Models\Candidate;
use DB;
use File;
use Hash;

class ManageCandidateController extends Controller
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
        //$candidates = DB::table('candidates')->where('candidate_status', 1)->orderBy('id', 'DESC')->get();
    	$candidates = DB::table('candidates')->orderBy('id', 'DESC')->get();
    	
        return view('admin.candidate.candidateListing')->with([
            'user' => $users,
            'candidates' => $candidates
        ]);
    }

    // deleteCandidate
    public function deleteCandidate(Request $request)
    {
        try {
            $candidateID = $request->input('candidate_id');                
            if($candidateID){

                DB::beginTransaction();

                $employerDelete = DB::table('conversations')->where('from_id',$candidateID)->delete();
                $employerDelete = DB::table('conversations')->where('to_id',$candidateID)->delete();
                $jobApplyDelete = DB::table('jobs_apply')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('messages')->where('from',$candidateID)->delete();
                $employerDelete = DB::table('messages')->where('to',$candidateID)->delete();
                $employerDelete = DB::table('coc_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('medical_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('offshore_certification_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('personal_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('skills_training_certificates')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('stcw_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('travel_docs')->where('candidate_id',$candidateID)->delete();
                $employerDelete = DB::table('yacht_certification_docs')->where('candidate_id',$candidateID)->delete();

                $candidateDelete = DB::table('candidates')->where('id',$candidateID)->delete();
                $UserDelete = DB::table('users')->where('request_chat_id',$candidateID)->delete();

                DB::commit();

            }
            return redirect()->route('candidate.listing')->with('success', 'Candidate deleted successfully.');

         } catch (\Exception $exception) {
                
            DB::rollback();

            // Return error
            return redirect()->route('candidate.listing')->with('error', 'Something went wrong, Please try again');
        }  
    }

    //editCandidate
    public function editCandidate(Request $request){
        // echo "<pre>";
        // print_r($request->input('candidate_id'));
        // exit;
        $candidate_id = $request->input('candidate_id');
        $candidate = DB::table('candidates')->where('id', $candidate_id)->get();
        $userid = Session::get('userid');
        $users = User::where('id', '=', $userid)->first();
        return view('admin.candidate.editCandidate')->with([ 'user' => $users, 'candidate' => $candidate ]);
    }

    //updateCandidate
    public function updateCandidate(Request $request, $id){
        // echo $id.'<br>';

        $results = $request->input();
        $candidate = Candidate::where('id', $id)->first();

        //----------------------profile-----------------------------------------------------
        if($request->hasFile('profile_path')){
            $files=$request->file('profile_path');
            $path = public_path() . '/profile/';
            
            $profile_file = time().'.'.$request->file('profile_path')->getClientOriginalExtension();

            
            $files->move($path,$profile_file);
            $oldfile = url('/public/profile/'.$candidate['profile_path']);
            //delete old file
            File::delete($path.$candidate['profile_path']);
            // unset($oldfile);
        }else{
            $profile_file = $candidate['profile_path'];
        }

        $resume_file = '';
        //----------------------Resume----------------------------------------------------------
        if($filescv = $request->file('resume_file')){  
            // $filePath = public_path() . '/resume/';
            // $resume_file = $filescv->getClientOriginalName();  //name
            $resume_file = time().'.'.$request->file('resume_file')->getClientOriginalExtension();
            // echo $resume_file.'<br>';
            $dpath = public_path().'/resume/';
            $request->file('resume_file')->move($dpath, $resume_file);
            //delete old file
            File::delete($dpath.$candidate['resume_file']);
        }

        foreach($results as $k=>$v){
            unset($results['id']);
            unset($results['_token']);
            unset($results['old_pic_path']);

            echo $results['dob'].'<br>';
            
            if($k=='dob'){
                $dateInput = explode('-',$results['dob']);
                
                $dob = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $results[$k] = $dob;  
            }
            
            
            $results['profile_path'] = $profile_file;
            $results['resume_file'] = $resume_file;
            $results['candidate_status'] = "1";
            // $results['updated_at'] = (string)(date('Y-m-d H:i:s'));
        }

        //update Candidate
        $candidateProfileUpdate = DB::table('candidates')->where('id', $id)->update($results);

        if ($candidateProfileUpdate) {
            return redirect()->route('candidate.listing')->with('success', 'Candidate profile updated successfully.');
        } else {
            return redirect()->route('editCandidate')->with('Error', 'Candidate profile not updated.');
        }
        exit;
    }


    //CandidateFormLoad
    public function CandidateFormLoad()
    {
        $countryList = DB::select('SELECT countryname FROM country ORDER BY countryname ASC');

        return view('admin.candidate.addCandidate')->with(['countryList' => $countryList]);
    }

    //addCandidate
    public function addCandidate(Request $request)
    {
        // echo "<pre>";
        // print_r($request->file('profile_path'));
        // print_r($request->file('resume_file'));
        // print_r($request->input());
        // exit;
        $results = $request->input();
        // echo "<pre>";        
       //  print_r($request->all());
        // exit;

        $messages = [
            'profile_path.required'=> 'Profile image is required.', // custom message
            'competency_certificate.required' => 'Competency certificate is required.',
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
            'regex' => ':attribute must be 10 digits long for examle 1234567890'
        ];
        $this->validate($request,
            [
            'country_code' => 'required',
            'phone_number' => 'required|integer|regex:/^[0-9]{10}$/',
            'nationality' => 'required',
            'dob' => 'required|date',
            'applied_for' => 'required',
            'experience_years' => 'required|integer',
            'experience_months' => 'required|integer',
            'availablefrom' => 'required|date',
            'competency_certificate' => 'required',
            'last_vassel_served' => 'required',
            'resume_file' => 'required|mimes:pdf,doc,docx,jpg,jpeg|max:2048',
            'profile_path' =>  'required|mimes:jpg,jpeg,png,svg|max:2048',
            ], $messages); 


        //profile Pic 
        if($request->hasFile('profile_path')){
            $files=$request->file('profile_path');
            $path = public_path() . '/profile/';
            // $profile_file = $request->file('profile_pic')->getClientOriginalName();  //name
            $profile_file = time().'.'.$request->file('profile_path')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('profile_pic')->getClientOriginalName();;
            $files->move($path,$profile_file);
            // echo $oldfile = url('/public/profile/'.$candidate['profile_path']);
            //delete old file
            // File::delete($path.$candidate['profile_path']);
            // unset($oldfile);
        }
        ////////////////
        //Resume / CV //
        $resume_file = '';
        if($filescv = $request->file('resume_file')){  
            // $filePath = public_path() . '/resume/';
            // $resume_file = $filescv->getClientOriginalName();  //name
            $resume_file = time().'.'.$request->file('resume_file')->getClientOriginalExtension();
            // echo $resume_file.'<br>';
            $dpath = public_path().'/resume/';
            $request->file('resume_file')->move($dpath, $resume_file);
            //delete old file
            // File::delete($dpath.$candidate['resume_file']);
        }
        $dateInput2 = explode('-',$results['availablefrom']);
         // echo "<pre>";        
        // print_r($dateInput2);
        // $availablefrom = $dateInput2[2].'-'.$dateInput2[0].'-'.$dateInput2[1];
        // print_r($availablefrom);        
        // exit;
        foreach($results as $k=>$v){
            unset($results['_token']);
            unset($results['update_candidate']);
            if($k == 'phone_number'){
                $results['phone_number'] = $results['country_code'].'-'.$results['phone_number'];
                unset($results['country_code']);
            }
            if($k=='dob'){
                $dateInput = explode('-',$results['dob']);
                $dob = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $results[$k] = $dob;  
            }
            if($k=='password'){
                $password = Hash::make($results['password']);
                $results[$k] = $password;  
            }
            if($k == 'availablefrom'){
                $dateInput2 = explode('-',$results['availablefrom']);
                $availablefrom = $dateInput2[2].'-'.$dateInput2[0].'-'.$dateInput2[1];
                $results[$k] = $availablefrom;
            }
            $results['profile_path'] = $profile_file;
            $results['resume_file'] = $resume_file;
            $results['candidate_status'] = "1";
            $results['created_at'] = (date('Y-m-d H:i:s'));
            $results['updated_at'] = (date('Y-m-d H:i:s'));
        }
        //insert candidate details
        $candidateProfileUpdate = DB::table('candidates')->insert($results);
        
        if ($candidateProfileUpdate) {
            return redirect()->route('candidate.listing')->with('success', 'Candidate inserted successfully.');
        } else {
            return redirect()->route('candiform')->with('Error', 'Candidate can not not inserted.');
        }
    }

    //Candidate email verified status update
    public function candidateEmailVerifiedByAdmin(Request $request)
    {
        // echo "<pre>";
        // print_r($request->input());
        // exit;
        $candidateID = $request->input('candidateID');
        $email_verified_status = $request->input('email_verified_status');        
        $UpdateCandidate = DB::table('candidates')->where('id',$candidateID)->update([ 'email_verified_at' => $email_verified_status]);
        if($UpdateCandidate){    
            echo "1";            
        }else{
            echo "0";            
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
