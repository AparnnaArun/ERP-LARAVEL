                     <div class="card-body">
 <img src="{{ public_path('assets/images') . '/' . $cmpid->imagename }}" style="width: 650px; height: 100px">
<h2 class="card-title " ><center>Project Invoice</center></h2>
      <table style="border-collapse: collapse;border-color: #808080;width:100%">
        
        <tr><td colspan="3">{{$data ->customer}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Ref No</td>
          <td>: {{$data ->projinv_no}}</td></tr>
        <tr><td colspan="3">{{$data ->address}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: 
{{ \Carbon\Carbon::parse($data->dates)->format('j -F- Y')  }}</td></tr>
       
         
        
      </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
        
            <th>Qnty</th>
            <th>Unit Price<br>in KWD</th>
        
            <th>Tot.Price<br>in KWD</th>

          </tr>
        </thead>
        <tbody>
          @foreach($data->projectinvoicedetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item}}</td>
            
            <td style="text-align: center;">{{$sqoute->qnty}}</td>
            <td style="text-align: center;">{{$sqoute->rate}}</td>
            
            <td style="text-align: center;">{{$sqoute->total}}</td>
          </tr>
          @endforeach
          <tr>
            <th colspan="11">Total Value</th>
            <th>{{$data ->totalamount}}</th>
           
          </tr>
          
          
        </tbody>

      </table>
      <br/>
      
<table>
          <tr> <td>Best Regards,</td></tr>
           <tr><td><b>Agrim Projects Solutions</b></td>
         </tr></table>




                  </div>