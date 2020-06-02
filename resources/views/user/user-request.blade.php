@extends('layouts.prf')

@section('search')
<form action="{{route('search-request')}}" method="GET" class="form-inline md-form form-sm mt-0">
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
                            <th>Project</th>
                            <th>Usage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prform as $key => $row)
                        <tr id="{{$row->pr_id}}">
                            <td style="display: none;">{{$row->pr_id}}</td>
                            <td>{{$prform->firstItem() + $key}}</td>
                            <td>{{Carbon\Carbon::parse($row->date)->format('m-d-Y')}}</td>
                            <td>{{$row->project}}</td>
                            <td>{{$row->purpose}}</td>
                            <td>
                                <a href="{{route('user-send', [$id=$row->pr_id, $requestor=$row->requestor])}}" style="cursor: pointer; color: #51cbce;" class="approvalData" data-content="Send Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-paper-plane" style="font-size: 20px;"></i>
                                </a>&nbsp;
                                <span style="cursor: pointer; color:red;" class="deleteData" data-content="Delete" rel="popover" data-placement="bottom">
                                    <i class="fas fa-trash" style="font-size: 20px;"></i>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{$prform->links()}} 
<form id="del_req" style="display: none;">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <input type="hidden" id="req_id" name="req_id">
</form>

@endsection

@section('scripts')
<script type="text/javascript">

    $('.viewData').popover({ trigger: "hover focus"});
    $('.approvalData').popover({ trigger: "hover focus"});
    $('.deleteData').popover({ trigger: "hover focus"});

    $('.deleteData').on('click', function(){
        let parents = $(this).parent().parent();
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();
        
        $('#req_id').val(data[0]);

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this item",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                   url: "{{route('request.delete')}}",
                   type: "PUT",
                   data: $('#del_req').serialize(),
                   success: function(){
                        swal('Success', 'Deleted Successfully', 'success').then(function(){
                            window.location.reload();
                        });
                   },
                    error: function(){
                        $('.overlay').hide();
                        swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
                    }
                });
            }
        });
    });

    $('.viewData').on('click', function(){

        $(this).popover('dispose');
        
    });

    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });
</script>
@endsection
