@extends('layouts.admin-prf')

@section('search')
<form action="{{route('pending.search')}}" method="GET" class="form-inline md-form form-sm mt-0">
    <div class="input-group no-border">

        <input type="search" id="search" name="search" value="" class="form-control" placeholder="Search...">
        <div class="input-group-append">
            <button type="submit"  class="btn-sm btn-outline-info"><i class="fas fa-search"></i> </button>
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
                            <td>
                                <a href="{{route('admin-view', [$id=$row->pr_id, $requestor=$row->requestor])}}" style="cursor: pointer; color: #51cbce;" class="viewData" data-content="View Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-eye" style="font-size: 15px;"></i>
                                </a>&nbsp;
                                <a href="{{route('view.pdf', [$id=$row->pr_id, $requestor=$row->requestor])}}" target="_blank" style="cursor: pointer; color: #51cbce;" class="viewPDF" data-content="View PDF" rel="popover" data-placement="bottom">
                                    <i class="fas fa-file-pdf" style="font-size: 15px;"></i>
                                </a>&nbsp;
                                @if(isset($row->attachment_id))
                                <span style="cursor: pointer; color: #34eb80;" class="attach" data-content="View Attachment" rel="popover" data-placement="bottom">
                                    <i class="fas fa-paperclip" style="font-size: 15px;"></i>
                                </span>
                                @else
                                <span href="" target="_blank" style="color: #51cbce;" class="noAttach" data-content="No Attachment Found" rel="popover" data-placement="bottom">
                                    <i class="fas fa-paperclip" style="font-size: 15px;"></i>
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">PRF Attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <input type="hidden" id="attachment_id" name="attachment_id">
                        <div id="attachs" style="display: none;">
                            @include('admin.admin-attachment')
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
@endsection
@section('scripts')
<script type="text/javascript">
    $('.viewData').popover({trigger : "hover focus"});
    $('.viewPDF').popover({trigger : "hover focus"});
    $('.attach').popover({trigger : "hover focus"});
    $('.noAttach').popover({trigger : "hover focus"});
    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });
    
    $('.attach').on('click', function(){
        $('#attachs').show();
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();

        $('#attachment_id').val(data[0]);

        let attachment_id = $('#attachment_id').val();
        $(".overlay").show();
        $.ajax({
            url : "{{route('show-attachment')}}",
            type : "GET",
            data : {'attachment_id' : attachment_id},
            success: function(e){
                $('#attachs').html(e);
                $('img').EZView();
                $(".overlay").fadeOut(200);
            },
            error: function(e){     
                console.log(e);
            }
        });
        $('#modalAttachment').modal('show');
    });
</script>
@endsection
