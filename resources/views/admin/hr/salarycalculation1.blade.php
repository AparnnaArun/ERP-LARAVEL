@extends('admin/layout')
@section ('content')
<style type="text/css">
  td{
    padding:5px!important;
    height:50%!important;
    text-align: center;
  }
  td input{
padding:0px!important;
border-color:white!important;
height: 100%!important;
  }
</style>
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
                    <form class="forms-sample" action ="{{('/salarycalculation')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	
             
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Month</span>
                        </div>
                        <select class="form-control month"  name="month" required="">
                          <option hidden="" value="">Month</option>
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

                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Year</span>
                        </div>
                        
                        <input type="text" class="form-control year"  name="year" value="{{ now()->year }}" required="" >
                      
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group voucher">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vchr#</span>
                        </div>
                       <input type="text" class="form-control "  name="voucher" value="" required="" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Workng.Days</span>
                        </div>
                        <input type="text"  class="form-control auto-cal workingdays"  name="workingdays" value="26" >
                        
                        
                      </div>
                    </div>
                </div>
              </div>
          <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-bordered ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th title="Employee Name">Name</th>
                          <th title="Basic Salary">Salary</th>
                          <th title="Allowance">Alwce</th>
                          <th title="Additional Allowance">Add. Alwce</th>
                           <th class="required" title="Total Worked Days">Workd. Days</th>
                          <th title="Normal Overtine Rates">NOT</th>
                          <th title="Friday Overtine Rates">FOT</th>
                          <th title="Holiday Overtine Rates">HOT</th>
                          <th class="required">Total Salary</th>
                          <th title="dedection">Dedctn</th>
                          <th title="Net Salary">Net Salary</th>
                          <th title="Advance">Adnce</th>

                          <th class="required" title="Total Amount">Amount</th>
                          <th></th>
                       
                        </tr>
                      </thead>
                      <tbody>
                       @foreach($emp as $em) 
<tr>
  <td>{{$loop->iteration}}</td>
  <td><input type="hidden" class="form-control inputpadd "  name="name[]" value="{{$em->name}}"   >{{$em->name}}</td>
  <td><input type="hidden" class="form-control auto-cal bsalary"  name="bsalary[]" value="{{$em->bsalary}}"   >{{$em->bsalary}}</td>
  <td><input type="hidden" class="form-control inputpadd auto-cal allowance"  name="allowance[]" value="{{$em->allowance}}"   >{{$em->allowance}}</td>
 <td ><input type="text" class="form-control inputpadd auto-cal addallowance"  name="addallowance[]" value="0"   >
                       </td>
  <td><input type="text" class="form-control inputpadd auto-cal workeddays"  name="workeddays[]" value="26"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal not"  name="norover[]" value="0"   >
    <input type="hidden" class="form-control inputpadd auto-cal ovr1"  name="nrrate[]" value="{{ $over1->rate }}"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal fot"  name="frover[]" value="0"   ><input type="hidden" class="form-control inputpadd auto-cal ovr2"  name="frrate[]" value="{{ $over2->rate }}"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal hot"  name="holover[]" value="0"   ><input type="hidden" class="form-control inputpadd auto-cal ovr3"  name="hrrate[]" value="{{ $over3->rate }}"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal totsal"  name="thissalary[]" 
    value="{{(($em->bsalary)/26)*26}}"  readonly="" ></td>
    <td><input type="text" class="form-control inputpadd auto-cal deduc"  name="deduction[]" value="0"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal netsal"  name="nettotal[]" value="{{(($em->bsalary)/26)*26}}" readonly  ></td>
  <td><input type="text" class="form-control inputpadd auto-cal advance"  name="advance[]" value="0"   ></td>
  <td><input type="text" class="form-control inputpadd auto-cal amount"  name="amount[]" value="0"   ></td>
   <td ><button id="" class="btn btn-danger btn-xs buttons remove"><i class="mdi mdi-delete-forever"></i></button></td>
</tr>

                       @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
            <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Net Salary</span>
                        </div>
                        <input type="text"  class="form-control auto-cal tnetsal"  name="totalnetsalary" value="" readonly >
                        
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Advance</span>
                        </div>
                        <input type="text"  class="form-control auto-cal tadvance"  name="totaladvance" value="" readonly>
                        
                        
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

//////////////// CALCULATION///////////////////////////
$(document).on("keyup change paste", ".auto-cal", function() {
    row = $(this).closest("tr");
   
    bsalary = parseFloat(row.find("td input.bsalary").val());
    allowance = parseFloat(row.find("td input.allowance").val());
    addallowance = parseFloat(row.find("td input.addallowance").val());
    workeddays = parseFloat(row.find("td input.workeddays").val());
    not = parseFloat(row.find("td input.not").val());
    ovr1 = parseFloat(row.find("td input.ovr1").val());
    fot = parseFloat(row.find("td input.fot").val());
    ovr2 = parseFloat(row.find("td input.ovr2").val());
    hot = parseFloat(row.find("td input.hot").val());
    ovr3 = parseFloat(row.find("td input.ovr3").val());
    deduc =parseFloat(row.find("td input.deduc").val());
    advance=parseFloat(row.find("td input.advance").val());
    totovr =(not*ovr1) +(fot*ovr2)+(hot*ovr3);
    workingdays = parseFloat($(".workingdays").val());
    calsal =(bsalary/workingdays)*workeddays;
    totsal =calsal + allowance +addallowance+totovr;
    row.find("td input.totsal").val(totsal.toFixed(3));
    row.find("td input.netsal").val((totsal-deduc).toFixed(3));
    row.find("td input.amount").val(((totsal-deduc) + advance).toFixed(3));
sum =0;
sum1 =0;
$(".netsal").each(function() {
sum += +$(this).val();
   });
$(".advance").each(function() {
sum1 += +$(this).val();
   });
$(".tnetsal").val(sum.toFixed(3));
$(".tadvance").val(sum1.toFixed(3));
    });
 $(document).ready(function(){
  sum =0;
sum1 =0;
$(".netsal").each(function() {
sum += +$(this).val();
   });
$(".advance").each(function() {
sum1 += +$(this).val();
   });
$(".tnetsal").val(sum.toFixed(3));
$(".tadvance").val(sum1.toFixed(3));
 });
$(".month").change(function(){
 month = $(".month").val();
  year = $(".year").val();
  token=$("#token").val();

  if(month!=""  && year!="" ){
     //alert(year);
$.ajax({
         type: "POST",
         url: "{{url('getsalvouchernumber')}}", 
         data: {_token: token,month:month,year:year},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $(".voucher").html(data);

              }
          });
}
else{

  alert("all fields are required");
}
})
$(document).on('click', '.remove', function(){  
  row = $(this).closest("tr");
   row.remove();
    advance=parseFloat(row.find("td input.advance").val());
    netsal=parseFloat(row.find("td input.netsal").val());
    tnetsal=parseFloat($(".tnetsal").val());
    tadvance=parseFloat($(".tadvance").val());
    $(".tnetsal").val((tnetsal-netsal).toFixed(3));
$(".tadvance").val((tadvance-advance).toFixed(3));
    t
   });
       </script> 
@stop