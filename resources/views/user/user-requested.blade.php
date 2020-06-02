@extends('layouts.prf')

@section('search')
<form action="{{route('search-requested')}}" method="GET" class="form-inline md-form form-sm mt-0">
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
                            <td>{{$row->series}}</td>
                            <td>{{$row->project}}</td>
                            <td>{{$row->purpose}}</td>
                            <td>
                                <a href="{{route('user-edit', [$id=$row->pr_id, $series=$row->series])}}"  style="cursor: pointer; color: #51cbce;" class="viewData" data-content="Edit" rel="popover" data-placement="bottom">
                                    <i class="fas fa-edit" style="font-size: 20px;"></i>
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
{{$prform->links()}}

@endsection

@section('scripts')
<script type="text/javascript">
    
    $('.viewData').popover({ trigger: "hover focus"});
    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });
</script>
@endsection
