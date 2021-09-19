@foreach($pos as $item)
<tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>
      <input type="hidden" class="form-control "  name="pid[]" value="{{$item->id}}" id=""  >
      <input type="hidden" class="form-control "  name="mid[]" value="{{$item->reqid}}" id=""  >
      <input type="hidden" class="form-control "  name="item_id[]" value="{{$item->item_id}}" >
      <input type="hidden" class="form-control "  name="item_code[]" value="{{$item->item_code}}" >
      {{$item->item_code}}
      </td>
      <td>
    <input type="hidden" class="form-control "  name="item_name[]" value="{{$item->item_name}}"   >
     {{$item->item_name}}
     </td>
     <td>
    <input type="hidden" class="form-control"  name="unit[]" value="{{$item->unit}}" id="unit[]"  >{{$item->unit}}
    </td>
    <td>
    <input type="hidden" class="form-control"  name="location[]" value="{{$locs}}"   >
    {{$sto->locationname}}
    </td>
    <td>
    <input type="text" class="form-control"  name="batch[]" value="{{ \Carbon\Carbon::parse(now())->format('j -F- Y')  }}"  required >
    
    </td>
      <td>
        <input type="hidden" class="form-control auto-calc "  name="apprqnty[]" value="{{$item->apprqnty}}" >
        <input type="hidden" class="form-control auto-calc "  name="pgrnqnty[]" value="{{$item->grnqnty}}" >
        <input type="hidden" class="form-control auto-calc penpoqnty"  name="penpoqnty[]" value="{{$item->balqnty}}" >
      {{$item->balqnty}}
    </td>
    <td>
        <input type="text" class="form-control auto-calc grnqnty"  name="quantity[]" value="{{$item->balqnty}}" >
      <input type="hidden" class="form-control auto-calc rate"  name="rate[]" value="{{$item->rate}}" >
      <input type="hidden" class="form-control auto-calc amount"  name="amount[]" value="{{($item->balqnty)*($item->rate)}}"  >
      <div class="divshow" style="color:red;display:none;">This qnty should be less than PO Qnty</div>
    </td>
<td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
     
     
    </tr>
    @endforeach
    <script type="text/javascript">
  $(document).on("keyup change paste", ".auto-calc", function() {
  row = $(this).closest("tr");
    first = parseFloat(row.find("td input.penpoqnty").val());
    second = parseFloat(row.find("td input.grnqnty").val());
    third = parseFloat(row.find("td input.rate").val());
   row.find("td input.amount").val((third*second).toFixed(3));
 var sums = 0;
$("input.grnqnty").each(function() {
  sums += +$(this).val();
  
  });
if(first >=second){
  row.find("td .divshow").hide();
  $(".tqnty").val(sums.toFixed(3));
  
}else{
row.find("td .divshow").show();
$(".tqnty").val('');
}
      
});
  $(document).ready(function() {
   var sums1 = 0;
$("input.grnqnty").each(function() {
  sums1 += +$(this).val();
  
  });
$(".tqnty").val(sums1.toFixed(3));
});
</script>