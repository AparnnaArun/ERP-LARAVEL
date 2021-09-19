<div class="row" >
  <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates1" value="{{ \Carbon\Carbon::parse($pi->dates)->format('j -F- Y')  }}" required="required" >
                        
                      </div>
                    </div>
                </div>
	<div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Vendor</span>
                        </div>
                        <input  class="form-control"  name=""  value="{{$pi->vendor}}" readonly>
                          
                      </div>
                    </div>
                </div>

<div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Amt({{$pi->currency}})</span>
                        </div>
                        <input  class="form-control"  name="" value="{{$pi->tamount}}" readonly >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Amt</span>
                        </div>
                        <input  class="form-control"  name="" id="brand" value="{{$pi->totalamount}}" >
                          
                      </div>
                    </div>
                </div>
            </div>
@if(empty($pcharge))
<div id="dynamic_field1">
                   <div class="row" >
            <div class="col-md-3">        
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates[]" value="" required="required" value="">
                        
                      </div>
                    </div>
                  </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cost For</span>
                        </div>
                        <select class="form-control" placeholder="" name="costfor[]" required="" >
                          <option value="" hidden>Cost For</option>
                     
                      <option value="Addcharges" >Additional Charges</option>
                      <option value="Customs" >Customs</option>
                      <option value="Freight" >Freight</option>
                      <option value="Insurance" >Insurance</option>
                      <option value="Transports" >Transports</option>
                      
                        </select>
                          
                      </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vendor</span>
                        </div>
                        <select class="form-control" placeholder="" name="vendor[]" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->account,old('vendor')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Amt</span>
                        </div>
                        <input  class="form-control inputpadd"  name="amount[]" id="brand" required="required" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
              </div>
              </div>
            </div>
            @else
             <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Date</th>
                          <th>Cost For</th>
                          <th>Vendor</th>
                          <th>Amount</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pcharge->purchasecostdetail as $item)
                    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{ \Carbon\Carbon::parse($item->dates)->format('j -F- Y')  }}</td>
      <td>{{$item->costfor}}</td>
        <td>{{$item->vendor}}</td>
        <td>{{$item->amount}}</td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons " disabled><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>
                        @endforeach
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              <div id="dynamic_field1">
                   <div class="row" >
                   <div class="col-md-3">        
            <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Date</span>
                        </div>
                        <input type="text" class="form-control editpicker"  name="dates[]" value="" required="required" value="">
                        
                      </div>
                    </div>
                  </div> 
            
                <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cost For</span>
                        </div>
                        <select class="form-control" placeholder="" name="costfor[]" required="" >
                          <option value="" hidden>Cost For</option>
                     
                      <option value="Addcharges" >Additional Charges</option>
                      <option value="Customs" >Customs</option>
                      <option value="Freight" >Freight</option>
                      <option value="Insurance" >Insurance</option>
                      <option value="Transports" >Transports</option>
                      
                        </select>
                          
                      </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Vendor</span>
                        </div>
                        <select class="form-control" placeholder="" name="vendor[]" required="" >
                          <option value="" hidden>Vendor</option>
                     @foreach($vendor as $cust)
                        <option value="{{$cust->account,old('vendor')}}" >{{$cust->short_name}}</option>
                        @endforeach
                        </select>
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Amt</span>
                        </div>
                        <input  class="form-control inputpadd"  name="amount[]" id="brand" required="required" >
                          
                      </div>
                    </div>
                </div>
                <div class="col-md-1 ">
    
               <button type="button" class="btn btn-gradient-info btn-sm" id="adds"><i class="mdi mdi-comment-plus-outline"></i></button>
              </div>
              </div>
            </div>
            @endif
            <div class="row">
               <div class="col-md-8 col-md-offset-1 mt-2">
                @if( !empty($pcharge->paidstatus) )
                @if($pcharge->paidstatus !='0')
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            @else
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw" disabled title="Edit is enabled if cost not settled ">Save</button>

            @endif
            @else
            <button type="submit"  class="btn btn-gradient-dark btn-rounded btn-fw">Save</button>
            @endif
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Cancel</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw" data-toggle="modal" data-target=".bd-find-modal-lg" disabled>Find</button>
            <button type="button" class="btn btn-gradient-dark btn-rounded btn-fw">Delete</button>
            
          </div>
        </div>



<script type="text/javascript">
	$(document).ready(function(){  
      var i=1;  
       $('#adds').click(function(){  
           i++;  
           $('#dynamic_field1').append('<div class="row" id="dynamic_field'+i+'"><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white ">Date</span></div><input type="text" class="form-control editspicker"  name="dates[]" value="" required="required" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white required">Cost For</span></div><select class="form-control" placeholder="" name="costfor[]" required="" ><option value="" hidden>Cost For</option><option value="Addcharges" >Additional Charges</option><option value="Customs" >Customs</option><option value="Freight" >Freight</option><option value="Insurance" >Insurance</option><option value="Addcharges" >Transports</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white required">Vendor</span></div><select class="form-control" placeholder="" name="vendor[]" required="" ><option value="" hidden>Vendor</option>@foreach($vendor as $cust)<option value="{{$cust->account,old('vendor')}}" >{{$cust->short_name}}</option>@endforeach</select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-gradient-info text-white required">Amt</span></div><input  class="form-control inputpadd"  name="amount[]" id="brand" required="required" ></div></div></div><div class="col-md-1 "><button type="button" class="btn btn-gradient-danger btn-sm btn_remove" id="'+i+'"><i class="mdi mdi-delete-forever"  ></i></button></div></div>').find(".editspicker").datepicker({
    dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');

      });  
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");
           //alert(button_id);  
           $('#dynamic_field'+button_id+'').remove();  
      });

    $(".editpicker").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');

    });

</script>
