<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Advance</span>
                        </div>
                        
                        <input type="text" class="form-control advances"  name="advance" value="@if(!empty($result->sum_adv)){{$result->sum_adv}} @else {{0.000}} @endif" readonly >
                         <input type="hidden" class="form-control"  name="vendname" value="{{$vend->short_name}}" readonly >
                         <input type="hidden" class="form-control"  name="vendaccount" value="{{$vend->account}}" readonly > 
                     
                      </div>
                    </div>