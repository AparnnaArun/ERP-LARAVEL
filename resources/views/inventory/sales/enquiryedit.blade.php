@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Enquiry Details
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
                    <form class="forms-sample" action ="{{('/editsenquirys')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="id" value="{{ $enqq->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Enq#</span>
                        </div>
                       
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="enq_no" id="code" value="{{ $enqq->enq_no }}"  readonly >
                       
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($enqq->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Enquiry Ref.</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="enq_ref" value="{{ $enqq->enq_ref }}">
                          
                     
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
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer" required="" >
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer')}}" {{($enqq->customer == $cust->id ? ' selected' : '') }}>{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Authority</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="authority" value="{{$enqq->authority}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Designation</span>
                        </div>
                         <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="designation"  value="{{$enqq->designation}}">
                           
                        
                      </div>
                    </div>
                </div>
              </div>
           
                 <div class="row">
                  <div class="col-md-2">
                 <span class="input-group-text bg-gradient-dark text-white"> @if($enqq->is_deleted==1) Deleted @elseif($enqq->call_for_quote==1) Qouted @else Active @endif</span>
</div>
                 </div>
                  <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Item</th>
                          <th>Description</th>
                          <th>Unit</th>
                           <th>Quantity</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
            @foreach($enqq->salesenquirydetails as $salesenquirydetails)
            @if($salesenquirydetails->quantity!='0')
                        <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><input type="hidden" class="form-control gridid" aria-label="Amount (to the nearest dollar)" name="sid[]" value="{{$salesenquirydetails->id}}" id=""  placeholder="Current Stock">
      	{{$salesenquirydetails->item_name}}</td>
      <td>{{$salesenquirydetails->description}}</td>
      <td>{{$salesenquirydetails->unit}}</td>
      <td><input type="text" class="form-control auto-calc qnty" aria-label="Amount (to the nearest dollar)" name="quantity[]"  id="qnty"  placeholder="Quantity" required="required" value="{{$salesenquirydetails->quantity}}"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons" disabled><i class="mdi mdi-delete-forever" ></i></button></td>
                       </tr>
                       @endif
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
                          {{$enqq->deli_info}}
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
                  {{$enqq->remarks}}
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
                         <input type="text" class="form-control nettotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$enqq->net_total}}" readonly>
                           
                        
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
              <!-- /////////////////////// POPUP FOR FIND BUTTON ////////////////////////  --> 
  <div class="modal fade bd-find-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="companyModalLabel">Sales Enquiry Details</h5>
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
      <th scope="col">Enq#</th>
      <th scope="col">Enq Date</th>
      <th scope="col">Customer</th>
      <th scope="col">Status</th>
      <th scope="col">Delete</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/enquiry/{{$data->id}}">{{$data->enq_no}}</a></td>
      <td><a href="/inventory/enquiry/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/enquiry/{{$data->id}}">{{$data->name}}</a></td>
    <td><a href="/inventory/enquiry/{{$data->id}}">@if($data->is_deleted==1) Deleted @else Active @endif</a></td>
    @if($data->is_deleted == '1' || $data->call_for_quote == '1')
    <td><a href="#"><i class="mdi mdi-delete-forever"></i></a></td>
    @else
    <td><a href="/inventory/enquiry-delete/{{$data->id}}"><i class="mdi mdi-delete-forever"></i></a></td>@endif
     
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
if(itemid !== gridid && itemid!=""){
$.ajax({ 
         type: "POST",
         url: "{{url('datastogrid')}}", 
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
   ntotal = $(".nettotal").val();
   qty = row.find("td input.qnty").val();
$(".nettotal").val((ntotal - qty).toFixed(3));
      });
$(document).on("keyup change paste", ".auto-calc", function() {
	var sum = 0;
	 $("input.qnty").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".nettotal").val(sum.toFixed(3));
});
              </script>
@stop