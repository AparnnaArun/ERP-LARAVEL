<ul>
    @foreach($childs as $child)
        <li>
            
            	@if($child->accounttype=='s1')
            	<span style="color:blue;" class="text-uppercase" >{{ $child->name }}</span>
            	@if(count($child->childs))
               <span style="color:green;" class="text-uppercase" > @include('manageChild',['childs' => $child->childs])</span>
            @endif
            	@else
            	<span style="color:green;" class="text-uppercase" >{{ $child->name }}</span>
            	@if(count($child->childs))
               <span style="color:green;" class="text-uppercase" > @include('manageChild',['childs' => $child->childs])</span>
            @endif
               @endif
            
        </li>
    @endforeach
</ul>