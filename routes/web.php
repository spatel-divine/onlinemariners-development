<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('clear_cache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');

    dd("Cache is cleared");
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//guest Routes
Route::group(['middleware' => ['guest']], function () {
    // Guest routes
    // Route::get('/', function()
    // {
    //     return View::make('homepage');
    // });
    //  Route::get('/signup', function()
    // {
    //     return View::make('register');
    // });
    Route::get('/', 'SiteController@index')->name('homepage');
    Route::get('/signup', 'SignupController@index')->name('signup');
    Route::post('/signup', 'SignupController@create')->name('signup.create');
    Route::get('/verification', 'SignupController@load')->name('verifying.load');

    Route::get('/verification/verifyme/{email}/{key}', 'SignupController@verifyme')->name('verify.me');

    Route::get('/signin', 'SigninController@index')->name('signin.index');
    Route::post('/signin', 'SigninController@checkLogin')->name('signin.validate');
    Route::get('/signin/emailverify', 'SigninController@unverifiedCandidate')->name('signin.emailverify');

    //testimonialGridList
    Route::get('/testimonial' ,'SiteController@testimonialGridList')->name('testimonialGridList');

    //privacyPolicy
    Route::get('/privacypolicy' ,'SiteController@privacyPolicy')->name('privacyPolicy');
    //termsAndCondition
    Route::get('/termsandcondition' ,'SiteController@termsAndCondition')->name('termsAndCondition');
    
});

Auth::routes();

