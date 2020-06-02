@extends('layouts.admin-prf')

@section('search')
<form action="{{route('check.search')}}" method="GET" class="form-inline md-form form-sm mt-0">
    <div class="input-group no-border">
        <input type="search" id="search" name="search" value="" class="form-control" placeholder="Search...">
        <div class="input-group-append">
            <button type="submit"  class="btn-sm btn-outline-info"><i class="fas fa-search"></i></button>
        </div>
    </div>
</form>
@endsection

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
            <div class="table">
                <table class="table">
                    <thead class=" text-primary">
                        <tr>
                            <th style="display: none;">ID</th>
                            <th>#</th>
                            <th>Date</th>
                            <th>Series</th>
                            <th>Requestor</th>
                            <th>Project</th>
                            <th>Reference</th>
                            <th>Approval Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prform as $key => $row)
                        <tr>
                            <td style="display: none;">{{$row->pr_id}}</td>
                            <td>{{++$key}}</td>
                            <td>{{Carbon\Carbon::parse($row->date)->format('m-d-Y')}}</td>
                            <td>{{$row->series}}</td>
                            <td>{{$row->requestor}}</td>
                            <td>{{$row->project}}</td>
                            <td>{{$row->checks_remarks}}</td>
                            <td>{{Carbon\Carbon::parse($row->status_date)->format('m-d-Y')}}</td>
                            <td>
                                <a href="{{route('view.admin-prform', [$id=$row->pr_id, $requestor=$row->requestor])}}" style="cursor: pointer; color: #51cbce;" class="approveData" data-content="View Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-eye" style="font-size: 15px;"></i>
                                </a>&nbsp;
                                <a href="#" style="cursor: pointer; color: #51cbce;" class="editData" data-content="Edit Reference" rel="popover" data-placement="bottom">
                                    <i class="fas fa-edit" style="font-size: 15px;"></i>
                                </a>&nbsp;
                                <a href="#" style="cursor: pointer; color: #34eb80;" class="revertData" data-content="Revert" rel="popover" data-placement="bottom">
                                    <i class="fas fa-history" style="font-size: 15px;"></i>
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

<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="status_edit" onsubmit="return false;">
                <div class="modal-body">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id="edit_id" name="edit_id" value="">
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

<form id="status" style="display: none;">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <input type="hidden" id="status_id" name="status_id" value="">
</form>



{{$prform->links()}}

@endsection

@section('scripts')

<script type="text/javascript">

    $('.approveData').popover({trigger : "hover focus"});
    $('.editData').popover({trigger : "hover focus"});
    $('.revertData').popover({trigger : "hover focus"});

    $('.revertData').on('click', function(){

        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();
        
        $('#status_id').val(data[0]);

        swal({
            title: "Revert?",
            text: "Restore to its approved status",
            icon: "info",
            buttons: true,
        })
        .then((willRestore) => {
            if (willRestore) {
                $('.overlay').show();
                $.ajax({
                    url : "{{route('admin.revert')}}",
                    type : "PUT",
                    data : $('#status').serialize(),
                    success : function(){
                        $('.overlay').hide();
                        swal("Success", "Reverted Successfully", "success").then(function(){
                            $('.overlay').show();
                            window.location.href = "{{route('admin-approved')}}";
                        });
                    },
                    error : function(){
                        $('.overlay').hide();
                        swal("Error", "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
                    }
                });
            }
        });
    });
    
    $('.editData').on('click', function(){

        $('#checkModal').modal('show');
        
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();

        $('#edit_id').val(data[0]);
        $('#checks_remarks').val(data[6]);

    });
    
    $('#status_edit').on('submit', function(){
        $.ajax({
            url : "{{route('admin.edit')}}",
            type : "PUT",
            data : $('#status_edit').serialize(),
            success : function(){
                $('.overlay').hide();
                swal("Success", "Updated Successfully", "success").then(function(){
                    $('.overlay').show();
                    window.location.reload();
                });
            },
            error : function(){
                $('.overlay').hide();
                swal("Error", "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
            }
        });
        
    });
    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });

</script>

@endsection
