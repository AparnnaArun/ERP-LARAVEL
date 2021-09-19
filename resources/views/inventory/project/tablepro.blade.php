
@if($texce == $pro->executive || empty($texce))
<tr>
     <th scope="row">{{$rowCount}}</th>
    
        <td><input type="hidden" class="form-control "  name="projectcode[]" value="{{$pro->project_code}}" id="" >
          <input type="hidden" class="form-control doproid"  name="projectid[]" value="{{$pro->id}}" id="" >{{$pro->project_code}}</td>
      <td><input type="hidden" class="form-control "  name="projectname[]" value="{{$pro->short_name}}" id="" >
      {{$pro->short_name}}</td>
      <td><input type="hidden" class="form-control "  name="customerid[]" value="{{$pro->customer_id}}" id="" >
        <input type="hidden" class="form-control "  name="customer[]" value="{{$pro->name}}" id="" >
      {{$pro->name}}</td>
      <td><input type="hidden" class="form-control inpexce "  name="executive[]" value="{{$pro->executive}}" id="" >
      {{$pro->executive}}</td>
      <td><input type="text" class="form-control auto-calc amount"  name="amount[]" value="" id=""  placeholder="Amount" required>
      </td>
      <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
      
    </tr>
    @else
    
<tr>
     <th scope="row" colspan="6" style="color:red;">Select Project code from same executive for one expense entry</th>
    
        
      <td ><input type="hidden" class="form-control auto-calc amount"  name="" value="0" id=""  placeholder="Amount"><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button></td>
      
    </tr>
    @endif
       <script type="text/javascript">
  $(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
   
  var sum = 0;
   $("input.amount").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".nettotal").val(sum.toFixed(3));

});

</script>