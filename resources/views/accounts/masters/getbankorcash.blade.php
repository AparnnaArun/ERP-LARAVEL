@if($pay =='1')
  <div class="col-md-4">
<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Cash</span>
                        </div>
                          <select  class="form-control"  name="bank" value="{{ old('short_name') }}" required >
                          <option value="" hidden>Cash</option>
                          @foreach($account as $cat)
                          <option value="{{$cat->id}}" >{{$cat->printname}}</option>
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
                          <input type="text"  class="form-control"  name="" value="{{ old('short_name') }}" disabled >
                         
                       
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cheque Date</span>
                        </div>
                          <input type="text"  class="form-control "  name="chequedate" disabled >
                         
                       
                      </div>
                    </div>
                  </div>
               
       

                @elseif($pay < 5)


                  <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Bank</span>
                        </div>
                          <select  class="form-control"  name="bank" value="{{ old('short_name') }}" required >
                          <option value="" hidden>Bank</option>
                          @foreach($account as $cat)
                          <option value="{{$cat->id}}" >{{$cat->printname}}</option>
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
                          <input type="text"  class="form-control"  name="chequeno" value="{{ old('short_name') }}" >
                         
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Cheque Date</span>
                        </div>
                          <input type="text"  class="form-control datepickers"  name="chequedate" value="{{ old('chequedate') }}"  >
                         
                       
                      </div>
                    </div>
                  </div>
                
               
                @else
          
           
            @endif

           <script type="text/javascript">
       $(document).ready(function () {
    $(".datepickers").datepicker(
      { dateFormat: 'dd-M-yy',
      changeYear: true,
      yearRange: "-100:+0",
      changeMonth: true}).datepicker("setDate",'now');
    
});
           </script>