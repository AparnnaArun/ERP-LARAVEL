<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Project Name</span>
                        </div>
                        <input type="text" class="form-control executive" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="projectname" required="" value="{{$pros->project_name  }}" readonly="readonly">
                          
                    
                      </div>
                    </div>
                </div>
<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Customer</span>
                        </div>
                        <input type="hidden" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customerid" required="" value="{{$pros->customer_id  }}">
                        <input type="text" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="customer" required="" value="{{$pros->name  }}" title="{{$pros->name  }}" readonly="readonly">
                        <input type="hidden" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="cus_accnt" required="" value="{{$pros->account  }}" title="{{$pros->account  }}" readonly="readonly">
                         
                      </div>
                    </div>
                </div>
             <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required ">Executive</span>
                        </div>
                        <input type="text" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" required="" value="{{$pros->executive    }}" readonly="readonly" >
                        <input type="hidden" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="commission_percentage" required="" value="{{$pros->commission_percentage    }}" readonly="readonly" >
                        <input type="hidden" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="comm_pay_account" required="" value="{{$pros->comm_pay_account    }}" readonly="readonly" >
                        <input type="hidden" class="form-control projectid" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="exe_com_exp_ac" required="" value="{{$pros->exe_com_exp_ac    }}" readonly="readonly" >
                         
                      </div>
                    </div>
                </div>