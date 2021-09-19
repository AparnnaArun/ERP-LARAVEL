@extends('admin/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span> User Details
              </h3>
              
            </div>
 <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                                                                          @if (session('status'))
<div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                     <form class="forms-sample" action ="{{('/editsusers')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="{{$user->id}}" />
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="name" value="{{$user->name}}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Login Name</span>
                        </div>
                        <input type="text" class="form-control" name="login_name" value="{{$user->login_name}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Phone</span>
                        </div>
                        
                        <input type="text" class="form-control" name="mobile" value="{{$user->mobile}}" >
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Email</span>
                        </div>
                        <input type="email" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="email" value="{{$user->email}}" >
                      </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Manager</span>
                        </div>
                        
                        <select class="form-control" aria-label="" name="manager" >
                          <option value="" {{($user->manager == '' ? ' selected' : '') }} >Not Applicable</option>
                          @foreach($users as $us)
                          <option value="{{$us->id}}" {{($user->manager == $us->id ? ' selected' : '') }}>{{$us->login_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                    
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                        
                        <select class="form-control" aria-label="" name="executive" required>
                          <option value="" hidden >Not Applicable</option>
                           @foreach($exes as $data)
<option value="{{$data->short_name}}" {{($user->executive == $data->short_name ? 'selected' : '') }}>{{$data->short_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Usertype</span>
                        </div>
                        
                        <select class="form-control" aria-label="" name="usertype">
                          <option value="Admin" {{($user->usertype == 'Admin' ? ' selected' : '') }}>Admin</option>
                          <option value="Subadmin" {{($user->usertype == 'Subadmin' ? ' selected' : '') }} >Subadmin</option>
                          <option value="User" {{($user->usertype == 'User' ? ' selected' : '') }} >User</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                     
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"  name="costvisible"   value="yes" {{($user->costvisible == 'yes' ? ' checked' : '') }}> Cost Visible </label>
                            </div>
                </div>
            </div>
            <div class="row">
               <div class="col-md-2">
                <label class="form-check-input required">Company</label>
              </div>
              @foreach($comp as $uco)
           
              <div class="col-md-2">
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="company[]" value="{{$uco->id}}" {{($uco->id == $ucom[0]->companyid ? 'checked' : '') }}> 
                                 {{$uco->short_name}} </label>
                                 <input type="hidden" class="form-check-input" name="uid[]" value="{{$user->id}}" >
                            </div>
                          </div>
                         
              @endforeach
                           </div>
            <div class="row">
               <div class="col-md-2">
                <label class="form-check-input required">Modules</label>
              </div>
              <div class="col-md-2">
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="admin"  value="admin" {{($user->admin == 'admin' ? ' checked' : '') }}> Admin </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="inventory"  value="inventory" {{($user->inventory == 'inventory' ? ' checked' : '') }}> Inventory </label>
                            </div>
           </div>
           <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="accounts"  value="accounts" {{($user->accounts == 'accounts' ? ' checked' : '') }} > Accounts </label>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="hr"  value="hr" {{($user->hr == 'hr' ? ' checked' : '') }} > HR </label>
                            </div>
                             </div>
                           </div>
                           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg">Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
        </div>
                </form>    
                  </div>
                </div>
              </div>

     <!-- /////////////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Login Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/users-edit/{{$user->id}}">{{$user->name}}</a></td>
      <td><a href="/admin/users-edit/{{$user->id}}">{{$user->login_name}}</a></td>
      <td><a href="/admin/users-edit/{{$user->id}}">{{$user->mobile}}</a></td>
      <td><a href="/admin/users-edit/{{$user->id}}">{{$user->email}}</a></td>
    </tr>
   @endforeach
  </tbody>
</table>
                  </div>
                </div>
              </div>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              </div>
    </div>
  </div>
</div>
 <script type="text/javascript">
   /////////////////////Password Show///////////////////////
//   function myFunction() {
//   var x = document.getElementById("password");
//   if (x.type === "password") {
//     x.type = "text";
//   } else {
//     x.type = "password";
//   }
// }
 </script>             
@stop