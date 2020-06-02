@extends('layouts.prf')

@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="container">
  <div class="card">
    <div class="row justify-content-center border m-2 p-2">
        <div class="col-md-4 col-4 mt-3">
            <img src="{{asset('images/'.$view_msg->user_avatar)}}" alt="Circle Image" class="img-responsive" style="width: 50px;">
        </div>
        <div class="col-md-8 col-8 mt-4">
            <strong>{{$view_msg->name}}</strong>
        </div>
    </div>
    <div class="card-body">
      <ul class="list-unstyled team-members">
        @if(isset($msgs))
        @foreach($msgs as $msg)
        <li>
          <div class="row justify-content-center border m-2 p-2">
            <div class="col-md-2 col-2 mt-3">
                <img src="{{asset('images/'.$msg->user_avatar)}}" alt="Circle Image" class="img-responsive" style="width: 50px;">
            </div>
            <div class="col-md-7 col-7 mt-4">
              <strong>{{$msg->name}}</strong>
            </div>
            <div class="col-md-3 col-3 text-right mt-2">
              <a href="#" id="{{$msg->pr_id}}" role="button" class="btn btn-sm btn-outline-success btn-round btn-icon msgStatus"><i class="fa fa-envelope"></i></a>
            </div>
          </div>
        </li>
        @endforeach
        @else
        <li>No new messages</li>
        @endif
      </ul>
    </div>
    <div class="card-footer">
      
    </div>
  </div>
  <div class="modal fade" id="write_msg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form onsubmit="return false;" autocomplete="off" id="reply_message" method="POST">
        <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="recipient">Recipient</label>
              <input type="hidden" class="form-control" id="recipient_id" name="recipient_id">
              <input type="text" class="form-control" id="recipient" name="recipient">
              <small id="e_recipient" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea type="text" class="form-control" id="msg_input" name="msg_input" placeholder="Write message here"></textarea>
              <small id="e_msg_input" class="form-text text-muted"></small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-envelope"> </i> Send Message</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $('#create_msg').on('click', function(){
    $('#write_msg').modal('show');
  });

  $('#reply_message').on('submit', function(){
    let recipient = $('#recipient');
    let msg_input = $('#msg_input');
    let recipient_status = false;
    let msg_status = false;

    if(recipient.val() == "" ||  $('#recipient_id').val() == ""){
      $('#recipient_id').val("");
      recipient.addClass('border-danger');
      $('#e_recipient').html('<span class="text-danger"><strong>Recipient is required<strong></span>');
      recipient_status = false;
    } else {
      recipient.removeClass('border-danger');
      $('#e_recipient').html('');
      recipient_status = true;
    }

    if(msg_input.val() == ""){
      msg_input.addClass('border-danger');
      $('#e_msg_input').html('<span class="text-danger"><strong>Message is required<strong></span>');
      msg_status = false;
    } else {
      msg_input.removeClass('border-danger');
      $('#e_msg_input').html('');
      msg_status = true;
    }

    if(recipient_status && msg_status == true){

      $.ajax({
      url : "{{route('to-recipient')}}",
      type : "POST",
      data : $('#reply_message').serialize(),
      success: function(res){
        swal({
          icon : 'success',
          title : 'Success',
          text : 'Send Successfully.'
        }).then(function(){
          location.reload();
        });
      },
      error : function(err){
        console.log(err);
      }
    });

    }

  });

  let rec = "{{route('recipient')}}";
  $('#recipient').typeahead({
    items: 5,
    source: function(recipient, process){
      $.ajax({
        url : rec,
        type : "GET",
        data : {recipient: recipient},
        success : function(data){
          if(data.length == 0){
            $('#recipient_id').val("");
          }
          return process(data);
        },
      });
    },
    autoSelect: true,
    displayText: function(item){
      $('#recipient_id').val(item.id);
      return item.name;
    }
  });

  $(window).on('load', function() {
    $(".overlay").fadeOut(200);
  });
</script>
          
@endsection


