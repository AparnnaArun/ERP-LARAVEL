@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar   menu-icon"></i>
                </span>Purchase Invoice
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
                    <form class="forms-sample" action ="{{('/createpi')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">PI#</span>
                        </div>
                       
                  <input type="text" class="form-control"  name="slno" id="code" value="{{ $pi->p_invoice }} "  readonly >
                       
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="dates" value="{{ \Carbon\Carbon::parse($pi->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Invoice</span>
                        </div>
                        
                        <input type="text"  class="form-control "  name="invoice" value="{{$pi->invoice}}">
                          
                     
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
                        <select class="form-control vendor" placeholder="" name="vendor" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->id,old('vendor')}}" {{($pi->vendor == $cust->id ? 'selected' : 'disabled') }}>{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Inv Date</span>
                        </div>
                       <input  class="form-control datepicker" placeholder="" name="inv_date" value="
{{ \Carbon\Carbon::parse($pi->inv_date)->format('j -F- Y')  }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control " placeholder="" name="project_code"  >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_code')}}"  {{($pi->project_code == $pro->id ? 'selected' : 'disabled') }} >{{$pro->project_code}}</option>
                        @endforeach
                        </select>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
            	<div class="col-md-4">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="payment_mode" value='Cash' {{($pi->payment_mode == 'Cash' ? 'checked' : 'disabled') }}> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " checked name="payment_mode"   value="Credit"  {{($pi->payment_mode == 'Credit' ? 'checked' : 'disabled') }}> Credit </label>
                            </div>
           
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Purchase From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup"   name="purchase_method" value='Direct' {{($pi->purchase_method == 'Direct' ? 'checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="purchase_method"   value="LocalPurchase" {{($pi->purchase_method == 'LocalPurchase' ? 'checked' : 'disabled') }} > Local Purchase </label>
                            </div>
                            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup grn" name="purchase_method"   value="GRN" {{($pi->purchase_method == 'GRN' ? 'checked' : 'disabled') }} > GRN </label>
                            </div>
          
           
                             
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Currency</span>
                        </div>
                        <select class="form-control" placeholder="" name="currency" required="" >
                          <option value="" hidden>Currency</option>
                     @foreach($curr as $cur)
                        <option value="{{$cur->shortname,old('currency')}}" {{($pi->currency == $cur->shortname ? 'selected' : 'disabled') }}>{{$cur->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            </div>
             <div class="row ">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Location </span>
                        </div>
                        <select class="form-control loc"  name="locations" required="" >
                         
                     @foreach($store as $str)
                        <option value="{{$str->id,old('locations')}}" {{($pi->locations == $str->id ? 'selected' : 'disabled') }}>{{$str->locationname}}</option>
                        @endforeach
                        </select>
                          
                      </div>
                    </div>
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">GRN #</span>
                        </div>
                          <input type="text" class="form-control "  name="dates" value="@foreach($doo as $do){{$do->grn_no}},@endforeach" readonly >
                           
                        
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
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          <th>Unit</th>
                          <th>Batch</th>
                        
                           <th> Qnty</th>
                           <th>Free Qnty</th>
                           <th>Rtn Qnty</th>
                           <th>Rate</th>
                           <th>Amount</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pi->purchaseinvoicedetail as $item)
                    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>
        {{$item->item_code}}</td>
      <td>{{$item->item_name}}</td>
     
      <td>{{$item->unit}}</td>
      <td>{{$item->batch}}</td>
      <td>{{$item->quantity}}</td>
      <td>{{$item->freeqnty}}</td>
       <td>{{$item->rtnqnty}}</td>
        <td>{{$item->rate}}</td>
        <td>{{$item->total}}</td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled><i class="mdi mdi-delete-forever"></i></button></td>
     
     
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
                          <span class="input-group-text bg-gradient-info text-white"> Additional Charges</span>
                        </div>
                         <input type="text" class="form-control auto-cal adchrg" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="additionalcharges"  value="{{$pi->additionalcharges}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-0">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Qnty</span>
                        </div>
                       <input  class="form-control tqnty" placeholder="" name="tot_qnty" value="{{$pi->tot_qnty}}" readony>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Amount</span>
                        </div>
                       <input  class="form-control tamount " placeholder="" name="tamount" value="{{$pi->tamount}}" readony >
                        
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
                         <input type="text" class="form-control auto-cal disctotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="discount_total"  value="{{$pi->discount_total}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Tax</span>
                        </div>
                         <input type="text" class="form-control auto-cal tax" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tax"  value="{{$pi->tax}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Net Total </span>
                        </div>
                         <input type="text" class="form-control auto-cal nettotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$pi->net_total}}" >
                           
                        
                      </div>
                    </div>
                </div>
                
                
              </div>
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="erate"  value="{{$pi->erate}}" >
                           
                        
                      </div>
                    </div>
                </div>
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount(KWD)</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="totalamount"  value="{{$pi->totalamount}}" readonly>
                         
                        
                      </div>
                    </div>
                </div>  
                
              </div>
            <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
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
        <h5 class="modal-title" id="companyModalLabel">Purchase Invoice Details</h5>
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
      <th scope="col">PI#</th>
      <th scope="col">PI Date</th>
      <th scope="col">Vendor</th>
      <th scope="col">GRN #</th>
      </tr>
  </thead>
  <tbody>
   @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/purchase-invoice/{{$data->id}}">{{$data->p_invoice}}</a></td>
      <td><a href="/inventory/purchase-invoice/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/inventory/purchase-invoice/{{$data->id}}">{{$data->vendor}}</a></td>
      
    
    <td><a href="/inventory/purchase-invoice/{{$data->id}}">{{$data->grn_no}}</a></td>
  
     
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
  $(".enqpopup").click(function(){
   pfrom =$("input[name='purchase_method']:checked").val();
token = $("#token").val();
vendor =$(".vendor").val();
   if(pfrom== 'Direct'){
$(".showspsn").show();
 $(".showvendor").hide();
 $(".addtocart").hide();
 $(".loadgrn").hide();

$.ajax({
         type: "POST",
         url: "{{url('getlocalitems')}}", 
         data: {_token: token,pfrom:pfrom},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".itemvalue").html(data);

              }
          });

   }
   else if(pfrom== 'LocalPurchase'){
    $(".showspsn").hide();
    $(".showvendor").hide();
    $(".addtocart").hide();
 $(".loadgrn").hide();
    $.ajax({
         type: "POST",
         url: "{{url('getlocalitems')}}", 
         data: {_token: token,pfrom:pfrom},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".itemvalue").html(data);

              }
          });
   }else{
    $(".showspsn").hide();
    if(vendor==""){
  $(".showvendor").show();
}
   }
});
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

                })
