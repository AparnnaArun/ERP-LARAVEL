@extends('inventory/layout')
@section ('content')
@include('inventory.newcustomer')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Delivery Note Return 
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
                    <form class="forms-sample" action ="{{('/editsdnotertns')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">DORtn#</span>
                        </div>
                   
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="rtn_no" id="" value="{{ $dortn->rtn_no }}"  readonly >
                       
                       
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($dortn->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Location</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="location" required="" id="">
                          
                     @foreach($store as $st)
                        <option value="{{$st->id}}" {{($dortn->location == $st->id ? 'selected' : 'disabled') }}>{{$st->locationname}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer" required="" id="customer">
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id,old('customer')}}" {{($dortn->customer == $cust->id ? 'selected' : 'disabled') }} >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                        <div class="alert alert-danger custdiv" role="alert" style="display: none;" >
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session('failed') }}
</div>
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4 doresult">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Delivery Note No</span>
                        </div>
                       <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="deli_note_number" required="" id="" value="{{$do->deli_note_no}}">
                        
                    
                      
                        
                      </div>
                    </div>
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
                           <th>Location</th>
                            <th>Batch</th>
                             <th>DO Qnty</th>
                             <th>Rtn Qnty</th>
                             
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($dortn->deliveryreturndetail as $row)

<tr>
    <td>{{$loop->iteration}}</td>
      <td>{{$row->item_code}}</td>
      <td>{{$row->item_name}}</td>
      <td>{{$row->unit}}</td>
       <td>{{$row->locationname}}</td>
      <td>{{$row->batch}}</td>
      <td>{{$row->dnqnty}}</td>
      <td>{{$row->rtnqnty}}</td>
     
     
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
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" >
                         
{{$dortn->remarks}}
                        </textarea>
                      </div>
                    </div>
                </div>
               
              </div>
            
              
          
            
<div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled="disabled">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="{{url('printeditdortn')}}/{{$dortn->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
      
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
        <h5 class="modal-title" id="companyModalLabel">Delivery Note Return  Details</h5>
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
      <th scope="col">Rtn #</th>
      <th scope="col">Customer</th>
      <th scope="col">DO #</th>
     
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/doreturn-edit/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/inventory/doreturn-edit/{{$data->id}}">{{$data->rtn_no}}</a></td>
      <td><a href="/inventory/doreturn-edit/{{$data->id}}">{{$data->name}}</a></td>
    <td><a href="/inventory/doreturn-edit/{{$data->id}}">{{$data->deli_note_no}}</a></td>
      
     
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
////////////////Enquiry Radio MENU /////////////////


              </script>
@stop