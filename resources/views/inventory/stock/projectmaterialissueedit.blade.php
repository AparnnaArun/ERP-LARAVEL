@extends('inventory/layout')
@section ('content')
@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history  menu-icon"></i>
                </span>Project Material Issue
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
                    <form class="forms-sample" action ="{{('/createproissue')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Issue#</span>
                        </div>
                       
                        <input type="text" class="form-control"  name="issue_no" id="code" value="{{ $iss->issue_no }}"  readonly >
                       
                     </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="Amount (to the nearest dollar)" name="dates" value="{{ \Carbon\Carbon::parse($iss->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project</span>
                        </div>
                        <select class="form-control project"  name="project_id" required="" >
                          <option value="" hidden>Project</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_id')}}" {{($iss->project_id == $pro->id ? 'selected' : 'disabled') }}>{{$pro->project_code}}</option>
                        @endforeach
                        </select>
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
                        <input type="text" class="form-control"  name="customer"  value="{{ $iss->customer }}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer PO</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" value="{{ $iss->customerpo }}" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" value="{{ $iss->executive }}"  >
                          
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Req.No</span>
                        </div>
                        <input type="text" class="form-control"  name="issue_to" readonly="" value="{{ $reqq->matreq_no }}" >
                          
                      </div>
                    </div>
                </div>
                  <div class="col-md-4">
                   
                <label class="form-check-label">Issue From</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input direct" {{($iss->issue_from == '0' ? ' checked' : 'disabled') }}  name="invoicefrom" value='0'> Direct </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input enqpopup" name="invoicefrom"   value="1"  {{($iss->issue_from == '1' ? ' checked' : 'disabled') }}> Request </label>
                            </div>
           
           
                             
                </div>
                
              
          </div>
        </div>
                
            <!-- <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Item</span>
                        </div>
                         <select class="form-control itemvalue "  name="" id="item" >
                          <option value="" hidden>Item</option>
                          @foreach($item as $row)
                        <option value="{{$row->id}}" >{{$row->code}}/{{$row->item}}/{{$row->part_no}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>
                </div>
               <div class="col-md-1 poppup">
                              
                
                 </div>
                 </div> -->
                  <div class="col-md-1 poppup">
                              
                
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
                           <th>Iss Qnty</th>
                            <th>Rtn Qnty</th>
                            <th>Bal Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($iss->projectmaterialissuedetail as $item)

<tr>
  <th>{{$loop->iteration}}</th>
  <td>{{$item->item_code}}</td>
  <td>{{$item->item}}</td>
  <td>{{$item->unit}}</td>
  <td>{{$item->issue_qnty}}</td>
  <td>{{$item->rtn_qnty}}</td>
  <td>{{$item->pen_qnty}}</td>
  <td>{{$item->rate}}</td>
  <td>{{$item->total}}</td>
   
     <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
    </tr>
    @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
             
            <div class="row" >
                <div class="col-md-12">
                  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Amount</span>
                        </div>
                        <input type="text" class="form-control totalcost" aria-label="Amount (to the nearest dollar)" name="total_amount"  required="required"  value="{{ $iss->total_amount }}">
                        
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
            <a href="{{url('printmatissue')}}/{{$iss->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
            
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
        <h5 class="modal-title" id="companyModalLabel">Material Issue Details</h5>
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
      <th scope="col">Issue#</th>
      <th scope="col">Date</th>
      <th scope="col">Project Code</th>
      
      <th scope="col">Customer</th>
      <th scope="col">Status</th>
  
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/matissue/{{$data->id}}">{{$data->issue_no}}</a></td>
      <td><a href="/inventory/matissue/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/matissue/{{$data->id}}">{{$data->project_code}}</a></td>
      <td><a href="/inventory/matissue/{{$data->id}}">{{$data->customer}}</a></td>
      <td><a href="/inventory/matissue/{{$data->id}}">@if($data->is_returned==1) Fully Returned @elseif($data->is_returned==2) Partially Returned @else Active @endif</a></td>
  
     
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