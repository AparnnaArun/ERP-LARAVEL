 <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Executive</span>
                        </div>
                         <select class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="executive" id="" >
                          <option value="" hidden>Executive</option>
                       
                     @foreach($cuss as $cust)
                        <option value="{{$cust->executive}}" >{{$cust->executive}}</option>
                        @endforeach
                    
                        </select>
                           
                        
                      </div>
                    </div>