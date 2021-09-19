@extends('admin/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </span> Financial Year
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
                     <form class="forms-sample" action ="{{('/createfinyear')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
             <input type="hidden" name="id" value="{{ $fyear->id }}" id="token"/>

                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Starting Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" placeholder="" aria-label="Username" aria-describedby="basic-addon1"  name="start_date" value="{{ $fyear->start_date }}">
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Ending Date</span>
                        </div>
                        <input type="text" class="form-control datepicker" aria-label="" name="end_date" value="{{ old('end_date') }}">
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Fin.Year</span>
                        </div>
                        
                        <input type="text" class="form-control yearpicker" aria-label=""  name="finyear" value="{{ old('finyear') }}">
                        
                      </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
               <div class="col-md-2">
                <label class="form-check-label">Staus</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked name="active" value="yes"> Active </label>
                            </div>
                             </div>
                             <div class="col-md-2">
                              <label class="form-check-label"></label>
                              <div class="form-check form-check-info">
                               
                            </div>
                             </div>
                             
                           </div>
                           <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
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
        <h5 class="modal-title" id="companyModalLabel">Financial Year Details</h5>
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
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th>
      <th scope="col">Finyear</th>
      <th scope="col">Active</th>
      <th scope="col">Default</th>
    </tr>
  </thead>
  <tbody>
    @foreach($years as $year)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/finyear-edit/{{$year->id}}">{{$year->start_date}}</a></td>
      <td><a href="/admin/finyear-edit/{{$year->id}}">{{$year->end_date}}</a></td>
      <td><a href="/admin/finyear-edit/{{$year->id}}">{{$year->finyear}}</a></td>
      <td><a href="/admin/finyear-edit/{{$year->id}}">{{$year->active}}</a></td>
      <td><a href="/admin/finyear-edit/{{$year->id}}">{{$year->defaults}}</a></td>
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