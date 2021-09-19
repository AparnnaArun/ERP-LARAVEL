                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Material Issue Return</center></h2>
      <table style="width:100%;">
        
        <tr><td colspan="0">Issue No</td>
          <td>: {{$datt->issue_no}}</td>
          <td></td>
          <td></td>
           <td>Date</td>
          <td>: {{ \Carbon\Carbon::parse($data->issuertn_date)->format('j -F- Y')  }}</td></tr>
     
          
          
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>Batch</th>
            <th>Iss Qnty</th>
           <th>Rtn Qnty</th>
            

          </tr>
        </thead>
        <tbody>
          @foreach($data->stockissuereturndetail as $sqoute)
          
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item_name}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->batch}}</td>
            <td style="text-align: center;">{{$sqoute->issqnty}}</td>
            <td style="text-align: center;">{{$sqoute->rtnqnty}}</td>
          
          </tr>
          @endforeach
         
        </tbody>

      </table>
      <br/>
      
<table>
         <tr>
           <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>