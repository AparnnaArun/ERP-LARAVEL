@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Sales Order
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
                    <form class="forms-sample" action ="{{('/editssorders')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="id" value="{{ $sodr->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Order#</span>
                        </div>
                   
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="order_no" id="code" value="{{ $sodr->order_no }}"  readonly >
                       
                       
                      
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Delivery Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{  \Carbon\Carbon::parse($sodr->dates)->format('j -F- Y')  }} " required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Reference</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="reference" value="{{ $sodr->reference }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer')}}" {{($sodr->customer == $cust->id ? 'selected' : 'disabled') }}>{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                        <div class="alert alert-danger custdiv" role="alert" style="display: none;" >
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">FOB Point</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="fob_point" value="{{$sodr->fob_point}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Puchase Date</span>
                        </div>
                         <input type="text" class="form-control editpicker " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="purodr_date"  value="{{  \Carbon\Carbon::parse($sodr->purodr_date)->format('j -F- Y')  }}">
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Currency</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="currency" required="" >
                          
                     @foreach($currency as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" {{($sodr->currency == $cur->shortname ? 'selected' : 'disabled') }} >{{$cur->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Ship To</span>
                        </div>
                         <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="ship_to"  value="{{ $sodr->ship_to}}">
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Order From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="order_from" value='0' {{($sodr->order_from == '0' ? ' checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="order_from"   value="1"  {{($sodr->order_from == '1' ? ' checked' : 'disabled') }}> Quotation </label>
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
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                           <th>Quantity</th>
                            <th>Rates</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach ($sodr->salesorderdetail as $eenq )  
    <tr>
     <th scope="row"><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="main[]" value="{{$eenq->id}}" id="item_id"  placeholder="Current Stock">{{$loop->iteration}}</th>
    <td><input type="hidden" class="form-control gridid" aria-label="Amount (to the nearest dollar)" name="item_id[]" value="{{$eenq->item_id}}" id="item_id"  placeholder="Current Stock">
        <input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="item[]" value="{{$eenq->item}}" id=""  placeholder="Current Stock">{{$eenq->code}}</td>
      <td><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="code[]" value="{{$eenq->code}}" id=""  placeholder="Current Stock">
      {{$eenq->item}}</td>
      
      <td><input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="unit[]" value="{{$eenq->unit}}" id="unit[]"  placeholder="Current Stock">{{$eenq->unit}}</td>
      
      <td><input type="text" class="form-control auto-calc qnty inputpadd" aria-label="Amount (to the nearest dollar)" name="quantity[]"  id="qnty"  placeholder="Quantity" required="required" value="{{$eenq->quantity}}"></td>
      <td><input type="text" class="form-control auto-calc rate inputpadd" aria-label="Amount (to the nearest dollar)" name="rate[]" value="{{$eenq->rate}}" id=""  placeholder="Rates" required="required"></td>
      <td><input type="text" class="form-control auto-calc discount inputpadd" aria-label="Amount (to the nearest dollar)" name="discount[]" value="{{$eenq->discount}}" id=""  placeholder="Discount" ></td>
      <td><input type="text" class="form-control auto-calc tabamount inputpadd" aria-label="Amount (to the nearest dollar)" name="amount[]" value="{{$eenq->amount}}" id="amount"  placeholder="Total" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons" disabled=""><i class="mdi mdi-delete-forever"></i></button></td>
      </tr>
      @endforeach
                      </tbody>
                    </table>
                  
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
                         <input type="text" class="form-control auto-cal disctotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="discount_total"  value="{{$sodr->discount_total}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="erate"  value="{{$sodr->erate}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="total"  value="{{$sodr->total}}" readonly>
                           
                        
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
                         <input type="text" class="form-control auto-cal tax" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tax"  value="{{$sodr->tax}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="freight"  value="{{$sodr->freight}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="pf"  value="{{$sodr->pf}}" >
                           
                        
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
                         <input type="text" class="form-control auto-cal insurance" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="insurance"  value="{{$sodr->insurance}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="others"  value="{{$sodr->others}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total</span>
                        </div>
                         <input type="text" class="form-control auto-cal  nettotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$sodr->net_total}}" readonly>
                           
                        
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
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="deli_info"  >
                          {{$sodr->deli_info}}
                        </textarea>
                      </div>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Payment Info</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="payment_terms" >
                         {{$sodr->payment_terms}}
                        </textarea>
                      </div>
                    </div>
                </div>
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Remarks</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" >
                           {{$sodr->remarks}}

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
                          <span class="input-group-text bg-gradient-info text-white  ">Dispatch Details</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dispatch_details"  >
                        {{$sodr->dispatch_details}}
                        </textarea>
                      </div>
                    </div>
                </div> 
                
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white  ">Approved By</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="approved_by"  value="{{$sodr->approved_by}}" readonly="">
                           
                      </div>
                    </div>
                </div>
                
              </div>
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="#" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
            
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
        <h5 class="modal-title" id="companyModalLabel">Sales Order Details</h5>
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
      <th scope="col">Order#</th>
      <th scope="col">Order Date</th>
      <th scope="col">Customer</th>
      <th scope="col">Status</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/sorder/{{$data->id}}">{{$data->order_no}}</a></td>
      <td><a href="/inventory/sorder/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/sorder/{{$data->id}}">{{$data->name}}</a></td>
      <td><a href="/inventory/sorder/{{$data->id}}">
       @if($data->call_for_do==1) Fully Delivered @elseif($data->call_for_do==2) Partially Delivered  @else Not Delivered @endif</a></td>
    
     
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

// //////////ADD TO GRID SECTION ///////////////////////

///////////////// Grid Calculation/////////////////////
$(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
    first = row.find("td input.rate").val();
    second = row.find("td input.qnty").val();
    //alert(second);
    third = row.find("td input.discount").val();
    row.find(".tabamount").val((first * second) - third);
  var sum = 0;
   $("input.tabamount").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".gridtotal,.nettotal").val(sum.toFixed(3));
});
$(document).on("keyup change paste", ".auto-cal", function() {
   var total =$(".gridtotal").val();
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
   //alert(all);
   $(".nettotal").val(all.toFixed(3));
 });

              </script>
@stop