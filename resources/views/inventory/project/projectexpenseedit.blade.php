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
                    <p class="card-description">Admin Can Edit Expense Entry If Not Paid</p>
                    <form class="forms-sample" action ="{{('/editsproexp')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="id" value="{{$exp->id  }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Entry#</span>
                        </div>
                       
                   
                        <input type="text" class="form-control"  name="entry_no" id="" value="{{ $exp->entry_no }}"  readonly >
                       
                      
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white "> Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($exp->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white  ">Vendor</span>
                        </div>
                        <select class="form-control vendor"  name="vendor_id"   id="vennnd">
                          <option value="" hidden>Vendor</option>
                          @foreach($vendor as $vend)
                        <option value="{{$vend->id,old('vendor_id')}}" {{($exp->vendor_id == $vend->id ? 'selected' : 'disabled') }}>{{$vend->short_name}}</option>
                        @endforeach
                    
                        </select>
                        <div class="vendacc">
                        
                         <input type="hidden" class="form-control "  name="commission_percentage"  value="{{$exp->commission_percentage}}" readonly>
                         <input type="hidden" class="form-control "  name="comm_pay_account"  value="{{$exp->comm_pay_account}}" readonly>
                         <input type="hidden" class="form-control "  name="exe_com_exp_ac"  value="{{$exp->exe_com_exp_ac}}" readonly>
                        
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
                  @foreach($execs as $exec)
                        <option value="{{$exec->short_name,old('executive')}}" {{($exp->executive == $exec->short_name ? 'selected' : 'disabled') }} >{{$exec->short_name}}</option>
                       @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            <!--  <div class="col-md-4 resultdiv">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Code</span>
                        </div>
                        <select class="form-control projectid"  name="projectids" required="" >
                          <option value="" >Project Code</option>
                     
                        </select>
                      </div>
                    </div>
                </div> -->
             <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" disabled=""  name="paymentmode" value='cash' {{($exp->paymentmode == 'cash' ? 'checked' : 'disabled') }}> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="paymentmode"   value="credit" {{($exp->paymentmode == 'credit' ? 'checked' : 'disabled') }} > Credit </label>
                            </div>
           
           
                             
                </div>
                 <div class="col-md-2">
                   
                <label class="form-check-label">Expense Type</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input projj"   name="expense_type" value='1' {{($exp->expense_type == '1' ? 'checked' : 'disabled') }}> Project </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input sall" name="expense_type"   value="2" {{($exp->expense_type == '2' ? 'checked' : 'disabled') }} > Salary </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input sall" name="expense_type"   value="3" {{($exp->expense_type == '3' ? 'checked' : 'disabled') }} > Commission </label>
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
                        @foreach($exp->projectexpenseentrydetail as $pro)
                      <tr>
     <th scope="row"><input type="hidden" class="form-control "  name="id1[]" value="{{$pro->id}}" id="" >{{$loop->iteration}}</th>
    
        <td><input type="hidden" class="form-control "  name="projectcode[]" value="{{$pro->projectcode}}" id="" >
          <input type="hidden" class="form-control "  name="projectid[]" value="{{$pro->id}}" id="" >{{$pro->projectcode}}</td>
      <td><input type="hidden" class="form-control "  name="projectname[]" value="{{$pro->projectname}}" id="" >{{$pro->projectname}}</td>
      <td><input type="hidden" class="form-control "  name="customerid[]" value="{{$pro->customerid}}" id="" >
        <input type="hidden" class="form-control "  name="customer[]" value="{{$pro->customer}}" id="" >{{$pro->customer}}</td>
      <td><input type="hidden" class="form-control inpexce "  name="executive[]" value="{{$pro->executive}}" id="" >{{$pro->executive}}</td>
      <td><input type="text" class="form-control auto-calc amount"  name="amount[]" value="{{$pro->amount}}"  required></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled><i class="mdi mdi-delete-forever"></i></button></td>
      
    </tr>
                        @endforeach
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
                          {{$exp->remarks }}
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
                         <input type="text" class="form-control nettotal "  name="totalamount"  value="{{$exp->totalamount}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
                @if(session('utype')=='Admin' && $exp->paidstatus=='0')
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" >Save</button>
            @else
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled title="Contact admin to edit" >Save</button>
            @endif
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
<script type="text/javascript">
    $(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
   
  var sum = 0;
   $("input.amount").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".nettotal").val(sum.toFixed(3));

});
</script>
@stop