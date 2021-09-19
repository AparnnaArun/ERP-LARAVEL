@extends('inventory/layout')
@section ('content')
@include('inventory.newvendor')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart-bar menu-icon"></i>
                </span>Goods Received Note
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
                    <form class="forms-sample" action ="{{('/editssgrn')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" class="token"/>
                       <input type="hidden" name="id" value="{{ $grn->id }}" />
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">GRN#</span>
                        </div>
                      <input type="text" class="form-control"  name="grn_no"  value="{{ $grn->grn_no }}"  readonly >
                       </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker" name="dates" value="{{ \Carbon\Carbon::parse($grn->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">DC</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" name="dc" value="{{ $grn->dc }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">DC Date</span>
                        </div>
                       <input  class="form-control editpicker "  name="dc_date" value="{{ \Carbon\Carbon::parse($grn->dc_date)->format('j -F- Y')  }}" >
                        
                      </div>
                    </div>
                </div>
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Vendor</span>
                        </div>
                        <select class="form-control vendor"  name="vendor" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->id,old('vendor')}}" {{($grn->vendor == $cust->id ? 'selected' : 'disabled') }} >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                   	
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Project Code</span>
                        </div>
                        <select class="form-control "  name="project_code"  >
                          <option value="" hidden>Project Code</option>
                     @foreach($pros as $pro)
                        <option value="{{$pro->id,old('project_code')}}" {{($grn->project_code == $pro->id ? 'selected' : 'disabled') }} >{{$pro->project_code}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white required ">Location</span>
                        </div>
                        <select class="form-control loc"  name="locations" required="" >
                         
                     @foreach($store as $str)
                        <option value="{{$str->id,old('locations')}}" {{($grn->locations == $str->id ? 'selected' : 'disabled') }}>{{$str->locationname}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4 result">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">PO #</span>
                        </div>
                        <input type="text"  class="form-control " name="dc" value="{{ $grn->po_no }}">
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
                          
                           <th>Batch</th>
                           
                          <th>GRN Qnty</th>
                          <th>Inv Qnty</th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach($grn->goodsreceivednotedetail as $item)
<tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>
      
      {{$item->item_code}}
      </td>
      <td>
    
     {{$item->item_name}}
     </td>
     <td>
   {{$item->unit}}
    </td>
    
    <td>
     {{$item->unit}}
    </td>
      <td>
        
      {{$item->quantity}}
    </td>
    <td>
    {{$item->invqnty  }}
    </td>

     
     
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
                          {{$grn->remarks}}
                        </textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Total Qnty</span>
                        </div>
                       <input  class="form-control tqnty"  name="tot_qnty" value="{{$grn->tot_qnty}}" required="" >
                        
                      </div>
                    </div>
                </div>
                
                
              </div>
              
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            <a href="{{url('printgrn')}}/ {{$grn->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Print</a>
            
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
        <h5 class="modal-title" id="companyModalLabel">GRN Details</h5>
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
      <th scope="col">Grn#</th>
      <th scope="col">Date</th>
      <th scope="col">PO Number</th>
      <th scope="col">Vendor</th>
      </tr>
  </thead>
  <tbody>
  @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/grn/{{$data->id}}">{{$data->grn_no}}</a></td>
      <td><a href="/inventory/grn/{{$data->id}}">
        {{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/inventory/grn/{{$data->id}}">{{$data->po_no}}</a></td>
      <td><a href="/inventory/grn/{{$data->id}}">{{$data->vendor}}</a></td>
      
    
    
  
     
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
$(".vendor").change(function(){
               vendor = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('loadponumber')}}", 
         data: {_token: token,vendor:vendor},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
                $(".result").html(data);

              }
          });

                })


              </script>
@stop