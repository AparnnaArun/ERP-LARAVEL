<div class="modal fade currenytstock" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-text="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delivery Note Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-text="true">&times;</span>
        </button>
      </div>
      <form id="form">
     <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token1"/>
    <input type="hidden" class="form-control  soquantity inputpadd"  name="soquantity"  id="soquantity"   required="required" value="{{$soqty}}">
                  
<input type="hidden" class="form-control  inputpadd"  name="itemiid"  id="itemiid"   value="{{$itemmid}}">
<input type="hidden" class="form-control  inputpadd"  name=""  id="rsrates"   value="{{$rsrate}}">
<input type="hidden" class="form-control  inputpadd"  name=""  id="costs"   value="{{$cost}}">
      <div class="modal-body">
     <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  
                <div class="table table-responsive">
                    <table class="table table-striped viewtable " id="">
                      <thead>
                        <tr>
                          <th>DO#</th>
                          <th>Batch</th>
                         <th>DO Qnty</th>
                         <th>{{$action}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($doitem as $cur)
  @if(!empty($cur->item_id))                     
<tr>
  <td ><input type="hidden" class="form-control   inputpadd "   name="dln_id[]"   id=""   required="required" value="{{$cur->dln_id}}">
<input type="hidden" class="form-control   inputpadd idid"   name=""   id=""   required="required" value="{{$cur->item_id}}">
    <input type="hidden" class="form-control calculate inputpadd"  name="dodid[]"     required="required" value="{{$cur->id}}">{{$cur->deli_note_no}}</td>
  <td>
  <input type="hidden" class="form-control auto-calc  inputpadd"  name="batch[]" value="{{$cur->batch}}" id="batch"  placeholder="Rates" required="required">{{$cur->batch}}</td>
  <td><input type="hidden" class="form-control calculate  inputpadd"  name="doqty[]" value="{{$cur->quantity}}"    >
    <input type="hidden" class="form-control calculate  inputpadd"  name="doity[]" value="{{$cur->inv_qnty}}"    >
    <input type="hidden" class="form-control calculate  inputpadd"  name="dodrty[]" value="{{$cur->dortn_qnty}}"    >
    <input type="hidden" class="form-control calculate bqnty inputpadd"  name="dobty[]" value="{{$cur->bal_qnty}}" id="balqnty"   >{{$cur->bal_qnty}}</td>
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
                        <div class="alertdiv" style="color:red;display: none;">Sorry, Selected quantity should less than DO Qnty!!! </div>
                        <div class="alertdiv1" style="color:red;display: none;">Cost is missing</div>

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
  $(".alertdiv").hide();
$('.addtogrid').one('click', function(e) { 
    var rowCount;
        token = $("#token1").val();
        itemid=$("#itemiid").val();
       totqnty=$("#totqnty").val();
       rsrate =$("#rsrates").val();
       cost=$("#costs").val();
        batch   =$("#batch").val();
        amt =totqnty * rsrate;
        camt =cost*totqnty;
        var isExists=false;
        
        $(".stocktable td .idid").each(function(){
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
    $(`.invqnty[data-id= ${itemid}]`).val(totqnty);
   $(`.batchs[data-id= ${itemid}]`).val(batch);
      $(`.batchs[data-id= ${itemid}]`).val(batch);
      $(`.batchs1[data-id= ${itemid}]`).text(batch);
      $(`.salammmt[data-id= ${itemid}]`).val(amt.toFixed(3));
      $(`.costammmt[data-id= ${itemid}]`).val(camt.toFixed(3));
            } else {
$('tr', '.viewtable').each(function() {
       var rowFromTable1 = $(this).attr("data-id",itemid);;
   var clonedRowFromTable1 = rowFromTable1.clone();
$('tbody', '.stocktable').append( clonedRowFromTable1 )
 })

 $(`.invqnty[data-id= ${itemid}]`).val(totqnty);
   $(`.batchs[data-id= ${itemid}]`).val(batch);
      $(`.batchs[data-id= ${itemid}]`).val(batch);
      $(`.batchs1[data-id= ${itemid}]`).text(batch);
      $(`.salammmt[data-id= ${itemid}]`).val(amt.toFixed(3));
      $(`.costammmt[data-id= ${itemid}]`).val(camt.toFixed(3));
                   }

       $('.currenytstock').modal('hide');
       $(".modal-backdrop").remove();
          var sums = 0;
    var sums1 = 0;
    $("input.salammmt").each(function() {
  sums += +$(this).val();
  
  });
     $("input.costammmt").each(function() {
  sums1 += +$(this).val();
  
  });
    $(".gridtotal,.nettotal").val(sums.toFixed(3));
   $(".totalcost").val(sums1.toFixed(3));
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