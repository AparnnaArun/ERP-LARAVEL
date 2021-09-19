<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive"  value="{{$inv1->executive}}" readonly>
                        <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="percent"  value="{{$percent->commission_percentage}}" readonly>
                        <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="comm_pay_account"  value="{{$percent->comm_pay_account}}" readonly>
                        <input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="exe_com_exp_ac"  value="{{$percent->exe_com_exp_ac}}" readonly>

                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white"> Sales Date</span>
                        </div>
                         <input type="text" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="salesdate"  value="{{ \Carbon\Carbon::parse($inv->dates)->format('j -F- Y')  }}" readonly>
                           
                        
                      </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                   
                <label class="form-check-label">Payment Mode</label>
              <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input"   name="payment_mode" value='cash' style="opacity: 1;"> Cash </label>
                            </div>
            
            <div class="form-check form-check-info">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input " name="payment_mode" checked   value="credit" style="opacity: 1;" > Credit </label>
                            </div>
           
           
                             
                </div>