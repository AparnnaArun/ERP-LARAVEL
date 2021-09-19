<div class="modal fade grnstock" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">GRN  Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token1"/>
    <input type="hidden" class="form-control  soquantity inputpadd"  name="reqqnty"  id="soquantity"   required="required" value="{{$reqqnty}}">
    <input type="hidden" class="form-control   inputpadd"  name="itemiid"  id="itemiid"   required="required" value="{{$itemid}}">
              <div class="modal-body">
     <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  
                <div class="table table-responsive">
                    <table class="table table-striped viewtable " id="">
                      <thead>
                        <tr>
                          <th>GRN#</th>
                          <th>Batch</th>
                         <th>GRN Qnty</th>
                         <th>Choose</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($grnitem as $cur)
                      @if(!empty($cur->item_id)) 
<tr>
  <td ><input type="hidden" class="form-control   inputpadd "   name="grnid[]"   id=""   required="required" value="{{$cur->grnid}}">
    <input type="hidden" class="form-control   inputpadd "   name="mainid[]"   id=""   required="required" value="{{$cur->id}}">
<input type="hidden" class="form-control   inputpadd"   name=""   id=""   required="required" value="{{$cur->grn_no}}">
<input type="hidden" class="form-control idid inputpadd"   name=""   id=""   required="required" value="{{$cur->item_id}}">{{$cur->grn_no}}
   </td>
  <td>
  <input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$cur->batch}}" id="batch"  placeholder="Rates" required="required">{{$cur->batch}}</td>
  <td><input type="hidden" class="form-control calculate  inputpadd"  name="gqnty[]" value="{{$cur->quantity}}"    >
    <input type="hidden" class="form-control calculate  inputpadd"  name="ginvqnty[]" value="{{$cur->invqnty}}"    >
  
    <input type="hidden" class="form-control calculate bqnty inputpadd"  name="" value="{{$cur->balqnty}}" id="balqnty"   >{{$cur->balqnty}}</td>
      <td><input type="text" class="form-control calculate reqqnty inputpadd"  name="quantity1[]" value="{{0}}" id="reqqnty"  placeholder="Quantity"  ><div class="calculate alertss" style="display: none;color:red;">Check the qnty</div></td>
         </tr>
         @endif
                 
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
                        <div class="alertdiv" style="color:red;display: none;">Sorry, Selected quantity should less than GRN Qnty!!! </div>
                        <div class="alertdiv1" style="color:red;display: none;">Cost is missing</div>

                        </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-gradient-danger btn-xs" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-gradient-success btn-xs addtogrid">Add To Grid</button>
        
      </div>
</form>
    </div>
  </div>
</div>
<script type="text/javascript">
  // //////////ADD TO GRID SECTION ///////////////////////
  $(document).ready(function(){
  $(".alertdiv").hide();
$('.addtogrid').one('click', function(e) { 
    var rowCount;
        token = $("#token1").val();
        itemids=$("#itemiid").val();
       totqnty=$("#totqnty").val();
       batch=$("#batch").val();
    var isExists=false;
$(".stocktable td .idid").each(function(){
              var val=$(this).val();
              if(val==itemids)
                isExists=true;
              
});
            if (isExists) {
          $('.stocktable tr[data-id="'+itemids+'"]').remove();
          $('tr', '.viewtable').each(function() {
       var rowFromTable1 = $(this).attr("data-id",itemids);
   var clonedRowFromTable1 = rowFromTable1.clone();
$('tbody', '.stocktable').append( clonedRowFromTable1 )
 });
  $(`.invqnty[data-id= ${itemids}]`).val(totqnty);
  $(`.batchs[data-id= ${itemids}]`).val(batch);
  $(`.batchs1[data-id= ${itemids}]`).text(batch);
  } else {
$('tr', '.viewtable').each(function() {
       var rowFromTable1 = $(this).attr("data-id",itemids);;
   var clonedRowFromTable1 = rowFromTable1.clone();
$('tbody', '.stocktable').append( clonedRowFromTable1 )
 })
$(`.invqnty[data-id= ${itemids}]`).val(totqnty);
$(`.batchs[data-id= ${itemids}]`).val(batch);
$(`.batchs1[data-id= ${itemids}]`).text(batch);
     
                   }
$('.grnstock').modal('hide');

     });
 });
//////////////// CALCULATION///////////////////////////
$(document).on("keyup change paste", ".calculate", function() {
    row = $(this).closest("tr");
    first = parseFloat(row.find("td input.bqnty").val());
    second = parseFloat(row.find("td input.reqqnty").val());
if(second > first){
  $(".alertdiv").hide();
row.find(".alertss").show();
row.find("td input.reqqnty").val("");
    }
else
    {
 row.find(".alertss").hide();
    }
sum =0;
$(".viewtable .reqqnty").each(function() {
sum += +$(this).val();
   });
 soquantity1 = parseFloat($(".soquantity").val());
 if(soquantity1 >= sum){
   $(".alertdiv").hide();
 $("#totqnty").val(sum.toFixed(3));
}else{
  $(".alertdiv").show();
  $("#totqnty").val("");
}
    });
</script>