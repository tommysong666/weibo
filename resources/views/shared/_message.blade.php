@foreach(['success','danger','warning','info','status'] as $msg)
@if(session()->has($msg))
  <div class="alert alert-{{$msg}}" role="alert">
    <strong>{{session()->get($msg)}}</strong>
  </div>
@endif
@endforeach
