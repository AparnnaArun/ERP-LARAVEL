@extends('accounts/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-history menu-icon"></i>
                </span>Customer Receipt
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
                    <form class="forms-sample" action ="{{('/createreceipt')}}" method = "post" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
                        <input type="hidden" name="id" value="" id="id"/>
                   <div class="row">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Receipt#</span>
                        </div>
                        <input type="text" class="form-control"  name="rept_no" id="code" value="{{$rec->rept_no}}"   >
                       
                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        <input type="text" class="form-control "  name="dates" value="{{ \Carbon\Carbon::parse($rec->dates)->format('j -F- Y')  }}" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Customer</span>
                        </div>
                        
                        <select class="form-control customer "  name="customer" required >
                          <option value="" hidden>Customer</option>
                          @foreach($cust as $row)
                        <option value="{{$row->id}}" {{($rec->customer == $row->id ? 'selected' : '') }} >{{$row->name}}</option>
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
                          <span class="input-group-text bg-gradient-info text-white required">Payment Mode</span>
                        </div>
                        
                        <select  class="form-control paymentMode"  name="paymentmode" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Payment Mode</option>
                         
  <option value="1" {{($rec->paymentmode == '1' ? 'selected' : '') }}>Cash</option>
 <option value="2" {{($rec->paymentmode == '2' ? 'selected' : '') }} >Cheque</option>
  <option value="3" {{($rec->paymentmode == '3' ? 'selected' : '') }}>DD</option>
   <option value="4" {{($rec->paymentmode == '4' ? 'selected' : '') }}>Online Transfer</option>
   <option value="5" {{($rec->paymentmode == '5' ? 'selected' : '') }}>Adv Settlement</option>
                        </select>
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4 advnce">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Advance</span>
                        </div>
                        

                        <input type="text" class="form-control advances"  name="" value="{{$rec->advance}}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Amount</span>
                        </div>
                        
                        <input type="text" class="form-control auto-calc totalamount"  name="totalamount" value="{{$rec->totalamount}}"  >
                          
                     
                      </div>
                    </div>
                </div>
            </div>
           
             <div class="row results">
                    <div class="col-md-4">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Bank/Cash</span>
                        </div>
                        <input type="text" class="form-control"  name="vendor" id="code" 
                        value="{{$rec->printname}}"   >

                         
                           </div>
                        </div>
                      </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque No</span>
                        </div>
                        <input type="text" class="form-control"  name="" value="{{$rec->cheque_no}}" readonly >
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cheque Date</span>
                        </div>
                        <input type="text" class="form-control "  name="" value="{{ \Carbon\Carbon::parse($rec->bank_date )->format('j -F- Y')  }}" readonly >
                        
                      </div>
                    </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-md-3">
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          @if($rec->is_deleted==1)
                          <span class="input-group-text bg-gradient-dark text-white ">Deleted</span>
                          @endif
                        </div>
                        
                        
                      </div>
                    </div>
                </div>
              </div>
               <div class="row loadrece">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                        
                          <th>Date</th>
                            <th>Invoice No</th>
                           <th>Net Amount</th>
                           <th>Collected Amount</th>
                            <th>Credit Note Amount</th>
                          
                            <th>Balance</th>
                             <th>Amount</th>
                            <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($rec->receiptdetail as $pnv)
                              <tr>
<td>{{ $loop->iteration }}</td>
      
      <td>{{ \Carbon\Carbon::parse($pnv->dates)->format('j -F- Y')  }}</td>
      <td>{{ $pnv->invoiceno }}</td>
      <td>{{ $pnv->grandtotal  }}</td>
      
     <td>{{ $pnv->collected }}</td>
     
     <td> {{ $pnv->creditnote}} </td>
     <td> {{ $pnv->balance}} </td>
     <td> {{ $pnv->amount}}</td>
    </tr>
@endforeach
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
       
           <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Roundoff</span>
                        </div>
                        <input type="text" class="form-control auto-calc roundoff"  name="roundoff" value="{{$rec->roundoff}}"  >
                        <div class="rnddiv" style="color:red;display:none;">Prefix mathematical sign ±</div>
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                                            <span class="input-group-text bg-gradient-danger text-white spanshow " style="display: none;">Unmatched Amount</span>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Unsettled </span>
                        </div>
                        

                        <input type="text" class="form-control totaladvance"  name="totaladvace" value="{{$rec->totaladvace}}" readonly >
                        <input type="hidden"  name="" class="advacetest form-control form-control-xs" id="advacetest" readonly value="0.000" >
                          
                     
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total</span>
                        </div>
                        
                        <input type="text" class="form-control gridtotal"  name="total" value="{{$rec->total}}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
              </div>
           <div class="row">
                    <div class="col-md-8">
                       <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend address">
                          <span class="input-group-text bg-gradient-info text-white">Remarks</span>
                        </div>
                        <textarea class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="remarks" >
                  {{$rec->remarks}}
                        </textarea>
                         
                           </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Net Total</span>
                        </div>
                        
                        <input type="text" class="form-control nettotal"  name="nettotal" value="{{$rec->nettotal}}" readonly >
                          
                     
                      </div>
                    </div>
                </div>
                    </div>
            
                      
        <div class="row mt-1">
               <div class="col-md-8 col-md-offset-1 ">
            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-fw" disabled>Save</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" >Find</button>
            @if($rec->is_deleted!=1)
           <a href="{{url('deletereceipt')}}/{{$rec->id}}" type="button" class="btn btn-gradient-dark btn-rounded btn-fw" >Delete</a>
           @endif
            
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
        <h5 class="modal-title" id="companyModalLabel">Customer Receipt Details</h5>
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
      <th scope="col">Receipt#</th>
      <th scope="col">Date</th>
      <th scope="col">Customer</th>
      <th scope="col">Mode</th>
     <th scope="col">Amount</th>
     <th scope="col">Invoices</th>
    </tr>
  </thead>
  <tbody>
    @foreach($datas as $data)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td><a href="/accounts/receipt/{{$data->id}}">{{$data->rept_no}}</a></td>
      <td><a href="/accounts/receipt/{{$data->id}}">{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</a></td>
      <td><a href="/accounts/receipt/{{$data->id}}">{{$data->short_name}}</a></td>
    <td><a href="/accounts/receipt/{{$data->id}}">@if($data->paymentmode =='1') Cash @elseif($data->paymentmode =='2') Cheque @elseif($data->paymentmode =='3') DD @elseif($data->paymentmode =='4') Online Transfer @elseif($data->paymentmode =='5') Adv Settlement @endif</a></td>
    <td><a href="/accounts/receipt/{{$data->id}}">{{$data->nettotal}}</a></td>
    <td><a href="/accounts/receipt/{{$data->id}}">@foreach($data->receiptdetail as $item){{$item->invoiceno}},@endforeach</a></td>  
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


@stop