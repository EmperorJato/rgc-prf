@extends('layouts.sa-prf')

@section('search')
<form action="#" method="GET" class="form-inline md-form form-sm mt-0">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($prform as $key => $row)
                        <tr>
                            <td style="display: none;">{{$row->pr_id}}</td>
                            <td>{{++$key}}</td>
                            <td>{{Carbon\Carbon::parse($row->date)->format('m-d-Y')}}</td>
                            <td>{{$row->series}}</td>
                            <td>{{$row->requestor}}</td>
                            <td>{{$row->project}}</td>
                            <td>
                                <a href="{{route('admin-view', [$id = $row->pr_id, $requestor = $row->requestor])}}" style="cursor: pointer; color: #51cbce;" class="viewData" data-content="View Request" rel="popover" data-placement="bottom">
                                    <i class="fas fa-eye" style="font-size: 20px;"></i>
                                </a>&nbsp;
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<form id="status">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <input type="hidden" id="status_id" name="status_id" value="">
    <input type="hidden" id="requestor" name="requestor" value="">
</form>

{{-- {{$prform->links()}} --}}

@endsection

@section('scripts')
<script type="text/javascript">

    $('.viewData').popover({trigger : "hover focus"});
 
</script>
@endsection
