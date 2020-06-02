@extends('layouts.admin-prf')

@section('search')
<form action="{{route('remove.search')}}" method="GET" class="form-inline md-form form-sm mt-0">
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
                            <th>Usage</th>
                            <th>Disapproval Date</th>
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
                            <td>{{$row->name}}</td>
                            <td>{{$row->project}}</td>
                            <td>{{$row->purpose}}</td>
                            <td>{{Carbon\Carbon::parse($row->status_date)->format('m-d-Y')}}</td>
                            <td>
                                <a href="{{route('admin-message', ['id' => $row->pr_id, 'name' => Auth::user()->name])}}" style="cursor: pointer; color: #51cbce;" class="viewData" data-content="View Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-eye" style="font-size: 20px;"></i>
                                </a>
                                <span style="cursor: pointer; color: #34eb80;" class="restoreData" data-content="Restore Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-trash-restore" style="font-size: 20px;"></i>
                                </span>&nbsp;
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
    $('.viewData').popover({trigger : "hover focus"});
    $('.restoreData').popover({trigger : "hover focus"});


    $('.restoreData').on('click', function(){
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();
        
        $('#status_id').val(data[0]);
        
        $('.overlay').show();
        
        $.ajax({
            url: "{{route('admin-restored')}}",
            type: "PUT",
            data: $('#status').serialize(),
            success: function(){
                $('.overlay').hide();
                swal("Success", "Restored Successfully", "success").then(function(){
                    window.location.href = "{{route('admin-pending')}}";
                });
            },
            error: function(){
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
