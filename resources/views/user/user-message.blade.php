@extends('layouts.prf')

@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Messages:</span>
            </div>
            <div class="card-body">
                @if(isset($messages))
                @foreach($messages as $message)
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2 col-2">
                            <div class="avatar">
                                <img src="{{asset('images/'.$message->user_avatar)}}" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                            </div>
                        </div>
                        <div class="col-md-10 col-10">
                            <div class="form-group">
                                <label for="name"><b>{{$message->name}}</b> &nbsp; <small>{{$message->cmt_date}}</small></label>
                                <textarea type="text" class="form-control" id="comments" name="comments">{{$message->comments}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
                @endif
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <form onsubmit="return false;" autocomplete="off" id="reply_message" method="POST">
                        @csrf
                        <input type="hidden" name="prf_id" id="prf_id" value="{{$prf->pr_id}}">
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="comments" name="comments" placeholder="Write message here"></textarea>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-envelope"> </i> Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            @if(isset($prf))
            <div class="card-header">
                <div class="text-center">
                    <h3>{{$prf->series}}</h3>
                    <p>{{Carbon\Carbon::parse($prf->date)->format('m/d/Y')}}</p>
                    <hr>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="form-row">
                        <div class="form-group col-md-6 text-left">
                            <label for="department" style="font-size: 13px;"><b>Department: </b></label>
                            <input type="text" class="form-control" id="department" name="department" value="{{$prf->department}}" style="background-color: #fff;" readonly>
                        </div>
                        <div class="form-group col-md-6 text-left">
                            <label for="project" style="font-size: 13px;"><b>To be used in <i style="font-size: 12px;">(Project Name)</i> </b> :</label>
                            <input type="text" class="form-control" id="project" name="project" value="{{$prf->project}}" style="background-color: #fff;" readonly>
                        </div>
                    </div><br>
                    <div class="form-row">
                        <div class="form-group col-md-12 text-left">
                            <label for="purpose" style="font-size: 13px;"><b>Specific Purpose or Usage:</b> </label>
                            <input type="text" class="form-control" id="purpose" name="purpose" value="{{$prf->purpose}}" style="background-color: #fff;" readonly>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                            <th style="display: none;">ID</th>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach($products as $key => $row)
                        <tr>
                            <td style="display: none;">{{$row->p_id}}</td>
                            <td class="key">{{++$key}}</td>
                            <td>{{$row->product}}</td>
                            <td>{{$row->quantity}}</td>
                            <td>{{$row->unit}}</td>
                            <td class="price-currency">{{$row->price}}</td>
                            <td class="total-currency">{{$row->total}}</td>
                            <input type="hidden" class="total" value="{{$row->total}}" />
                            <td>{{$row->remarks}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grand Total:</h4>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h1><span>&#8369; </span><span id="grandTotal">0.00</span></h1>
                </div>
            </div>
            <div class="card-footer text-center">
                @if(Auth::user()->id == $prf->user_id)
                <a href="{{route('user-resend', [$id=$prf->pr_id, $requestor=$prf->requestor])}}" class="btn btn-warning"><i class="fas fa-paper-plane"></i>&nbsp; Resend PRF</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

function grandTotal(){
    var grand = 0;
    
    $('.total').each(function(i, e){
        var amount = $(this).val()-0;
        grand += amount;
    });
    $('.price-currency').formatCurrency({symbol : ''});
    $('.total-currency').formatCurrency({symbol : '₱ '});
    $('#grandTotal').html(grand).formatCurrency({symbol: ''});
}

    grandTotal();

    $('#reply_message').on('submit', function(){
        $.ajax({
            url : '{{route("user-reply")}}',
            type : 'POST',
            data : $('#reply_message').serialize(),
            success : function(res){
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
        })
    });

    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });
</script>
@endsection
