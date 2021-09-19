       
    <tr>
      <th scope="row">{{$rowCount}}</th>
      <td><input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="code[]" value="{{$item->code}}" id="code"  placeholder="Current Stock">
        {{$item->code}}</td>
      <td><input type="hidden" class="form-control gridid" aria-label="Amount (to the nearest dollar)" name="item_id[]" value="{{$item->id}}" id="item_id"  placeholder="Current Stock">
      	<input type="hidden" class="form-control " aria-label="Amount (to the nearest dollar)" name="item_name[]" value="{{$item->item}}" id=""  placeholder="Current Stock">{{$item->item}}</td>
      <td><input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="description[]" value="{{$item->description}}" id="description[]"  placeholder="Current Stock">{{$item->description}}</td>
      <td><input type="hidden" class="form-control" aria-label="Amount (to the nearest dollar)" name="unit[]" value="{{$item->basic_unit}}" id="unit[]"  placeholder="Current Stock">{{$item->basic_unit}}</td>
      <td><input type="text" class="form-control auto-calc qnty" aria-label="Amount (to the nearest dollar)" name="quantity[]" value="" id="qnty"  placeholder="Quantity" required="required"></td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>
<script type="text/javascript">
	$(document).on("keyup change paste", ".auto-calc", function() {
	var sum = 0;
	 $("input.qnty").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".nettotal").val(sum.toFixed(3));
});

</script>