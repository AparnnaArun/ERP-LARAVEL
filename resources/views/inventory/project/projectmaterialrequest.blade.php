@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table   menu-icon"></i>
                </span>Material Request
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
                    <form class="forms-sample" action ="{{('/creatematerialreq')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Req#</span>
                        </div>
                       
                        <input type="text" class="form-control"  name="matreq_no" id="code" value="{{ $voucher->constants }}{{ $nslno }}"  readonly >
                       
                        <input type="hidden" class="form-control"  name="slno" id="code" value="{{ $nslno }} "  readonly >
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Req Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="req_date" value="{{ old('req_date') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Req.By</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="req_by" value="{{ session('name') }}" readonly="">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Code</span>
                        </div>
                        <select class="form-control project"  name="project_id" required="" >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_id')}}" >{{$pro->project_code}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Purpose</span>
                        </div>
                       <input  class="form-control "  name="purpose" value="{{old('purpose')}}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Delivery Date</span>
                        </div>
                         <input type="text" class="form-control datepicker  "  name="delivery_date"  value="{{old('delivery_date')}}">
                           
                        
                      </div>
                    </div>
                </div>
              </div>
               <div class="resultrow">
            <div class="row ">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer PO</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" >
                          
                      </div>
                    </div>
                </div>
            </div>
          </div>
            <div class="row">
              <div class="col-md-5">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required add-on">Item</span>
                        
                         <select class="form-control itemvalue mySelect2"  name="" id="item" >
                          <option value="" hidden>Item</option>
                          @foreach($item as $row)
                        <option value="{{$row->id}}" >{{$row->code}}/{{$row->item}}/{{$row->part_no}}/({{$row->sumqnty}})</option>
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
                <!-- <div class="col-md-2">
                   <span class="input-group-text bg-gradient-info text-white ">Pending</span>
                </div> -->
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
                          <th>Description</th>
                          <th>Unit</th>
                           <th>Quantity</th>
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
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Quantity</span>
                        </div>
                         <input type="text" class="form-control nettotal "  name="net_total"  value="{{old('net_total')}}" readonly>
                           
                        
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
        <h5 class="modal-title" id="companyModalLabel">Project Material Request Details</h5>
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
      <th scope="col">Req#</th>
      <th scope="col">Project Code</th>
      <th scope="col">User</th>
      <th scope="col">Status</th>
      
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/Material/{{$data->id}}">{{$data->matreq_no}}</a></td>
      <td><a href="/inventory/Material/{{$data->id}}">{{ $data->project_code }}</a></td>
      <td><a href="/inventory/Material/{{$data->id}}">{{$data->createdby}}</a></td>
      <td><a href="/inventory/Material/{{$data->id}}">@if($data->status==1) Fully Issues @elseif($data->status==2) particially Issued @else Not issued @endif</a></td>
   
     
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
              function(result){
              //alert(result);
                $(".result").html(result);

              }
          });
       });
              });
    $(".project").change(function(){
               pid = $(this).val();
               token = $("#token").val();
               action="Reqst";
              $.ajax({
         type: "POST",
         url: "{{url('alldetails')}}", 
         data: {_token: token,pid:pid,action:action},
         dataType: "html",  
         success: 
              function(result){
            $(".resultrow").html(result);
                              }
          });

          });


// //////////ADD TO GRID SECTION ///////////////////////
////This is same for both Sales Enquiry & material request////////
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
         url: "{{url('itemstogrid')}}", 
        data: {itemid: itemid,rowCount: rowCount,_token:token,gridid:gridid},
         dataType: "html",  
         success: 
              function(data){
               
                $('#ItemGrid tbody').append(data);
                $(".itemvalue").select2('val', 'All');

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
              </script>
@stop