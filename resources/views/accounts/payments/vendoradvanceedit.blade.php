@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-table menu-icon"></i>
                </span>Vendor Advance
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
                    <form class="forms-sample" action ="{{('/createvadvance')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="{{$vadv->id}}" id="id"/>
                   <div class="row">
                    <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pay#</span>
                        </div>
                        <input type="text" class="form-control "  name="advanceno" value="{{ $vadv->advanceno  }}" required >
                        <input type="hidden" class="form-control "  name="slno" value="{{ $vadv->slno  }}" required >
                        
                      </div>
                    </div>
                </div>
                    
                    <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control "  name="dates" value="{{ \Carbon\Carbon::parse($vadv->dates)->format('j -F- Y')  }}" required >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vendor</span>
                        </div>
                        
                        <select class="form-control customer "  name="vendor" id="" required >
                          <option value="" hidden>Vendor</option>
                          @foreach($vend as $row)
                        <option value="{{$row->id}}" {{($vadv->vendor == $row->id ? 'selected' : '') }}>{{$row->short_name}}</option>
                        @endforeach
                    
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Pay.Mode</span>
                        </div>
                        
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required >
                          <option value="" hidden>Payment Mode</option>
                         
  <option value="1" {{($vadv->paymentmode == '1'? 'selected' : '') }}>Cash</option>
 <option value="2" {{($vadv->paymentmode == '2'? 'selected' : '') }}>Bank</option>
  
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
              </div>
              <div class="row results">
                <div class="col-md-4">
<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cash/Bank</span>
                        </div>
                          <select  class="form-control"  name="bank" value="{{ old('short_name') }}" required >
                          <option value="" hidden>Cash</option>
                          @foreach($account as $cat)
                          <option value="{{$cat->id}}" {{($vadv->bankcash == $cat->id ? ' selected' : '') }}>{{$cat->printname}}</option>
                          @endforeach
                        </select>
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cheque No</span>
                        </div>
                          <input type="text"  class="form-control"  name="chequeno" value="{{ $vadv->chequeno }}"  >
                         
                       
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cheque Date</span>
                        </div>
                          <input type="text"  class="form-control "  name="chequedate" value="{{ \Carbon\Carbon::parse($vadv->chequedate)->format('j -F- Y')  }}" >
                         
                       
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                 <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Currency</span>
                        </div>
                        
                       <select class="form-control "  name="currency" id="" required >
                         
                          @foreach($curr as $rows)
                        <option value="{{$rows->shortname}}" {{($vadv->currency == $rows->shortname ? 'selected' : '') }}>{{$rows->shortname}}</option>
                        @endforeach
                    
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                 <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Exchange Rate</span>
                        </div>
                        
                        <input type="text" class="form-control"  name="erate" value="{{$vadv->erate}}" required >
                          
                     
                      </div>
                    </div>
                </div>
                 
                <div class="col-md-4 advnce">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Advance Amount</span>
                        </div>
                        
                        <input type="text" class="form-control"  name="advance" value="{{$vadv->advance}}" required >
                          
                     
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Remarks</span>
                        </div>
                        <textarea class="form-control "  name="remarks" >
                  {{$vadv->remarks}}
                        </textarea>
                         
                           </div>
                        </div>
                      </div>
            </div>
           
            
          
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" >Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Cancel</button>
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
        <h5 class="modal-title" id="companyModalLabel">Vendor Advance Details</h5>
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
      <th scope="col">Payment Mode</th>
      <th scope="col">Advance</th>
     <th scope="col">Advance Date</th>
    </tr>
  </thead>
  <tbody>
 @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/vendor-advance/{{$data->id}}">{{$data->short_name}}</a></td>
      <td><a href="/accounts/vendor-advance/{{$data->id}}">  @if($data->paymentmode==1) Cash @else Bank @endif</a></td>
      <td><a href="/accounts/vendor-advance/{{$data->id}}">{{$data->advance}}</a></td>
    <td><a href="/accounts/vendor-advance/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}
</a></td>
      
     </a></td>
     
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

 ///////////////////// Load Payment Mode/////////
   $('.paymentMode').change(function(){
  pay = $('.paymentMode').val();
   csrf=$("#token").val();
   //alert(pay);
  $.ajax({ 
         type: "POST",
         url: "{{url('getbankorcash')}}", 
         data: {pay: pay,_token:csrf},
         dataType: "html",  
         success: 
              function(data){
                //alert(data);
                $('.results').html(data);
                  }
          });

  });

</script>
@stop