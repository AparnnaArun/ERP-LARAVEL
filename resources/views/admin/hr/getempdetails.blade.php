<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="empname" value="{{ $emp->name}}" readonly >
                        
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Position</span>
                        </div>
                        
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="position" value="{{ $emp->joiningposition }}" readonly>
                      
                      </div>
                    </div>
                </div>