<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Candidate;
use App\Models\Employer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\emailvarificationMail;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Log;
// use Illuminate\Foundation\Auth\RegistersUsers;

class SignupController extends Controller
{
    protected $redirectTo = '/homepage';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('signup');
    }

    public function load()
    {
        return view('userverificationer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
    

    public function decompress($input, $ascii_offset = 38) {

        $output = '';
        foreach(str_split($input, 3) as $chunk) {

            //Reassemble the 24 bit ints from 3 bytes
            $int_24 = 0;
            foreach(unpack('C*', $chunk) as $char) {
                $int_24 <<= 8;
                $int_24 |= $char & 0b11111111;
            }

            //Expand the 24 bits to 4 sets of 6, and take their character values
            for($i = 0; $i < 4; $i++) {
                $output = chr($ascii_offset + ($int_24 & 0b111111)) . $output;
                $int_24 >>= 6;
            }
        }

        //Make lowercase again and trim off the padding.
        return strtolower(rtrim($output, '='));
    }
    
    public function create(Request $request)
    {

        $CurrentTime = Carbon::now()->toDateTimeString();        
        Log::info('Call SignupController -> create', array('email'=>$request['email'], 'name' => $request['name'], 'CurrentTime' => $CurrentTime));
        $data = $request->input();
        
       $messages = [
            'required' => 'The :attribute field can not be blank.',
            'same:password' => 'Original password and confirm password must be same.',
            'min' => ':arrtibute field must be aleast 6 character long.',
            'regex' => 'Password must be combination of upper, lowercase letter and special symbols like@,#,$ etc.'
       ];
       $validator = $this->validate($request, [
            'name'             => 'required',                        
            'email'            => 'required|email|unique:candidates',     
            'password'         => 'required|min:6|regex:/^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{6,}$/|confirmed',
            // 'password_confirm' => 'required|min:6|same:password',
        ], $messages);
        
        ///^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/
        if (!$validator) {
            // get the error messages from the validator
            $messages = $validator->messages();
            return Redirect::to('signup.index')->withErrors($validator);   
            // return redirect()->route('signup.index')->withInput($request);       
        }
        if ($validator) {

            if($request['user-type'] == 'employer'){
                $emp_email_token = Str::random(16);
                $url = url('verification/verifyme/'.$request['email'].'/'.$emp_email_token);
                
                $data = [
                    'username' => $request['name'],
                    'email' => $request['email'],
                    'url' =>  $url,
                ];
                
                $employerArray = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),                    
                    'email_token' => $emp_email_token,
                    'created_at' => date('Y-m-d h:i:s', time()),
                    'updated_at' => date('Y-m-d h:i:s', time()),
                ];
                
                $addEmployer =  Employer::create($employerArray);

                Log::info('Call SignupController -> create -> Employer -> Added Employer', $employerArray);

                $lastUserID = $addEmployer->id;
                
                $allUsertbl = User::create([
                    'usertype' => $request['user-type'],
                    'request_chat_id' => $lastUserID,
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'email_verified_at' => $CurrentTime,
                    'password' => Hash::make($request['password']),
                    'last_seen' => date('Y-m-d h:i:s', time()),
                    'is_online' => 1,
                    'is_active' => 1,
                    'is_system' => 1,
                    'decrpted_password' => $request['password'],
                ]);                
                
                $lastInseredAllUserID = $allUsertbl->id;                
                $resultsData = [ 'employer_chat_id' => $lastInseredAllUserID ];
            
                $empUpdateWithChatID = DB::table('employer')->where('id', $lastUserID)->update($resultsData);


                Log::info('Call SignupController -> create -> Employer -> Send email to user', array('email'=>$request['email']));

                
                Mail::to($request['email'])->send(new emailvarificationMail($data));
                
                Session::put('employerEmail', $request['email']);
                Session::put('employerName', $request['name']);
                if($addEmployer){
                   
                    Log::info('Call SignupController -> create -> Employer -> Email sent and return response', array('email'=>$request['email']));

                    return redirect()->route('verifying.load')->with('success', 'Employer registered successfully.Please verify your email address by checking your inbox or spam folder.In case you did not receive mail then kindly contact to our online agent through chat.');
                }
                
            }else{
                //candidate User
                $email_token = Str::random(16);
                $url = url('verification/verifyme/'.$request['email'].'/'.$email_token);
                
                $data = [
                    'username' => $request['name'],
                    'email' => $request['email'],
                    'url' =>  $url,
                ];

                Log::info('Call SignupController -> create -> Candidate -> Send email to user', array('email'=>$request['email']));
                
                Mail::to($request['email'])->send(new emailvarificationMail($data));
                
                $candidateArray = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'candidate_status' => 0,
                    'email_token' => $email_token,
                    'created_at' => date('Y-m-d h:i:s', time()),
                    'updated_at' => date('Y-m-d h:i:s', time()),
                ];
                $addCandidate =  Candidate::create($candidateArray);

                Log::info('Call SignupController -> create -> Candidate -> Added Candidate', $candidateArray);

                $lastCandiUserID = $addCandidate->id;
                //candidate password 
                $encryptedCandi = base64_encode($request['password']);//Crypt::encryptString($request['password']);
                // $decryptedpasswordCandidate = Crypt::decryptString($encryptedCandi);
                //insert candi to user table
                $allUsertblForCandidate = User::create([
                    'usertype' => $request['user-type'],
                    'request_chat_id' => $lastCandiUserID,
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'email_verified_at' => $CurrentTime,
                    'password' => Hash::make($request['password']),
                    'last_seen' => date('Y-m-d h:i:s', time()),
                    'is_online' => 1,
                    'is_active' => 1,
                    'is_system' => 1,
                    'decrpted_password' => $request['password'],
                ]);
                $lastInsertAllUserID = $allUsertblForCandidate->id;                
                $resultsData = [ 'candidate_chat_id' => $lastInsertAllUserID ];
            
                //add chat id to candidate tbl
                $candiUpdateWithChatID = DB::table('candidates')->where('id', $lastCandiUserID)->update($resultsData);

                Session::put('userEmail', $request['email']);
                Session::put('userName', $request['name']);
                
                if ($addCandidate) {    

                    Log::info('Call SignupController -> create -> Candidate -> Email sent and return response', array('email'=>$request['email']));

                       
                    return redirect()->route('verifying.load')->with('success', 'Candidate registered successfully.Please verify your email address by checking your inbox or spam folder.In case you did not receive mail then kindly contact to our online agent through chat.');
                }   
            }
            
        }
         
    }

    /* Get token and varify user email address */
    public function verifyme($email,$key) {
        // echo "<br>email: ".$email;
        // echo '<br>k:'.$key;
        // exit;
        // $email = Session::get('userEmail');
        $candidateCount = Candidate::where('email', '=', $email)->count();
        if($candidateCount > 0){
            $varified = Candidate::where('email_token','=',$key)->where('email' , $email)->update(['email_verified_at' => 1 ]);
        }
        // var_dump(isset($varified));
        // echo "<br>";
        // exit;
        $candEmail = Session::get('userEmail');         
        if($candEmail != ''){
            $candidateData = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");   
        }else{
            $candidateData = [];
        }
        
        $employerCount = Employer::where('email', '=', $email)->count();
        if($employerCount > 0){
            $varified_emp = Employer::where('email_token','=',$key)->where('email' , $email)->update(['email_varified' => 1 ]);
        }

        if(isset($varified)){
            if(isset($candidateData[0]->docs_uploaded) && ($candidateData[0]->docs_uploaded == 1)){
                return redirect()->route('cand.dashboard')->with('success', 'Candidate email address varified. Now you create your profile to activate account.');
            }else{
                return redirect()->route('cand.profile')->with('success', 'Candidate email address varified. Now you create your profile to activate account.');    
            }
        }else if(isset($varified_emp)){
            return redirect()->route('employer.dashboard')->with('success', 'Employer email address varified. Now you create your profile to activate account.');      
        }else{
            // echo 'dashboard no';
            // exit;
            return redirect()->route('verifying.load')->with('success', 'Candidate registered successfully.Please verify your email address by checking your inbox or spam folder.In case you did not receive mail then kindly contact to our online agent through chat.');
        }
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
