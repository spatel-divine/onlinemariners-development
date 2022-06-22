<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ManageDocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentList = DB::table('docs_by_admin')->get();
        return view('admin.docs.documentListing')->with([
            'documentList' => $documentList
        ]);
    }

    public function loadDocForm(){
        return view('admin.docs.addDocument');
    }

    //addDocs
    public function addDocs(Request $request){
        // echo "<pre>";
        // print_r($request->post());
        // $message = [ 'document_name' => 'required'];
        $this->validate($request, [ 
            'document_name' => 'required', 
        ], [ 'integer' => ':attribute is must be number.', ]);
        $results = $request->post();
        unset($results['_token']);
        //echo "<pre>";
        //print_r($results);
        //insert Document into list
        $documentInsert = DB::table('docs_by_admin')->insert($results);
        if ($documentInsert) {
            return redirect()->route('admin.doclisting')->with('success', 'Document inserted successfully.');
        } else {
            return redirect()->route('admin.addDocs')->with('Error', 'Document can not not inserted.');
        }
    }

    //Delete Docs
    public function deleteDocs(Request $request){
        $documentID = $request->input('document_id');
        if($documentID){
            $deleteDoc = DB::table('docs_by_admin')->where('id', $documentID)->delete();
        }
        return redirect()->route('admin.doclisting')->with(['success', 'Document deleted successfully.']);
    }

    //edit form
    public function editForm(Request $request){

        $documentID = $request->input('document_id');
        $documentList = DB::table('docs_by_admin')->where('id', $documentID)->get();
        // echo "<pre>";
        // print_r($documentList);
        // exit;
        return view('admin.docs.editDocument')->with([ 'documentList' => $documentList ]);
    }

    //update docs
    public function updateDocs(Request $request){
        $documentID = $request->input('id');
        $result = $request->input();
        unset($result['_token']);
        
        $data = [
            'document_name' => $result['document_name'],            
        ];
        // echo "<pre>";
        // print_r($data);
        // exit;
        $documentUpdate = DB::table('docs_by_admin')->where('id', $documentID)->update($data);
        if ($documentUpdate) {
            // $documentList = DB::table('docs_by_admin')->get();
            return redirect()->route('admin.doclisting')->with('success','Document updated successfully.');
        } else {
            return redirect()->route('admin.editForm')->with('Error', 'Document profile not updated.');
        }
        
        // echo $documentID;
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
