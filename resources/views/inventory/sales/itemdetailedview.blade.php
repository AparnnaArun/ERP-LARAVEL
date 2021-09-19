<div class="form-group">
                      <div class="input-group">
                        
           <button type="button" class="btn btn-gradient-info btn-xs" data-toggle="modal" data-target=".itempopups"> <span class="mdi mdi-eye "></span></button>
                           
                      </div>
                    </div>
                  <!--   //////////// ITEM POPUP////////////// -->


                   <div class="modal fade itempopups" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>

      <div class="modal-body">
      <div class="form-group">
                        <label for="exampleInputUsername1" class="">Current Stock</label>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="name" value="{{$curitem}}" id="name"  placeholder="Current Stock">
                        
                       
                       
                    
                     </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="">Minimum Stock</label>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="shortname" value="{{$item->minimum_stock}}" id="shortname"  placeholder="Minimum Stock">
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="">Maximum Stock</label>
                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="shortname" value="{{$item->maximum_stock}}" id="shortname"  placeholder="Maximum Stock">
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1" class="">ROL</label>
                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="shortname" value="{{$item->reorder_level}}" id="shortname"  placeholder="ROL">
                        
                      </div>
               
      </div>
      <div class="form-group">
            <div class="col-sm-12">
             <span id="f_mssg"></span>
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
</form>
    </div>
  </div>
</div>