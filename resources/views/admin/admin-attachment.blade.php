
    @if(isset($attachments))
        <div class="row">
            @foreach($attachments as $attachment)
            <div class="col-md-6">
                <div class="card">
                    <div class="d-none">
                        {{$ext = pathinfo(asset('storage/attachments/'.$attachment->attach_path), PATHINFO_EXTENSION)}}
                    </div>
                    @if( $ext == 'jpg' ||  $ext == 'jpeg' ||  $ext == 'tiff' ||  $ext == 'gif' ||  $ext == 'png')
                        <img class="card-img-top" src="{{asset('storage/attachments/'.$attachment->attach_path)}}">
                    @else   
                        <img class="card-img-top" src="{{asset('images/attachment.png')}}" href="{{asset('storage/attachments/'.$attachment->attach_path)}}">
                    @endif
                    <div class="card-body" style="height: 80px;">
                        <p class="card-text">{{$attachment->attach_name}}</p>
                    </div>
                  </div>
            </div>
            @endforeach
        </div>
    @else
    <h4 class="text-center">No Product Found</h4>
    @endif


