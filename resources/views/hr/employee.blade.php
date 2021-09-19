@extends('hr/layout')
@section ('content')
@include('admin.newaccount') 
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span>Employee Details
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
                    <form class="forms-sample" action ="{{('/createemployees')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Emp.ID</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="empid" value="{{ $empid,old('empid') }}"  readonly="readonly">

                        <input type="hidden" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="slno" value="{{$nepm}}"  readonly="readonly">
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">DOB</span>
                        </div>
                        
                        <input type="text" class="form-control datepicker" name="dob" value="{{ old('dob') }}" >
                      
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-md-8">
                <a href="#"  class="btn btn-dark btn-sm btn-fw mr-2 obutton">Office Info</a>
              <a href="#"  class="btn btn-dark btn-sm btn-fw mr-2 cbutton">Contact Info</a>
              <a href="#" class="btn btn-dark btn-sm btn-fw mr-2 pbutton">Personal Info</a>
            </div>
            </div>
            <div class="office" >
            <div class="row mt-3">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date Of Joining</span>
                        </div>
                        <input type="text" class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dateofjoining" value="{{ old('dateofjoining') }}" >
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Joining Position</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="joiningposition" value="{{ old('joiningposition') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Department</span>
                        </div>
                        <input type="text" class="form-control" name="department" value="{{ old('department') }}">
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Current Position</span>
                        </div>
                        
                        <input type="text" class="form-control" name="curposition" value="{{ old('curposition') }}">
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                  <label class="form-check-label required">Salaried </label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input" checked  name="salaried" value='1'> Yes </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="salaried" value='0'> No </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label required">
                                <input type="checkbox" class="form-check-input approve" name="approve"   value="1" > Approve </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Basic Salary</span>
                        </div>
                        <input type="text"  class="form-control" name="bsalary" value="{{old('bsalary')}}" >
                        
                        
                      </div>
                    </div>
                </div>
                           </div>
            <div class="row">
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Allowance</span>
                        </div>
                        <input type="text"  class="form-control" name="allowance" value="{{ old('allowance') }}">
                      
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Vehicle Reg.No</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vehicleno" value="{{ old('vehicleno') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">A/C Name</span>
                        </div>
                        <select class="form-control accname" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="accname"  required="">
                          <option value="" hidden>Account</option>
                        @foreach($accountslist as $list)
                        <option value="{{$list->id}}" >{{$list->printname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
            </div>
             <div class="contact" style="display:none;">
            <div class="row mt-3" >
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Address</span>
                        </div>
                        <textarea class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="address" value="{{ old('address') }}" >
                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Actual DOB</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="actualdob" value="{{ old('actualdob') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group ">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Address Home</span>
                        </div>
                        <textarea class="form-control" name="homeaddr" value="{{ old('homeaddr') }}">
                        </textarea>
                        
                      </div>
                    </div>
                </div>
               </div>
              <div class="row">
                <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Kwt.Tel1</span>
                        </div>
                        <input type="text" class="form-control " name="kwttel1" value="{{ old('kwttel1') }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Kwt.Tel2</span>
                        </div>
                        <input type="text" class="form-control " name="kwttel2" value="{{ old('kwttel2') }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Home.Tel</span>
                        </div>
                        <input type="text" class="form-control " name="hometel" value="{{ old('hometel') }}">
                        
                      </div>
                    </div>
                          </div>
                        </div>
                        <div class="row"> 
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Email</span>
                        </div>
                        <input type="email" class="form-control " name="email" value="{{ old('email') }}">
                        
                      </div>
                    </div>
                          </div>
                <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 1st Contact</span>
                        </div>
                        <input type="text" class="form-control " name="emergency1" value="{{ old('emergency1') }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 1st Contact#</span>
                        </div>
                        <input type="text" class="form-control " name="emergency1no" value="{{ old('emergency1no') }}">
                        
                      </div>
                    </div>
                          </div>
                        </div>
                        <div class="row"> 
                          
                <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 2nd Contact</span>
                        </div>
                        <input type="text" class="form-control " name="emergency2" value="{{ old('emergency2') }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 2nd Contact#</span>
                        </div>
                        <input type="text" class="form-control " name="emergency2no" value="{{ old('emergency2no') }}">
                        
                      </div>
                    </div>
                          </div>
                        </div>
                      </div>
                      <div class="personal" style="display:none;">
                          <div class="row mt-3" >
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Spouse Name</span>
                        </div>
                        <input type="text" class="form-control" name="spouse" value="{{ old('spouse') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Spouse #</span>
                        </div>
                        <input type="text" class="form-control" name="spouseno" value="{{ old('spouseno') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">No.Of Children</span>
                        </div>
                        <input type="text" class="form-control" name="nochildren" value="{{ old('nochildren') }}">
                        
                      </div>
                    </div>
                </div>  
              
               </div>
               <div class="row" >
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Education</span>
                        </div>
                        <input type="text" class="form-control" name="education" value="{{ old('education') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Passport#</span>
                        </div>
                        <input type="text" class="form-control" name="passportno" value="{{ old('passportno') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Passport Exp.</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="passportexp" value="{{ old('passportexp') }}">
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Civil ID.</span>
                        </div>
                        <input type="text" class="form-control " name="civilidno" value="{{ old('civilidno') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">CivilID Exp.</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="civilidexp" value="{{ old('civilidexp') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Lisence#.</span>
                        </div>
                        <input type="text" class="form-control " name="lisenceno" value="{{ old('lisenceno') }}">
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Lisence Exp.</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="lisenceexp" value="{{ old('lisenceexp') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Wedding Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="weddate" value="{{ old('weddate') }}">
                        
                      </div>
                    </div>
                </div>  
              
               </div>
                      </div>
                
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
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
        <h5 class="modal-title" id="companyModalLabel">Employee Details</h5>
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
      <th scope="col">Emp#</th>
      <th scope="col">Name</th>
      <th scope="col">Position</th>
     
    </tr>
  </thead>
  <tbody>
      @foreach($emps as $emp)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/hr/employee-details/{{$emp->id}}">{{$emp->empid}}</a></td>
      <td><a href="/hr/employee-details/{{$emp->id}}">{{$emp->name}}</a></td>
     <td><a href="/hr/employee-details/{{$emp->id}}">{{$emp->curposition}}</a></td>
     
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
<!-- ///////Js Start here//////////////////// -->
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
$('.approve').click(function(){
accname = $(".accname").val();
if(accname==""){
              alert("Account filed is mandatory!");
              $(this).prop("checked",false) ;
            }
           
            
        });
    });

  
  $(".personal").hide();
  $(".contact").hide();
  $('.obutton').addClass('actives');  
  $(".cbutton").click(function(){
  $(".contact").show(); 
  $(".personal").hide();
  $(".office").hide();
  $('.cbutton').addClass('actives');   
$('.obutton').removeClass('actives');
$('.pbutton').removeClass('actives');
  })
  $(".pbutton").click(function(){
  $(".personal").show(); 
  $(".office").hide();
  $(".contact").hide();
  $('.pbutton').addClass('actives');   
$('.obutton').removeClass('actives');
$('.cbutton').removeClass('actives');   
  })
    $(".obutton").click(function(){
  $(".personal").hide(); 
  $(".office").show();
  $(".contact").hide();
  $('.obutton').addClass('actives');   
$('.pbutton').removeClass('actives');
$('.cbutton').removeClass('actives');   
  })
</script>
@stop