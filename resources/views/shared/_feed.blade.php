@if ($feeds->count() > 0)
  <ul class="list-unstyled">
    @foreach ($feeds as $status)
      @include('statuses._status',  ['user' => $status->user])
    @endforeach
  </ul>
  <div class="mt-5">
    {{$feeds->links()}}
  </div>
@else
  <p>没有数据！</p>
@endif
