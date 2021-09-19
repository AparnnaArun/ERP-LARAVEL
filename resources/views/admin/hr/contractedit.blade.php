@extends('admin/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-contacts  menu-icon"></i>
                </span>Contract Details
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
                    <form class="forms-sample" action ="{{('/editscontracts')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="{{ $con->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Emp.ID</span>
                        </div>
                        <select class="form-control empno" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="empno"  required="" >
                        <option value="" hidden>Emp No</option>
                        @foreach($emp as $em)
                        <option value="{{$em->id}}" {{($con->empno == $em->id? ' selected' : '') }}>{{$em->empid}}</option>
                        @endforeach
                         </select>
                      
                      </div>
                    </div>
                </div>
              </div>
               <div class="row result">
              <!-- <div id="testt"> -->
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="empname" value="{{ $con->empname }}" >
                        
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Position</span>
                        </div>
                        
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="position" value="{{ $con->position }}" >
                      
                      </div>
                    </div>
                </div>
        <!--     </div> -->
          </div>
           
          
            <div class="row ">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date Of Joining</span>
                        </div>
                        <input type="text" class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dateofjoin" value="{{ \Carbon\Carbon::parse($con->dateofjoin)->format('j -F- Y') }}" >
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Contract Period</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="contractperiod" value="{{ $con->contractperiod }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Probation Start</span>
                        </div>
                        
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the neares dotllar)" name="probperiodstart" value="{{ \Carbon\Carbon::parse($con->probperiodstart)->format('j -F- Y') }}">
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              
                
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Probation End</span>
                        </div>
                        <input type="text"  class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="probperiodend" value="{{$con->probperiodend}}" >
                        
                        
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Probation Salary</span>
                        </div>
                        <input type="text"  class="form-control " aria-label="Amount (to the nearest dollar)" name="probsalary" value="{{$con->probsalary}}" >
                        
                        
                      </div>
                    </div>
                </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Tickets</span>
                        </div>
                        <input type="text"  class="form-control " aria-label="Amount (to the nearest dollar)" name="ticket" value="{{$con->ticket}}" >
                        
                        
                      </div>
                    </div>
                </div>
                           </div>
            <div class="row">
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Mobile Allowance</span>
                        </div>
                        <input type="text"  class="form-control" aria-label="Amount (to the nearest dollar)" name="moballowance" value="{{ $con->moballowance }}">
                      
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Vehicle</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vehicle" value="{{ $con->vehicle }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Fuel Allowance</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="fuelallowance" value="{{ $con->fuelallowance }}" >
                      </div>
                    </div>
                </div>
              </div>
           
            <div class="row" >
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white ">Accommodation</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="accommodation" value="{{ $con->accommodation }}" >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Food</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="food" value="{{ $con->food }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group ">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white">Leave Details</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="leavedetails" value="{{ $con->leavedetails }}">
                    
                        
                      </div>
                    </div>
                </div>
               </div>
              <div class="row">
                <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Penality On Early Leaving</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="penality" value="{{ $con->penality }}">
                        
                      </div>
                    </div>
                          </div>
                          <div class="col-md-4">
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Confirmed Salary</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="confirmsalary" value="{{ $con->confirmsalary }}">
                        
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
        <h5 class="modal-title" id="companyModalLabel">Contract Details</h5>
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
      @foreach($contracts as $con)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/contract-edit/{{$con->id}}">{{$con->empno}}</a></td>
      <td><a href="/admin/contract-edit/{{$con->id}}">{{$con->empname}}</a></td>
     <td><a href="/admin/contract-edit/{{$con->id}}">{{$con->position}}</a></td>
     
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
$(".empno").change(function(){
  emp = $(this).val();
  token=$("#token").val();
  //alert(emp);
  $.ajax({
         type: "POST",
         url: "../getempcontract", 
         data: {_token: token,emp:emp},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $(".result").html(data);

              }
          });
})
</script>
@stop