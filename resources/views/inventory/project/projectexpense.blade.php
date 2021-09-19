@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table   menu-icon"></i>
                </span>Project Expense Entry
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
                    <form class="forms-sample" action ="{{('/createproexp')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Entry#</span>
                        </div>
                       
                       @if(!empty($voucher->constants))
                        <input type="text" class="form-control"  name="entry_no" id="" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="" value="{{ $nslno }} "  readonly >
                        <input type="hidden" class="form-control"  name="constants" id="" value="{{$voucher->constants }} "  readonly >
                       @else
                       <input type="text" class="form-control"  name="" id="" value=""  readonly >
                          @endif
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white "> Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ old('dates') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Vendor</span>
                        </div>
                        <select class="form-control vendor"  name="vendor_id" required=""  id="vennnd">
                          <option value="" hidden>Vendor</option>
                          @foreach($vendor as $vend)
                        <option value="{{$vend->id,old('vendor_id')}}" >{{$vend->short_name}}</option>
                        @endforeach
                    
                        </select>
                        <div class="vendacc">
                         <input type="hidden" class="form-control "  name="vendaccount"  value="" readonly>
                       </div>
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <select class="form-control executive"  name="executives" required="" >
                          <option value="" hidden>Executive</option>
                  
                        <option value="{{$execs->short_name,old('executive')}}" >{{$execs->short_name}}</option>
                       
                        </select>
                      </div>
                    </div>
                </div>
             <div class="col-md-4 resultdiv">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Code</span>
                        </div>
                        <select class="form-control projectid"  name="projectids" required="" >
                          <option value="" hidden>Project Code</option>
                     
                        </select>
                      </div>
                    </div>
                </div>
             <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" disabled=""  name="paymentmode" value='cash'> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="paymentmode"   value="credit" checked > Credit </label>
                            </div>
           
           
                             
                </div>
                 <div class="col-md-2">
                   
                <label class="form-check-label">Expense Type</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input projj" checked  name="expense_type" value='1'> Project </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input sall" name="expense_type"   value="2"  > Salary </label>
                            </div>
           
           
                             
                </div>
             
              </div>

           
                 <div class="row">
                  <div class="col-md-12">
                  <div class="alert alert-danger" role="alert" id="myalertdiv" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">×</button></div>
</div>
                 </div>
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Project Code</th>
                          <th>Project</th>
                          <th>Customer</th>
                          <th>Executive</th>
                           <th>Amount</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div class="row">
             <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white"> Remarks</span>
                        </div>
                         <textarea class="form-control  "  name="remarks"   >
                           </textarea>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control nettotal "  name="totalamount"  value="{{old('totalamount')}}" readonly>
                           
                        
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
        <h5 class="modal-title" id="companyModalLabel">Project Expense Entry Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
            <p>Missing Entry numbers are used for  material issue or  its return</p>
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Entry#</th>
      <th scope="col">Project Code</th>
      <th scope="col">Vendor</th>
      <th scope="col">Executive</th>
      <th scope="col">Amount</th>
    <th scope="col">Exp From</th>
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/expense-edit/{{$data->id}}">{{$data->entry_no}}</a></td>
      <td><a href="/inventory/expense-edit/{{$data->id}}">{{ $data->project_code }}</a></td>
      <td><a href="/inventory/expense-edit/{{$data->id}}">{{$data->vendor}}</a></td>
      <td><a href="/inventory/expense-edit/{{$data->id}}">{{$data->executive}}</a></td>
   <td><a href="/inventory/expense-edit/{{$data->id}}">{{$data->totalamount}}</a></td>
    <td><a href="/inventory/expense-edit/{{$data->id}}">{{$data->remarks}}</a></td> 
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
 <script type="text/javascript">
  $(".executive").change(function(){
               eid = $(this).val();
               token = $("#token").val();
               
              $.ajax({
         type: "POST",
         url: "{{url('getexceprodetails')}}", 
         data: {_token: token,eid:eid},
         dataType: "html",  
         success: 
              function(result){
             // alert(result);
                $(".resultdiv").html(result);

              }
          });

                })
$(".vendor").change(function(){
               vid = $(this).val();
               token = $("#token").val();
               
              $.ajax({
         type: "POST",
         url: "{{url('getvendoracc')}}", 
         data: {_token: token,vid:vid},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".vendacc").html(result);

              }
          });

                })
$(".sall").click(function(){
   $("#vennnd").val('').trigger('change');
  $('#vennnd').prop('disabled', true);
})
$(".projj").click(function(){
   
  $('#vennnd').prop('disabled', false);
})
 
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotal = $(".nettotal").val();
   amount = row.find("td input.amount").val();
$(".nettotal").val((ntotal - amount).toFixed(3));
      });
              </script>
@stop