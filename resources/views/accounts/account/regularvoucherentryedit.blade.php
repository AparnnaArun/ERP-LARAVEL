@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-chart-bar  menu-icon"></i>
                </span>Regular Voucher Entry
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
                    <form class="forms-sample" action ="{{('/createvoucherentry')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                   <div class="row ">
                    <div class="col-md-3 number">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Voucher#</span>
                        </div>
                      <input type="text" class="form-control"  name="voucher_no"  value="{{$ent->voucher_no}}"  readonly >
                       
                     
                       
                      </div>
                    </div>
                </div>
                   	<div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"   name="dates" value="{{ \Carbon\Carbon::parse($ent->dates)->format('j -F- Y')  }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vouch.Type </span>
                        </div>
                        <select  class="form-control voucher"  name="" value="{{ old('short_name') }}" required id="voucher">
                           <option value="" hidden>Voucher Type </option>
                         <option value="P" {{($ent->voucher == '1' ? 'selected' : 'disabled') }}>Payment</option>
                         <option value="R" {{($ent->voucher == '2' ? 'selected' : 'disabled') }} >Receipt</option>
                         <option value="Con" {{($ent->voucher == '3' ? 'selected' : 'disabled') }}>Contra</option>
                         <option value="Jr" {{($ent->voucher == '4' ? 'selected' : 'disabled') }}>Journal</option>
                         <option value="Pv" {{($ent->voucher == '5' ? 'selected' : 'disabled') }}>Purchase</option>
                          <option value="Sv" {{($ent->voucher == '6' ? 'selected' : 'disabled') }}>Sales</option>
                          <option value="DN" {{($ent->voucher == '7' ? 'selected' : 'disabled') }}>Debit Note</option>
                        <option value="CN" {{($ent->voucher == '8' ? 'selected' : 'disabled') }}>Credit Note</option>
                        </select>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"id="bankcash">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">From</span>
                        </div>
                        <select  class="form-control borc"  name="froms" value="{{ old('froms') }}" required >
                         
                         <option value="B" {{($ent->froms == 'B' ? 'selected' : 'disabled') }} >Bank</option>
                         <option value="C" {{($ent->froms == 'C' ? 'selected' : 'disabled') }}>Cash</option>
                        
                        
                        </select>
                        
                      </div>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body ">
                   
                   <table class="table table-bordered ItemGrid" id="ItemGrid">
                     <thead>
  <tr>
    <th rowspan="2">#</th>
    <th rowspan="2">DR/CR</th>
    <th rowspan="2">Account</th>
<th rowspan="2">Narration</th>
<th colspan="4">Cheque Details</th>
<th rowspan="2">Debit</th>
 <th rowspan="2">Credit</th>
  </tr>
  <tr>
  <th>Cheq.No</th>
<th>Cheque Date</th>
<th>Cheque Bank</th>
<th>Clearance Date</th>
  </tr>
  </thead>
  <tbody>
   <tr>
    @foreach($eent as $item)
      <th scope="row">{{$loop->iteration}}</th>
      <td>@if($item->debitcredit =='debt')<button type="button" class="btn btn-gradient-info btn-xs btn-fw dr">DR</button>@else<button type="button" class="btn btn-gradient-info btn-xs btn-fw cr">CR</button>@endif</td>
      <td class="results">{{ $item->printname }}
                       </td>
     <td>{{ $item->narration }}</td>
     <td>{{ $item->cheque_no }}</td>
     <td>{{ \Carbon\Carbon::parse($item->cheque_date)->format('j -F- Y')  }}</td>
     <td>{{ $item->cheque_bank }}</td>
     <td>{{ $item->cheque_clearance }}</td>
     <td>@if($item->debitcredit =='debt'){{ $item->amount }}@else 0.000 @endif
                       </td>
     <td>@if($item->debitcredit =='cred'){{ $item->amount }}@else 0.000 @endif
                       </td>
          
     
    </tr> 
    @endforeach
  </tbody>
                   </table>
                   </div>
                   </div>
                   </div>

             </div>
                  <div class="row ">
                    
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Approved By</span>
                        </div>
                        <input type="text" class="form-control "   name="approved_by" value="{{ $ent->approved_by }}" required >
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Debit </span>
                        </div>
                        <input type="text" class="form-control totdebit"   name="totdebit" value="{{$ent->totdebit}}" required >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"id="">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Credit</span>
                        </div>
                        <input type="text" class="form-control totcredit"   name="totcredit" value="{{$ent->totcredit}}" required >
                        
                      </div>
                    </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-md-12 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white ">Remarks</span>
                        </div>
                        

                        <textarea  class="form-control"  name="remarks"   >
                          {{$ent->remarks}}
                        </textarea>
                     
                       
                      </div>
                    </div>
                </div>
                </div>
              <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
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
        <h5 class="modal-title" id="companyModalLabel">Regular Voucher Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body ">
                   
                   <table class="table table-bordered findtable" id="findtable">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Voucher#</th>
      <th scope="col">Date</th>
      <th scope="col">Description</th>
      <th scope="col">Amount</th>
      
    </tr>
  </thead>
  <tbody>
     @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/regular-entry/{{$data->id}}">{{$data->voucher_no}}</a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">
        {{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">@if(!empty($data->remarks)){{$data->remarks}}@else {{$data->from_where}} @endif </a></td>
      <td><a href="/accounts/regular-entry/{{$data->id}}">{{$data->totcredit}}</a></td>
      
    
    
  
     
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

@stop