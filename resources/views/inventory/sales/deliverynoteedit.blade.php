@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Delivery Note 
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
                    <form class="forms-sample" action ="{{('/editsdos')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">DO#</span>
                        </div>
                      
                        <input type="text" class="form-control"  name="deli_note_no" id="" value="{{ $dos->deli_note_no }}"  readonly >
                       
                       
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($dos->dates)->format('j -F- Y')   }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Manual DO</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="manual_do" value="{{ $dos->manual_do }}">
                          
                     
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
                        <select class="form-control "  name="customer" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id}}" {{($dos->customer == $cust->id ? ' selected' : 'disabled') }} >{{$cust->short_name}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white  ">Customer PO</span>
                        </div>
                       <input  class="form-control "  name="customer_po" value="{{$dos->customer_po}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control "  name="project_code" >
                          <option value="" hidden="" >Project Code</option> 
                     @foreach($pros as $pro)
                        <option value="{{$pro->id}}" {{($dos->project_code == $pro->id ? ' selected' : 'disabled') }} >{{$pro->project_code}}</option>
                        @endforeach
                        </select>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                
              <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="" class="form-control executive"  name="executive" value="{{$dos->executive}}" readonly="">
                          
                    
                        
                      </div>
                    </div>
                </div>
                   
                <div class="col-md-2">
                   
                <label class="form-check-label">DO From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" checked  name="from_so" value='0' {{($dos->from_so == '0' ? ' checked' : 'disabled') }}> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="from_so"   value="1" {{($dos->from_so == '1' ? ' checked' : 'disabled') }} > Sales Order </label>
                            </div>
           
           
                             
                </div>
                  <div class="col-md-2">
                   
               <span class="input-group-text bg-gradient-dark text-white ">@if($dos->is_deleted==1) Deleted @elseif($dos->is_invoiced==1) Fully Invoiced @elseif($dos->is_invoiced==2) Partially Invoiced @elseif($dos->is_dortn==1) Fully Return @elseif($dos->is_dortn==2) Partially Return @else Not Invoiced @endif</span>
               
              </div>
              <div class="col-md-4">
                   <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white  ">SO#</span>
                        </div>
                        @if(!empty($so->order_no))
                        <input type="" class="form-control executive"  name="executive" value="{{$so->order_no}}" readonly="">
                        @else
                        <input type="" class="form-control executive"  name="executive" value="" readonly="">
                        @endif  
                    
                        
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
                  <div class="row soodiv">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                          <!--  <th>Location</th> -->
                            <th>Batch</th>
                          
                            <th>DO Qnty</th>
                            <th>Inv Qnty</th>
                            <th>DORtn Qnty</th>
                            <th>Balance</th>
                          </tr>
                      </thead>
                      <tbody>
                                             @foreach ($dos->deliverynotedetail as $eenq )  
    <tr>
    <th>{{$loop->iteration}}</th>
    <td>{{$eenq->code}}</td>
      <td>
      {{$eenq->item}}</td>
      
      <td>{{$eenq->unit}}</td>
 <!--      <td>{{$eenq->location_id}}</td> -->
      <td>{{$eenq->batch}}</td>
      <td>{{$eenq->quantity}}</td>
      <td>{{$eenq->inv_qnty}}</td>
      <td>{{$eenq->dortn_qnty}}</td>
      <td>{{$eenq->bal_qnty}}</td>
     
      </tr>
      @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
             
              <div class="row">
              
                <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Remarks</span>
                        </div>
                        <textarea class="form-control "  name="remarks" >
                        {{$dos->remarks}}

                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Quantity</span>
                        </div>
                         <input type="text" class="form-control auto-cal gridtotal "  name="total"  value="{{$dos->total}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
            
              <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Cancelled Reason </span>
                        </div>
                        <textarea class="form-control "  name="cancelled_reason"  >
                      {{$dos->cancelled_reason}}
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
            @if($dos->is_invoiced == 0 && $dos->is_dortn == 0 && $dos->is_deleted == 0 && session('utype')=='Admin')
            <a href="{{url('deletedo')}}/{{$dos->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
            @endif
            <a href="{{url('printeditdo')}}/{{$dos->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
          
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
        <h5 class="modal-title" id="companyModalLabel">Delivery Note  Details</h5>
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
      <th scope="col">DO#</th>
      <th scope="col">Customer</th>
      <th scope="col">PO #</th>
      <th scope="col">Manual DO #</th>
      <th scope="col">SO #</th>
      <th scope="col">Status</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/delivery-note/{{$data->id}}">{{$data->deli_note_no}}</a></td>
      <td><a href="/inventory/delivery-note/{{$data->id}}">{{$data->name}}</a></td>
      <td><a href="/inventory/delivery-note/{{$data->id}}">{{$data->customer_po}}</a></td>
    <td><a href="/inventory/delivery-note/{{$data->id}}">{{$data->manual_do}}</a></td>
      <td><a href="/inventory/delivery-note/{{$data->id}}">{{$data->order_no}}</a></td>
      <td><a href="/inventory/delivery-note/{{$data->id}}">
        @if($data->is_deleted==1) Deleted @elseif($data->is_invoiced==1) Fully Invoiced @elseif($data->is_invoiced==2) Partially Invoiced  @elseif($data->is_dortn==1) Fully Return @elseif($data->is_dortn==2) Partially Return @else Not Invoiced @endif</a></td>
     
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
         url: "{{url('getcurrentstock')}}", 
         data: {_token: token,itemid:itemid},
         dataType: "html",  
         success: 
              function(result){
             
                $(".poppup").html(result);
               $('.currenytstock').modal('show')
              }
          });

                })

///////////////// Grid item to remove parellely from the hidden table for current stock/////////////////////
 $(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotals = $(".gridtotal").val();
   item_id = row.find("th input.doitemid").val();
   tabamount = row.find("td input.totqnty").val();
$(".gridtotal").val((ntotals - tabamount).toFixed(3));
$(".stocktable tr").each(function(){
       $(this).find('td input.idid').each(function(){
          var currentText = $(this).val();
 if(currentText == item_id){
              $(this).parents('tr').remove();
          }
      });
   });


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
         url: "{{url('sorderdetails')}}", 
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
   if($('.enqpopup').is(':checked')){


$.ajax({ 
         type: "POST",
         url: "{{url('sorderdetails')}}", 
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
         url: "{{url('getexecutive')}}", 
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