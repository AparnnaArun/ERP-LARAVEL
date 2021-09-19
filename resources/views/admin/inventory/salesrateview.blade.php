<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Sales Rate</h4>
                    <p class="card-description"> 
                    </p>
                    <div class="table table-responsive">
                    <table class="table table-striped findtable" id="findtable">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Item</th>
                          <th>Cost Details</th>
                          <th>Dealer Price</th>
                           <th>Whole. Price</th>
                          <th>Retail Price</th>
                         
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($items as $item)
                        <tr>
                          <td>{{$item->code}}</td>
                          <td style="overflow: hidden;">{{$item->item}}<input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="items[]" value="{{$item->item}}"  ><input type="hidden" class="form-control " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="itemid[]" value="{{$item->itemid}}"  ></td>
                          <td><input type="text" class="form-control tbinput" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="cost[]" value="{{$item->cost}}"  ></td>
                           <td><input type="text" class="form-control tbinput" placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="dsrate[]" value="{{$item->dsrate}}"  ></td>
                           <td><input type="text" class="form-control tbinput " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="wsrate[]" value="{{$item->wsrate}}"  ></td>
                          <td><input type="text" class="form-control tbinput " placeholder="" aria-label="Username" aria-describedby="basic-addon1" name="rsrate[]" value="{{$item->rsrate}}"   ></td>
                          
                         
                          
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
             
                <script src="../../assets/js/find.js" ></script>