@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table   menu-icon"></i>
                </span>Project Invoice
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
                      <p class="card-description">Admin Can delete Proj Invoice If Not Paid</p>
                    <form class="forms-sample" action ="{{('/createprojinv')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Proj Inv#</span>
                        </div>
                       
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="projinv_no" id="code" value="{{ $pinv->projinv_no }}"  readonly >
                       
                        
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white "> Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($pinv->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Code</span>
                        </div>
                        <select class="form-control projectid " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="projectid" required="" >
                          <option value="" hidden>Project Code</option>
                          @foreach($pros as $vend)
                        <option value="{{$vend->id,old('executive')}}" {{($pinv->projectid == $vend->id ? 'selected' : 'disabled') }}>{{$vend->project_code}}</option>
                        @endforeach
                    
                        </select>
                      </div>
                    </div>
                </div>
            </div>
           <div class="row proresult">
            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Name</span>
                        </div>
                        <input type="text" class="form-control executive" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="projectname" required="" value="{{$pinv->projectname}}">
                          
                    
                      </div>
                    </div>
                </div>
             <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="" required="" value="{{$pinv->customer}}">
                         
                      </div>
                    </div>
                </div>
             <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" required="" value="{{$pinv->executive}}" >
                         
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
                  <div class="col-md-2">
                    <span class="input-group-text bg-gradient-dark text-white  ">@if($pinv->is_deleted ==1) Deleted @elseif($pinv->paidstatus ==1) Fully Paid @elseif($pinv->paidstatus ==2) Particially Paid @else Not Paid @endif</span>
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
                          <th>Description</th>
                          <th>Quantity</th>
                          <th>Rate</th>
                          <th>Total</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pinv->projectinvoicedetail as $pp)
                      <tr>
  <th scope="row">{{$loop->iteration}}</th>
    <td>
      {{$pp->item}}</td>
      <td>{{$pp->qnty}}
      </td>
      <td>{{$pp->rate}}
        </td>
      <td>{{$pp->total}}
      </td>
      
      <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled><i class="mdi mdi-delete-forever" ></i></button></td>
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
                          <span class="input-group-text bg-gradient-info text-white"> Remarks</span>
                        </div>
                         <textarea class="form-control  " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks"   >

{{$pinv->remarks}}

                           </textarea>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Total Amount</span>
                        </div>
                         <input type="text" class="form-control nettotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="totalamount"  value="{{$pinv->totalamount}}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            @if(session('utype')=='Admin' && $pinv->is_deleted!=='1' && $pinv->paidstatus=='0' )
            <a href="{{url('deleteprinvoice')}}/{{$pinv->id}}" class="btn btn-gradient-dark btn-rounded btn-fw"  onclick="return myFunction();" >Delete</a>
            @endif
<a href="{{url('printpinv')}}/{{$pinv->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
            
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
        <h5 class="modal-title" id="companyModalLabel">Project Invoice Details</h5>
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
      <th scope="col">Customer</th>
      <th scope="col">Project #</th>
      <th scope="col">Project Code</th>
      <th scope="col">Executive</th>
      <th scope="col">Status</th>
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/pro-inv/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/inventory/pro-inv/{{$data->id}}">{{ $data->customer }}</a></td>
      <td><a href="/inventory/pro-inv/{{$data->id}}">{{$data->projinv_no}}</a></td>
      <td><a href="/inventory/pro-inv/{{$data->id}}">{{$data->project_code}}</a></td>
      <td><a href="/inventory/pro-inv/{{$data->id}}">{{$data->executive}}</a></td>
      <td><a href="/inventory/pro-inv/{{$data->id}}">@if($data->is_deleted==1) Deleted @elseif($data->paidstatus==1) Fully Paid @elseif($data->paidstatus==2) Particially Paid @else Not Paid @endif</a></td>
   
     
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
  
$(".projectid").change(function(){
               pid = $(this).val();
               token = $("#token").val();
                 //alert(token);
              $.ajax({
         type: "POST",
         url: "{{url('getallprodetails')}}", 
         data: {_token: token,pid:pid},
         dataType: "html",  
         success: 
              function(result){
            //alert(result);
                $(".proresult").html(result);


              }
          });

                })
$(".addtogrid").click(function(){
item =$(".itemvalue").val();
token = $("#token").val();
rowCount = $('.ItemGrid tr').length;
//alert(item);
     $.ajax({
         type: "POST",
         url: "{{url('getitemstogrid')}}", 
         data: {_token: token,item:item,rowCount:rowCount},
         dataType: "html",  
         success: 
              function(result){
            //alert(result);
                $(".ItemGrid tbody").append(result);
                $(".itemvalue").val("");
              }
          });

})
 
///////////////// Grid item to remove/////////////////////
$(document).on('click', '#remove', function(){  
  row = $(this).closest("tr");
   row.remove();
   ntotal = $(".nettotal").val();
   amount = row.find("td input.amount").val();
$(".nettotal").val((ntotal - amount).toFixed(3));
      });
/////// Deleete confirmation/////////////////
 function myFunction() {
      if(!confirm("Are You Sure to delete this ?"))
      event.preventDefault();
  }
              </script>
@stop