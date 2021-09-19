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
                       
                        <input type="text" class="form-control" placeholder=""   name="invoice_no" id="code" value="{{ $invs->invoice_no }}"  readonly >
                       
                        
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white "> Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ $invs->dates }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4" id="podiv">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Customer PO</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="po_number" value="{{ $invs->po_number }}">
                          
                     
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
                        <select class="form-control " placeholder=""   name="customer_id" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id}}" {{($invs->customer_id == $cust->id ? ' selected' : 'disabled') }} >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
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
                       <input  class="form-control " placeholder=""   name="manual_do_no" value="{{$invs->manual_do_no}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Manual Invoice</span>
                        </div>
                         <input type="text" class="form-control  " placeholder=""   name="manual_inv_no"  value="{{$invs->manual_inv_no}}">
                           
                        
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
                        <select class="form-control " placeholder=""   name="currency" required="" >
                          
                     @foreach($currency as $cur)
                        <option value="{{$cur->shortname}}" {{($invs->currency == $cur->shortname ? ' selected' : 'disabled') }}>{{$cur->shortname}}</option>
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
                         <input type="text" class="form-control " placeholder=""   name="ship_to"  value="{{$invs->ship_to}}">
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                   
                <label class="form-check-label">Invoice From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="invoicefrom" value='0' {{($invs->invoicefrom == '0' ? ' checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="invoicefrom"   value="1"  {{($invs->invoicefrom == '1' ? ' checked' : 'disabled') }}> DO </label>
                            </div>
           
           
                             
                </div>
                <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="payment_mode" value='0' {{($invs->payment_mode == '0' ? ' checked' : 'disabled') }}> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="payment_mode"    value="1" {{($invs->payment_mode == '1' ? ' checked' : 'disabled') }} > Credit </label>
                            </div>
           
           
                             
                </div>
              </div>
            <div class="row">
              
                 
                 <div class="col-md-4 executive">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                         <input class="form-control " placeholder=""   name="" value="{{$invs1->executive}}"  >
                        
                          
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4 executive">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">DO #</span>
                        </div>
                         <input class="form-control " placeholder=""   name="" value="@foreach($doo as $do){{$do->deli_note_no}},@endforeach"  readonly>
                          
                           
                        
                      </div>
                    </div>
                </div>
                 <div class="col-md-3 ">
                   <span class="input-group-text bg-gradient-dark text-white ">@if($invs->is_deleted=='1') DELETED @elseif($invs->paidstatus=='1') PAID @elseif($invs->is_returned=='1') Fully Returned @elseif($invs->is_returned=='2') Partially Returned   @else NOT PAID @endif  </span>          
                
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
                            <th>Rtn Qnty</th>
                            <th>Free Qnty</th>
                            <th>Bln Qnty</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            
                            <th>Total</th>
                            
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($invs->salesinvoicedetail as $item)
                      <tr>
     <th scope="row">{{$loop->iteration}}</th>
    
        <td>{{$item->item_code}}</td>
      <td>
      {{$item->item_name}}</td>
      
      <td>{{$item->unit}}</td>
      <td>
        {{$item->batch}}</td>
      <td>
        <b>{{$item->quantity}}</b></td>
         <td>
        <b>{{$item->isslnrtn_qnty}}</b></td>
         <td>
        {{$item->freeqnty}}</td>
        <td>
        {{$item->penrtn_qnty}}</td>
         <td>
        {{$item->rate }}</td>
         <td>
        {{$item->discount}}</td>
         <td>
        {{$item->amount}}</td>
     
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
                         <input type="text" class="form-control auto-cal disctotal" placeholder=""   name="discount_total"  value="{{$invs->discount_total}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Exchange Rate</span>
                        </div>
                         <input type="text" class="form-control auto-cal erate " placeholder=""   name="erate"  value="{{$invs->erate}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal " placeholder=""   name="total"  value="{{$invs->total}}" readonly>
                          <input type="hidden" class="form-control auto-cal totalcost " placeholder=""   name="totcosts"  value="{{old('total'),0}}" readonly> 
                        
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
                         <input type="text" class="form-control auto-cal tax" placeholder=""   name="tax"  value="{{$invs->tax}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Freight</span>
                        </div>
                         <input type="text" class="form-control auto-cal freight" placeholder=""   name="freight"  value="{{$invs->freight}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> PF</span>
                        </div>
                         <input type="text" class="form-control auto-cal pf " placeholder=""   name="pf"  value="{{$invs->pf}}" >
                           
                        
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
                         <input type="text" class="form-control auto-cal insurance" placeholder=""   name="insurance"  value="{{$invs->insurance}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Others </span>
                        </div>
                         <input type="text" class="form-control auto-cal others" placeholder=""   name="others"  value="{{$invs->others}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Advance</span>
                        </div>
                         <input type="text" class="form-control auto-cal  advance" placeholder=""   name="advance"  value="{{$invs->advance}}" >
                           
                        
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
                        <textarea class="form-control " placeholder=""   name="deli_info"  >
                         {{$invs->deli_info}}
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
                        <textarea class="form-control " placeholder=""   name="payment_terms" >
                          {{$invs->payment_terms}}
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
                         <input type="text" class="form-control auto-cal  nettotal" placeholder=""   name="net_total"  value="{{$invs->net_total}}" readonly>
                           
                        
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
                        <textarea class="form-control " placeholder=""   name="vehicle_details" >
                           {{$invs->vehicle_details}}

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
           
            <a href="{{url('printeditinvoice')}}/{{$invs->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
             @if(session('utype')=='Admin' && $invs->is_deleted=='0' && $invs->paidstatus=='0' && $invs->is_returned=='0' && $invs->invoicefrom=='0')
            <a href="{{url('deleteinvoice')}}/{{$invs->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
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
    <td><a href="/inventory/salesinvoice/{{$data->id}}">  @if($data->is_deleted==1) Deleted @elseif($data->paidstatus==1) Paid @elseif($data->is_returned="1") Fully Returned @elseif($data->is_returned="2") Particially Returned   @else Not Paid @endif</a></td>
     
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

@stop