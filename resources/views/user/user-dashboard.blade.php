@extends('layouts.prf')

@section('content')
  <div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
  </div>
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-list-ul text-warning"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Request</p>
                <p class="card-title">{{$req}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fas fa-eye"></i> <a href="{{route('user-request')}}" style="text-decoration: none;">View</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-tasks text-primary"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Requested PR</p>
                <p class="card-title">{{$requested}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fas fa-eye"></i> <a href="{{route('user-requested')}}" style="text-decoration: none;">View</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-thumbs-up text-success"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Approved PR</p>
                <p class="card-title">{{$approved}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fas fa-eye"></i> <a href="{{route('user-approved')}}" style="text-decoration: none;">View</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-thumbs-down text-danger"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Rejected PR</p>
                <p class="card-title">{{$rejected}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fas fa-eye"></i> <a href="{{route('user-rejected')}}" style="text-decoration: none;">View</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="row justify-content-center">
  @if(isset($last_pr))
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card">
      <div class="card-header">
        <span class="card-title">Your last PRF:</span>
      </div>
      <div class="card-body">
        <div class="text-center">
          <p>{{$last_requested}}</p>
          <h1><span>&#8369; </span><span id="grandTotal">@money($last_total)</span></h1>
          @if($status == "Approved")
          <h5 class="text-success"><i class="fas fa-check"></i> Approved</h5>
          <a href="{{route('view.prform', [$id=$send->pr_id, $requestor=$send->requestor])}}" type="button" class="btn btn-primary" id="send_btn"><i class="fas fa-eye"></i>&nbsp; view</a>
          @elseif($status == "Rejected")
          <h5 class="text-danger"><i class="fas fa-times"></i> Rejected</h5>
          <a href="{{route('user-message', [$id=$send->pr_id, $name=$send->requestor])}}" type="button" class="btn btn-primary" id="send_btn"><i class="fas fa-eye"></i>&nbsp; view</a>
          @elseif($status == "Requested")
          <h5 class="text-primary"><i class="fas fa-mug-hot"></i> Pending</h5>
          <a href="{{route('user-edit', [$id=$send->pr_id, $series=$send->series])}}" type="button" class="btn btn-primary" id="send_btn"><i class="fas fa-eye"></i>&nbsp; view</a>
          @else
          <h5> You did not send this PRF</h5>
          <a href="{{route('user-send', [$id=$send->pr_id, $requestor=$send->requestor])}}" type="button" class="btn btn-primary" id="send_btn"><i class="fas fa-eye"></i>&nbsp; view</a>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card">
      <div class="card-header">
        <span class="card-title">Grand Total of your Approved PRF:</span>
      </div>
      <div class="card-body">
        <div class="text-center">
          @if(isset($app))
          <h3><span>&#8369; </span><span id="grandTotal">@money($grand)</span></h3>
          @else
          <h3><span>&#8369; </span><span id="grandTotal">0.00</span></h3>
          @endif
          <a href="{{route('user-form')}}" type="button" class="btn btn-primary"><i class="fas fa-sticky-note"></i>&nbsp; ADD PRF</a>
        </div>
      </div>
    </div>
  </div>
  @if(isset($messages) && count($messages)>0)
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
                <a href="{{route('user-message', [$id=$message->pr_id, $name=$message->name])}}" id="{{$message->pr_id}}" role="button" class="btn btn-sm btn-outline-success btn-round btn-icon msgStatus"><i class="fa fa-envelope"></i></a>
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
