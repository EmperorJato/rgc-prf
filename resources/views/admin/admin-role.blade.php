@extends('layouts.admin-prf')
@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="float-right">
                <button class="btn btn-success" id="addUser">Add User</button>
            </div>
            <h4 class="card-title">Accounts</h4>
        </div>
        <div class="card-body">
            <div style="overflow-x:auto;">
                <div class="table">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th style="display: none;">ID</th>
                                <th>#</th>
                                <th>Date Created</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $row)
                            <tr>
                                <td style="display: none;">{{$row->id}}</td>
                                <td>{{($users->currentpage()-1) * $users->perpage() + ++$key}}</td>
                                <td>{{Carbon\Carbon::parse($row->created_at)->format('m-d-Y')}}</td>
                                <td>{{$row->name}}</td>
                                <td>
                                    <a style="cursor: pointer; color: #6bd098;" class="approveUser" data-content="Approve User" rel="popover" data-placement="bottom">
                                        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Register</a>
                          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Share Link</a>
                        </div>
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <span id="form_result"></span>
                            <form method="POST" onsubmit="return false;" id="registerUser">
                                {{csrf_field()}}
                                <div class="form-group row mt-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>                           
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmed Password') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                    <div class="col-md-6">
                                        <select class="custom-select" name="user_type" id="user_type">
                                            <option value="user" selected>User</option>
                                            <option value="admin">Admin</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-user-plus"> </i>
                                        {{ __('Register') }}
                                    </button>
                                </div>
                        </form>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="https://prf-rgc.ribshack.info/register">
                                </div>
                            </div>
                        </div>
                      </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

{{$users->links()}}

@endsection

@section('scripts')

<script type="text/javascript">
    
    $('.approveUser').popover({trigger : "hover focus"});

    $('#addUser').on('click', function(){
        $('#showModal').modal('show');
        
        $('#registerUser').on('submit', function(){
            $.ajax({
                url: "{{ route('admin.create') }}",
                type: "POST",
                data: $('#registerUser').serialize(),
                success: function(res){
                    console.log(res)
                    let html = '';
                    if(res.errors){
                        html = '<div class="alert alert-danger">';
                        for(let count = 0; count < res.errors.length; count++){
                            html += '<p>' + res.errors[count] + '</p>';
                        }
                        html += '</div>';
                    } else {

                        swal("Success", "Registered Successfully", "success").then(function(){
                            location.reload();
                        });
                    }

                    $('#form_result').html(html);
                },
                error: function(err){
                    console.log(err)
                },
            })
        })
        
    });
    
    
    $('.approveUser').on('click', function(){
        
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();
        
        swal({
            text: "Approve User?",
            icon: "info",
            buttons: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{route('admin.approveUser')}}",
                    type : "PUT",
                    
                    data : {'approveID' : data[0]},
                    success : function(){
                        swal("Success", "", "success").then(function(){
                            location.reload();
                        });
                        
                    },
                    error: function(err){
                        $('.overlay').hide();
                        swal("Error", err, "error");
                    }
                    
                })
            }
        });
    });
    
    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });
    
</script>

@endsection
