<div class="row">
                      <div class="col-md-12">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
                          <th>Date</th>
                          <th>Customer</th>
                          <th>Total Qnty</th>
       <th>Sold Amount</th>
       <th>Transaction No</th>
       
                          </tr>
                      </thead>
                      <tbody>

                       
                         @foreach($stock as $custs)
                 
    <tr>

      
      <td>{{ $custs->dates }}</td>
     <td> {{ $custs->short_name}} </td> 
     <td> {{ $custs->sqout}} </td>
     <td> {{ round(($custs->sumamt),3)}} </td>
   
     <td> {{ $custs->invoice_no}} / {{ $custs->deli_note_no}}</td>
     
    </tr>
@endforeach
                 


   
                      </tbody>
                    </table>
                  </div>
                </div>