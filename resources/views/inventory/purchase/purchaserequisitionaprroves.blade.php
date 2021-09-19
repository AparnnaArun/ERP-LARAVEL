@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar   menu-icon"></i>
                </span>Purchase Requisition
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
                    <form class="forms-sample" action ="{{('/createreqapprov')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="idd" value="{{ $reequsi->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Req#</span>
                        </div>
                       
                        <input type="text" class="form-control"   name="req_no" id="code" value="{{ $reequsi->req_no }}"  readonly >
                       
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($reequsi->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Req. By</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="req_by" value="{{ $reequsi->req_by}}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Vendor</span>
                        </div>
                        <select class="form-control"   name="vendor" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->id,old('vendor')}}" {{($reequsi->vendor == $cust->id ? 'selected' : 'disabled') }} >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Req.Department</span>
                        </div>
                       <input  class="form-control "   name="reqdept" value="{{$reequsi->reqdept}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control "   name="projectcode"  >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('projectcode')}}" {{($reequsi->projectcode == $pro->id ? 'selected' : 'disabled') }} >{{$pro->project_code}}</option>
                        @endforeach
                        </select>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
            	<div class="col-md-4">
                   
                <label class="form-check-label">Delivery Address</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="deliveryaddr" value='0' {{($reequsi->deliveryaddr == '0' ? 'checked' : 'disabled') }} > Company </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="deliveryaddr"   value="1" {{($reequsi->deliveryaddr == '1' ? 'checked' : 'disabled') }} > Division </label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="deliveryaddr"   value="2" {{($reequsi->deliveryaddr == '2' ? 'checked' : 'disabled') }}  > Go-Down </label>
                            </div>
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Request From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="req_from" value='0' {{($reequsi->req_from == '0' ? 'checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="req_from"   value="1" {{($reequsi->req_from == '1' ? 'checked' : 'disabled') }}  > Material Request </label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="req_from"   value="2" {{($reequsi->req_from == '2' ? 'checked' : 'disabled') }} > ROL </label>
                            </div>
           
                             
                </div>
                 <div class="col-md-2">
                   <span class="input-group-text bg-gradient-dark text-white"> @if($reequsi->approvalstatus=='1') Approved @else Pending @endif</span>
                 </div>
            </div>
            
                
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          
                          <th>Unit</th>
                           <th>Req Qnty</th>
                           <th>Approv Qnty</th>
                           <!-- <th>Rate</th>
                           <th>Amount</th> -->
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                        @foreach($reequsi->purchaserequisitiondetail as $item)
      <th scope="row">{{$loop->iteration}}</th>
      <td><input type="hidden" class="form-control "  name="id1[]" value="{{$item->id}}" id="code" ><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id="code" >
        {{$item->item_code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->id}}" id="item_id" >
        <input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id="" >{{$item->item_name}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]" >{{$item->unit}}</td>
      <td><input type="hidden" class="form-control auto-calc reqqnty"  name="" value="{{$item->reqqnty}}" id="" >{{$item->reqqnty}}</td>
      <td><input type="text" class="form-control auto-calc apprqnty"  name="apprqnty[]" value="{{$item->apprqnty}}" id="apprqnty[]" >
        <div style="color:red;display:none;" class="alertdiv">This Qnty less than Req qnty</div>
      </td>
      <!--  <td>{{$item->rate}}</td>
        <td>{{$item->total}}</td> -->
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "disabled><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>  
    @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div class="row">
              
                   <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Remarks</span>
                        </div>
                        <textarea class="form-control "   name="remarks" >
                          {{$reequsi->remarks}}
                        </textarea>
                      </div>
                    </div>
                </div>
                
              </div>
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" >Save</button>
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
        <h5 class="modal-title" id="companyModalLabel">Purchase Requisition Details</h5>
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
      <th scope="col">Req#</th>
      <th scope="col">Vendor</th>
      <th scope="col">Req By</th>
      <th scope="col">Status</th>
      </tr>
  </thead>
  <tbody>
   @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/reqisition-approval/{{$data->id}}">{{$data->req_no}}</a></td>
      <td><a href="/inventory/reqisition-approval/{{$data->id}}">{{$data->vendor}}</a></td>
      <td><a href="/inventory/reqisition-approval/{{$data->id}}">{{$data->req_by}}</a></td>
     @if($data->is_deleted == '1')
    
    <td><a href="/inventory/reqisition-approval/{{$data->id}}">Deleted</a></td>@endif
  
     
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

  $(document).on("keyup change paste", ".auto-calc", function() {
  row = $(this).closest("tr");
    first = parseFloat(row.find("td input.reqqnty").val());
    second = parseFloat(row.find("td input.apprqnty").val());
    //alert(first);
   if(second > first){
    row.find("td .alertdiv").show();
   }else{
row.find("td .alertdiv").hide();
   }

});


 

              </script>
@stop