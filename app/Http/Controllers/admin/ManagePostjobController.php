<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\User;
use App\Models\Postjob;
use File;

class ManagePostjobController extends Controller
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
        // $postjobs = DB::table('postjob')->get();
        $postjobs = DB::table('postjob')
                ->join('employer','employer.id','=','postjob.employer_id')
                ->join('postjob-wages','postjob-wages.postjob_id','=','postjob.id')
                ->select('employer.name','employer.company_name','employer.company_logo','postjob.*','postjob-wages.id as postwage_id','postjob-wages.rank_position','postjob-wages.wages')
                 // ->select( DB::raw("count(`postjob-wages`.`postjob_id`) as rankcount") )
                // ->groupBy('postjob-wages.id')
                // ->orderBy('id','DESC')
                ->groupBy('postjob.id')
                ->where('postjob.postjob_status', 1)
                ->orderBy('postjob.id', 'DESC')                     
                ->get();
        // echo '<pre>';
        // print_r($postjobs);
        // exit;
                
        return view('admin.postjob.postjoblisting')->with(['postjobs' => $postjobs, 'user' => $users]);
    }

    //feature job
    public function featurejobAjax(Request $request)
    {
        $postjobID = $request->input('postjobID');
        $jobFeatured = '';
        // $postwageID = $request->input('postwageID');
        $postjobIDs = json_decode($request->input('postdatas'));
        
       

        for($i=0;$i<count($postjobIDs);$i++){
           $jobFeatured =  DB::table('postjob')->where('id', $postjobIDs[$i])->update(['featured_job' => 1]);
           if($jobFeatured){
                echo 'jobfeatured'; 
            }
        }
        // 

        // if($jobFeatured){
        //     echo 'jobfeatured';
        // }else{
        //     echo 'notjobfeatured';
        // }
        // return redirect()->route('postjob.listing')->with('success', 'Job featured successfully.');
    }

    //unfeaturejobAjax
    public function unfeaturejobAjax(Request $request){
        $postjobID = $request->input('postjobID');
        $jobUnFeatured = '';        
        $postjobIDs = json_decode($request->input('postdatas'));        
        $allids = DB::select("SELECT id FROM postjob");
        
        $ids = [];
        foreach($allids as $data) {
            foreach($data as $k => $v) {
                // echo $v.'<br>';
                $ids[] = $v;
            }
        }
        $diffIdsForUnfeatured = array_diff($ids, $postjobIDs);
        $finalIDs = [];
        foreach ($diffIdsForUnfeatured as $k => $v) {
            $finalIDs[] = $v;
        }
        
        // echo "<pre>";
        // print_r($finalIDs);
        // // print_r($ids);        
        // exit;

        for($i=0;$i<count($finalIDs);$i++){
           $jobUnFeatured =  DB::table('postjob')->where('id', $finalIDs[$i])->update(['featured_job' => 0]);
            if($jobUnFeatured){
                echo 'jobunfeatured';
            }           
        }
            
    }

    //non itf job Ajax call
    public function setUnsetItfJob(Request $request){
        $jobId = $request->input('jobId');
        $ItfValue = $request->input('ItfValue');

        $ItfValue = ($ItfValue && $ItfValue=='true') ? '1' : '0';
       
        $itfjobdata =  DB::table('postjob')->where('id', $jobId)->update(['itf_jobs' => $ItfValue]);

        echo $ItfValue;
        exit();         
            
    }

    //non itf job Ajax call
    public function setUnsetFeaturedJob(Request $request){
        $jobId = $request->input('jobId');
        $FeatureValue = $request->input('FeatureValue');

        $FeatureValue = ($FeatureValue && $FeatureValue=='true') ? '1' : '0';
       
        $itfjobdata =  DB::table('postjob')->where('id', $jobId)->update(['featured_job' => $FeatureValue]);

        echo $FeatureValue;
        exit();         
            
    }

    //itf job Ajax call
    public function itfJobAjax(Request $request)
    {
        $postjobID = $request->input('postjobID');
        $jobFeatured = '';
        // $postwageID = $request->input('postwageID');
        $postjobIDs = json_decode($request->input('postdatas'));
        
       

        for($i=0;$i<count($postjobIDs);$i++){
           $jobFeatured =  DB::table('postjob')->where('id', $postjobIDs[$i])->update(['itf_jobs' => 1]);
           if($jobFeatured){
                echo 'itfjobs'; 
            }
        }
        
    }

    //non itf job Ajax call
    public function nonitfJobAjax(Request $request){
        $postjobID = $request->input('postjobID');
        $jobUnFeatured = '';        
        $postjobIDs = json_decode($request->input('postdatas'));        
        $allids = DB::select("SELECT id FROM postjob");
        
       // echo "<pre>";
       //  print_r($postjobIDs);
       //  print_r($allids);        
       //  exit;

        $ids = [];
        foreach($allids as $data) {
            foreach($data as $k => $v) {
                // echo $v.'<br>';
                $ids[] = $v;
            }
        }
        $diffIdsForUnfeatured = array_diff($ids, $postjobIDs);
        $finalIDs = [];
        foreach ($diffIdsForUnfeatured as $k => $v) {
            $finalIDs[] = $v;
        }
        
        // echo "<pre>";
        // print_r($finalIDs);
        // // print_r($ids);        
        // exit;

        for($i=0;$i<count($finalIDs);$i++){
           $jobUnFeatured =  DB::table('postjob')->where('id', $finalIDs[$i])->update(['itf_jobs' => 0]);
            if($jobUnFeatured){
                echo 'nonitfjobs';
            }           
        }
            
    }
    
    //deletePostjob
    public function deletePostjob(Request $request)
    {
        $postjobID = $request->input('postjob_id');

        if($postjobID){
            $postjobDelete = DB::table('postjob')->where('id',$postjobID)->delete();           
        }
        return redirect()->route('postjobs.lists')->with('success', 'JobPost deleted successfully.');
    }

    //add job form by admin 
    public function addpostjob()
    {

        $employerList = DB::table('employer')->select('id','name','company_name')->where('profile_status', 1)->get();
        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");

        $documents = DB::table('docs_by_admin')->orderBy('id','DESC')->get();
        $docResult = [];
        foreach ($documents as $data) {
            $sub = [];
            foreach ($data as $k => $v) {                
                if($k == 'document_name'){
                    $sub['document_name'] = $v;    
                }
            }
            // echo $k.'<br>';
            $docResult[] = $sub['document_name'];
        }
        $documentList = $docResult;

        return view('admin.postjob.addPostJob')->with([
            'employerList' => $employerList,
            'states' => $states,
            'countries' => $countries,
            'documentList' => $documentList,
        ]);        
    }
    
    //insertPostjob
    public function insertPostjob(Request $request)
    {
        
        $postjobArr = $request->input();
        

        if($request->hasFile('postjob_banner')){
            $files=$request->file('postjob_banner');
            $path = public_path() . '/postjobBanner/';
            // $profile_file = $request->file('profile_pic')->getClientOriginalName();  //name
            $banner_img = time().'.'.$request->file('postjob_banner')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('profile_pic')->getClientOriginalName();;
            $moved = $files->move($path,$banner_img);
            // if($moved){
            //     echo 'file moved';
            // }else{
            //     echo 'not file moved';
            // }
            //$oldfile = url('/public/postjob_banner/'.$Employer['postjob_banner']);
            //delete old file
            //File::delete($path.$Employer['postjob_banner']);
            // unset($oldfile);
        }
        //document list
        //$docData = $postjobArr['document_name'];
        //$data = implode(",",$postjobArr['document_name']);
        //$document_name = [ 'document_name' => $data];
        //ranks and wages arrays
        $rank  = $postjobArr['rank'];
        // echo "<pre>";
        // print_r($postjobArr['rank']);
        // print_r($document_name);
        // exit;
        $wage = $postjobArr['wage'];
        $contract_duration = $postjobArr['contract_duration'];
        // $experience_years = $postjobArr['experience_years'];
        // $experience_months = $postjobArr['experience_months'];
        // $employer = DB::table('employer')->where('email', $empEmail)->get();
        // echo $postjobArr['app_deadline'].'<br>';
        // print_r(count($postjobArr));
        
        foreach ($postjobArr as $k => $v) {
            if($k == 'app_deadline'){    
                $date = $postjobArr['app_deadline'];
                $dateInput = explode('/',$date);
                $deadline = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $postjobArr[$k] = $deadline;
            }

            if($k == 'job_description'){
                // print_r($v);
                $postjobArr[$k] = trim($v," ");   
            }
            if(isset($banner_img)){
                $postjobArr['postjob_banner'] = $banner_img;
            }else{
                $postjobArr['postjob_banner'] = '';
            }
            
            // $postjobArr[$k] = trim($v);
        }
        // print_r(count($postjobArr));
        // echo "<pre>";
        // print_r($postjobArr); 
        // exit;
        
        unset($postjobArr['_token']);
        unset($postjobArr['id']);
        unset($postjobArr['_wysihtml5_mode']);
        //unset($postjobArr['document_name']);
        unset($postjobArr['rank']);
        unset($postjobArr['wage']);
        unset($postjobArr['contract_duration']);
        // unset($postjobArr['experience_years']);
        // unset($postjobArr['experience_months']);

        $jobsArr = $postjobArr;
        // echo "<pre>";
        // print_r($postjobArr); 
        // exit;
        foreach($jobsArr as $k=>$v){

            if($k == 'employer_id' || $k == 'contract_duration' || $k == 'experience_years'|| $k == 'experience_months'|| $k == 'mobile_no' || $k == 'app_deadline'){
                $jobsArr[$k] = $v;
            }else{
                if($k != 'document_name'){
                    $jobsArr[$k] = trim(strip_tags($v)); 
                }
               
            }
            $jobsArr['postjob_status'] =  1;
        }
      //  $jobsArr = array_merge($document_name, $jobsArr);

        // echo "<pre>";
        // print_r($jobsArr); 
        // exit;

        //Insert to post a job
        $lastJobID = DB::table('postjob')->insertGetId($jobsArr);

            // echo '<br>';
            // print_r($lastJobID);
            // exit;
        //post Job wise wages 
        $a3 = [];
        $a4 = [];
        $empID  = $jobsArr['employer_id'];
        foreach ($rank as $k => $v) {
            $a4 = [
                    'postjob_id' => $lastJobID,
                    'employer_id' => $empID,
                    'rank_position' => $v,
                    'wages' => $wage[$k],
                    'contract_duration' => $contract_duration[$k],
                    // 'experience_years' => $experience_years[$k],
                    // 'experience_months' => $experience_months[$k],                    
                ];
                array_push($a3, $a4);
        }
        // echo '<pre>';
        // print_r($a3);
        // exit;
        //Insert to wages
        $wageCount = count($a3); 
        for($i=0;$i<$wageCount;$i++){
            DB::table('postjob-wages')->insert($a3[$i]);
            // echo 'INsert record'.$i;
        }
        if($lastJobID){
            return redirect()->route('postjobs.lists')->with('success', 'Post Job successfully created.');    
        }else{
            return redirect()->route('addPostjob');    
        }
        
    }

    //editPostjob form load with current data
    public function editPostjob(Request $request){
        // echo "<pre>";
        // print_r($request->input('candidate_id'));
        // exit;
        $postjob_id = $request->query('postjob_id');//$request->input('postjob_id');
        $postjobs = DB::table('postjob')->where('id', $postjob_id)->get();
        $wages = DB::select("SELECT * FROM `postjob-wages` where postjob_id=".$postjob_id." order by id DESC");

        $userid = Session::get('userid');
        $users = User::where('id', '=', $userid)->first();
        $employerList = DB::table('employer')->select('id','name','company_name')->where('profile_status', 1)->get();

        $states = DB::select("SELECT id,name FROM states");
        $countries = DB::select("SELECT id,name FROM countries");
        
        return view('admin.postjob.editPostJob')->with(
            [ 
                'user' => $users, 
                'employerList' => $employerList,
                'wages' => $wages,
                'postjobs' => $postjobs,
                'states' => $states,
                'countries' => $countries
            ]
        );
    }

    //updatePostjob
    public function updatePostjob(Request $request)
    {
        // echo "hh<pre>";
        // print_r($request->input());
        // exit;
        $postjobID = $request->input('id');
        // print_r($postjobID);
        // exit;
        /*
            $messages = [
                'required' => ':attribute is required.',
                'integer' => ':attribute is must be number.',                
            ];
            $this->validate($request,[
                'job_title' => 'required|max:255',
                'job_description' => 'required|max:500',
                'postjob_banner' => 'mimes:jpg,jpeg,png,svg|max:2048',            
                'app_deadline' => 'required|date',
                'vassel_type' => 'required',            
                'address' => 'required',            
                'rank'  => 'required|array|min:1',//'required|array|min:1',
                'wage'  => 'required|array|min:1',
                // 'wage.*'  => 'required|integer',
                ]
            , $messages);
        */

        $postjobArr = $request->input();
        // print_r($postjobArr);
        // exit;
        //postjob banner
        $postjobData = Postjob::where('id', $postjobID)->first();

        if($request->hasFile('postjob_banner')){
            $files=$request->file('postjob_banner');
            $path = public_path() . '/postjobBanner/';
            // $profile_file = $request->file('profile_pic')->getClientOriginalName();  //name
            $banner_img = time().'.'.$request->file('postjob_banner')->getClientOriginalExtension();

            // echo 'IMG '.$request->file('profile_pic')->getClientOriginalName();;
            $moved = $files->move($path,$banner_img);
            
            $oldfile = url('/public/postjob_banner/'.$postjobData['postjob_banner']);
            //delete old file
            File::delete($path.$postjobData['postjob_banner']);
            // unset($oldfile);
        }else{
            $banner_img = $postjobData['postjob_banner'];
        }
        

        
        $EmpID =$request->input('employer_id');
        $emp = [
            'employer_id' => $EmpID,
        ];
        //Doc name array
      //  $docData = $postjobArr['document_name'];
       // $data = implode(",",$postjobArr['document_name']);
        //$document_name = [ 'document_name' => $data];
        // print_r($emp);
        // exit;
        // print_r(count($postjobArr));
       
        //array for wage and rank
        $rank = $postjobArr['rank'];
        $wage = $postjobArr['wage'];
        $contract_duration = $postjobArr['contract_duration'];
        // $experience_years = $postjobArr['experience_years'];
        // $experience_months = $postjobArr['experience_months'];
        // $employer = DB::table('employer')->where('email', $empEmail)->get();
        // echo $postjobArr['app_deadline'].'<br>';
        foreach ($postjobArr as $k => $v) {
            if($k == 'app_deadline'){    
                $date = $postjobArr['app_deadline'];
                $dateInput = explode('/',$date);
                $deadline = $dateInput[2].'-'.$dateInput[0].'-'.$dateInput[1];
                $postjobArr[$k] = $deadline;
            }
            // $postjobArr[$k] = trim($v);
        }
        
        
        unset($postjobArr['_token']);
        unset($postjobArr['id']);
        unset($postjobArr['_wysihtml5_mode']);
     //   unset($postjobArr['document_name']);
        unset($postjobArr['rank']);
        unset($postjobArr['wage']);
        unset($postjobArr['contract_duration']);
        // unset($postjobArr['experience_years']);
        // unset($postjobArr['experience_months']);

        $jobsArr = array_merge($emp, $postjobArr);
      //  $jobsArr = array_merge($document_name, $jobsArr);
        // echo "<pre>";
        // // print_r($rank);
        // // print_r($wage);
        // print_r($jobsArr);
        // exit;

        foreach($jobsArr as $k=>$v){
            if($k == 'employer_id' || $k == 'contract_duration' || $k == 'experience_years'|| $k == 'experience_months'|| $k == 'mobile_no' || $k == 'app_deadline'){
                $jobsArr[$k] = $v;
            }else{               
               if($k != 'document_name'){
                    $jobsArr[$k] = trim(strip_tags($v)); 
                }
            }
            if($k != 'employer_id'){
                // $jobsArr[$k] = "'".$v."'";
                $jobsArr[$k] = $v;
            }
            // $jobsArr['postjob_banner'] = "'".$banner_img."'";
            $jobsArr['postjob_banner'] = $banner_img;
        }
        // echo "<pre>";
        // print_r($jobsArr);
        // exit;

        //UPDATE to post a job        
        $postjobsUpdate = DB::table('postjob')->where('id', $postjobID)->update($jobsArr);
        
        // echo "<pre>";
        // print_r($rank);
        // echo "<br>";
        // print_r($wage);
        // exit;
        //post Job wise wages 
        $a3 = [];
        $a4 = [];
        $empID  = $jobsArr['employer_id'];
        foreach ($rank as $k => $v) {
            $a4 = [
                    'postjob_id' => $postjobID,
                    'employer_id' => $empID,
                    'rank_position' => $v,
                    'wages' => $wage[$k],
                    'contract_duration' => $contract_duration[$k],
                    // 'experience_years' => $experience_years[$k],
                    // 'experience_months' => $experience_months[$k],
                ];
                array_push($a3, $a4);
        }
        //  echo "hh<pre>";        
        // print_r($a3);
        // exit;
        //UPDATE to wages
        $wageCount = count($a3); 
        $deleteOldPost =  DB::table('postjob-wages')->where('postjob_id',$postjobID)->delete();
        if($deleteOldPost){
            for($i=0;$i<$wageCount;$i++){             
                // DB::table('postjob-wages')->insert($a3[$i]);
                $postjobsUpdate = DB::table('postjob-wages')
                ->where('postjob_id', $postjobID)
                ->insert($a3[$i]);
                // echo '<br>INsert record'.$i.'<br>';
            }    
        }
                
        return redirect()->route('postjobs.lists')->with('success', 'PostJob successfully updated.');
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
