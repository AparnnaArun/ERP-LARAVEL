@extends('inventory/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table  menu-icon"></i>
                </span>Project Details
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
                    <form class="forms-sample" action ="{{('/editsprojects')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="{{ $pro->id }}" id=""/>
                   <div class="row">
                   	<div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pro#</span>
                        </div>
                       <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="project_code" id="code" value="{{ $pro->project_code }}"  readonly >
                      
                      </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Name</span>
                        </div>
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="project_name" value="{{ $pro->project_name }}" required="required" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Short Name</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="short_name" value="{{ $pro->short_name }}">
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           <div class="row">
            <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Start Date</span>
                        </div>
                       <input  class="form-control editpicker " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="exp_startingdate" value="{{ \Carbon\Carbon::parse($pro->exp_startingdate)->format('j -F- Y')  }}" >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">End Date</span>
                        </div>
                       <input  class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="exp_endingdate" value="{{ \Carbon\Carbon::parse($pro->exp_endingdate)->format('j -F- Y')  }}" >
                        
                      </div>
                    </div>
                </div>
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <select class="form-control customer" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer_id" required="" >
                          <option value="" hidden>Customer</option>
                     @foreach($customer as $cust)
                        <option value="{{$cust->id}}" {{($pro->customer_id == $cust->id ? ' selected' : 'disabled') }} >{{$cust->short_name}}</option>
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
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white  ">Customer PO</span>
                        </div>
                       <input  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer_po" value="{{$pro->customer_po}}" >
                        
                      </div>
                    </div>
                </div>
              <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                         <select class="form-control result" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" id="item" >
                          <option value="{{$pro->executive}}" hidden>{{$pro->executive}}</option>
                        
                    
                        </select>
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                   
               
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" {{($pro->active == '1' ? ' checked' : '') }}  name="active" value='1' > Active </label>
                            </div>
            
           
           
           
                             
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white  ">Remarks</span>
                        </div>
                       <textarea  class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" value="" >
                    {{$pro->remarks}}
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
        <h5 class="modal-title" id="companyModalLabel">Project Details</h5>
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
      <th scope="col">Pro#</th>
      <th scope="col">Project Name</th>
      <th scope="col">Customer</th>
      <th scope="col">Executive</th>
      <th scope="col">Status</th>
      <th scope="col">Completed</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/inventory/project-edit/{{$data->id}}">{{$data->project_code}}</a></td>
      <td><a href="/inventory/project-edit/{{$data->id}}">{{ $data->project_name }}</a></td>
      <td><a href="/inventory/project-edit/{{$data->id}}">{{$data->name}}</a></td>
      <td><a href="/inventory/project-edit/{{$data->id}}">{{$data->executive}}</a></td>
      <td><a href="/inventory/project-edit/{{$data->id}}">@if($data->is_deleted==1) Deleted @elseif($data->is_completed==1) Completed @else On Going @endif</a></td>
        <td>@if($data->is_deleted==1 || $data->is_completed==1)<a href="#"><i class="mdi mdi-wrap"></i></a>@else <a href="/inventory/project-complete/{{$data->id}}"><i class="mdi mdi-wrap"></i></a>@endif</td>
    <td>@if($data->is_deleted==1 || $data->is_completed==1)<a href="#"><i class="mdi mdi-delete-forever"></i></a>@else<a href="/inventory/project-delete/{{$data->id}}"><i class="mdi mdi-delete-forever"></i></a>@endif</td>
     
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
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">
$(".customer").change(function(){
               id = $(this).val();
               token = $("#token").val();
                 //alert(id);
              $.ajax({
         type: "POST",
         url: "{{url('getexecutives')}}", 
         data: {_token: token,id:id},
         dataType: "html",  
         success: 
              function(result){
              //alert(result);
                $(".result").html(result);

              }
          });

                })

              </script>
@stop