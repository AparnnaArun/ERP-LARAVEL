 <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Invoice</span>
                        </div>
                       <select  class="form-control "  name="invoice_no" value="{{ old('short_name') }}" required id="catid">
                          <option value="" hidden>Invoice</option>
                          
                          @foreach($exes as $cat)
                          <option value="{{$cat->invoice_no}}" >{{$cat->invoice_no}}</option>
                          @endforeach
                        </select>
                        
                       
                      </div>
                    </div>