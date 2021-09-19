@extends('admin/layout')
@section ('content')
@include('admin.newaccount') 
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Vendor Details
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
                    <form class="forms-sample" action ="{{('/editsvendors')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="{{ $vend->id }}" id="id"/>
                   <div class="row">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Vendor</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="vendor" id="code" value="{{ $vend->vendor }}"   >

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Short Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="" value="{{ $vend->short_name }}" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Acc.</span>
                        </div>
                        
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="" value="{{ $vend->printname }}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
            </div>
             <div class="row">
              
                <div class="col-md-2">
                  
              <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input"   name="active" value='1' {{($vend->active == '1' ? ' checked' : '') }}> Active </label>
                            </div>
                          </div>
                          <div class="col-md-2">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="approve"   value="1" {{($vend->approve == '1' ? ' checked' : '') }} > Approve </label>
                            </div>
                          </div>
                          </div>
            <div class="row mt-2">
             <div class="template-demo">
                      <a href="#popup"  class="btn btn-dark btn-sm btn-fw gbutton">General Details </a>
                     <!--  <a href="#popup"  class="btn btn-dark btn-sm btn-fw  vbutton"> </a> -->
                      <a href="#popup" class="btn btn-dark btn-sm btn-fw  cbutton">Contract Details </a>
                       
                      
                    </div>
            </div>
            <div class="general" >
            <div class="row mt-3">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white required ">Address</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="address" >
                      {{ $vend->address }}
                        </textarea>
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">Business Type</span>
                        </div>
                       <select class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="business_type" required="">
                        <option value="" hidden>Business Type</option>
                          @foreach($btypes as $btype)
                          <option value="{{$btype->btype,old('businesstype') }}" {{($vend->business_type == $btype->btype ? ' selected' : '') }}>{{$btype->btype}}</option>
                          @endforeach
                       
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Contact Person</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="contact_person" value="{{$vend->contact_person}}" >
                           
                        
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Designation</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="designation"  value="{{$vend->designation}}">
                           
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Lead time</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="lead_time" value="{{$vend->lead_time}}" >
                           
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Email</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="email" value="{{$vend->email}}" >
                           
                      </div>
                    </div>
                </div>
                 </div>
                  <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Tax Applicable</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="tax_applicable" value="{{$vend->tax_applicable}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Credit Limit </span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="credit_limit" value="{{$vend->credit_limit}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Credit days</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="credit_days" value="{{$vend->credit_days}}">
                      
                      </div>
                    </div>
                </div>
               
                
              </div>
              <div class="row">
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Phone </span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="phone" value="{{$vend->phone}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Fax</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="fax" value="{{$vend->fax}}" >
                      
                      </div>
                    </div>
                </div>
             
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Website</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="website" value="{{$vend->website}}" >
                      
                      </div>
                    </div>
                </div>
                
                 </div>
              <div class="row">
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Rating </span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="rating" value="{{$vend->rating}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="tax_exempted"   value="1" {{($vend->tax_exempted == '1' ? ' checked' : '') }}> Tax Exempted </label>
                            </div>
                          </div>
             
                <div class="col-md-3">
            <div class="form-check form-check-info">
                              <label class="form-check-label ">
                                <input type="checkbox" class="form-check-input" name="exciseduty_applicable"   value="1" {{($vend->exciseduty_applicable == '1' ? ' checked' : '') }} > Excise Duty Applicable </label>
                            </div>
                            
                          
                        </div>
                        </div>
                        
                         </div>
                       <div class="contract" style="display: none;">
                           <div class="row mt-3">
               <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Contract Date</span>
                        </div>
                        
                        <input type="text" class="form-control editpicker " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="contract_date"  value="{{$vend->contract_date}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Security Deposit</span>
                        </div>
                        
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="security_deposit" value="{{$vend->security_deposit}}" >
                      
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Terms & Cond</span>
                        </div>
                        
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="termsand_conditions" >
                          {{$vend->termsand_conditions}}
                        </textarea>
                      
                      </div>
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
        <h5 class="modal-title" id="companyModalLabel">Vendor Details</h5>
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
      <th scope="col">Vendor</th>
      <th scope="col">Short Name</th>
      <th scope="col">Account</th>
     
    </tr>
  </thead>
  <tbody>
    @foreach($vendors as $vendor)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/admin/vendor-edit/{{$vendor->id}}">{{$vendor->vendor}}</a></td>
      <td><a href="/admin/vendor-edit/{{$vendor->id}}">{{$vendor->short_name}}</a></td>
      <td><a href="/admin/vendor-edit/{{$vendor->id}}">{{$vendor->account}}</a></td>
     
     
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

 //////////////////////// details tabs show/hide////////////////////////////
  $('.gbutton').addClass('actives');  
  $(".cbutton").click(function(){
  $(".contract").show(); 
  $(".general").hide();
 $('.cbutton').addClass('actives');   
$('.gbutton').removeClass('actives');

  })
  $(".gbutton").click(function(){
  $(".general").show(); 
  $(".contract").hide();
 $('.gbutton').addClass('actives');   
$('.cbutton').removeClass('actives');
  
  })
  
      ////////////////////////// 


</script>
@stop