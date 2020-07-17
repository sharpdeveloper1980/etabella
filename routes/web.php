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
Route::get('set-message','ClientController@send_message');
Route::get('show-notification',function(){
	return view('showNotification');
});
Route::get('open_presentation/{id}','ClientController@open_presentation');
Route::get('open_presentation_admin/{id}','ClientController@open_presentation_admin');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact_us', function () {
    return view('contactus');
});

Route::get('/about', function () {
    return view('aboutus');
});

Route::get('/features', function () {
    return view('features');
});

						/** Routes For Admin Panel **/ 

Route::prefix('admin')->group(function(){

Auth::routes();

/**
Start Routes Files
**/
Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/export-file/{type}', 'HomeController@exportFile')->name('export.file');
Route::post('/render-logs','HomeController@renderLogs')->name('renderLogs');

Route::prefix('files')->group(function(){
	Route::get('/{id}', 'HomeController@subFiles')->name('Subfiles');
	Route::get('/get_file/{id}', 'HomeController@getFileById')->name('Getfile');
	Route::post('/rename/{id}', 'HomeController@renameFiles')->name('Renamefile');
	Route::post('/create_folder', 'HomeController@createFolder')->name('CreateFolder');
	Route::put('/update_folder/{id}', 'HomeController@updateFolder')->name('Renamefile');
	Route::post('/upload_files', 'HomeController@uploadFiles')->name('uploadFiles');
	Route::get('/file/shared/{fileid}/{parentid}/{id}', 'HomeController@fileShared')->name('fileShared');
	Route::get('/file/added/{fileid}/{parentid}/{id}', 'HomeController@fileAdded')->name('fileAdded');
	Route::delete('/delete/{fileId}','HomeController@deleteFile');
});
/**
End Routes Files
**/

/**
Start Routes Clients
**/
Route::prefix('clients')->group(function(){
    Route::get('uploadodfonserver', 'HomeController@uploadodfonserver')->name('uploadodfonserver');
	Route::get('/', 'HomeController@clients')->name('adminClients');
	Route::get('/client_log', 'HomeController@clientActivityLog')->name('clientActivityLog');
	Route::get('/active_clients', 'HomeController@activeClients')->name('activeClients');
	Route::get('/inactive_clients', 'HomeController@inactiveClients')->name('inactiveClients');
	Route::get('/add', 'HomeController@addClient')->name('addClient');
	Route::post('/save', 'HomeController@saveClient')->name('saveClient');
	Route::get('/edit/{id}', 'HomeController@editClient')->name('editClient');
	Route::put('/update/{id}', 'HomeController@updateClient')->name('updateClient');
	Route::delete('/delete/{id}', 'HomeController@deleteClient')->name('deleteClient');
	Route::get('/downloaded_files/{id}', 'HomeController@getClientDownloaded')->name('getClientDownloaded');
});
/**
End Routes Clients
**/

/**
Start Routes All Admins
**/
Route::prefix('admins')->group(function(){
	Route::get('/', 'HomeController@admins')->name('adminAdmins');
	Route::get('/admin_log', 'HomeController@adminActivityLog')->name('adminActivityLog');
	Route::get('/active_admins', 'HomeController@activeAdmins')->name('activeAdmins');
	Route::get('/inactive_admins', 'HomeController@inactiveAdmins')->name('inactiveAdmins');
	Route::get('/add', 'HomeController@addAdmins')->name('addAdmins');
	Route::post('/save', 'HomeController@saveAdmins')->name('saveAdmins');
	Route::get('/edit/{id}', 'HomeController@editAdmins')->name('editAdmins');
	Route::put('/update/{id}', 'HomeController@updateAdmins')->name('updateAdmins');
	Route::delete('/delete/{id}', 'HomeController@deleteAdmins')->name('deleteAdmins');
});
/**
End Routes All Admins
**/

/**
Start Routes Settings
**/
Route::prefix('settings')->group(function(){
	Route::get('/change_password', 'HomeController@changePassword')->name('changePassword');
	Route::put('/update_password', 'HomeController@updatePassword')->name('updatePassword');
	Route::get('/ftp', 'HomeController@ftp')->name('Ftp');
	Route::post('/ftp/save', 'HomeController@saveFtp')->name('saveFtp');
	Route::put('/ftp/update/{id}', 'HomeController@updateFtp')->name('updateFtp');
});
/**
End Routes Settings
**/

/**
Start Routes Groups
**/
Route::prefix('groups')->group(function(){
	Route::get('/', 'HomeController@groups')->name('groups');
	
	Route::get('/add', 'HomeController@addGroup')->name('addgroup');
	Route::post('/save', 'HomeController@saveGroup')->name('saveGroup');
	Route::get('/edit/{id}', 'HomeController@editGroup')->name('editGroup');
	Route::put('/update/{id}', 'HomeController@updateGroup')->name('updateGroup');
	Route::delete('/delete/{id}', 'HomeController@deleteGroup')->name('deleteGroup');
});
/**
End Routes Groups
**/

/**
Start Routes Jobs
**/
Route::prefix('jobs')->group(function(){
	Route::get('/', 'HomeController@jobs')->name('jobs');
	Route::get('/add', 'HomeController@addJob')->name('addJob');
	Route::post('/save', 'HomeController@saveJob')->name('saveJob');
	Route::get('/edit/{id}', 'HomeController@editJob')->name('editJob');
	Route::put('/update/{id}', 'HomeController@updateJob')->name('updateJob');
	Route::delete('/delete/{id}', 'HomeController@deleteJob')->name('deleteJob');
	});
});
/**
End Routes Jobs
**/

							/** End Admin Routes **/

						/** Start Client Panel Routing **/