//////////////////Load GRN//////////////////
$(".vendor").change(function(){
               vendor = $(this).val();
               token = $("#token").val();
              radio =$("input[name='purchase_method']:checked").val();
              if(radio=="GRN"){
                //alert(vendor);
              $.ajax({
         type: "POST",
         url: "{{url('loadgrndetails')}}", 
         data: {_token: token,vendor:vendor},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".loadgrn").html(data);
                $(".loadgrn").show();
                $(".addtocart").show();
$(".showvendor").hide();
              }
          });
            }

                });
///////////// Add to cart click //////////////////////
$(".addtocart").click(function(){
grnno = $(".select_product").val();
//alert(endno);
$.ajax({ 
         type: "POST",
         url: "{{url('grndetailsfromcart')}}", 
        data: {grnno: grnno,_token:token},
         dataType: "html",  
         success: 
             function(data){
               //alert(data);
                $('#ItemGrid').html(data);

              }
          });
  });
// //////////ADD TO GRID SECTION ///////////////////////
$('.addtogrid').click(function () {
  $('#myalertdiv').hide();
    var rowCount;
        token = $("#token").val();
        rowCount = $('.ItemGrid tr').length; 
        itemid = $('.itemvalue').val();
       //alert(rowCount);
$.ajax({ 
         type: "POST",
         url: "{{url('itemstogridforpinvoice')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token},
         dataType: "html",  
         success: 
              function(data){
               //alert(data);
                $('#ItemGrid tbody').append(data);

              }
          });
             
}); 
/////////////////Calculation////////////////
 $(document).on("keyup change paste", ".auto-cal", function() {
   var total =parseFloat($(".tamount").val());
   var disc = parseFloat($(".disctotal").val());
   var erate =parseFloat( $(".erate").val());
   var tax =parseFloat($(".tax").val());
   var adchrg = parseFloat($(".adchrg").val());
   
    
   var nettotals = ((total+ adchrg + tax)-(disc));
   //alert(nettotals);
   var afrrate = erate*nettotals;
   // var othramt = tax + insurance + freight + others + pf;
   // var all = afrrate +  othramt;
   // var actual = all;
    $(".nettotal").val(nettotals.toFixed(3));
 $(".gridtotal").val(afrrate.toFixed(3));
  
 });
 $(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();

   ntotals = parseFloat($(".gridtotal").val());
   ttqnty=parseFloat($(".tqnty").val());
   tabqnty =parseFloat(row.find("td input.qnty").val());
   tabamount = parseFloat(row.find("td input.amount").val());
   

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
$(".gridtotal,.tamount").val((ntotals - tabamount).toFixed(3));
$(".tqnty").val((ttqnty - tabqnty).toFixed(3));
$(".nettotal").val(allbalss.toFixed(3));
});
              </script>
@stop