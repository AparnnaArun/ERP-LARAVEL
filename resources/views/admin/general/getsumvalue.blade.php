@foreach($sinv as $si)
 <input type="hidden" class="form-control"   id="sin1{{$si->executive}}" value="{{$si->sin1}}"  readonly >
 <input type="hidden" class="form-control"   id="sexec" value="{{$si->executive}}"  readonly >
@endforeach
@foreach($pinv as $pi)
 <input type="hidden" class="form-control"   id="pinvs{{$pi->executive}}" value="{{$pi->pinvs}}"  readonly >
 <input type="hidden" class="form-control"   id="pexec" value="{{$pi->executive}}" readonly >
@endforeach
@foreach($exe as $ex)
<input type="hidden" class="form-control"   id="exc{{$loop->iteration}}" value="{{$ex->short_name}}"  readonly >
@endforeach
