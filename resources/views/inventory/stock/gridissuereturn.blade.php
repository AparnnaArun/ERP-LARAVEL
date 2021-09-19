@if($stock=='MatIssue')
<input type="hidden" class="form-control "  name="commission_percentage" value="{{ $datas->commission_percentage}}" required="required" >
<input type="hidden" class="form-control "  name="comm_pay_account" value="{{ $datas->comm_pay_account }}" required="required" >
<input type="hidden" class="form-control "  name="exe_com_exp_ac" value="{{ $datas->exe_com_exp_ac }}" required="required" >
<input type="hidden" class="form-control "  name="project_id" value="{{ $datas->project_id }}" required="required" >
<input type="hidden" class="form-control "  name="project_code" value="{{ $datas->project_code }}" required="required" >
<input type="hidden" class="form-control "  name="project_name" value="{{ $datas->project_name }}" required="required" >
<input type="hidden" class="form-control "  name="executive" value="{{ $datas->executive }}" required="required" >
<input type="hidden" class="form-control "  name="customer_id" value="{{ $datas->customer_id }}" required="required" >
<input type="hidden" class="form-control "  name="customer" value="{{ $datas->customer }}" required="required" >
<div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                           <th>Batch</th>
                            <th>Issue Qnty</th>
                            <th>Rtn Qnty</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($datas->projectmaterialissuedetail as $data )
<tr>
  <td>{{$loop->iteration}}<input type="hidden" class="form-control "  name="issue_id[]" value="{{ $data->id }}" required="required" >
    <input type="hidden" class="form-control "  name="iissue_qnty[]" value="{{ $data->issue_qnty }}" required="required" ><input type="hidden" class="form-control "  name="irtn_qnty[]" value="{{ $data->rtn_qnty }}" required="required" ><input type="hidden" class="form-control "  name="mainid[]" value="{{ $data->issue_id }}" required="required" ><input type="hidden" class="form-control "  name="item_id[]" value="{{ $data->item_id }}" required="required" ></td>
    
    
  <td><input type="hidden" class="form-control "  name="item_code[]" value="{{ $data->item_code }}" required="required" >{{$data->item_code}}</td>
  <td><input type="hidden" class="form-control "  name="item[]" value="{{ $data->item }}" required="required" >{{$data->item}}</td>
  <td><input type="hidden" class="form-control "  name="unit[]" value="{{ $data->unit }}" required="required" >{{$data->unit}}</td>
  <td><input type="hidden" class="form-control "  name="batch[]" value="{{ $data->batch }}" required="required" >{{$data->batch}}</td>
  <td><input type="hidden" class="form-control auto-calc penqnty"  name="pen_qnty[]" value="{{ $data->pen_qnty }}" required="required" >{{$data->pen_qnty}}</td>
  <td><input type="text" class="form-control auto-calc reqqnty"  name="rtn_qnty[]" value="" required="required" ><div class="alertsst" style="color: red;display:none;">This qnty less than Issue qnty </div></td>
  <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button>
  <input type="hidden" class="form-control auto-calc rate "  name="rate[]" value="{{ $data->rate }}" required="required" >
<input type="hidden" class="form-control auto-calc amount"  name="amount[]" value="" required="required" ></td>

</tr>

                        @endforeach
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              @else
              @if($datas->issue_for=='Rental')
              <input type="hidden" class="form-control "  name="issueacc" value="273" required="required" >
              @elseif($datas->issue_for=='Maintenance')
              <input type="hidden" class="form-control "  name="issueacc" value="274" required="required" >
              @elseif($datas->issue_for=='ScrapOut' || $datas->issue_for=='Sample')
              <input type="hidden" class="form-control "  name="issueacc" value="275" required="required" >
              @elseif($datas->issue_for=='OfficeOverhead')
              <input type="hidden" class="form-control "  name="issueacc" value="276" required="required" >
              @else
              @endif
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="table table-responsive">
                    <table class="table table-striped ItemGrid" id="ItemGrid">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Item</th>
                           <th>Unit</th>
                           <th>Batch</th>
                            <th>Issue Qnty</th>
                            <th>Rtn Qnty</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($datas->stockissuedetail as $data )
<tr>
  <td>{{$loop->iteration}}<input type="hidden" class="form-control "  name="issue_id[]" value="{{ $data->id }}" required="required" ><input type="hidden" class="form-control "  name="item_id[]" value="{{ $data->item_id }}" required="required" ><input type="hidden" class="form-control "  name="iissue_qnty[]" value="{{ $data->issue_qnty }}" required="required" ><input type="hidden" class="form-control "  name="irtn_qnty[]" value="{{ $data->rtn_qnty }}" required="required" >
    <input type="hidden" class="form-control "  name="mainid[]" value="{{ $data->stockissue_id }}" required="required" ></td>
    </td>
  <td><input type="hidden" class="form-control "  name="item_code[]" value="{{ $data->item_code }}" required="required" >{{$data->item_code}}</td>
  <td><input type="hidden" class="form-control "  name="item[]" value="{{ $data->item_name }}" required="required" >{{$data->item_name}}</td>
  <td><input type="hidden" class="form-control "  name="unit[]" value="{{ $data->unit }}" required="required" >{{$data->unit}}</td>
  <td><input type="hidden" class="form-control "  name="batch[]" value="{{ $data->batch }}" required="required" >{{$data->batch}}</td>
  <td><input type="hidden" class="form-control auto-calc penqnty "  name="pen_qnty[]" value="{{ $data->pen_qnty }}" required="required" >{{$data->pen_qnty}}</td>
  <td><input type="text" class="form-control auto-calc reqqnty "  name="rtn_qnty[]" value="" required="required" ><div class="alertsst" style="color: red;display:none;">This qnty less than Issue qnty </div></td>
  <td ><button id="remove" class="btn btn-danger btn-xs buttons "><i class="mdi mdi-delete-forever"></i></button>
  <input type="hidden" class="form-control auto-calc rate "  name="rate[]" value="{{ $data->rate }}" required="required" >
<input type="hidden" class="form-control auto-calc amount "  name="amount[]" value="" required="required" ></td>

</tr>

                        @endforeach
                        
                      </tbody>
                    </table>
                  
                </div>
              </div>
              @endif
              <script type="text/javascript">
  $(document).on("keyup change paste", ".auto-calc", function() {
    row = $(this).closest("tr");
    first = parseFloat(row.find("td input.rate").val());
    second = parseFloat(row.find("td input.reqqnty").val());
    third = parseFloat(row.find("td input.penqnty").val());
    //alert(third);
    if(second>third){
row.find(".alertsst").show();
$(".savebtn").prop('disabled',true);
    }else{
 row.find(".alertsst").hide();
      $(".savebtn").prop('disabled',false);
    row.find("td input.amount").val((first * second).toFixed(3));
  var sum = 0;
   $("input.amount").each(function() {
  sum += +$(this).val();
  //alert(sum);
  });
$(".totalcost").val(sum.toFixed(3));
}
});

</script>