/************************** After login routes **********************************************************/
//candidate
Route::group(['middleware' => ['verify.candidate']], function () {
    Route::get('/candidate/dashboard', 'CandidateController@candidateDashboard')->name('cand.dashboard');

    Route::get('/candidate/profile', 'CandidateController@showcandidateProfile')->name('cand.profile');
    Route::post('/candidate/store', 'CandidateController@store')->name('cand.store');

    Route::get('/candidate/edit', 'CandidateController@editCandidate')->name('cand.edit');
    // Route::get('/candidate/apply/position/{postjob_id}', 'SiteController@applyfor')->name('cand.apply');

    Route::get('/candidate/apply/position/{postjob_id}/{postwage_id?}', 'SiteController@listRanks')->name('cand.apply');
    Route::post('/candidate/save/rank', 'SiteController@saveRank')->name('save.rank');

    Route::get('/candidate/apply/list', 'CandidateController@candidateJobApplyList')->name('cand.applylist');
    //profile viewed by employer
    Route::get('/candidate/viewedProfile/list', 'CandidateController@profileViewByEmployer')->name('profileViewByEmployer');
    
    //endorsment docs------------------------
    Route::get('/candidate/endorsment/uploads', 'CandidateController@endorsementDocuments')->name('endorsment.docs');

    Route::post('/candidate/endorsment/save', 'CandidateController@endorsDocsSubmit')->name('endorsment.save');
    Route::post('/candidate/traveldoc/save', 'CandidateController@travelDocsSubmit')->name('traveldoc.save');
    Route::post('/candidate/medicaldoc/save', 'CandidateController@medicalDocsSubmit')->name('medicaldoc.save');
    Route::post('/candidate/skilTraining/save', 'CandidateController@skilTrainingDocsSubmit')->name('skilldoc.save');
    Route::post('/candidate/personal/save', 'CandidateController@personalDocsSubmit')->name('personaldoc.save');
    Route::post('/candidate/cocdoc/save', 'CandidateController@cocDocsSubmit')->name('cocDocs.save');

    Route::post('/candidate/stcwdoc/save', 'CandidateController@stcwDocsSubmit')->name('stcwdoc.save');
    Route::post('/candidate/Offshoredoc/save', 'CandidateController@OffshoreDocsSubmit')->name('Offshoredoc.save');
    Route::post('/candidate/yachtdoc/save', 'CandidateController@yachtDocsSubmit')->name('yachtdoc.save');
    Route::post('/candidate/anyotherdoc/save', 'CandidateController@anyOtherDocsSubmit')->name('anyotherdoc.save');
    //----------End endorsment docs------------------------
});
/* End of Candidate Route list */
//employer
Route::group(['middleware' => ['verify.employer']], function () {
    //employer
    Route::get('/employer/dashboard', 'EmployerController@index')->name('employer.dashboard');
    Route::post('/employer/picture', 'EmployerController@profilepicupdate')->name('employer.image');

    Route::get('/employer/profile', 'EmployerController@profileCreate')->name('employer.profile');
    Route::post('/employer/profile/store', 'EmployerController@storeEmployer')->name('employer.store');
    Route::get('/employer/edit', 'EmployerController@editEmployer')->name('employer.edit');
    //apllication list of candidate
    Route::get('/employer/application/listing', 'EmployerController@applyByCandidateList')->name('lists.appliedjob');
    //change application status
    Route::post('/employer/application/changeStatus', 'EmployerController@changeApplicationStatusByEmp')->name('change.applicationStatus');
    //postjob status change
    Route::post('/employer/postjob/changeStatus', 'EmployerController@postjobStatusChangeByEmp')->name('change.postjobState');

    Route::get('/employer/postajob', 'PostjobController@index')->name('postjob.index');
    Route::post('/employer/postajob/store', 'PostjobController@store')->name('postjob.store');

    Route::get('/employer/postajob/listing', 'PostjobController@postjobListing')->name('postjob.listing');
    Route::get('/employer/postajob/edit/{id}', 'PostjobController@edit')->name('postjob.edit');
    Route::post('/employer/postajob/update/{id}', 'PostjobController@postjobUpdate')->name('postjob.update');
    Route::get('/employer/postajob/delete/{id}/{employer_id}', 'PostjobController@deleteJobs')->name('postjob.delete');

    //show employer to candidate details
    Route::get('/employer/applyied/candidate/details/{id}', 'EmployerController@viewCandidateDetails')->name('cand.details');

    Route::get('/employer/applyied/postjob/details/{id}', 'EmployerController@postjobDetailView')->name('postjob.detailsview');
});
/* End of Employer Route list */

    //deatils view for candidate 
    Route::get('/postajob/details/{id}{requestpage?}', 'SiteController@jobDeatils')->name('postjob.details');

    //socialite 
    // Route::get('signin/facebook', 'SigninController@redirectToProvider')->name('fb.redirect');
    // Route::get('signin/facebook/callback', 'SigninController@handleProviderCallback');
    Route::get('signin/{provider}', 'SigninController@redirectToProvider')->name('fb.redirect');
    Route::get('signin/{provider}/callback', 'SigninController@handleProviderCallback');


    Route::get('signin/usertype', 'SigninController@socialLogin')->name('social.login');

    //Ajax call
    Route::post('/candidate/apply/rank/details', 'AjaxController@getPosthJobID')->name('job.data');
    Route::post('/candidate/apply/rank/potion/details', 'AjaxController@getPosthJobID')->name('jobposition.applylist');

    


    

    Route::get('/employer/download/resume/{id}', 'EmployerController@downloadResume')->name('download.resume');
 // });
    //job menu item1
    Route::get('/job/joblist/companywise/', 'PostjobController@companyWiseJoblist')->name('joblist.companywise');
    Route::get('/job/joblist/companywise/filter', 'PostjobController@companyWiseJoblistFilter')->name('joblist.companyfilter');

    //job menu item2
    // Route::get('/job/browse/joblist/', 'PostjobController@browseJoblist')->name('joblist.browse');
    Route::get('/job/browse/joblist/{company_name?}/{city?}/','PostjobController@browseJoblist')->name('joblist.browse');
    Route::get('/job/browse/joblist/search/{company_name?}/{city?}/{rank_position?}/','PostjobController@browseJoblistFromHome')->name('homepage_serach');
    
    Route::post('/job/browse/joblist/rankfilter/{company_name?}/{city?}/{rank_position?}/{params?}','PostjobController@browseJoblistRankfilter')->where('params', '(.*)')->name('rank.filter');
    //contact Us
    Route::get('/contactus/', 'SiteController@contactusView')->name('contactus.load');