Route::get('clients/login','Auth\LoginController@showClientLogin')->name('showClientLogin');
Route::post('clients/login','Auth\LoginController@postClientLogin')->name('postClientLogin');
Route::group(['middleware' => 'authcheck'], function () {
Route::prefix('clients')->group(function(){
	Route::post('/selected_text_information_save','ClientController@selected_text_information_save');
	Route::post('/read_all_text_comment','ClientController@read_all_text_comment');
	Route::post('/shareComment','ClientController@shareComment');
	Route::post('/shared_file_update','ClientController@shared_file_update');
	
	/**
	Start Client Authentication
	**/
	
	Route::get('/logout','Auth\LoginController@clientlogout')->name('clientlogout');
	/**
	End Client Authentication
	**/

	/**
	Start Client Panel Routing
	**/
	
	/*deependra*/
    Route::get('uploadodfonserver', 'ClientController@uploadodfonserver')->name('uploadodfonserver');
    Route::get('check_file', 'ClientController@check_file')->name('check_file');
	Route::get('/examination_schedule/{whchjob}', 'ClientController@examination_schedule')->name('examination_schedule');
	Route::get('/examination_schedule_inner/{whchjob}', 'ClientController@examination_schedule_inner')->name('examination_schedule_inner');
	Route::post('/create_witness', 'ClientController@create_witness')->name('create_witness');
	Route::post('/modify_witness', 'ClientController@modify_witness')->name('modify_witness');
	Route::post('/delete_witness', 'ClientController@delete_witness')->name('delete_witness');
	Route::post('/change_order', 'ClientController@change_order')->name('change_order');
	Route::post('/add_to_witness/{wid}', 'ClientController@add_to_witness')->name('add_to_witness');
	Route::post('/delete_witness_file/{wid}', 'ClientController@delete_witness_file')->name('delete_witness_file');
	Route::post('/copy_witness', 'ClientController@copy_witness')->name('copy_witness');
	Route::get('/dash', 'ClientController@dash')->name('dash');
	Route::get('/manage_docs/{witness_id}/{whchjob}', 'ClientController@manage_docs_copy')->name('manage_docs_copy');

    //Route::get('/manage_docs_copy/{witness_id}/{whchjob}', 'ClientController@manage_docs_copy')->name('manage_docs_copy');
	Route::get('/examination_schedule_render/{id}/{witness_id}', 'ClientController@examination_schedule_render')->name('examination_schedule_render');
	
	Route::post('/Modify_files/', 'ClientController@Modify_files')->name('Modify_files');
	Route::post('/change_order_docs/', 'ClientController@change_order_docs')->name('change_order_docs');
	Route::post('/search_witness_and_file/', 'ClientController@search_witness_and_file')->name('search_witness_and_file');
	Route::post('/search_witness/', 'ClientController@search_witness')->name('search_witness');
	Route::post('/search_witness_files', 'ClientController@search_witness_files')->name('search_witness_files');
	
	
	
	/*deependra*/
	Route::post('/files_goto', 'ClientController@files_goto')->name('files_goto');
	Route::get('get_doc_by_tagid/{tagid}/{whchjob}','ClientController@get_doc_by_tagid')->name('get_doc_by_tagid');
	Route::post('/move_to_witness_file/','ClientController@move_to_witness_file')->name('move_to_witness_file');
	
	
	Route::get('/','ClientController@clientDashboard')->name('clients');
	Route::get('/dashboard','ClientController@clientDashboard')->name('clientDashboard');
	Route::get('/dashboard/{job}','ClientController@clientDashboard')->name('clientDashboardwithJob');
	
	Route::get('/groups','ClientController@inbox')->name('Groups');
	
	Route::get('/groups/{job}','ClientController@inbox')->name('GroupsJob');
	Route::get('/groups/{job}/{group_id}','ClientController@inbox')->name('Groupselected');

	Route::get('/groups-single/{job}/{group_id}','ClientController@groups_single')->name('groups_single');
	
	Route::get('/user/{job}/{user_id}','ClientController@directChat')->name('Direct');
	Route::get('/user-single/{job}/{user_id}','ClientController@user_single')->name('user_single');
	Route::get('/read_message/{id}','ClientController@read_message')->name('read_message'); 
	
	/*deependra*/
	Route::get('/export_group_chat/{group_id}','ClientController@export_group_chat')->name('export_group_chat');
	Route::get('/export_topic_chat/{group_id}','ClientController@export_topic_chat')->name('export_topic_chat');
	Route::get('/export_direct_chat/{group_id}','ClientController@export_direct_chat')->name('export_direct_chat');
	/*deependra*/


	
	Route::get('/files/{id}/{whchjob}', 'ClientController@subFiles')->name('Subfiles');
	Route::get('/file/render/{name}', 'ClientController@fileRender')->name('fileRender');
	Route::get('/file/render/{name}/{page}', 'ClientController@fileRender')->name('fileRender');

	Route::get('/recent-opened/{file_id}', 'ClientController@recentOpened')->name('recentOpened');
	Route::get('/recent-annoted/{file_id}', 'ClientController@recentAnnoted')->name('recentAnnoted');
	Route::get('/recent-commented/{file_id}', 'ClientController@recentCommented')->name('recentCommented');
	Route::get('/recent-shared/{file_id}/{rec_id}', 'ClientController@recentShared')->name('recentShared');
	

	Route::get('/get-recent-opened/{job_id}', 'ClientController@getRecentOpened')->name('getRecentOpened');
	Route::get('/get-recent-annoted/{job_id}', 'ClientController@getRecentAnnoted')->name('getRecentAnnoted');
	Route::get('/get-recent-commented/{job_id}', 'ClientController@getRecentCommented')->name('getRecentCommented');
	Route::get('/get-recent-shared/{job_id}', 'ClientController@getRecentShared')->name('getRecentShared');
	Route::get('/get-recent-commented/{job_id}', 'ClientController@getRecentCommented')->name('getRecentCommented');
	Route::post('/render-quick/{job_id}/{type}', 'ClientController@renderQuick')->name('renderQuick');
	
	/**
	Start Download files routing
	**/
	Route::post('/files/downloading','ClientController@downloading')->name('downloading');
	Route::post('/files/exportzip','ClientController@exportZipFiles')->name('exportZipFiles');
	Route::post('/files/delete-downloaded','ClientController@deleteDownloaded')->name('deleteDownloaded');

	Route::post('/files/printing','ClientController@printing')->name('printing');

	Route::get('/get_notifications','ClientController@getNewNotifications')->name('getNewNotifications');

	Route::post('/files/download_file','ClientController@downloadFile')->name('downloadFile');
	// Route::get('/my_files','ClientController@myFiles')->name('myFiles');
	/**
	End Download files routing
	**/
	Route::post('/files/upload_files', 'ClientController@uploadFiles')->name('clientUploadFiles');
	/**
	Start My Files Routing
	**/
	Route::get('/myfiles','ClientController@myFiles')->name('myFiles');
    Route::get('/myfiles/{whchjob}','ClientController@myFiles')->name('myFilesWithJob');
    Route::get('/myfiles/{id}/{whchjob}','ClientController@subDownloadedFiles')->name('myFilesWithIdAndJob');
	/**
	End
	**/
	
	/**
	Start Rename Files Routing
	**/
	Route::get('/get_file/{id}', 'ClientController@getFileById')->name('Getfile');
	Route::get('/get_editedfile/{id}', 'ClientController@getEditedFileById')->name('GetEditedfile');
	Route::post('/rename/{id}', 'ClientController@renameFiles')->name('Renamefile');
	/**
	End
	**/

	/**
	Start Sort My Files Routing
	**/
	Route::get('/sorting/{job}/{order}','ClientController@sortingFiles')->name('sortingFiles');
	Route::get('/sortmyfiles/{job}/{order}','ClientController@sortingMyFiles')->name('sortingMyFiles');

	
	Route::post('/sortmyfiles','ClientController@sortMyFiles')->name('sortMyFiles');
	
	Route::post('/change_msg_status','ClientController@changeMsgStatus')->name('changeMsgStatus');
	Route::post('/change_notif_status','ClientController@changeNotifStatus')->name('changeNotifStatus');
	
	
	Route::post('/change_msg_status1','ClientController@changeMsgStatus1')->name('changeMsgStatus');
	Route::post('/change_notif_status1','ClientController@changeNotifStatus1')->name('changeNotifStatus');
	
	
	Route::post('/change_msg_status_topic','ClientController@changeMsgStatus_topic')->name('changeMsgStatus_topic');
	


	Route::post('/send_msg_group','ClientController@sendMsgGroup')->name('sendMsgGroup');
	Route::post('/send_msg_topic','ClientController@send_msg_topic')->name('send_msg_topic');

	Route::get('/get_group_messages/{group_id}/{last_msg}','ClientController@groupMessages')->name('groupMessages');
	Route::get('/get_topic_messages/{group_id}/{last_msg}','ClientController@topicMessages')->name('topicMessages');

	Route::get('/get_previous_messages/{group_id}/{last_msg_id}','ClientController@groupPrevMessages')->name('groupPrevMessages');
	 Route::get('/tokenPrevMessages/{group_id}/{last_msg_id}','ClientController@tokenPrevMessages')->name('tokenPrevMessages');


	Route::get('/topics','ClientController@topics')->name('topics');
    Route::post('/topics/add_topics','ClientController@add_topics')->name('add_topics');
	Route::get('/topics/{job}','ClientController@topics')->name('topicsJob');
	Route::get('/topics/{job}/{topic_id}','ClientController@topics')->name('topicselected');
	Route::get('/topics-single/{job}/{topic_id}','ClientController@topics_single')->name('topics_single');
	Route::post('/topics/update_topics','ClientController@update_topics')->name('update_topics');


	Route::post('/send_msg_direct','ClientController@sendMsgDirect')->name('sendMsgDirect');

	Route::get('/get_direct_messages/{client_id}/{last_msg}','ClientController@getDirectMessages')->name('getDirectMessages');

	Route::post('/change_direct_msg_status','ClientController@changeDirectMsgStatus')->name('changeDirectMsgStatus');
	Route::post('/change_direct_notif_status','ClientController@changeDirectNotifStatus')->name('changeDirectNotifStatus');

	Route::get('/get_previous_direct_messages/{client_id}/{last_msg_id}','ClientController@directPrevMessages')->name('directPrevMessages');
	/**
	End
	**/

	Route::get('/activity-log','ClientController@clientActivityLog')->name('myActivityLog');
	Route::post('/render-logs','ClientController@myRenderLogs')->name('myRenderLogs');

	Route::get('/search/{kewords}/{job}','ClientController@searchByKeywords')->name('searchByKeywords');

	Route::get('/search_inside/{kewords}/{job}','ClientController@searchInsideByKeywords')->name('searchInsideByKeywords');

	Route::get('/searchmyfiles/{keywords}/{job}','ClientController@searchMyFilesByKeywords')->name('searchMyFilesByKeywords');

	Route::get('/searchmyfiles/{keywords}','ClientController@searchMyFilesInModal')->name('searchMyFilesInModal');

	Route::get('/searchmyfileshyperlink/{keywords}','ClientController@searchMyFilesInHyperlink')->name('searchMyFilesInHyperlink');

	Route::post('/compare','ClientController@compareFiles')->name('compareFiles');

	Route::post('/compare-file','ClientController@compareFilesFirst')->name('compareFilesFirst');

	Route::post('/add_tag','ClientController@addTag')->name('addTag');

	Route::get('get-tags/{id}','ClientController@getTags')->name('getTags');

	Route::get('delete_tag/{id}','ClientController@deleteTag')->name('deleteTag');

	Route::get('change_tag/{tagid}/{fileid}','ClientController@changeTag')->name('changeTag');

	Route::get('get_active_tag/{fileid}','ClientController@getActiveTag')->name('getActiveTag');
	Route::get('removeFileTag/{fileid}/{tagid}','ClientController@removeFileTag')->name('removeFileTag');

	Route::get('get-tags-for-filter','ClientController@getTagsForFilter')->name('getTagsForFilter');
	Route::get('get-tags-for-filter-exe','ClientController@getTagsForFilter_exe')->name('getTagsForFilter_exe');

	Route::get('get-by-tagid/{tagid}/{whchjob}','ClientController@getByTagid')->name('getByTagid');

	/**
	Start Saving Instant Json for Annotations , Bookmarks & Notes Routing
	**/
	Route::post('/instant-json1','ClientController@instantJson1')->name('instantJson1');
	Route::post('/instant-json','ClientController@instantJson')->name('instantJson'); 

	Route::get('/get_tag_color/{id}','ClientController@get_tag_color')->name('get_tag_color');

	Route::post('/share-annotation','ClientController@shareAnnotation')->name('shareAnnotation');	
	/**
	End Saving Instant Json for Annotations , Bookmarks & Notes Routing
	**/
	Route::get('/reports','ClientController@reports')->name('Reports');
	Route::get('/reports/{job}','ClientController@reports')->name('ReportsJob');

	Route::post('/report-files','ClientController@reportFiles')->name('ReportFiles');

	Route::get('/dashboard-tree','ClientController@dashPlugin')->name('dashPlugin');
	Route::get('/mark_read/{id}','ClientController@markAsRead')->name('markAsRead');
	Route::get('/mark_all_read','ClientController@markAllRead')->name('markAllRead');
	Route::get('/notifications','ClientController@allnotifications')->name('allnotifications');
	Route::get('/notifications/{job_id}','ClientController@allnotifications')->name('notificationsjob');
	Route::get('/message_notification/{job_id}','ClientController@message_notofication')->name('message_notofication');
    Route::get('/read_message_notification/{job_id}','ClientController@read_message_notification')->name('read_message_notification');
	Route::get('/shared/{id}','ClientController@check')->name('check');
	Route::get('/from/dashboard/{id}','ClientController@fromDashboard')->name('fromDashboard');
	Route::get('/get-render-file/{id}','ClientController@getForRender')->name('getForRender');
	Route::get('/vue','ClientController@vueRender')->name('vueRender');

	Route::post('/add_new_issue','ClientController@addIssue')->name('addIssue');
	Route::get('/get_all_issue','ClientController@get_all_issue')->name('get_all_issue');
	Route::get('/delete_issue/{id}','ClientController@delete_issue')->name('delete_issue');
	Route::post('/check_hyperlink','ClientController@check_hyperlink')->name('check_hyperlink');
	Route::post('/add_to_link_add','ClientController@add_to_link_add')->name('add_to_link_add');
	Route::post('/add_to_link_page_no','ClientController@add_to_link_add')->name('add_to_link_add');
	Route::post('/upload_pdf_file_for_pdf/{id}','ClientController@upload_pdf_file_for_pdf')->name('add_to_link_add');
	Route::post('/get_document_file','ClientController@get_document_file')->name('get_document_file');
	Route::post('/get_document_file_one','ClientController@get_document_file_one')->name('get_document_file_one');
	Route::get('/move_doc/{to}/{from}','ClientController@moveDoc')->name('moveDoc');
	Route::get('/move_doc/{to}/{from}/{sufix}','ClientController@moveDoc')->name('moveDoc');
	Route::post('files/copy_doc','ClientController@copyDoc')->name('copyDoc');
	Route::get('check_filename/{folderid}/{fileid}','ClientController@checkFilename')->name('checkFilename');
	Route::post('delete_server_annotation','ClientController@delete_annotation')->name('delete_annotation');
	Route::get('add_activity/{text}','ClientController@add_activity')->name('add_activity');
	Route::get('get_file_token/{file_id}','ClientController@get_file_token')->name('get_file_token');


	Route::post('send_msg_direct_file','ClientController@send_msg_direct_file')->name('send_msg_direct_file');
	Route::post('render-notification','ClientController@render_notification')->name('render_notification');
	Route::post('update_timezone','ClientController@update_timezone')->name('update_timezone');

	Route::post('delete_overlay','ClientController@delete_overlay')->name('delete_overlay');
	Route::get('ipaddress_testing','ClientController@ipaddress_testing')->name('ipaddress_testing');
	
});
});
  
  						/** End Client Panel Routing **/

