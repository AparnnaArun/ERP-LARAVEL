@extends('inventory/layout')
@section ('content')

@include('inventory.additem')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history  menu-icon"></i>
                </span>Stock Issue Return Details
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
                    <form class="forms-sample" action ="{{('/createissurtn')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Rtn#</span>
                        </div>
                       
                        <input type="text" class="form-control"  name="issuertn_no" id="code" value="{{ $rtns->issuertn_no }}"  readonly >
                       
                       
                        

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" aria-label="Amount (to the nearest dollar)" name="issuertn_date" value="{{ \Carbon\Carbon::parse($rtns->issuertn_date)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Location</span>
                        </div>
                        <select class="form-control"  name="location" required="" >
                          <option value="" hidden>Location</option>
                     @foreach($store as $cust)
                        <option value="{{$cust->id,old('location')}}" {{($rtns->location == $cust->id ? 'selected' : 'disabled') }} >{{$cust->locationname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
            </div>
          
                
            <div class="row">
              
               
                 <div class="col-md-4">
                   
                <label class="form-check-label">Return Type</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input stock"   name="return_type" value='StockIssue' {{($rtns->return_type == 'StockIssue' ? 'checked' : 'disabled') }}> Stock Issue </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input stock" name="return_type"   value="MatIssue"  {{($rtns->return_type == 'MatIssue' ? 'checked' : 'disabled') }}>Material Issue </label>
                            </div>
          
           
                             
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Issue No</span>
                        </div>
                        <input type="text" class="form-control loadissue"  name="stockissueno" readonly="" value="{{$mat->issue_no}}" >
                         
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Return From</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="issuertn_from" value="{{ $rtns->issuertn_from }}" required="required" >
                        
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
                  <div class="row resulttab">
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
                            <th>Issue Qnty</th>
                            <th>Rtn Qnty</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($rtns->stockissuereturndetail as $data )
<tr>
  <td>{{$loop->iteration}}</td>
   
  <td>{{$data->item_code}}</td>
  <td>{{$data->item_name}}</td>
  <td>{{$data->unit}}</td>
  <td>{{$data->batch}}</td>
  <td>{{$data->issqnty}}</td>
  <td>{{$data->rtnqnty}}</td>
  <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled><i class="mdi mdi-delete-forever"></i></button>
  </td>

</tr>

                        @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              
            <div class="row" >
              <div class="col-md-8">
                  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Remarks</span>
                        </div>
                        <textarea class="form-control"  name="remarks">
                          {{ $rtns->remarks }}
                        </textarea>
                        
                      </div>
                    </div>
                 
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Amount</span>
                        </div>
                        <input type="text" class="form-control totalcost" aria-label="Amount (to the nearest dollar)" name="total_amount" value="{{ $rtns->total_amount }}" required="required"  readonly="">
                        
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
            <a href="{{url('printissuertn')}}/{{$rtns->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
        
            
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
        <h5 class="modal-title" id="companyModalLabel">Stock Issue Return Details</h5>
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
      <th scope="col">Return#</th>
      <th scope="col">Date</th>
      <th scope="col">Rtn From</th>
   
  
    
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/issueretn/{{$data->id}}">{{$data->issuertn_no}}</a></td>
      <td><a href="/inventory/issueretn/{{$data->id}}">{{ \Carbon\Carbon::parse($data->issuertn_date)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/issueretn/{{$data->id}}">{{$data->return_type}}</a></td>
     
  
     
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