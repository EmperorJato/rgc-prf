@extends('layouts.admin-prf')


@section('content')
<div class="overlay">
  <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="row justify-content-center">
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="fas fa-business-time text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Total Pending Request</p>
              <p class="card-title">{{$pr}}</p>
            </div>
          </div>
        </div>
      </div>
        <div class="card-footer ">
          <hr>
          <div class="stats text-center">
            <i class="fas fa-eye"></i> <a href="{{route('admin-pending')}}" style="text-decoration: none;">View</a>
          </div>
        </div>
    </div>
  </div>
  <div class="col-lg-8 col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <span class="card-title">Grand Total of Pending PRF:</span>
      </div>
      <div class="card-body">
        <div class="text-center">
          @if(isset($prform))
          <h1><span>&#8369; </span><span id="grandTotal">@money($total)</span></h1>
          @else
          <h1><span>&#8369; </span><span id="grandTotal">0.00</span></h1>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  @if(isset($messages)) 
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card">
      <div class="card-header">
        <span class="card-title">Unread Messages</span>
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
              <div class="col-md-7 col-7">
                {{$message->name}}
                <br />
                <span class="text-muted"><small>{{$message->series}}</small></span>
              </div>
              <div class="col-md-3 col-3 text-right">
                <a href="{{route('admin-message', ['id' => $message->pr_id, 'name' => $message->name])}}" id="{{$message->pr_id}}" role="button" class="btn btn-sm btn-outline-success btn-round btn-icon msgStatus"><i class="fa fa-envelope"></i></a>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endif
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
      url : "{{route('admin-msg')}}",
      type : "PUT",
      data : $('#msg_user').serialize(),
      success : function(res){
        console.log(res)
      },
      error : function(err){
        console.log(err)
      }
    });
  });
  $(window).on('load', function() {
    $(".overlay").fadeOut(200);
  });
</script>
@endsection
