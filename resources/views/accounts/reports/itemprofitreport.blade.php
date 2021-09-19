<div class="row">
                      <div class="col-md-12">
                    <table class="table table-striped reporttable" id="reporttable">
                      <thead>
                        <tr>
                     
                          <th>Code</th>
                          <th>Item Name</th>
                          <th>Unit</th>
       <th>Total Qnty</th>
       <th>Total Sales</th>
       <th>Total Profit</th>
       <th>Profit %</th>
      <th>Max Rate</th>
      <th>Min Rate</th>
                          </tr>
                      </thead>
                      <tbody>

                       
                         @foreach($stocks as $custs)
                 
    <tr>

      
      <td>{{ $custs->item_code }}</td>
     <td> {{ $custs->item_name}} </td> 
     <td> {{ $custs->unit}} </td>
     <td> {{ round(($custs->sqout),3)}} </td>
     <td> {{ round(($custs->sumamt),3)}} </td>
     <td> {{ round((($custs->sumamt) - ($custs->sqout*$custs->cost)),3)}} </td>
     <td> {{ round((((($custs->sumamt) - ($custs->sqout*$custs->cost))*100)/($custs->sqout*$custs->cost)),2)}} </td>
     <td> {{ $custs->max}} </td>
     <td> {{ $custs->min}} </td>
    </tr>
@endforeach
                 @foreach($stocks1 as $custs1)
                 
    <tr>

      
      <td>{{ $custs1->item_code }}</td>
     <td> {{ $custs1->item}} </td> 
     <td> {{ $custs1->unit}} </td>
     <td> {{ round(($custs1->pqout),3)}} </td>
     <td> {{ round(($custs1->pumamt),3)}} </td>
     <td> {{ round((($custs1->pumamt) - ($custs1->pqout*$custs1->cost)),3)}} </td>
     <td> {{ round((((($custs1->pumamt) - ($custs1->pqout*$custs1->cost))*100)/($custs1->pqout*$custs1->cost)),2)}} </td>
     <td> {{ $custs1->maxp}} </td>
     <td> {{ $custs1->minp}} </td>
    </tr>
@endforeach


   
                      </tbody>
                    </table>
                  </div>
                </div>