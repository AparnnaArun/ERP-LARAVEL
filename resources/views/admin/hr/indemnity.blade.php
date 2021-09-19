@extends('admin/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span> Indemnity Details
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
                     <form class="forms-sample" action ="{{('/updateindemnity')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Indemnity</h4>
                    <p class="card-description"> 
                    </p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Case</th>
                          <th>Status</th>
                          <th>Rate Details</th>
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($inds as $ind)
                        <tr>
                          <td>{{$ind->cases}}</td>
                          <td >{{$ind->status}}<input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="id[]" value="{{$ind->id}}"  ></td>
                          <td><input type="text" class="form-control tbinput" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="rate[]" value="{{$ind->rate}}"  ></td>
                          
                          
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
            
                           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled="">Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
        </div>
                </form>    
                  </div>
                </div>
              </div>


@stop