// Route::group(['middleware' => ['verify.employer']], function () {   
    //chat routes for Employers
    Route::get('/chat', 'ChatController@index')->name('empchat');
    Route::get('/message1/{id}', 'ChatController@getMessage')->name('message');
    Route::get('message1/{id?}', 'ChatController@sendMessage');
// });

// Route::group(['middleware' => ['verify.candidate']], function () {
    //chat routes for Candidates
    Route::get('chat2/', 'ChatFromCandidateController@index')->name('candi.chat');
    Route::get('/message/{id}', 'ChatFromCandidateController@getMessage')->name('fromcandi.message');
    Route::get('message/{id?}', 'ChatFromCandidateController@sendMessage');
// });

    Route::get('/All/candidate/Gridlist/', 'EmployerController@viewCandidateGridList')->name('cand.gridlist');
    
    //logout user
    Route::post('/logout/user', 'SigninController@logoutUser')->name('logoutUser');

    //contact US inquiry save
    Route::post('/site/inquire/save', 'SiteController@inquirySave')->name('inquirysave');
    //change password
    Route::get('/enter/email', 'SiteController@emailEnterView')->name('emailenter');
    Route::post('/sent/resetlink', 'siteController@sendEmailResetLink')->name('resetlink');

    //emloyer can filter candidate 
    Route::get('/filter/candidate', 'EmployerController@filterCanidate')->name('filterCanidate');

    //user can filter browse job from homepage
    Route::get('/job/filter', 'PostjobController@homeSerchListBrowseJobs')->name('homesidejobfilter');

    //about us page
    Route::get('/aboutus', 'SiteController@aboutus')->name('aboutus');

    //knowledgeBase
    Route::get('/knowledgeBase', 'SiteController@knowledgeBase')->name('knowledgeBase');

    /*------------------------ Admin Panel Routes --------------------------------------*/
    Route::get('/control', 'admin\LoginController@index')->name('adminlogin');

    Route::post('/admin/login/user', 'admin\LoginController@login')->name('logintodashboard');
    Route::get('/admin/logout', 'admin\LoginController@adminLogout')->name('admin.logout');
    

    Route::get('admin/dashboard/', 'admin\DashboardController@index')->name('admin.dashboard');    
    //employer Admin Routes listing
    Route::get('admin/employer/listing', 'admin\ManageEmployerController@index')->name('employer.lists');
    Route::get('admin/employee/load/form', 'admin\ManageEmployerController@emploadform')->name('emploadform');    
    Route::post('admin/employee/add', 'admin\ManageEmployerController@addEmployee')->name('addEmp');

    //Emp profile verified admin
    Route::get('admin/employee/status/change', 'admin\ManageEmployerController@employerStatus')->name('employerStatus');

    //delete employer
    Route::post('admin/delete/employee', 'admin\ManageEmployerController@deleteEmployee')->name('deleteEmp');
    Route::get('admin/employer/edit', 'admin\ManageEmployerController@editEmployee')->name('editEmp');
    //update employee
    Route::post('admin/employee/update', 'admin\ManageEmployerController@updateEmployee')->name('updateEmp');
    //get state list based on country
    Route::post('admin/employee/statelist', 'admin\ManageEmployerController@getStateList')->name('getStateList');
    Route::post('admin/employee/citylist', 'admin\ManageEmployerController@getCityList')->name('getCityList');

    Route::get('admin/employee/states', 'admin\ManageEmployerController@getStates')->name('states_m');
    
    Route::get('admin/employee/cities', 'admin\ManageEmployerController@getCities')->name('cities_m');
    
    //candidate listing
    Route::get('admin/candidate/listing', 'admin\ManageCandidateController@index')->name('candidate.listing');
    Route::post('admin/delete/candidate', 'admin\ManageCandidateController@deleteCandidate')->name('deleteCandidate');
    Route::post('admin/candidate/update/{id}', 'admin\ManageCandidateController@updateCandidate')->name('updateCandidate');
    Route::get('admin/candidate/load/form', 'admin\ManageCandidateController@CandidateFormLoad')->name('candiform');
    Route::post('admin/candidate/add', 'admin\ManageCandidateController@addCandidate')->name('addCandidate');

    //edit candidates
    Route::get('admin/candidate/edit', 'admin\ManageCandidateController@editCandidate')->name('editCandidate');
    Route::post('admin/delete/candidate', 'admin\ManageCandidateController@deleteCandidate')->name('deleteCandidate');
    //email verified status change
    Route::get('admin/candidate/verified/status', 'admin\ManageCandidateController@candidateEmailVerifiedByAdmin')->name('candiEverifiedChange');
    
    //postjob listing
    Route::get('admin/postjob/listing' ,'admin\ManagePostjobController@index')->name('postjobs.lists');    
    Route::post('admin/postjob/featured' ,'admin\ManagePostjobController@featurejobAjax')->name('featurePostjob');
    Route::post('admin/postjob/unfeatured' ,'admin\ManagePostjobController@unfeaturejobAjax')->name('unfeaturePostjob');
    //itf jobs
    Route::post('admin/postjob/itfjobs' ,'admin\ManagePostjobController@itfJobAjax')->name('itfjobsPostjob');
    Route::post('admin/postjob/nonitfjobs' ,'admin\ManagePostjobController@nonitfJobAjax')->name('nonitfjobsPostjob');

    Route::post('admin/postjob/updateitfpostjob' ,'admin\ManagePostjobController@setUnsetItfJob')->name('setunsetitfjob');
    Route::post('admin/postjob/updatefeaturedpostjob' ,'admin\ManagePostjobController@setUnsetFeaturedJob')->name('setunsetfeaturedjob');
    
    //postjob add update
    Route::get('admin/postjob/form' ,'admin\ManagePostjobController@addpostjob')->name('addPostjob');
    Route::post('admin/postjob/insert', 'admin\ManagePostjobController@insertPostjob')->name('insertNewPostJob');
    Route::get('admin/postjob/editform' ,'admin\ManagePostjobController@editPostjob')->name('editPostjob');
    Route::post('admin/postjob/updatedata', 'admin\ManagePostjobController@updatePostjob')->name('updatePostjobAdmin');

    //delete post job
    Route::post('admin/delete/postjob', 'admin\ManagePostjobController@deletePostjob')->name('deletePostjob');

    //jobapplylist
    Route::get('admin/jobapply/listing' ,'admin\ManageJobapplyController@index')->name('jobapply.listing');
    
    //chat conversion add call
    Route::get('chat/add/conversation/' ,'SiteController@conversationAdd')->name('chatrecAdd');

    //Document add by admin
    Route::get('admin/documents/listing', 'admin\ManageDocsController@index')->name('admin.doclisting');
    Route::get('admin/documents/loadform', 'admin\ManageDocsController@loadDocForm')->name('admin.loadDocForm');
    Route::post('admin/documents/adddocs', 'admin\ManageDocsController@addDocs')->name('admin.addDocs');
    Route::get('admin/documents/editform', 'admin\ManageDocsController@editForm')->name('admin.editForm');
    Route::post('admin/documents/update', 'admin\ManageDocsController@updateDocs')->name('admin.updateDocs');
    Route::post('admin/documents/delete', 'admin\ManageDocsController@deleteDocs')->name('admin.deleteDocs');
    Route::get('admin/enquiries', 'admin\DashboardController@enquiriesList')->name('enquiries');