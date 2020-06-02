@extends('layouts.prf')

@section('content')
<div class="overlay">
  <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="content">
  <div class="row">
    <div class="col-md-4">
      <div class="card card-user">
        <div class="image">
          <img src="{{asset('images/profile_bg.jpg')}}" alt="...">
        </div>
        <div class="card-body">
          <div class="author">
            <span>
              <img class="avatar border-gray" src="{{asset('images/'.$user->user_avatar)}}" alt="...">
              <h5 class="title">{{$user->name}}</h5>
            </span>
            <p class="description">
              <hr>
            </p>
          </div>
          <form id="upload_image" method="POST" onsubmit="return false;">
            @csrf
            <div class="text-center">
              <div class="file-loading">
                <input id="upload" name="upload" type="file" accept="image/*">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card card-user">
        <div class="card-header">
          <h5 class="card-title">Edit Profile</h5>
        </div>
        <div class="card-body">
          <form id="edit_profile" onsubmit="return false;" autocomplete="off">
            {{method_field('PUT')}}
            @csrf
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="fullname" value="{{$user->name}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" disabled name="username" value="{{$user->username}}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" disabled name="email"  value="{{$user->email}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="update ml-auto mr-auto">
                <button type="submit" class="btn btn-primary btn-round">Update Profile</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
  
  $("#upload").fileinput({
    theme : "fas",
    dropZoneEnabled: false,
    showCaption: false,
    autoReplace: true,
    overwriteInitial: true,
    showUploadedThumbs: false,
    initialPreviewShowDelete: false,
    browseLabel: "Upload Image",
    maxFilePreviewSize: 40000,
    maxFileSize: 40000,
  });
  
  $('#upload_image').on('submit', function(){
    $('.overlay').show();
    var formData = new FormData($('#upload_image')[0]);
    
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url : "{{ route('user.upload-image') }}",
      type : "POST",
      data: formData,
      contentType : false,
      processData : false,
      cache : false,
      success: function(e){
        $('.overlay').hide();
        swal(
        'Good job!',
        'Saved Successfully',
        'success'
        ).then(function(e){
          location.reload();
        });
      },
      error: function(e){
        $('.overlay').hide();
        swal({
          icon: "error",
          title : "Error",
          text : e
        })
      }
    });
  });

  $('#edit_profile').on('submit', function(){
    $.ajax({
      url : "{{route('user.save-profile')}}",
      type : "PUT",
      data : $('#edit_profile').serialize(),
      success: function(e){
        $('.overlay').hide();
        swal(
        'Good job!',
        'Saved Successfully',
        'success'
        ).then(function(e){
          location.reload();
        });
      },
      error: function(e){
        $('.overlay').hide();
        swal({
          icon: "error",
          title : "Error",
          text : e
        })
      }
    });
  });
  
  
  $(window).on('load', function() {
    $(".overlay").fadeOut(200);
  });
</script>
@endsection
