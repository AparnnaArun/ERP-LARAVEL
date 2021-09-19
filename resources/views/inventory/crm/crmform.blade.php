@extends('inventory/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-account-circle   menu-icon"></i>
                </span>CRM FORM
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
                    <form class="forms-sample" action ="{{('/createcrm')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control datepicker"  name="dates" value="{{ old('dates') }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <select class="form-control"  name="executive" required="" >
                          <option value="" hidden>Executive</option>
                     @foreach($exe as $ex)
                        <option value="{{$ex->short_name,old('executive')}}" >{{$ex->short_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Customer</span>
                        </div>
                        
                        <input type="text"  class="form-control accname"  name="customer" value="{{ old('customer') }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
             <div id="dynamic_field1">
           <div class="row">
              
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Con.Person</span>
                        </div>
                       <input  class="form-control "  name="contactperson[]" value="{{old('contactperson')}}" >
                        
                      </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Email</span>
                        </div>
                        <input type="email" class="form-control "  name="email[]"  value="{{old('email')}}">
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Contact#</span>
                        </div>
                         <input type="text" class="form-control "  name="contactno[]"  value="{{old('contactno')}}">
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
              </div>
              </div>
           </div>
                 
                  
              <div class="row">
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Next Followup</span>
                        </div>
                         <input type="text" class="form-control datepicker "  name="followupdate"  value="{{old('followupdate')}}" >
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Status</span>
                        </div>
                        <select class="form-control"  name="status" required="" >
                          <option value="" hidden>Status</option>
                  
                        <option value="0" >Open</option>
                   <option value="1" >Completed</option>
                   <option value="2" >Cancelled</option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                   <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Feedback</span>
                        </div>
                        <textarea class="form-control "  name="feedback" >
                          
                        </textarea>
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
        <h5 class="modal-title" id="companyModalLabel">CRM Details</h5>
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
      <th scope="col">Email</th>
      <th scope="col">Followup Date</th>
      
    
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
     
      <td><a href="/inventory/crm/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
      <td><a href="/inventory/crm/{{$data->id}}">{{$data->customer}}</a></td>
      <td><a href="/inventory/crm/{{$data->id}}">{{$data->email}}</a></td>
  
    <td><a href="/inventory/crm/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y') }}</a></td>
    
     
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


<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){  
      var i=1;  
       $('#adds').click(function(){  
           i++;  
           $('#dynamic_field1').append('<div class="row" id="dynamic_field'+i+'"><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white  ">Con.Person</span></div><input  class="form-control "  name="contactperson[]" value="" ></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white  ">Email</span></div><input type="email" class="form-control "  name="email[]"  value="{{old('email')}}"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white"> Contact#</span></div><input type="text" class="form-control "  name="contactno[]"  value="{{old('contactno')}}"></div></div></div><div class="col-md-1 "><button type="button" class="btn btn-gradient-danger btn-sm btn_remove" id="'+i+'"><i class="mdi mdi-delete-forever"  ></i></button></div></div>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");
           //alert(button_id);  
           $('#dynamic_field'+button_id+'').remove();  
      });
    });
</script>
@stop