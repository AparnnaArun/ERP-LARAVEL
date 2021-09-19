@extends('hr/layout')
@section ('content')
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
                    <form class="forms-sample" action ="{{('/editsemployis')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="id" value="{{ $emmp->id }}" id="token"/>
                   <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Emp.ID</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="empid" value="{{ $emmp->empid}}"  readonly="readonly">

                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="name" value="{{ $emmp->name }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">DOB</span>
                        </div>
                        
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dob" value="{{ $emmp->dob }}" >
                      
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
                        <input type="text" class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dateofjoining" value="{{ $emmp->dateofjoining }}" >
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Joining Position</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="joiningposition" value="{{ $emmp->joiningposition }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Department</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="department" value="{{ $emmp->department }}">
                        
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
                        
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="curposition" value="{{ $emmp->curposition }}">
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                  <label class="form-check-label required">Salaried </label>
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="salaried" value='1' {{($emmp->salaried == '1' ? ' checked' : 'disabled') }} > Yes </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="radio" class="form-check-input"   name="salaried" value='0' {{($emmp->salaried == '0' ? ' checked' : 'disabled') }}> No </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label required">
                                <input type="checkbox" class="form-check-input approve" name="approve"   value="1" {{($emmp->approve == '1' ? ' checked' : '') }} > Approve </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Basic Salary</span>
                        </div>
                        <input type="text"  class="form-control" aria-label="Amount (to the nearest dollar)" name="bsalary" value="{{$emmp->bsalary }}" >
                        
                        
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
                        <input type="text"  class="form-control" aria-label="Amount (to the nearest dollar)" name="allowance" value="{{ $emmp->allowance }}">
                      
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Vehicle Reg.No</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vehicleno" value="{{ $emmp->vehicleno }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">A/C Name</span>
                        </div>
                        <input type="text" class="form-control accname" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name=""  readonly=""  value="{{ $emmp->printname }}">
                         
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
                        <textarea class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="address"  >{{ $emmp->address }}
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
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="actualdob" value="{{ $emmp->actualdob  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group ">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Address Home</span>
                        </div>
                        <textarea class="form-control" aria-label="Amount (to the nearest dollar)" name="homeaddr" value="{{  $emmp->homeaddr  }}">
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
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="kwttel1" value="{{ $emmp->kwttel1  }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Kwt.Tel2</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="kwttel2" value="{{ $emmp->kwttel2 }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Home.Tel</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="hometel" value="{{ $emmp->hometel  }}">
                        
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
                        <input type="email" class="form-control " aria-label="Amount (to the nearest dollar)" name="email" value="{{ $emmp->email  }}">
                        
                      </div>
                    </div>
                          </div>
                <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 1st Contact</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="emergency1" value="{{ $emmp->emergency1  }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 1st Contact#</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="emergency1no" value="{{ $emmp->emergency1no  }}">
                        
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
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="emergency2" value="{{ $emmp->emergency2 }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Emergency 2nd Contact#</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="emergency2no" value="{{ $emmp->emergency2no  }}">
                        
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
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="spouse" value="{{ $emmp->spouse  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Spouse #</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="spouseno" value="{{ $emmp->spouseno  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">No.Of Children</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="nochildren" value="{{ $emmp->nochildren  }}">
                        
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
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="education" value="{{ $emmp->education  }}">
                        
                      </div>
                    </div>
                </div>
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Passport#</span>
                        </div>
                        <input type="text" class="form-control" name="passportno" value="{{ $emmp->passportno  }}">
                        
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
                        <input type="text" class="form-control " name="civilidno" value="{{ $emmp->civilidno  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">CivilID Exp.</span>
                        </div>
                        <input type="text" class="form-control editpicker" name="civilidexp" value="{{ \Carbon\Carbon::parse($emmp->civilidexp)->format('j -F- Y')  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Lisence#.</span>
                        </div>
                        <input type="text" class="form-control " name="lisenceno" value="{{ $emmp->lisenceno  }}">
                        
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
                        <input type="text" class="form-control editpicker" name="lisenceexp" value="{{ \Carbon\Carbon::parse($emmp->lisenceexp)->format('j -F- Y')  }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Wedding Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" name="weddate" value="{{ \Carbon\Carbon::parse($emmp->weddate)->format('j -F- Y')  }}">
                        
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