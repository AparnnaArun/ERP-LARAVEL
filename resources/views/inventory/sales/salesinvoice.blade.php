@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Sales Invoice
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
                    <form class="forms-sample" action ="{{('/createsinvoice')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Inv#</span>
                        </div>
                       @if(!empty($voucher->constants))
                        <input type="text" class="form-control"  name="invoice_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                       @else
                       <input type="text" class="form-control"  name="" id="code" value=""  readonly >
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
                <div class="col-md-4" id="podiv">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Customer PO</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="po_number" value="{{ old('po_number') }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required add-on">Customer</span>
                        
                        <select class="form-control mySelect2 customer"  name="customer_id" required="" id="customer">
                          <option value="" hidden>Customer</option>

                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer_id')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                        </div>
                        <div class="custdiv"  style="display: none;color:red;" >
  
</div>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Manual DO</span>
                        </div>
                       <input  class="form-control "  name="manual_do_no" value="{{old('manual_do_no')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Manual Invoice</span>
                        </div>
                         <input type="text" class="form-control  "  name="manual_inv_no"  value="{{old('manual_inv_no')}}">
                           
                        
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
                        <select class="form-control "  name="currency" required="" >
                          
                     @foreach($currency as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" >{{$cur->shortname}}</option>
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
                         <input type="text" class="form-control "  name="ship_to"  value="{{old('ship_to')}}">
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                   
                <label class="form-check-label">Invoice From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="invoicefrom" value='0'> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="invoicefrom"   value="1"  > DO </label>
                            </div>
           
           
                             
                </div>
                <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="payment_mode" value='cash'> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="payment_mode" checked   value="credit"  > Credit </label>
                            </div>
           
           
                             
                </div>
              </div>
            <div class="row">
              <div class="col-md-5">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white add-on required">Item</span>
                      
                        
                         <select class="form-control itemvalue mySelect2 "  name="" id="item" >
                          <option value="" hidden>Item</option>
                          @foreach($item as $row)
                        <option value="{{$row->id}}" >{{$row->code}}/{{$row->item}}/{{$row->part_no}}/({{$row->sumqnty}})</option>
                        @endforeach
                    
                        </select>
                          </div>   
                        
                      </div>
                    </div>
                </div>
                       
                 <div class="col-md-4 executive">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        
                         <select class="form-control  "  name="" id="" required >
                          <option value="" hidden>Executive</option>
                          
                    
                        </select>
                           
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="col-md-1 excecee">
                              
                
                 </div>
                <div class="col-md-1 poppup">
                              
                
                 </div>
                
               
                
                 </div>
                 <div class="row">
<div class="col-md-11 salesenq" >
                    
                </div>
                <div class="col-md-1 godiv" >
                    <div class="form-group">
                      <div class="input-group">
                        <button type="button" class="btn btn-gradient-success btn-xs addtocart" style="display: none;" > Go</button>
                           
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
                  <div class="row doGrid">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                           <th>Batch</th>
                            <th>Inv Qnty</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Free Qnty</th>
                            <th>Total</th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div class="row" >
                <div class="col-md-12">
                <table class="table table-striped stocktable" id="stocktable" style="display: none;" >
                      <thead>
                       
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
              </div>
            </div>
              <div class="row">
              
                  
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Discount</span>
                        </div>
                         <input type="text" class="form-control auto-cal disctotal"  name="discount_total"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate "  name="erate"  value="{{1}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal "  name="total"  value="{{old('total'),0}}" readonly>
                          <input type="hidden" class="form-control auto-cal totalcost "  name="totcosts"  value="{{old('total'),0}}" readonly> 
                        
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
                         <input type="text" class="form-control auto-cal tax"  name="tax"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight"  name="freight"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf "  name="pf"  value="{{0}}" >
                           
                        
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
                         <input type="text" class="form-control auto-cal insurance"  name="insurance"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others"  name="others"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Advance</span>
                        </div>
                         <input type="text" class="form-control auto-cal  advance"  name="advance"  value="{{0}}" >
                           
                        
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
                        <textarea class="form-control "  name="deli_info"  >
                          Ex Stocks
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
                        <textarea class="form-control "  name="payment_terms" >
                          Payment on delivery.
                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total</span>
                        </div>
                         <input type="text" class="form-control auto-cal  nettotal"  name="net_total"  value="{{old('net_total'),0}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
               
                
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Vehicle Details</span>
                        </div>
                        <textarea class="form-control "  name="vehicle_details" >
                           15 Days validity

                        </textarea>
                      </div>
                    </div>
                </div>
              </div>
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw save">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="#" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
            @if (session('status'))
             <a href="{{url('printinvoice')}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
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
        <h5 class="modal-title" id="companyModalLabel">Sales Invoice Details</h5>
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
      <th scope="col">Date</th>
      <th scope="col">Invoice #</th>
      <th scope="col">Customer</th>
      <th scope="col">Delivery Note#</th>
      <th scope="col">Customer PO</th>
      <th scope="col">Status</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
    <td><a href="/inventory/salesinvoice/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/salesinvoice/{{$data->id}}">{{$data->invoice_no}}</a></td>
      <td><a href="/inventory/salesinvoice/{{$data->id}}">{{$data->name}}</a></td>
    <td><a href="/inventory/salesinvoice/{{$data->id}}">{{$data->deli_note_no}}</a></td>
    <td><a href="/inventory/salesinvoice/{{$data->id}}">{{$data->po_number}}</a></td>
    <td><a href="/inventory/salesinvoice/{{$data->id}}">  @if(($data->is_deleted) == '1') Deleted @elseif(($data->paidstatus) == '1') Paid @elseif(($data->is_returned) == '1') Fully Returned @elseif(($data->is_returned) == '2') Particially Returned   @else Not Paid @endif</a></td>
     
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
               //alert(token);
              $.ajax({
         type: "POST",
         url: "{{url('getcurrentstockinv')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".poppup").html(result);
                $('.currenytstock').modal('show');

              }
          });

                })
              })


