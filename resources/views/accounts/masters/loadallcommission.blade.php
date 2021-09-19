@foreach($result as $row)
<div class="row">
               <div class="col-md-4 ">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Total Income</span>
                        </div>
                      <input type="text"  class="form-control"  name="total_income" value="{{ $row->income }}" required>
                      <input type="hidden"  class="form-control"  name="comm_pay_account" value="{{ $exe->comm_pay_account }}" readonly="">
                       
                      </div>
                    </div>
                </div>
                   <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Expense</span>
                        </div>
                          <input type="text"  class="form-control"  name="total_expense" value="{{ $row->expense }}" readonly>
                         
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Total Profit</span>
                        </div>
                          <input type="text"  class="form-control"  name="profit" value="{{ $row->profit }}" readonly>
                         
                       
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Comm.Payable</span>
                        </div>
                          <input type="text"  class="form-control totcomm"  name="commission_payable" value="{{ $row->totcomm }}" readonly>
                         
                       
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Comm Paid</span>
                        </div>
                          <input type="text"  class="form-control paidcomm"  name="commission_paid" value="{{ $row->paidcomm  }}" readonly>
                         @foreach($op as $p)
 <input type="hidden"  class="form-control sdebit"  name="amount" value="{{ $p->sdebit }}" required>
  <input type="hidden"  class="form-control"  name="amount" value="{{ $p->scredit }}" required>

@endforeach
                       
                      </div>
                    </div>
                </div>
                 <div class="col-md-4">
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">Balance</span>
                        </div>
                          <input type="text"  class="form-control balance"  name="balance" value="" readonly>
                         
                       
                      </div>
                    </div>
                </div>
              </div>
@endforeach
<script type="text/javascript">
	 $(document).ready( function() {
paidcomm=parseFloat($(".paidcomm").val());
sdebit =parseFloat($(".sdebit").val());
totcomm=parseFloat($(".totcomm").val());
$(".paidcomm").val((paidcomm +sdebit).toFixed(3));
$(".balance").val((totcomm-(paidcomm +sdebit)).toFixed(3));

	 });
</script>