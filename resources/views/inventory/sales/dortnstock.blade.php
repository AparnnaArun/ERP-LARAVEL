<div class="modal fade currenytstock" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Current Stock Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token1"/>
      <input type="hidden" name="" value="{{ $doqnty }}" id="doqnty"/>
      <input type="hidden" name="" value="{{ $item }}" id="itetee"/>
     <div class="modal-body">
     <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  
                <div class="table table-responsive">
                    <table class="table table-striped viewtable " id="">
                      <thead>
                  
                          <th>Location</th>
                          <th>Batch</th>
                         <th>Cur.Stock</th>
                         <th>Return</th>
                        
                      </thead>
                      <tbody>
                        @foreach($curitem as $cur)
<tr>
    <td hidden>{{$item}}</td>
  <td><input type="hidden" class="form-control   inputpadd idid"  name="itemid[]"  id="itemid"  placeholder="" required="required" value="{{$item}}">
    <input type="hidden" class="form-control   inputpadd "  name="stckid[]"  id="itemid"  placeholder="" required="required" value="{{$cur->id}}">
<input type="hidden" class="form-control calculate itemmcost   inputpadd"  name="cost[]"  id="cost"  placeholder="" required="required" value="{{$itemm->cost}}">
    <input type="hidden" class="form-control calculate locid   inputpadd"  name="locid[]"  id="locid"  placeholder="" required="required" value="{{$cur->location_id}}">{{$cur->locationname}}</td>
      <td><input type="hidden" class="form-control calculate batch inputpadd"  name="batches[]" value="{{$cur->batch}}" id=""  placeholder="Rates" required="required">{{$cur->batch}}</td>
      <td><input type="hidden" class="form-control calculate bqnty inputpadd"  name="cqnty[]" value="{{$cur->bal_qnty}}" id="balqnty"   >
        <input type="hidden" class="form-control calculate  inputpadd"  name="qntyin[]" value="{{$cur->qnty_in}}" id=""   ><input type="hidden" class="form-control calculate  inputpadd"  name="qntyout[]" value="{{$cur->qnty_out}}"    >{{$cur->bal_qnty}}</td>
        
      <td><input type="text" class="form-control calculate reqqnty inputpadd"  name="reqqnty[]" value="0" id="reqqnty"  placeholder="Quantity" >
        <div class="calculate alertss" style="display: none;color:red;">Check the qnty</div></td>
         </tr>
                         @endforeach
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
               
      </div>
       <div class="form-group">
                        <label for="exampleInputUsername1" class="required">Total Quantity</label>
                        <input type="text" class="form-control calculate"  name="totqnty" value="" id="totqnty"  placeholder="Total Quantity" readonly="">
                        <div class=" alertss1" style="display: none;color:red;">Item already exist</div>
                        
                           <div class=" alertss2" style="display: none;color:red;">Qnty should be less than  DO Qnty</div>
                       
                        </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-gradient-danger btn-xs close" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-gradient-success btn-xs addtogrid">Add To Grid</button>
        
      </div>
</form>
    </div>
  </div>
</div>
<script type="text/javascript">
  // //////////ADD TO GRID SECTION ///////////////////////
   $(document).ready(function(){

$('.addtogrid').one('click', function(e) { 
    var rowCount;
        token = $("#token1").val();
        rowCount = $('.ItemGrid tr').length; 
        itemid=$("#itetee").val();
        totqnty=$("#totqnty").val();
        itemmcost=$(".itemmcost").val();
        doqnty =parseFloat($("#doqnty").val());
    //alert(totqnty);
     if(doqnty < totqnty){
    //alert(doqnty);
$(".alertss2").show();
}
else{
    $(".alertss2").hide();
         var isExists=false;
        
        $(".ItemGrid td .doitemid").each(function(){
              var val=$(this).val();
              if(val==itemid)
                isExists=true;

            });
            if (isExists) {
              $('.stocktable tr[data-id="'+itemid+'"]').remove();
          $('tr', '.viewtable').each(function() {
       var rowFromTable1 = $(this).attr("data-id",itemid);
   var clonedRowFromTable1 = rowFromTable1.clone();
$('tbody', '.stocktable').append( clonedRowFromTable1 )
 });
          $(`.qnty[data-id= ${itemid}]`).val(totqnty);
           $('.currenytstock').modal('hide');
            $(".modal-backdrop").remove();
            } else {
                
   $('tr', '.viewtable').each(function() {
       var rowFromTable1 = $(this).attr("data-id",itemid);;
   var clonedRowFromTable1 = rowFromTable1.clone();
$('tbody', '.stocktable').append( clonedRowFromTable1 )
 })
   $(`.qnty[data-id= ${itemid}]`).val(totqnty);
    $('.currenytstock').modal('hide');
     $(".modal-backdrop").remove();
   
  }
}
  
});
  });
   $(".close").click(function (){
    $(".modal-backdrop").remove();
   
   })
//////////////// CALCULATION///////////////////////////
$(document).on("keyup change paste", ".calculate", function() {
    row = $(this).closest("tr");
    first = parseFloat(row.find("td input.bqnty").val());
    second = parseFloat(row.find("td input.reqqnty").val());
// if(second > first){
// row.find(".alertss").show();
// row.find("td input.reqqnty").val("");
//     }
// else
//     {
 row.find(".alertss").hide();

  sum =0;
$(".viewtable .reqqnty").each(function() {
sum += +$(this).val();
   });
//alert(sum);
 $("#totqnty").val(sum.toFixed(3));
//}
    });
</script>