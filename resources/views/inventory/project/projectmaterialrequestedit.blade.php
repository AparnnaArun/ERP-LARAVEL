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
                    <form class="forms-sample" action ="{{('/editmaterialreq')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                       <input type="hidden" name="idd" value="{{ $datas1->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Req#</span>
                        </div>
                       <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="matreq_no" id="code" value=" {{$datas1->matreq_no}}"  readonly >
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Req Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="req_date" value=" {{ \Carbon\Carbon::parse($datas1->req_date)->format('j -F- Y')  }} " required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Req.By</span>
                        </div>
                        
                        <input type="text"  class="form-control accname"  name="req_by" value="{{ $datas1->req_by }}" readonly="">
                          
                     
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
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="project_id" required="" >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_id')}}" {{($datas1->project_id == $pro->id ? ' selected' : 'disabled') }}>{{$pro->project_code}}</option>
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
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="purpose" value="{{$datas1->purpose }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Delivery Date</span>
                        </div>
                         <input type="text" class="form-control editpicker  " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="delivery_date"  value="{{ \Carbon\Carbon::parse($datas1->delivery_date)->format('j -F- Y')  }}">
                           
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="row ">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" value="{{$datas1->customer }}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer PO</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" value="{{$datas1->customerpo }}">
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" value="{{$datas1->executive }}" >
                          
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
              
                <div class="col-md-2">
                   <span class="input-group-text bg-gradient-dark text-white ">
                    @if($datas1->status=='0') Pending @elseif($datas1->status=='1') Fully Issued @else Partially Issued @endif </span>
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
                          <th>Description</th>
                          <th>Unit</th>
                           <th>Req Qnty</th>
                           <th>Issue Qnty</th>
                           <th>Bal Qnty</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($datas1->projectmaterialrequestdetail as $item)
                        <tr>
      <th scope="row">{{$loop->iteration}}<input type="hidden" class="form-control "  name="iiid[]" value="{{$item->id}}" id="iiid"  placeholder="Current Stock"></th>
      <td><input type="hidden" class="form-control "  name="code[]" value="{{$item->code}}" id="code"  placeholder="Current Stock">
        {{$item->code}}</td>
      <td><input type="hidden" class="form-control gridid"  name="item_id[]" value="{{$item->item_id}}" id="item_id"  placeholder="Current Stock">
        <input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}" id=""  placeholder="Current Stock">{{$item->item_name}}</td>
      <td></td>
      <td><input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}" id="unit[]"  placeholder="Current Stock">{{$item->unit}}</td>
      <td><input type="hidden" class="form-control auto-calc qnty"  name="quantity[]" value="{{$item->req_qnty}}" id="qnty"   required="required">{{$item->req_qnty}}</td>
      <td><input type="hidden" class="form-control auto-calc iss_qnty"  name="quantity[]" value="{{$item->iss_qnty}}" id="iss_qnty"   required="required">{{$item->iss_qnty}}</td>
      <td><input type="hidden" class="form-control auto-calc bal_qnty"  name="quantity[]" value="{{$item->bal_qnty}}" id="bal_qnty"   required="required">{{$item->bal_qnty}}</td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled=""><i class="mdi mdi-delete-forever"></i></button></td>
     
     
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
                          <span class="input-group-text bg-gradient-info text-white"> Total Quantity</span>
                        </div>
                         <input type="text" class="form-control nettotal " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="net_total"  value="{{$datas1->net_total}}" readonly>
                           
                        
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