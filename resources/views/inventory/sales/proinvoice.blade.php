@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Proforma Invoice
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
                    <form class="forms-sample" action ="{{('/createproinvoice')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pro#</span>
                        </div>
                       @if(!empty($voucher->constants))
                        <input type="text" class="form-control"  name="pro_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
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
                          <span class="input-group-text bg-gradient-info text-white ">Customer Ref.</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="customer_ref" value="{{ old('customer_ref') }}">
                          
                     
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
                    
                        <select class="form-control mySelect2 "  name="customer" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                            </div>
                        
                      </div>
                    </div>
                    <div class="alert alert-danger custdiv" role="alert" style="display: none;" >
 
  {{ session('failed') }}
</div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Authority</span>
                        </div>
                       <input  class="form-control "  name="authority" value="{{old('authority')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Designation</span>
                        </div>
                         <input type="text" class="form-control "  name="designation"  value="{{old('designation')}}">
                           
                        
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
                   
                <label class="form-check-label">Proforma From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="from_quote" value='0'> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="from_quote"   value="1"  > Quotation </label>
                            </div>
           
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="paymentmode" value='0'> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="paymentmode"   value="1"  > Credit </label>
                            </div>
           
           
                             
                </div>
              </div>
            <div class="row">
              <div class="col-md-4">
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
                
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        
                        
                        <button type="button" class="btn btn-gradient-success btn-xs addtogrid">Add To Grid</button>
                           
                      </div>
                    </div>
                </div>
                
                 </div>
                 <div class="row">
<div class="col-md-11 salesenq" >
                    
                </div>
                <div class="col-md-1 godiv" >
                    <div class="form-group">
                      <div class="input-group">
                        <button type="button" class="btn btn-gradient-info btn-xs addtocart" style="display: none;" > Go</button>
                           
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
                           <th>Quantity</th>
                            <th>Rates</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th></th>
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
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Discount</span>
                        </div>
                         <input type="text" class="form-control auto-calc disctotal"  name="discount_total"  value="{{0}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-calc gridtotal "  name="total"  value="{{old('total'),0}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Payment Info</span>
                        </div>
                        <textarea class="form-control "  name="paymentinfo" >
                          Payment on delivery.
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
                        <textarea class="form-control "  name="remarks" >
                           15 Days validity

                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Amount</span>
                        </div>
                         <input type="text" class="form-control auto-calc nettotal "  name="net_total"  value="{{0}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
             @if (session('status'))
            <a href="{{url('printproinvoice')}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
            @else
             <a href="#" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" title="Save your work first" disabled>Print</a>
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
        <h5 class="modal-title" id="companyModalLabel">Proforma Invoice Details</h5>
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
      <th scope="col">Inv#</th>
      <th scope="col">Inv Date</th>
      <th scope="col">Customer</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/proforma-edit/{{$data->id}}">{{$data->pro_no}}</a></td>
      <td><a href="/inventory/proforma-edit/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/proforma-edit/{{$data->id}}">{{$data->name}}</a></td>
    
     
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
                $(".itemvalue").change(function(){
               itemid = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getitemdetails')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".result").html(result);

              }
          });

                })
// //////////ADD TO GRID SECTION ///////////////////////
$('.addtogrid').click(function () {
  $('#myalertdiv').hide();
    var rowCount;
        token = $("#token").val();
        rowCount = $('.ItemGrid tr').length; 
        itemid = $('.itemvalue').val();
        gridid = $(".gridid").val();
        //alert(itemid);
        //alert(gridid);
if(itemid!= gridid && itemid!=""){
$.ajax({ 
         type: "POST",
         url: "{{url('itemstogridsqoute')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token,gridid:gridid},
         dataType: "html",  
         success: 
              function(data){
               
                $('#ItemGrid tbody').append(data);

              }
          });
          }
          else{
            $('#myalertdiv').show();
            $("#myalertdiv").text("Item exist/No item ");
          }    
}); 
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotal = $(".gridtotal").val();
  discs = $(".disctotal").val();
 tabamount = row.find("td input.tabamount").val();
bal = ntotal - tabamount;
$(".gridtotal").val((ntotal - tabamount).toFixed(3));
$(".nettotal").val((bal - discs).toFixed(3));
      });

$(document).on("keyup change paste", ".auto-calc", function() {
   var total =$(".gridtotal").val();
   var disc = $(".disctotal").val();
   var nettotal = total-disc;
   $(".nettotal").val(nettotal.toFixed(3));
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
         url: "{{url('quotedetails')}}", 
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
   if($('.enqpopup').is(':checked')){
token = $("#token").val();

$.ajax({ 
         type: "POST",
         url: "{{url('quotedetails')}}", 
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

    });

});
$(".addtocart").click(function(){
enqno = $(".select_product").val();
//alert(endno);
$.ajax({ 
         type: "POST",
         url: "{{url('quotedetailsfromcart')}}", 
        data: {enqno: enqno,_token:token},
         dataType: "html",  
         success: 
             function(data){
               
                $('#ItemGrid tbody').html(data);

              }
          });
  });
              </script>
@stop