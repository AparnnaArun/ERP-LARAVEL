                     
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/>

                     <div class="card-body mt-5">

<h2 class="card-title " ><center>Delivery Note</center></h2>
      <table style="width:100%;">
       <!--  <tr><td>To,</td></tr> -->
       <tr><td >Customer PO</td>
          <td>: {{$data1 ->customer_po}}</td>
          <td></td>
          <td></td>
          <td>DO NO</td>
          <td>: {{$data1->deli_note_no}}</td></tr>
        <tr><td>Messers</td>
          <td>: {{$data1->name}}</td>
          <td></td>
          <td></td>
          <td>Date</td>
          <td>: {{ \Carbon\Carbon::parse($data1->dates)->format('j -F- Y')  }}</td></tr>
        <tr><td >Address</td>
          <td>: {{$data1->address}}</td>
          <td></td>
          <td></td>
          <td>Manual DO</td>
          <td>: {{$data1->manual_do}}</td></tr>
       
  </table>
      <table border="1" style="border-collapse: collapse;border-color: #808080;width:100%">
        <thead>
          <tr>
            <th>SlNo</th>
            <th >Code</th>
            <th colspan="8" style="width:50%!important;" >Description</th>
            
            <th>Unit</th>
            <th>Qnty</th>
            

          </tr>
        </thead>
        <tbody>
          @foreach($data1->deliverynotedetail as $sqoute)
            <tr>
            <td style="text-align: center;">{{$loop->iteration}}</td>
            <td style="text-align: center;">{{$sqoute->code}}</td>
            <td colspan="8" style="width:50%!important;" >{{$sqoute->item}}</td>
            <td style="text-align: center;">{{$sqoute->unit}}</td>
            <td style="text-align: center;">{{$sqoute->bal_qnty}}</td>
           
          </tr>
          @endforeach
          
          
        </tbody>

      </table>
      <br/>
      <table>
       
        <tr>
          <td colspan="13"> {{$data1->remarks}}</td><br/>
          </tr>
        </table>
         <table>
          <tr><td colspan="2">Receiver Name</td>
            <td >:</td>
          <td colspan="11"></td>
          </tr>
        </table>
        <table>
          <tr><td colspan="2">Signature</td>
            <td >:</td>
          <td colspan="11"></td>
          </tr>
        </table>
        <table>
          <tr><td colspan="2">Delivery Site</td>
            <td >:</td>
          <td colspan="11"></td><br/>
          </tr>
        </table>
        
          
    
<table>
         <tr>
           <td>Issued By</td>
           <td>:</td>
         <td><b>{{$data1->executive}}</b></td></tr>
           <tr>
         </tr></table>




                  </div>