@extends('layouts.backend.app')

@section('title','Dashboard')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
            <button id="new_folder" type="button" class="btn btn-warning btn-pill-left"><i class="fa fa-plus"></i> New Folder</button>
            <button id="upload" type="button" class="btn btn-info btn-pill-right"><i class="fa fa-upload"></i> Upload Files</button>
         </div>
      </div>
      <!-- END Language list    -->
      Files
      <!-- <small>Hehe</small> -->
   </div>
   <div class ="container">
      <div class="col-lg-12 selectfiletype">
         <div class="col-lg-4">
            <select class="form-control" id="selectfiletype" name="selectfiletype">
               <option value="MyFile">MyFile</option>
               <option value="MyPresentedFile">MyPresentedFile</option>
               <option value="Both">Both</option>
            </select>
         </div>
         <div class="col-lg-6">
            <button class="btn btn-success pull-left" id="savefiletype" type="button">Save</button>
         </div>
      </div>
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="fa fa-home"></i> Home
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Date Modified</th>
                           <th>Size</th>
                           <th>Share</th>
                           <th>Add File</th>
                           <th>Options</th>
                           <th>filetype</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr id="row5995">
                           <td>
                              <a href="http://66.206.3.18/etabellaweb/files/5995"><i class='fa fa-folder-open'></i>                                                    <span class='file' id="name5995">demo</span>
                              </a>                                                
                           </td>
                           <td>July 31, 2019 at 05:38 PM</td>
                           <td>3.92MB</td>
                           <td>
                              <button id="share5995" type="button" class="mb-sm btn btn-default share" file-id="5995"><i class="fa fa-share"></i></button>
                           </td>
                           <td>
                           </td>
                           <td>
                           </td>
                           <td>
                              <button id="delete5995" type="button" class="mb-sm btn btn-danger delete" file-id="5995"><i class="fa fa-remove"></i></button>
                              <button id="rename5995" type="button" class="mb-sm btn btn-purple rename" file-id="5995"><i class="fa fa-edit"></i></button>
                              <button id="editfile5995" type="button" class="mb-sm btn btn-red editfile" file-id="5995"><i class="fa fa-edit"></i></button>
                           </td>
                        </tr>
                        <tr id="row2">
                           <td>
                              <a href="http://173.249.10.182:8080/etabellaweb/files/2"><i class='fa fa-folder-open'></i>                                                    <span class='file' id="name2">DIAC Case No. 197-2017</span>
                              </a>                                                
                           </td>
                           <td>July 29, 2019 at 10:33 AM</td>
                           <td>2.49GB</td>
                           <td>
                              <button id="share2" type="button" class="mb-sm btn btn-success share shared" file-id="2"><i class="fa fa-share"></i></button>
                           </td>
                           <td>
                           </td>
                           <td>
                           </td>
                           <td>
                              <button id="delete2" type="button" class="mb-sm btn btn-danger delete" file-id="2"><i class="fa fa-remove"></i></button>
                              <button id="rename2" type="button" class="mb-sm btn btn-purple rename" file-id="2"><i class="fa fa-edit"></i></button>
                              <button id="editfile2" type="button" class="mb-sm btn btn-red editfile" file-id="2"><i class="fa fa-edit"></i></button>
                           </td>
                        </tr>
                        <tr id="row5985">
                           <td>
                              <a href="http://173.249.10.182:8080/etabellaweb/files/5985"><i class='fa fa-folder-open'></i>                                                    <span class='file' id="name5985">Prep Info</span>
                              </a>                                                
                           </td>
                           <td>July 31, 2019 at 05:35 PM</td>
                           <td>819.36KB</td>
                           <td>
                              <button id="share5985" type="button" class="mb-sm btn btn-default share" file-id="5985"><i class="fa fa-share"></i></button>
                           </td>
                           <td>
                           </td>
                           <td>
                           </td>
                           <td>
                              <button id="delete5985" type="button" class="mb-sm btn btn-danger delete" file-id="5985"><i class="fa fa-remove"></i></button>
                              <button id="rename5985" type="button" class="mb-sm btn btn-purple rename" file-id="5985"><i class="fa fa-edit"></i></button>
                              <button id="editfile5985" type="button" class="mb-sm btn btn-red editfile" file-id="5985"><i class="fa fa-edit"></i></button>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <!-- END dashboard main content-->
      <input type="hidden" id="parent_id" value="0"/>
   </div>
</div>
</section>
@endsection
