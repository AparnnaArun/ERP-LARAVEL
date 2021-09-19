
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Short Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="short_name" value="{{ old('short_name') }}" required>
                        
                      </div>
                    </div>
                </div>
                
                 <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">Account</span>
                        </div>
                        
                        <input type="text" class="form-control " aria-label="Amount (to the nearest dollar)" name="" value="{{ $emp->printname }}" >
                       <input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="account" value="{{ $emp->accname }}" >
                      </div>
                    </div>
                </div>
           