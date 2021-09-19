@extends('admin/layout')
@section ('content')
<style type="text/css">
  .form-check .form-check-label input{
    opacity: 1;
    z-index: 0;
  }
</style>
<div class="page-header">
<h3 class="page-title">
<span class="page-title-icon bg-gradient-info text-white mr-2">
<i class="mdi mdi-chart-bar  menu-icon"></i>
                </span> Unit Details</h3>
              
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
                     <form class="forms-sample" action ="{{('/createunit')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                  <div id="dynamic_field1">
                   <div class="row" >
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Unit</span>
                        </div>
                        <input  class="form-control"  name="unit[]" id="unit" required="required" >
                          
                      </div>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Short Name</span>
                        </div>
                        <input type="text"  class="form-control"  name="shortname[]" id="shortname" required="required" >
                          
                        
                      </div>
                    </div>
                </div>
                 <div class="col-md-2 ">
                <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="active[]" value="1" checked>Active</label>
                            </div>
                          </div>
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
              </div>
              </div>
            </div>
           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg">Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
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
        <h5 class="modal-title" id="companyModalLabel">Unit Details</h5>
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
      <th scope="col">unit</th>
      <th scope="col">Shortname</th>
     <th scope="col">Status</th>
   </tr>
  </thead>
 <tbody>
    @foreach($unit as $un)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/unit-edit/{{$un->id}}">{{$un->unit}}</a></td>
      <td><a href="/admin/unit-edit/{{$un->id}}">{{$un->shortname}}</a></td>
      <td><a href="/admin/unit-edit/{{$un->id}}">@if($un->active==1) Active @else Inactive @endif</a></td>
     
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
           $('#dynamic_field1').append('<div class="row" id="dynamic_field'+i+'"><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white required">Unit</span></div><input  class="form-control"  name="unit[]" id="unit" required="required" ></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white">Shortname</span></div><input type="text"  class="form-control"  name="shortname[]" id="shortname" required="required" ></div></div></div><div class="col-md-2 "><div class="form-check form-check-info"><label class="form-check-label"><input type="checkbox" class="form-check-input" name="active[]" value="1" checked>Active</label></div></div><div class="col-md-1 "><button type="button" class="btn btn-gradient-danger btn-sm btn_remove" id="'+i+'"><i class="mdi mdi-delete-forever"  ></i></button></div></div>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");
           //alert(button_id);  
           $('#dynamic_field'+button_id+'').remove();  
      });
    });
       </script>             
@stop