<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use App\Models\Candidate;
use App\Models\Employer;
use DB;
use File;

class ManageEmployerController extends Controller
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
        // $employers = DB::table('employer')->orderBy('id', 'DESC')->get();
        $employers = DB::table('employer')
            ->join('cities','cities.id','=','employer.city')
            ->join('countries','countries.id','=','employer.country')            
            ->select('employer.*', 'cities.name AS city', 'countries.name AS country')
            ->orderBy('employer.id','DESC')->get();
            //->where('employer.profile_status',1)
            //->limit(5)
        // echo "<pre>";
        // print_r($employers);
        // exit;
        return view('admin.employer.employerListing')->with([
            'user' => $users,
            'employers' => $employers
        ]);
    }
    // deleteEmployee
    public function deleteEmployee(Request $request)
    {
        try {
            $employerID = $request->input('employer_id');

            if($employerID){            
                DB::beginTransaction();

                $employerDelete = DB::table('candidate_profile_viewed')->where('employer_id',$employerID)->delete();
                $employerDelete = DB::table('conversations')->where('from_id',$employerID)->delete();
                $employerDelete = DB::table('conversations')->where('to_id',$employerID)->delete();
                $jobApplyDelete = DB::table('jobs_apply')->where('employer_id',$employerID)->delete();
                $employerDelete = DB::table('messages')->where('from',$employerID)->delete();
                $employerDelete = DB::table('messages')->where('to',$employerID)->delete();
                $PostjobDelete = DB::table('postjob')->where('employer_id',$employerID)->delete();
                $postwageDelete = DB::table('postjob-wages')->where('employer_id',$employerID)->delete();
                $employerDelete = DB::table('employer')->where('id',$employerID)->delete();
                
                $UserDelete = DB::table('users')->where('request_chat_id',$employerID)->delete();
                   
                DB::commit();

                
            }

            return redirect()->route('employer.lists')->with('success', 'Employer and their jobpost deleted successfully.');

        } catch (\Exception $exception) {
                
            DB::rollback();


            // Return error
            return redirect()->route('employer.lists')->with('error', 'Something went wrong, Please try again');
        }  
        
    }

    //editEmployee
    public function editEmployee(Request $request)
    {
        $empid = $request->input('employer_id');
        $employer = DB::table('employer')->where('id', $empid)->get();
        $userid = Session::get('userid');
        $users = User::where('id', '=', $userid)->first();
        
       //state and country list
        $cities = DB::select("SELECT id,name FROM cities");
        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");
        
        return view('admin.employer.editEmployee')->with([ 
            'user' => $users,
            'employer' => $employer,
            'cities' => $cities,
            'states' => $states,
            'countries' => $countries
        ]);
    }

    //emploadform
    public function emploadform(){
        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");

        return view('admin.employer.addEmployer')->with([
            'states' => $states,
            'countries' => $countries
        ]);
    }
    //addEmployee
    public function addEmployee(Request $request){
        // print_r($request->file('pic_path'));
        // print_r($request->file('company_logo'));
        // echo "<pre>";
        // print_r($request->file());
        // print_r($request->input());
        // exit;

        // $messages = [
        //     'required' => ':attribute is required.',
        //     'integer' => ':attribute is must be number.',
        // ];

        // $this->validate($request,[
        //     'employer_pic' =>  'mimes:jpg,jpeg,png,svg|max:2048',
        //     'company_name' => 'required|max:100',
        //     'contact_person' => 'required|max:50',
        //     'mobile_number' => 'required|integer|min:10',
        //     'company_logo' => 'mimes:jpg,jpeg,png,svg|max:2048',
        //     'address' => 'required|max:500',
        //         ], $messages);
        /*
        $candidateCount = (array)Candidate::where('email', '=', $request->input('email'))->count();
        $employerCount = (array)Employer::where('email', '=', $request->input('email'))->count();        
       
        if( ($candidateCount[0] != 0) || ($employerCount[0] != 0) ){
            return redirect()->route('emploadform')->with('error', 'User is already exist');
        }
        */
        // echo "<pre>";
        // print_r($request->input());
        // exit;

        $messages = [
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
            'dimensions' => 'Invalid Company Logo Dimension.The maximum width must be 225px and height must be 225px',
        ];
        $v = $this->validate($request,[
            // 'pic_path' =>  'required|mimes:jpg,jpeg,png,svg|max:2048',
            'company_name' => 'required|max:100',
            // 'contact_person' => 'required|max:50',
            'street1' => 'required',
            'state' => 'required',
            'country' => 'required',
            'mobile_number' => 'required|integer|min:10',
            // 'company_logo' => 'required|mimes:jpg,jpeg,png,svg|max:2048|dimensions:max_width=225,max_height=225',
            'company_logo' => 'required|mimes:jpg,jpeg,png,svg|max:2048',
            ], $messages);
        // echo "<pre>";
        // print_r($v);
        // exit;
        if($request->file('pic_path') != ''){
            $pic_path_file = $request->file('pic_path');    
        }else{
            $pic_path_file = '';
        }
        $company_logo_file = $request->file('company_logo');        
        //--------------- Profile Path --------------
        if($request->hasFile('pic_path')){
            $files=$request->file('pic_path');
            $path = public_path() . '/empProfile/';
            $pic_path = time().'.'.$request->file('pic_path')->getClientOriginalExtension();
            $files->move($path,$pic_path);
            // $oldfile = url('/public/empProfile/'.$pic_path_file);
            // File::delete($path.$pic_path_file);
        }
                
        //----------------- company Logo ----------------
        if($request->file('company_logo')){
            $company_logo = $request->file('company_logo');
            $files = $request->file('company_logo');
            $path = public_path() . '/companyLogo/';
            $company_logo = time().'.'.$request->file('company_logo')->getClientOriginalExtension();
            $files->move($path,$company_logo);
            // $oldfile = url('/public/companyLogo/'.$company_logo_file);
            //delete old file
            // File::delete($path.$company_logo_file);
        }
        
        $addr = explode(',' ,$request->input('address'));
        if(count($addr) > 1){
            $country = $addr[count($addr)-1];
            $state = substr($addr[count($addr)-2], 0, strrpos($addr[count($addr)-2], ' '));;
            $city = $addr[count($addr)-3];    
        }else{
            $country = $addr[0];
            $state = '';
            $city = '';
        }
        

        // echo $addr[count($addr)-1].' '.$state.' '.$city;
        if($request->file('pic_path') == ''){
            $pic_path = '';
        }
        $data = [
            'name'  => trim($request->input('name')),
            'email' => trim($request->input('email')),
            'pic_path' => $pic_path,
            'company_name'=> trim($request->input('company_name')),
            // 'contact_person' => trim($request->input('contact_person')),
            'mobile_number' => trim($request->input('mobile_number')),            
            'address' => trim($request->input('address')),
            'street1' => trim($request->input('street1')),
            'street2' => trim($request->input('street2')),
            'city' => trim($request->input('city')),
            'state' => trim($request->input('state')),
            'country' => trim($request->input('country')),
            'company_logo' => $company_logo,
            'profile_status' => 1,
        ];
        // echo '123<pre>';
        // print_r($data);
        // exit;
        
        
        $InserEmployer = DB::table('employer')->insert($data);

        if($InserEmployer){
            return redirect()->route('employer.lists')->with('success', 'Employer add to the system successfully');
        }else{
            return view('admin.employer.addEmployer')->with('error', 'Employer not added');
            // return redirect()->route('emploadform')->with('error', 'Employer not added');
        }

    }
    //update Employee
    public function updateEmployee(Request $request){

        // echo '<pre>';
        // print_r($request->input());
        // exit;
        // echo '<br>'.$company_logo = $request->file('company_logo');
        // echo '<br>'.$pic_path = $request->file('pic_path');
       $messages = [
            'required' => ':attribute is required.',
            'integer' => ':attribute is must be number.',
            'dimensions' => 'Invalid Company Logo Dimension.The maximum width must be 225px and height must be 225px',
        ];
        $v = $this->validate($request,[
            // 'pic_path' =>  'required|mimes:jpg,jpeg,png,svg|max:2048',
            'company_name' => 'required|max:100',
            // 'contact_person' => 'required|max:50',
            'street1' => 'required',
            'state' => 'required',
            'country' => 'required',
            'mobile_number' => 'required|integer|min:10',
            // 'company_logo' => 'mimes:jpg,jpeg,png,svg|max:2048|dimensions:max_width=225,max_height=225',
            'company_logo' => 'mimes:jpg,jpeg,png,svg|max:2048',
                ], $messages); 

        $Employer = Employer::where('id', $request->input('id'))->first();
        // echo $request->input('id');
        // echo $request->file('pic_path');
        // exit;
        //--------------- Profile Path --------------
        if($request->hasFile('pic_path')){
            $files=$request->file('pic_path');
            $path = public_path() . '/empProfile/';
            $pic_path = time().'.'.$request->file('pic_path')->getClientOriginalExtension();
            $files->move($path,$pic_path);
            $oldfile = url('/public/empProfile/'.$Employer['pic_path']);
            File::delete($path.$Employer['pic_path']);
        }else{
            $pic_path = $Employer['pic_path'];
        }
        
        
        //----------------- company Logo ----------------
        if($request->file('company_logo')){
            $company_logo = $request->file('company_logo');
            $files = $request->file('company_logo');
            $path = public_path() . '/companyLogo/';
            $company_logo = time().'.'.$request->file('company_logo')->getClientOriginalExtension();
            $files->move($path,$company_logo);
            $oldfile = url('/public/companyLogo/'.$Employer['company_logo']);
            //delete old file
            File::delete($path.$Employer['company_logo']);
        }else{
            $company_logo = $Employer['company_logo'];
        }
            // echo $request->file('pic_path').' '.$request->file('company_logo').'<br>';    
            // echo '<br>'.$pic_path.' '.$company_logo;
            // exit;
        $addr = explode(',' ,$request->input('address'));
        if(count($addr) > 1){
            $country = $addr[count($addr)-1];
            $state = substr($addr[count($addr)-2], 0, strrpos($addr[count($addr)-2], ' '));;
            $city = $addr[count($addr)-3];    
        }else{
            $country = $addr[0];
            $state = '';
            $city = '';
        }
        

        // echo $addr[count($addr)-1].' '.$state.' '.$city;        
        if($request->file('pic_path') == ''){
            $pic_path = '';
        }
        $data = [
            'name'  => trim($request->input('name')),
            'email' => trim($request->input('email')),
            'pic_path' => $pic_path,
            'company_name'=> trim($request->input('company_name')),           
            'mobile_number' => trim($request->input('mobile_number')),            
            'address' => trim($request->input('address')),
            'street1' => trim($request->input('street1')),
            'street2' => trim($request->input('street2')),
            'city' => trim($request->input('city')),
            'state' => trim($request->input('state')),
            'country' => trim($request->input('country')),
            'company_logo' => $company_logo,
            'profile_status' => 1,
        ];

        
        // echo '<pre>';
        // print_r($data);
        // exit;
        
        $update = DB::table('employer')->where('id', $request->input('id'))->update($data);
        if($update){
            return redirect()->route('employer.lists')->with('success', 'Employer detail updated successfully');
        }else{
            //$url = 'editEmp?employer_id='.$request->input('id');
            return redirect()->route('editEmp', ['employer_id' => $request->input('id')])->with('error', 'Employer detail not updated');
        }
    }
    
    

    //employerStatus
    public function employerStatus(Request $request)
    {
        // echo "<pre>";
        // print_r($request->input());
        // exit;
        $empid = $request->input('empid');
        $email_varified = $request->input('profile_status');        
        $UpdateEmployer = DB::table('employer')->where('id',$empid)->update([ 'email_varified' => $email_varified]);
        if($UpdateEmployer){
            // json_encode(['success','1'])
            echo "1";
            // return redirect()->route('employer.lists')->with('success', 'Employer profile successfully actived');
        }else{
            echo "0";
            // return redirect()->route('employer.lists')->with('error', 'Error in Employer profile activation');
        }
        // exit;
    }

    
    //Ajax getStateList
    public function getStateList(Request $request)
    {
        $countryID = $request->post('countryID');
        // $stateList = DB::table('states')->select('id','name')->where('country_id', $countryID)->get();
        $stateList = DB::select("select id,name from states where country_id=".$countryID);
        // echo "<pre>";

        $final = [];
        for($i=0;$i<count($stateList);$i++){
            // echo $stateList[$i]->id;
            echo "<option value='".$stateList[$i]->id."'>".$stateList[$i]->name."</option>";
        }
    }

    //Ajax getCityList
    public function getCityList(Request $request)
    {
        $stateID = $request->post('stateID');
        // $stateList = DB::table('states')->select('id','name')->where('country_id', $countryID)->get();
        $cityList = DB::select("select id,name from cities where state_id=".$stateID);
        // echo "<pre>";

        $final = [];
        for($i=0;$i<count($cityList);$i++){
            // echo $stateList[$i]->id;
            echo "<option value='".$cityList[$i]->id."'>".$cityList[$i]->name."</option>";
        }
    }


    //For fetching states
    public function getStates(Request $request)
    {
        $id = $request->cid;
        $states = DB::table("states")
                    ->where("country_id",$id)
                    ->pluck("name as state_name","id");
        return response()->json($states);
    }

    //For fetching cities
    public function getCities(Request $request)
    {
        $id = $request->cid;
        $cities= DB::table("cities")
                    ->where("state_id",$id)
                    ->pluck("name as city_name","id");
        return response()->json($cities);
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
