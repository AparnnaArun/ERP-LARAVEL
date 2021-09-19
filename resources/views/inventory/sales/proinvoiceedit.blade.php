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
                    <form class="forms-sample" action ="{{('/editsproinvoices')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="{{ $proinv->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pro#</span>
                        </div>
                      
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="pro_no" id="code" value="{{ $proinv->pro_no }}"  readonly >
                       
                       
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($proinv->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Customer Ref.</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="customer_ref" value="{{  $proinv->customer_ref  }}">
                          
                     
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
                        <option value="{{$cust->id,}}" {{($proinv->customer == $cust->id ? 'selected' : '') }}>{{$cust->short_name}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white  ">Authority</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="authority" value="{{$proinv->authority }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Designation</span>
                        </div>
                         <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="designation"  value="{{$proinv->designation }}">
                           
                        
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
                        <option value="{{$cur->shortname,old('currency')}}" {{($proinv->customer == $cur->shortname ? 'selected' : '') }} >{{$cur->shortname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                    
                <div class="col-md-4">
                   
                <label class="form-check-label">Proforma From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="from_quote" value='0' {{($proinv->from_quote == '0' ? 'checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="from_quote"   value="1" {{($proinv->from_qoute == '1' ? 'checked' : 'disabled') }} > Quotation </label>
                            </div>
           
           
                             
                </div>
                <div class="col-md-4">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="paymentmode" value='0' {{($proinv->paymentmode == '0' ? 'checked' : '') }}> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="paymentmode"   value="1" {{($proinv->paymentmode == '1' ? 'checked' : '') }} > Credit </label>
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
                          @foreach ($proinv->proformainvoicedetail as $eenq )  
    <tr>
     <th scope="row"><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="enqid[]" value="{{$eenq->enq_id}}" id="item_id"  placeholder="Current Stock"><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="menqid[]" value="{{$eenq->id}}" id=""  placeholder="Current Stock">{{$loop->iteration}}</th>
    <td><input type="hidden" class="form-control gridid" aria-label="Amount (to the nearest dollar)" name="item_id[]" value="{{$eenq->item_id}}" id="item_id"  placeholder="Current Stock"><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="code[]" value="{{$eenq->code}}" id=""  placeholder="Current Stock">
        {{$eenq->code}}</td>
      <td><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="item[]" value="{{$eenq->item}}" id=""  placeholder="Current Stock">
      {{$eenq->item}}</td>
      
      <td><input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="unit[]" value="{{$eenq->unit}}" id="unit[]"  placeholder="Current Stock">{{$eenq->unit}}</td>
      
      <td><input type="text" class="form-control auto-calc qnty inputpadd" aria-label="Amount (to the nearest dollar)" name="quantity[]"  id="qnty"  placeholder="Quantity" required="required" value="{{$eenq->quantity}}"></td>
      <td><input type="text" class="form-control auto-calc rate inputpadd" aria-label="Amount (to the nearest dollar)" name="rate[]"  id=""  placeholder="Rates" required="required" value="{{$eenq->rate}}"></td>
      <td><input type="text" class="form-control auto-calc discount inputpadd" aria-label="Amount (to the nearest dollar)" name="discount[]" value="{{$eenq->discount}}"  id=""  placeholder="Discount" ></td>
      <td><input type="text" class="form-control auto-calc tabamount inputpadd" aria-label="Amount (to the nearest dollar)" name="amount[]" value="{{$eenq->amount}}" id="amount"  placeholder="Total" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons" disabled><i class="mdi mdi-delete-forever"></i></button></td>
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
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Info</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="deli_info"  >
                        {{ $proinv->deli_info }}
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
                         <input type="text" class="form-control auto-calc disctotal" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="discount_total"  value="{{$proinv->discount_total }}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-calc gridtotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="total"  value="{{$proinv->total }}" readonly>
                           
                        
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
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="paymentinfo" >
                          {{ $proinv->paymentinfo }}
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
                           {{$proinv->remarks}} 

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
                         <input type="text" class="form-control auto-calc nettotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$proinv->net_total }}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="{{url('printproinvoice')}}/{{$proinv->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
            
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

///////////////// Grid item to remove/////////////////////


$(document).on("keyup change paste", ".auto-calc", function() {
   var total =$(".gridtotal").val();
   var disc = $(".disctotal").val();
   var nettotal = total-disc;
   $(".nettotal").val(nettotal.toFixed(3));
 });
////////////////Enquiry Radio MENU /////////////////

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
$(".gridtotal").val(sum.toFixed(3));
});
              </script>
@stop