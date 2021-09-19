<tr>
	<th scope="row">{{$rowCount}}</th>
    <td>
       <input type="hidden" class="form-control "  name="item[]" value="{{$item}}" id="" >{{$item}}</td>
      <td><input type="text" class="form-control calculate qnty"  name="qnty[]" value="0" id="" >
      </td>
      <td><input type="text" class="form-control calculate rate"  name="rate[]" value="0" id="" >
        </td>
      <td><input type="text" class="form-control calculate amount "  name="total[]" value="{{0.000}}" id="" >
      </td>
      
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
</tr>
<script type="text/javascript">
	$(document).on("keyup change paste", ".calculate", function() {
    row = $(this).closest("tr");
    first = parseFloat(row.find("td input.qnty").val());
    second = parseFloat(row.find("td input.rate").val());
    tot = first * second;
    row.find("td input.amount").val(tot.toFixed(3));
sum =0;
$("input.amount").each(function() {
sum += +$(this).val();
   });
//alert(sum);
 $(".nettotal").val(sum.toFixed(3));

    });
</script>