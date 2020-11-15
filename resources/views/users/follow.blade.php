@extends('layout.default')
@section('title', $title)

@section('content')
  <div class="offset-md-2 col-md-8">
    <h2 class="mb-4 text-center">{{ $title }}</h2>

    <div class="list-group list-group-flush">
      @foreach ($follows as $follow)
        <div class="list-group-item">
          <img class="mr-3" src="{{ $follow->gravatar() }}" alt="{{ $follow->name }}" width=32>
          <a href="{{ route('users.show', $follow) }}">
            {{ $follow->name }}
          </a>
        </div>

      @endforeach
    </div>

    <div class="mt-3">
      {{$follows->links()}}
    </div>
  </div>
@stop
