     @foreach ($eenqs as $eenq )  
    <tr>
     <th scope="row"><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="enqid[]" value="{{$eenq->id}}" id="item_id"  placeholder="Current Stock">{{$loop->iteration}}</th>
    <td><input type="hidden" class="form-control gridid" aria-label="Amount (to the nearest dollar)" name="item_id[]" value="{{$eenq->item_id}}" id="item_id"  placeholder="Current Stock">
        <input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="item[]" value="{{$eenq->item}}" id=""  placeholder="Current Stock">{{$eenq->code}}</td>
      <td><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="code[]" value="{{$eenq->code}}" id=""  placeholder="Current Stock">
      {{$eenq->item}}</td>
      
      <td><input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="unit[]" value="{{$eenq->unit}}" id="unit[]"  placeholder="Current Stock">{{$eenq->unit}}</td>
      
      <td><input type="text" class="form-control auto-calc qnty inputpadd" aria-label="Amount (to the nearest dollar)" name="quantity[]"  id="qnty"  placeholder="Quantity" required="required" value="{{$eenq->quantity}}"></td>
      <td><input type="text" class="form-control auto-calc rate inputpadd" aria-label="Amount (to the nearest dollar)" name="rate[]" value="{{$eenq->rate}}" id=""  placeholder="Rates" required="required"></td>
      <td><input type="text" class="form-control auto-calc discount inputpadd" aria-label="Amount (to the nearest dollar)" name="discount[]" value="{{$eenq->discount}}" id=""  placeholder="Discount" ></td>
      <td><input type="text" class="form-control auto-calc tabamount inputpadd" aria-label="Amount (to the nearest dollar)" name="amount[]" value="{{$eenq->amount}}" id="amount"  placeholder="Total" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
      </tr>
      @endforeach
<script type="text/javascript">
  $(document).ready(function(){
    var sums = 0;
    $("input.tabamount").each(function() {
  sums += +$(this).val();
  //alert(sum);
  });
    $(".gridtotal").val(sums.toFixed(3));
    $(".nettotal").val(sums.toFixed(3));
  })
	$(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
    first = row.find("td input.rate").val();
    second = row.find("td input.qnty").val();
    //alert(second);
    third = row.find("td input.discount").val();
    row.find(".tabamount").val((first * second) - third);
	var sum = 0;
	 $("input.tabamount").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".gridtotal,.nettotal").val(sum.toFixed(3));
});

</script>