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
                    <form class="forms-sample" action ="{{('/createrequisition')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Odr#</span>
                        </div>
                       
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="req_no" id="code" value="{{ $reequsi->po_no }}"  readonly >
                       
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates" value="{{ \Carbon\Carbon::parse($reequsi->order_date)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                          
                          <th>Unit</th>
                           <th>PO Qnty</th>
                           <th>PO Appr Qnty</th>
                           <th>Rate</th>
                           <th>Amount</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                        @foreach($reequsi->purchaseorderdetail as $item)
      <th scope="row">{{$loop->iteration}}</th>
      <td><input type="hidden" class="form-control "  name="item_code[]" value="{{$item->code}}" id="code"  placeholder="Current Stock">
        {{$item->item_code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->id}}" id="item_id"  placeholder="Current Stock">
        <input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item}}" id=""  placeholder="Current Stock">{{$item->item_name}}</td>
     
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  placeholder="Current Stock">{{$item->unit}}</td>
      <td>{{$item->reqqnty}}</td>
      <td>{{$item->apprqnty}}</td>
       <td>{{$item->rate}}</td>
        <td>{{$item->total}}</td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "disabled><i class="mdi mdi-delete-forever"></i></button></td>
     
     
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
                         <input type="text" class="form-control auto-cal gridtotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="total"  value="{{$reequsi->total}}" readonly>
                          
                        
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
         url: "{{url('itemstogridforrequisition')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token},
         dataType: "html",  
         success: 
              function(data){
               //alert(data);
                $('#ItemGrid tbody').append(data);

              }
          });
             
}); 

              </script>
@stop