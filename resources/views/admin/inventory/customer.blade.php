@extends('admin/layout')
@section ('content')
@include('admin.newaccount') 
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Customer Details
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
                    <form class="forms-sample" action ="{{('/createcustomer')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row">
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="name" value="{{ old('name') }}" required >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Short Name</span>
                        </div>
                        <input type="text" class="form-control"  name="short_name" value="{{ old('short_name') }}" required>
                        
                      </div>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Acc.</span>
                        </div>
                        <select  class="form-control mySelect2 accname"  name="printname" value="{{ old('account') }}">
                          <option value="" hidden>Account</option>
                        @foreach($allaccounts as $account)
                        <option value="{{$account->id}}" >{{$account->printname}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white ">Phone</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="phone" value="{{ old('phone') }}" >
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Email</span>
                        </div>
                        <input type="email" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="email" value="{{ old('email') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Fax</span>
                        </div>
                        <input type="text" class="form-control"  name="fax" value="{{ old('fax') }}">
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              <!--  -->
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Address</span>
                        </div>
                        
                        <textarea type="text" class="form-control"  name="address" >{{ old('address') }}</textarea>
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked  name="active" value='1'> Active </label>
                            </div>
                          </div>
            <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label required">
                                <input type="checkbox" class="form-check-input" name="approve"   value="1" > Approve </label>
                            </div>
                          </div>
                          <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label required">
                                <input type="checkbox" class="form-check-input" name="specialprice"   value="1" > Special Price </label>
                            </div>
                          </div>
                           </div>
            <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Bus.Type</span>
                        </div>
                        <select  class="form-control mySelect2"  name="businesstype" required >
                          <option value="" hidden>Business Type</option>
                          @foreach($btypes as $btype)
                          <option value="{{$btype->id,old('businesstype') }}">{{$btype->btype}}</option>
                          @endforeach
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Rate Type</span>
                        </div>
                        <select  class="form-control mySelect2"  name="ratetype" value="{{ old('ratetype') }}">
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Credit Limit</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="creditlimit" value="{{ old('creditlimit') }}" >
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Credit Days</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="creditdays" value="{{ old('creditdays') }}" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Tax Applicable</span>
                        </div>
                        <input type="text" class="form-control"  name="taxapplicable" value="{{ old('taxapplicable') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Website</span>
                        </div>
                        <input type="text" class="form-control"  name="website" value="{{ old('website') }}">
                        
                      </div>
                    </div>
                </div>
               </div>
              <div class="row">
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="taxexempted"   value="1" > Tax Exempted </label>
                            </div>
                          </div>
                <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="customerstatus"   value="R" > Regular </label>
                            </div>
                          </div>
                          <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="customerstatus"   value="I" > Inactive </label>
                            </div>
                          </div>
                          <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="customerstatus"   value="P" > Prospective </label>
                            </div>
                          </div>
              </div>
             
              <div class="row" >
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Contact Person</span>
                        </div>
                        <input type="text" class="form-control"  name="contactperson" value="{{ old('contactperson') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Designation</span>
                        </div>
                        <input type="text" class="form-control"  name="designation" value="{{ old('designation') }}">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Phone</span>
                        </div>
                        <input type="text" class="form-control"  name="cpersonphone" value="{{ old('cpersonphone') }}">
                        
                      </div>
                    </div>
                </div>  
              
               </div>
             
                   <div id="dynamic_field1">
                   <div class="row" >
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                        <select  class="form-control text-uppercase"  name="executive[]" id="executive" required="required" >
                           <option value="" hidden>Executive</option>
                          @foreach($exe as $exx)
                          <option value="{{$exx->short_name }}">{{$exx->short_name}}</option>
                          @endforeach
                        </select>
                          
                      </div>
                    </div>
                </div>
          
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
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
        <h5 class="modal-title" id="companyModalLabel">Customer Details</h5>
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
      <th scope="col">Name</th>
      <th scope="col">Short Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
      @foreach($custs as $cut)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/customer-edit/{{$cut->id}}">{{$cut->name}}</a></td>
      <td><a href="/admin/customer-edit/{{$cut->id}}">{{$cut->short_name}}</a></td>
      <td><a href="/admin/customer-edit/{{$cut->id}}">{{$cut->phone}}</a></td>
      <td><a href="/admin/customer-edit/{{$cut->id}}">{{$cut->email}}</a></td>
      
     
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
  
  $(document).ready(function(){  
      var i=1;  
       $('#adds').click(function(){  
           i++;  
           $('#dynamic_field1').append('<div class="row" id="dynamic_field'+i+'"><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white required">Executive</span></div><select  class="form-control text-uppercase"  name="executive[]" id="executive" required="required" > <option value="" hidden>Executive</option>@foreach($exe as $exx)<option value="{{$exx->short_name }}">{{$exx->short_name}}</option>@endforeach</select></div></div></div><div class="col-md-1 "><button type="button" class="btn btn-gradient-danger btn-sm btn_remove" id="'+i+'"><i class="mdi mdi-delete-forever"  ></i></button></div></div>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");
           //alert(button_id);  
           $('#dynamic_field'+button_id+'').remove();  
      });
    });
 
</script>
@stop