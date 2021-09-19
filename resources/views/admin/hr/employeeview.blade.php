 
@if(!empty($salcal->bsalary))
 <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Emp #</span>
                        </div>
                        <input type="text" class="form-control " placeholder=""  name="empid" value="{{ $emp->empid  }}" readonly="" >
                      </div>
                    </div>
                </div>
                   	<div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Basic Salary</span>
                        </div>
                        <input type="text" class="form-control auto-calc bsalary" placeholder=""  name="bsalary" value="{{ $emp->bsalary }}" readonly="" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Allowance</span>
                        </div>
                        
                        <input type="text" class="form-control auto-calc allowance " aria-label="Amount (to the nearest dollar)" name="allowance" value="{{ $emp->allowance }}" readonly="">
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              
                
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">NO.Of Working Days</span>
                        </div>
                        <input type="text"  class="form-control auto-calc workingdays " aria-label="Amount (to the nearest dollar)" name="workingdays" value="@if(!empty($salcal->workingdays)){{$salcal->workingdays}}@else{{26}}@endif" required >
                        
                        
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required">No.Of Days Worked </span>
                        </div>
                        <input type="text"  class="form-control auto-calc workeddays " aria-label="Amount (to the nearest dollar)" name="workeddays" value="@if(!empty($salcal->workeddays)){{$salcal->workeddays}}@else{{26}}@endif" required >
                        
                        
                      </div>
                    </div>
                </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Add.Allowance</span>
                        </div>
                        <input type="text"  class="form-control auto-calc addallowance " aria-label="Amount (to the nearest dollar)" name="addallowance" value="@if(!empty($salcal->addallowance)){{$salcal->addallowance}}@else{{0}}@endif" >
                        
                        
                      </div>
                    </div>
                </div>
                           </div>
            <div class="row">
              
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Normal Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc norover" placeholder=""  name="norover" value="@if(!empty($salcal->norover)){{$salcal->norover}}@else{{0}}@endif" >
                        <input type="hidden" class="form-control auto-calc overn" placeholder=""  name="" value="{{ $over1->rate }}" >
                        <input type="hidden" class="form-control auto-calc nramount" placeholder=""  name="nramount" value="0" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Friday Overtine(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc frover" placeholder=""  name="frover" value="@if(!empty($salcal->frover)){{$salcal->frover}}@else{{0}}@endif" >
                        <input type="hidden" class="form-control auto-calc overf" placeholder=""  name="" value="{{ $over2->rate }}" >
                        <input type="hidden" class="form-control auto-calc framount" placeholder=""  name="framount" value="0" >
                      </div>
                    </div>
                </div>
             
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white ">Holiday Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc holover" placeholder=""  name="holover" value="@if(!empty($salcal->holover)){{$salcal->holover}}@else{{0}}@endif" >
                        <input type="hidden" class="form-control auto-calc overh" placeholder=""  name="overh" value="{{ $over3->rate }}" >
                         <input type="hidden" class="form-control auto-calc holamount " placeholder=""  name="holamount" value="0" >
                       
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">This Month Salary</span>
                        </div>
                        <input type="text" class="form-control thissal" aria-label="Amount (to the nearest dollar)" name="thissalary" value="@if(!empty($salcal->thissalary)){{$salcal->thissalary}}@else{{$net}}@endif" readonly="">
                        
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                 <!--  <p> statement will shows only database values</p> -->
                    <button type="button" class="btn btn-gradient-success btn-xs btn-fw" onclick="myApp.printTable()">View Statement</button>
                </div>
              </div>
              <div class="row" style="display: none;">
                <div id="DivIdToPrint" class="DivIdToPrint" >
             <table class="table" border='1' >
                      <thead>
                        <tr>
                          <th>Name :</th> 
                          <th>{{ $emp->name  }}</th>
                          <th>ID:</th>
                          <th>{{ $emp->empid  }}</th>
                           </tr>
                            <tr>
                          <th>Month :</th> 
                          <th>{{ $salcal->month  }}</th>
                          <th>Year:</th>
                          <th>{{ $salcal->year }}</th>
                           </tr>
                      </thead>
                      <tbody>
                        
                        <tr>
                          <td colspan="2">Total Working Days</td><td colspan="2">{{ $salcal->workingdays  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Total Worked Days</td><td colspan="2">{{ $salcal->workeddays  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Basic Slary</td><td colspan="2">{{ $salcal->bsalary  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Allowance</td><td colspan="2">{{ $salcal->allowance  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Additional Allowance</td><td colspan="2">{{ $salcal->addallowance  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Normal Overtime</td><td colspan="2">{{ $salcal->nramount  }}</td>
                        </tr>
                          
                          
                        <tr>
                          <td colspan="2">Friday Overtime</td><td colspan="2">{{ $salcal->framount  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Holiday Overtime</td><td colspan="2">{{ $salcal->holamount  }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">Grand Total</td><td colspan="2"><b>{{ $salcal->thissalary  }}</b></td>
                        </tr>
                        
                      </tbody>
                    </table>
              </div>
              </div>
             @else
             <div class="row">
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Emp #</span>
                        </div>
                        <input type="text" class="form-control " placeholder=""  name="empid" value="{{ $emp->empid  }}" readonly="" >
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Basic Salary</span>
                        </div>
                        <input type="text" class="form-control auto-calc bsalary" placeholder=""  name="bsalary" value="{{ $emp->bsalary }}" readonly="" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Allowance</span>
                        </div>
                        
                        <input type="text" class="form-control auto-calc allowance " aria-label="Amount (to the nearest dollar)" name="allowance" value="{{ $emp->allowance }}" readonly="">
                      </div>
                    </div>
                </div>
              </div>
            <div class="row">
              
                
                          <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">NO.Of Working Days</span>
                        </div>
                        <input type="text"  class="form-control auto-calc workingdays " aria-label="Amount (to the nearest dollar)" name="workingdays" value="{{26}}" >
                        
                        
                      </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white required ">No.Of Days Worked </span>
                        </div>
                        <input type="text"  class="form-control auto-calc workeddays " aria-label="Amount (to the nearest dollar)" name="workeddays" value="{{26}}" required >
                        
                        
                      </div>
                    </div>
                </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Add.Allowance</span>
                        </div>
                        <input type="text"  class="form-control auto-calc addallowance " aria-label="Amount (to the nearest dollar)" name="addallowance" value="{{0}}" >
                        
                        
                      </div>
                    </div>
                </div>
                           </div>
            <div class="row">
              
              
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Normal Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc norover" placeholder=""  name="norover" value="{{0}}" >
                        <input type="hidden" class="form-control auto-calc overn" placeholder=""  name="" value="{{ $over1->rate }}" >
                        <input type="hidden" class="form-control auto-calc nramount" placeholder=""  name="nramount" value="0" >
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white ">Friday Overtine(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc frover" placeholder=""  name="frover" value="{{0}}" >
                        <input type="hidden" class="form-control auto-calc overf" placeholder=""  name="" value="{{ $over2->rate }}" >
                        <input type="hidden" class="form-control auto-calc framount" placeholder=""  name="framount" value="0" >
                      </div>
                    </div>
                </div>
             
              <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white ">Holiday Overtime(hr)</span>
                        </div>
                        <input type="text" class="form-control auto-calc holover" placeholder=""  name="holover" value="{{0}}" >
                        <input type="hidden" class="form-control auto-calc overh" placeholder=""  name="overh" value="{{ $over3->rate }}" >
                         <input type="hidden" class="form-control auto-calc holamount " placeholder=""  name="holamount" value="0" >
                       
                      </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-info text-white">This Month Salary</span>
                        </div>
                        <input type="text" class="form-control thissal" aria-label="Amount (to the nearest dollar)" name="thissalary" value="{{$net}}" readonly="">
                        
                      </div>
                    </div>
                </div>
                </div>
                @endif 

<script type="text/javascript">
$(document).on("keyup change paste", " input.auto-calc", function() {
bsalary = parseFloat($(".bsalary").val());
allowance = parseFloat($(".allowance").val());
workingdays = parseFloat($(".workingdays").val());
workeddays = parseFloat($(".workeddays").val());
addallowance = parseFloat($(".addallowance").val());
norover = parseFloat($(".norover").val());
overn = parseFloat($(".overn").val());
frover = parseFloat($(".frover").val());
overf =parseFloat($(".overf").val());
holover = parseFloat($(".holover").val());
overh = parseFloat($(".overh").val());
csalary=  bsalary/workingdays;
newcalsalary =   csalary*workeddays;
cal_allowance = allowance + addallowance;
cal_normalot = norover*overn;
cal_fridayot= frover*overf;
cal_holidayot= holover*overh;
total_salary = newcalsalary+cal_allowance+cal_normalot+ cal_fridayot+cal_holidayot;
$(".nramount").val(cal_normalot.toFixed(3));
$(".framount").val(cal_fridayot.toFixed(3));
$(".holamount").val(cal_holidayot.toFixed(3));
$(".thissal").val(total_salary.toFixed(3));
});       
     
 var myApp = new function () {
        this.printTable = function () {
          
            var tab = document.getElementById('DivIdToPrint');
            var win = window.open('', '', 'height=700,width=700');
            win.document.write('<head><style>');
win.document.write('table {border-collapse:collapse;width:100%}');
win.document.write('table { text-align:center;  margin-left: auto;  margin-right: auto;}');
win.document.write('</style></head>');
            win.document.write('<body> <h3><center>Salary Statement</center></h3><br>'); 
            win.document.write(tab.outerHTML);
            win.document.close();
            setTimeout(function() {
                   win.print();
            },3000)        }
    }
</script>