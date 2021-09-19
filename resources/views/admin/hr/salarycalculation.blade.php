@extends('admin/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-contacts  menu-icon"></i>
                </span>Salary Calculation
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
                    <form class="forms-sample" action ="{{('/createsalarycalculation')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Emp.Name</span>
                        </div>
                        <select class="form-control name" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="name"  required="" >
                            <option value="" hidden>Emp Name</option>
                        @foreach($emp as $em)
                        <option value="{{$em->id}}" >{{$em->name}}</option>
                        @endforeach
                         </select>
                      
                      </div>
                    </div>
                </div>
             
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Month</span>
                        </div>
                        <select class="form-control month"  name="month" required="">
                          <option hidden="" value="">Select A Month</option>
         <option value="January">January</option>
         <option value="February">February</option>
         <option value="March">March</option>
         <option value="April">April</option>
         <option value="May">May</option>
         <option value="June">June</option>
         <option value="July">July</option>
         <option value="August">August</option>
         <option value="September">September</option>
         <option value="October">October</option>
         <option value="November">November</option>
         <option value="December">December</option>
       </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Year</span>
                        </div>
                        
                        <input type="text" class="form-control year"  name="year" value="{{ now()->year }}" required="" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-gradient-dark btn-xs btn-fw go">Go</button>
                </div>
        <!--     </div> -->
          </div>
           <div class="result">
          
            <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Emp #</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dateofjoin" value="{{ old('dateofjoin') }}" >
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Basic Salary</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="contractperiod" value="{{ old('contractperiod') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Allowance</span>
                        </div>
                        
                        <input type="text" class="form-control "  name="probperiodstart" value="{{ old('probperiodstart') }}">
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              
                
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">NO.Of Working Days</span>
                        </div>
                        <input type="text"  class="form-control "  name="probperiodend" value="{{old('probperiodend')}}" >
                        
                        
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">No.Of Days Worked </span>
                        </div>
                        <input type="text"  class="form-control "  name="probsalary" value="{{old('probsalary')}}" >
                        
                        
                      </div>
                    </div>
                </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Add.Allowance</span>
                        </div>
                        <input type="text"  class="form-control "  name="ticket" value="{{old('ticket')}}" >
                        
                        
                      </div>
                    </div>
                </div>
                           </div>
            <div class="row">
              
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Normal Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vehicle" value="{{ old('vehicle') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Friday Overtine(hr)</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="fuelallowance" value="{{ old('fuelallowance') }}" >
                      </div>
                    </div>
                </div>
             
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white ">Holiday Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="address" value="{{ old('accommodation') }}" >
                       
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">This Month Salary</span>
                        </div>
                        <input type="text" class="form-control"  name="food" value="{{ old('food') }}">
                        
                      </div>
                    </div>
                </div>
             
                
               </div>
             </div>
            
                       
                      
                
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled >Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</button>
            
          </div>
        </div>
                    
                  
                </form>
                </div>
                </div>
              </div>

<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(".go").click(function(){
  name = $(".name").val();
  month = $(".month").val();
  year = $(".year").val();
  token=$("#token").val();

  if(name!="" && month!=""  && year!="" ){
     //alert(name);
$.ajax({
         type: "POST",
         url: "{{url('getcalsssalary')}}", 
         data: {_token: token,name:name,month:month,year:year},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $(".result").html(data);

              }
          });
}
else{

  alert("all fields are required");
}
})

</script>
@stop