@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar   menu-icon"></i>
                </span>Purchase Order Approval
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
                    <form class="forms-sample" action ="{{('/editapproval')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                    
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Odr#</span>
                        </div>
                       
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="po_no" value="{{ $reequsi->po_no }}"  readonly >
                         <input type="hidden" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="idd" value="{{ $reequsi->id }}"  readonly >
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates" value="{{ \Carbon\Carbon::parse($reequsi->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Odr. By</span>
                        </div>
                        
                        <input type="text"  class="form-control accname"  name="odr_by" value="{{ $reequsi->odr_by}}">
                          
                     
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
                        <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vendor" required="" >
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
                          <span class="input-group-text bg-gradient-info text-white  ">Reference</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="reference" value="{{$reequsi->reference}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="projectcode"  >
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
                   
                <label class="form-check-label">Urgency Level</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="urgency_level" value='Low' {{($reequsi->urgency_level == 'Low' ? 'checked' : 'disabled') }} > Low </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="urgency_level"   value="Medium" {{($reequsi->urgency_level == 'Medium' ? 'checked' : 'disabled') }} > Medium </label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="urgency_level"   value="Heigh" {{($reequsi->urgency_level == 'Heigh' ? 'checked' : 'disabled') }}  > Heigh </label>
                            </div>
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Request From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="request_from" value='Direct' {{($reequsi->request_from == 'Direct' ? 'checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="request_from"   value="Requisition" {{($reequsi->request_from == 'Requisition' ? 'checked' : 'disabled') }}  > Requisition</label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="request_from"   value="ROL" {{($reequsi->request_from == 'ROL' ? 'checked' : 'disabled') }} > ROL </label>
                            </div>
           
                             
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Currency</span>
                        </div>
                        <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="currency" required="" >
                          <option value="" hidden>Currency</option>
                     @foreach($curr as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" {{($reequsi->currency == $cur->shortname ? 'selected' : 'disabled') }} >{{$cur->shortname}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white required ">FOB Point</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="fob_point" value="{{$reequsi->fob_point}}" >
                          
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Order Validity</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="order_validity" value="{{$reequsi->order_validity}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Date</span>
                        </div>
                       <input  class="form-control editpicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="deli_date" value="{{ \Carbon\Carbon::parse($reequsi->deli_date)->format('j -F- Y')  }}" >
                        
                      </div>
                    </div>
                </div>
              </div>
                
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <!-- <th>#</th> -->
                          <th>Code</th>
                          <th>Item</th>
                          
                          <th>Unit</th>
                           <th>PO Qnty</th>
                           <th>Approved Qnty</th>
                           <th>Approved Rate</th>
                           <th>Approved Amt</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                        @foreach($reequsi->purchaseorderdetail as $item)
                        @if($item->balqnty!='0')
      <!-- <th scope="row">{{$loop->iteration}}</th> -->
      <td><input type="hidden" class="form-control "  name="id1[]" value="{{$item->id}}" >
        <input type="hidden" class="form-control "  name="item_code[]" value="{{$item->item_code}}" >
        {{$item->item_code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->id}}" id="item_id" >
        <input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}" id="" >{{$item->item_name}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}"  >{{$item->unit}}</td>
      <td><input type="hidden" class="form-control auto-calc reqqnty"  name="reqqnty[]" value="{{$item->reqqnty}}"   placeholder="Approved Qnty">{{$item->reqqnty}}
        </td>
       <td><input type="text" class="form-control auto-calc apprqnty"  name="apprqnty[]" value="{{$item->reqqnty}}"   placeholder="Approved Qnty"> <div style="color:red;display:none;" class="alertdiv">This Qnty less than Req qnty</div></td>
       <td>
        <input type="text" class="form-control auto-calc apprrate "  name="appr_rate[]" value="{{$item->rate}}" id="" ></td>
        <td><input type="text" class="form-control auto-calc amount"  name="total[]" value="{{($item->reqqnty)*($item->rate)}}" id="amount"  placeholder="Amount" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "disabled><i class="mdi mdi-delete-forever"></i></button></td>
     @endif
     
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
                          <span class="input-group-text bg-gradient-info text-white  ">Total Qnty</span>
                        </div>
                       <input  class="form-control tqnty" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tot_qnty" value="{{$reequsi->tot_qnty}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Amount</span>
                        </div>
                       <input  class="form-control tamount " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tamount" value="{{$reequsi->tamount}}" >
                        
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Discount</span>
                        </div>
                         <input type="text" class="form-control auto-cal disctotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="discount_total"  value="{{$reequsi->discount_total}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="erate"  value="{{$reequsi->erate}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount(KWD)</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="totals"  value="{{$reequsi->total}}" readonly>
                          
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Tax</span>
                        </div>
                         <input type="text" class="form-control auto-cal tax" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tax"  value="{{$reequsi->tax}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="freight"  value="{{$reequsi->freight}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="pf"  value="{{$reequsi->pf}}" >
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Insurance</span>
                        </div>
                         <input type="text" class="form-control auto-cal insurance" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="insurance"  value="{{$reequsi->insurance}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="others"  value="{{$reequsi->others}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total</span>
                        </div>
                         <input type="text" class="form-control auto-cal  nettotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$reequsi->net_total}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
              
                   <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Info</span>
                        </div>
                        <textarea class="form-control " placeholder="" name="deliveryinfo" >
                          {{$reequsi->deliveryinfo}}
                        </textarea>
                      </div>
                    </div>
                </div>
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Payment Terms</span>
                        </div>
                        <textarea class="form-control " placeholder="" name="paymentterms" >
                          {{$reequsi->paymentterms}}
                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Shipping Info</span>
                        </div>
                        <textarea class="form-control " placeholder="" name="shipping" >
                          {{$reequsi->shipping}}
                        </textarea>
                      </div>
                    </div>
                </div>
                
              </div>
               <div class="row">

              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Remarks</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" >
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
            @if (session('status'))
             <a href="{{url('printpoapproval')}}/{{$reequsi->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
             @endif
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
        <h5 class="modal-title" id="companyModalLabel">Approved Purchase Order Details</h5>
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
     
      <th scope="col">Ord#</th>
      <th scope="col">Vendor</th>
      <th scope="col">Odr By</th>
     
      </tr>
  </thead>
  <tbody>
   @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
       
      <td><a href="/inventory/purchaseorder-approvals/{{$data->id}}">{{$data->po_no}}</a></td>
      <td><a href="/inventory/purchaseorder-approvals/{{$data->id}}">{{$data->vendor}}</a></td>
      <td><a href="/inventory/purchaseorder-approvals/{{$data->id}}">{{$data->odr_by}}</a></td>
    
    
  
     
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
   $(document).ready(function() {
    var sums11=0;
    $("input.amount").each(function() {
  sums11 += +$(this).val();
  
  });
    $(".tamount,.gridtotal,.nettotal").val(sums11.toFixed(3));
    var sums12=0;
    $("input.apprqnty").each(function() {
  sums12 += +$(this).val();
  
  });
    $(".tqnty").val(sums12.toFixed(3));
    $(".tamount").val(sums11.toFixed(3));
    var total =$(".tamount").val();
   var disc = $(".disctotal").val();
   var erate = $(".erate").val();
   var tax =parseFloat($(".tax").val());
   var pf = parseFloat($(".pf").val());
   var insurance =parseFloat($(".insurance").val());
   var freight = parseFloat($(".freight").val());
   var others = parseFloat($(".others").val());
    
   var nettotals = total-disc;
   var afrrate = erate*nettotals;
   var othramt = tax + insurance + freight + others + pf;
   var all = afrrate +  othramt;
   var actual = all;
 $(".gridtotal").val(afrrate.toFixed(3));
   $(".nettotal").val(actual.toFixed(3));
  });
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

    first1 = parseFloat(row.find("td input.apprqnty").val());
    second1 = parseFloat(row.find("td input.apprrate").val());
   row.find("td input.amount").val((first1*second1).toFixed(3));
 var sums = 0;
  var sums1 = 0;
    $("input.apprqnty").each(function() {
  sums += +$(this).val();
  
  });
      $("input.amount").each(function() {
  sums1 += +$(this).val();
  
  });
      $(".tqnty").val(sums.toFixed(3));
      $(".tamount").val(sums1.toFixed(3));
       var total1 =$(".tamount").val();
   var disc1 = $(".disctotal").val();
   var erate1 = $(".erate").val();
   var tax1 =parseFloat($(".tax").val());
   var pf1 = parseFloat($(".pf").val());
   var insurance1 =parseFloat($(".insurance").val());
   var freight1 = parseFloat($(".freight").val());
   var others1 = parseFloat($(".others").val());
    
   var nettotals1 = total1-disc1;
   var afrrate1 = erate1*nettotals1;
   var othramt1 = tax1 + insurance1 + freight1 + others1 + pf1;
   var all1 = afrrate1 +  othramt1;
   var actual1 = all1;
 $(".gridtotal").val(afrrate1.toFixed(3));
   $(".nettotal").val(actual1.toFixed(3));
});
 $(document).on("keyup change paste", ".auto-cal", function() {
   var total =$(".tamount").val();
   var disc = $(".disctotal").val();
   var erate = $(".erate").val();
   var tax =parseFloat($(".tax").val());
   var pf = parseFloat($(".pf").val());
   var insurance =parseFloat($(".insurance").val());
   var freight = parseFloat($(".freight").val());
   var others = parseFloat($(".others").val());
    
   var nettotals = total-disc;
   var afrrate = erate*nettotals;
   var othramt = tax + insurance + freight + others + pf;
   var all = afrrate +  othramt;
   var actual = all;
 $(".gridtotal").val(afrrate.toFixed(3));
   $(".nettotal").val(actual.toFixed(3));
 });

              </script>
@stop