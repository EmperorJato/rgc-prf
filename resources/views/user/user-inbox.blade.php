@extends('layouts.prf')


@section('content')
<div class="overlay">
  <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title text-center">Inbox</h5>
        <hr>
      </div>
      <div class="card-body">
        <ul class="list-unstyled team-members">
          @foreach($messages as $message)
          <li>
            <div class="row">
              <div class="col-md-2 col-2">
                <div class="avatar">
                  <img src="{{asset('images/'.$message->user_avatar)}}" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-5 col-5">
                {{$message->name}}
                <br />
                <span class="text-muted"><small>{{$message->series}}</small></span>
              </div>
              <div class="col-md-2 col-2">
                {{Carbon\Carbon::parse($message->msg_status_date)->format('M d, Y')}}
              </div>
              <div class="col-md-3 col-3 text-right">
                @if($message->msg_status == 0)
                <a href="{{route('user-message', ['id' => $message->pr_id, 'name' => $message->name])}}" id="{{$message->pr_id}}" role="button" class="btn btn-sm btn-outline-success btn-round btn-icon msgStatus"><i class="fa fa-envelope"></i></a>
                @else
                <a href="{{route('user-message', ['id' => $message->pr_id, 'name' => $message->name])}}" id="{{$message->pr_id}}" role="button" class="btn btn-sm btn-outline-danger btn-round btn-icon msgStatus"><i class="fa fa-envelope-open"></i></a>
                @endif
              </div>
            </div>
          </li>
          <hr>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
<form onsubmit="return false;" id="msg_user">
  {{method_field('PUT')}}
  @csrf
  <input type="hidden" id="prf_id" name="prf_id" value="">
</form>
@endsection

@section('scripts')
<script type="text/javascript">
  $('.msgStatus').on('click', function(){
    let id = $(this).attr('id');
    $('#prf_id').val(id);
    
    $.ajax({
      url : "{{route('msg.status-user')}}",
      type : "PUT",
      data : $('#msg_user').serialize(),
      success : function(res){
        console.log(res)
      },
      error : function(err){
        console.log(err)
      }
    });
    
  })
  $(window).on('load', function() {
    $(".overlay").fadeOut(200);
  });
</script>
@endsection