// //////////ADD TO GRID SECTION ///////////////////////
 $(document).on("keyup change paste", ".auto-cal", function() {
   var total =$(".gridtotal").val();
   var disc = $(".disctotal").val();
   var erate = $(".erate").val();
   var tax =parseFloat($(".tax").val());
   var pf = parseFloat($(".pf").val());
   var insurance =parseFloat($(".insurance").val());
   var freight = parseFloat($(".freight").val());
   var others = parseFloat($(".others").val());
    var advance = parseFloat($(".advance").val());
   var nettotals = total-disc;
   var afrrate = erate*nettotals;
   var othramt = tax + insurance + freight + others + pf;
   var all = afrrate +  othramt;
   var actual = all - advance;
   //alert(all);
   $(".nettotal").val(actual.toFixed(3));
 });
////////////////Enquiry Radio MENU /////////////////
$(document).ready(function () {
 
$(".enqpopup").click(function(){
   $(".custdiv").hide();
  customer =$("#customer").val();
  token = $("#token").val();
  if(customer!=""){
$.ajax({ 
         type: "POST",
         url: "{{url('dodetailstoinv')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.salesenq').html(data);
               $(".addtocart").show();
                           }
          });
}
else{
$(".custdiv").show();
$(".custdiv").text('Please choose customer');
}
    });
  $(".custdiv").hide();
$("#customer").change(function(){
  $(".custdiv").hide();
  customer =$("#customer").val();
  token = $("#token").val();
  //alert(token);
   if($('.enqpopup').is(':checked')){
$.ajax({ 
         type: "POST",
         url: "{{url('dodetailstoinv')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.salesenq').html(data);
               $(".addtocart").show();
                           }
          });
}
$.ajax({ 
         type: "POST",
         url: "{{url('getexecutiveinv')}}", 
        data: {customer: customer,_token:token},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
               $('.executive').html(data);
            
                           }
          });
    });

});
$(".addtocart").click(function(){
  customer =$("#customer").val();
enqno = $(".select_product").val();
$.ajax({ 
         type: "POST",
         url: "{{url('dodetailsfromcart')}}", 
        data: {enqno: enqno,_token:token,customer:customer},
         dataType: "html",  
         success: 
             function(data){
               //alert(data);
                $('.doGrid').html(data);

              }
          });
$.ajax({
    url:"{{url('getpo')}}",
    method:"POST",
    data:{enqno:enqno,_token:token},
    success:function(data)
    {
  
  $('#podiv').html(data);
  }
   });
  });

///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();

   item_id = row.find("th input.doitemid").val();
   ntotals = parseFloat($(".gridtotal").val());
   costtotals = parseFloat($(".totalcost").val());
   tabamount = parseFloat(row.find("td input.salammmt").val());
   tabcost = parseFloat(row.find("td input.costammmt").val());

   discss = parseFloat($(".disctotal").val());
   erats = parseFloat($(".erate").val());
   taxs = parseFloat($(".tax").val());
  freights = parseFloat($(".freight").val());
  insurances =parseFloat( $(".insurance").val());
  pfs = parseFloat($(".pf").val());
  otherss = parseFloat($(".others").val());
  advances = parseFloat($(".advance").val());
  alls =pfs + insurances + freights + otherss + taxs;
   ball = ntotals - tabamount- discss;
   ballx =  erats * ball;
allbalss =  ballx + alls - advances;
$(".gridtotal").val((ntotals - tabamount).toFixed(3));
$(".totalcost").val((costtotals - tabcost).toFixed(3));
$(".nettotal").val(allbalss.toFixed(3));
$(".stocktable tr").each(function(){
       $(this).find('td input.idid').each(function(){
          var currentText = $(this).val();
 if(currentText == item_id){
              $(this).parents('tr').remove();
          }
      });
   });
   });
              </script>
@stop