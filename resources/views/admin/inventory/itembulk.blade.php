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
                </span> Item Bulk Upload</h3>
              
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
                    <p class="card-title">If you want to know the format of bulk upload <a href="/assets/images/bulk.xlsx" download target="_blank">click here</a></p>
                     <form class="forms-sample" action ="{{('/createitembulk')}}" method = "post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                  <input type="hidden" name="id" value="" />
                  <div id="dynamic_field1">
                   <div class="row" >
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Bulk Upload</span>
                        </div>
                        <input type="file"  class="form-control"  name="file" id="file" required="required" >
                          
                      </div>
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

 
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
 <script type="text/javascript">

       </script>             
@stop