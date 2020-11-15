@can('follow',$user)
  <div class="text-center mt-2 mb-4">
    @if(Auth::user()->isFollowing($user->id))
      <form action="{{route('followers.destroy',$user)}}" method="post">
        {{csrf_field()}}
        {{method_field('delete')}}
        <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
      </form>
    @else
      <form action="{{route('followers.store',$user)}}" method="post">
        {{csrf_field()}}
        <button type="submit" class="btn btn-sm btn-outline-primary">关注</button>
      </form>
  </div>
  @endif
@endcan
