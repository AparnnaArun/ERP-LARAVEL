
<div class="row">

                <div class="col-md-2">
                </div>
                <div class="col-lg-8 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped CostTable" id="CostTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Account</th>
                          <th>Debit</th>
                          <th> Credit</th>
                           
                        </tr>
                      </thead>
                      <tbody>
                        @if(empty($op))
                        @foreach($acc as $items)
                    <tr>
      <th>{{$loop->iteration}}</th>
      <td><input type="hidden" class=""  name="accountid[]" 
      value="{{$items->id}}"  ><input type="hidden" class=""  name="accname[]" 
      value="{{$items->printname}}"  >{{$items->printname}}</td>
      <td ><input type="text" class="form-control auto-calc debit"  name="debit[]" 
      value="0"  ></td>
     <td><input type="text" class="form-control auto-calc credit "  name="credit[]" 
      value="0"  ></td>
     
     
     
    </tr>
                        @endforeach
                        @else
                         @foreach($op->openingaccountdetail as $item)
                    <tr>
      <th>{{$loop->iteration}}</th>
      <td><input type="hidden" class=""  name="accountid[]" 
      value="{{$item->acchead}}"  >
      <input type="hidden" class=""  name="accname[]" 
      value="{{$item->accname}}"  >{{$item->accname}}</td>
      <td ><input type="text" class="form-control auto-calc debit"  name="debit[]" 
      value="{{$item->debit}}"  ></td>
     <td><input type="text" class="form-control auto-calc credit "  name="credit[]" 
      value="{{$item->credit}}"  ></td>
     
     
     
    </tr>
                        @endforeach
              @endif
                      </tbody>
                    </table>
                  
                </div>
              </div>
              </div>
              
            
                <script type="text/javascript">
$(document).on("keyup change paste", "td > input.auto-calc", function() {
   var sum = 0;
   var sum1 =0;
 $("input.debit").each(function() {
  sum += +$(this).val();
  });
 $("input.credit").each(function() {
  sum1 += +$(this).val();
  });
 $(".totdebit").val(sum.toFixed(3));
 $(".totcredit").val(sum1.toFixed(3));
$(".diffopenbal").val((sum - sum1).toFixed(3));
});
$(document).ready(function() {
var sum = 0;
var sum1 =0;
 $("input.debit").each(function() {
  sum += +$(this).val();
  });
$("input.credit").each(function() {
  sum1 += +$(this).val();
  });
 $(".totdebit").val(sum.toFixed(3));
 $(".totcredit").val(sum1.toFixed(3));
$(".diffopenbal").val((sum - sum1).toFixed(3));
});
</script>