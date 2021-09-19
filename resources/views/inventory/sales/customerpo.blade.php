<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Customer PO</span>
                        </div>
                        
                        <input type="text"  class="form-control accname" aria-label="Amount (to the nearest dollar)" name="po_number" value="@foreach($eenqs as $eenq)
                             {{$eenq->customer_po}},
                             @endforeach">
                          
                     
                      </div>
                    </div>