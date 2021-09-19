@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar   menu-icon"></i>
                </span>Purchase Order
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
                    <form class="forms-sample" action ="{{('/createpo')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Order#</span>
                        </div>
                       
                        <input type="text" class="form-control"  name="po_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ old('dates') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Order By</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="odr_by" value="{{ session('name') }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required add-on ">Vendor</span>
                        
                        <select class="form-control mySelect2"  name="vendor" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->id,old('vendor')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                        </div>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Reference</span>
                        </div>
                       <input  class="form-control "  name="reference" value="{{old('reference')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control "  name="project_code"  >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_code')}}" >{{$pro->project_code}}</option>
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
                                <input type="radio" class="form-check-input" checked  name="urgency_level" value='Low'> Low </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="urgency_level"   value="Medium"  > Medium </label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="urgency_level"   value="Heigh"  > Heigh </label>
                            </div>
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Request From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="request_from" value='Direct'> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="request_from"   value="Requisition"  > Requisition </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="request_from"   value="Quotation"  > Quotation </label>
                            </div>
           <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="request_from"   value="ROL"  > ROL </label>
                            </div>
           
                             
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Currency</span>
                        </div>
                        <select class="form-control"  name="currency" required="" >
                          <option value="" hidden>Currency</option>
                     @foreach($curr as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" >{{$cur->shortname}}</option>
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
                        <input type="text" class="form-control"  name="fob_point" value="{{old('fob_point')}}" >
                          
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Order Validity</span>
                        </div>
                       <input  class="form-control "  name="order_validity" value="{{old('order_validity')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Date</span>
                        </div>
                       <input  class="form-control datepicker"  name="deli_date" value="{{old('deli_date')}}" >
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required add-on">Item</span>
                        
                         <select class="form-control itemvalue mySelect2"  name="" id="item" >
                          <option value="" hidden>Item</option>
                          @foreach($item as $row)
                        <option value="{{$row->id}}" >{{$row->code}}/{{$row->item}}/{{$row->part_no}}</option>
                        @endforeach
                    
                        </select>
                          </div> 
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-1 result">
                    <div class="form-group">
                      <div class="input-group">
                        
                        
                       <button type="button" class="btn btn-gradient-info btn-xs" disabled> <span class="mdi mdi-eye-off "></span></button>
                           
                      </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        
                        
                        <button type="button" class="btn btn-gradient-success btn-xs addtogrid">Add To Grid</button>
                           
                      </div>
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
                           <th> Qnty</th>
                           <th>Rate</th>
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
              
                   <div class="col-md-4">
                    
                </div>
                <div class="col-md-4 col-md-offset-0">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Qnty</span>
                        </div>
                       <input  class="form-control tqnty"  name="tot_qnty" value="{{old('tot_qnty')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Amount</span>
                        </div>
                       <input  class="form-control tamount "  name="tamount" value="{{old('tamount')}}" >
                        
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
                         <input type="text" class="form-control auto-cal disctotal"   name="discount_total"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate "   name="erate"  value="{{1}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount(KWD)</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal "   name="totals"  value="{{old('totals'),0}}" readonly>
                          <input type="hidden" class="form-control auto-cal totalcost "   name="totcosts"  value="{{old('total'),0}}" readonly> 
                        
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
                         <input type="text" class="form-control auto-cal tax"   name="tax"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight"   name="freight"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf "   name="pf"  value="{{0}}" >
                           
                        
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
                         <input type="text" class="form-control auto-cal insurance"   name="insurance"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others"   name="others"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total</span>
                        </div>
                         <input type="text" class="form-control auto-cal  nettotal"   name="net_total"  value="{{old('net_total'),0}}" readonly>
                           
                        
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
                        <textarea class="form-control "  name="deliveryinfo" >
                          
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
                        <textarea class="form-control "  name="paymentterms" >
                          
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
                        <textarea class="form-control "  name="shipping" >
                          
                        </textarea>
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
              
                   <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Notes</span>
                        </div>
                        <textarea class="form-control "  name="remarks" >
                          
                        </textarea>
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
<!-- ///////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">Purchase Order Details</h5>
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
      <th scope="col">Status</th>
      </tr>
  </thead>
  <tbody>
   @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/po/{{$data->id}}">{{$data->po_no}}</a></td>
      <td><a href="/inventory/po/{{$data->id}}">{{$data->vendor}}</a></td>
      <td><a href="/inventory/po/{{$data->id}}">{{$data->odr_by}}</a></td>
    
    <td><a href="/inventory/po/{{$data->id}}">@if($data->is_approved=='1') Approved @elseif($data->is_approved=='2') Partially Approved @else Pending @endif</a></td>
  
     
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
  $(function(){
$(".itemvalue").change(function(){
               itemid = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getitemdetails')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".result").html(data);

              }
          });
  });
                });
// //////////ADD TO GRID SECTION ///////////////////////
$('.addtogrid').click(function () {
  $('#myalertdiv').hide();
    var rowCount;
        token = $("#token").val();
        rowCount = $('.ItemGrid tr').length; 
        itemid = $('.itemvalue').val();
       //alert(itemid);
$.ajax({ 
         type: "POST",
         url: "{{url('itemstogridforrequisition')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token},
         dataType: "html",  
         success: 
              function(data){
                 var isExists=false;
        
        $(".ItemGrid td input.gridid").each(function(){
              var val=$(this).val();
              if(val==itemid)
                isExists=true;

            });
            if (isExists) {
               alert('Item exist');
      
            }else{ 
              
                $('#ItemGrid tbody').append(data);
}
              }
          });
             
}); 
/////////////////Calculation////////////////
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
 $(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
    item_id = row.find("th input.doitemid").val();
   ntotals = parseFloat($(".tamount").val());
   tabamount = parseFloat(row.find("td input.amount").val());
   tqnty =$(".tqnty").val();
   var disc = $(".disctotal").val();
   var erate = $(".erate").val();
   var tax =parseFloat($(".tax").val());
   var pf = parseFloat($(".pf").val());
   var insurance =parseFloat($(".insurance").val());
   var freight = parseFloat($(".freight").val());
   var others = parseFloat($(".others").val());
    var total =ntotals -tabamount;
   var nettotals = total-disc;
   var afrrate = erate*nettotals;
   var othramt = tax + insurance + freight + others + pf;
   var all = afrrate +  othramt;
   var actual = all;
   tabqnty = parseFloat(row.find("td input.qnty").val());
   $(".tamount").val(total.toFixed(3));
    $(".gridtotal").val(afrrate.toFixed(3));
   $(".nettotal").val(actual.toFixed(3));
   $(".tqnty").val(tqnty -tabqnty);
 });
              </script>
@stop