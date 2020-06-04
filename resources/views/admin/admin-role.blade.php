@extends('layouts.admin-prf')
@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"></h4>
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
                                <td>{{++$key}}</td>
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

<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="status" onsubmit="return false;">
                <div class="modal-body">
                    
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id="status_id" name="status_id" value="">
                    <div class="form-group">
                        <label for="reason">Reference</label>
                        <textarea type="text" class="form-control" id="checks_remarks" name="checks_remarks"></textarea>
                        <small id="e_reason" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{$users->links()}}

@endsection

@section('scripts')

<script type="text/javascript">
    
    $('.approveUser').popover({trigger : "hover focus"});
    
    
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
