
    @foreach($childs as $child)
        <tr>
            
            	
                <td>
            	<span  >{{ $child->seqnumber }}</span>
            	
            	
          </td>
               <td style="color:blue;" class="text-uppercase">{{ $child->name }}</td>
               <td></td>
               <td></td>
               <td>{{$child->sum_adv}}</td>
               <td></td>
               <td></td>
               <td></td>
            
        </tr>
        <tr>
           <td>@if(count($child->childs))
               <span style="color:green;" class="text-uppercase" > @include('child',['childs' => $child->childs])</span>
            @endif
         </td>
            <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
        </tr>
    @endforeach
