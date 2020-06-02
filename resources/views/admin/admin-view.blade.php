@extends('layouts.admin-prf')

@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="card">
    @if(isset($prforms))
    <div class="card-header" style="margin-bottom: -12px;">
        <input type="hidden" id="requestor" name="requestor" value="{{$prforms->requestor}}">
        <h3 class="card-title text-center">{{$prforms->requestor}}</h3>
        <div class="text-center">
            {{$prforms->series}}<br>
            {{Carbon\Carbon::parse($prforms->date)->format('m/d/Y')}}
        </div>
    </div>
    <div class="card-body">
        <hr>
        <input type="hidden" id="pr_id" name="pr_id" value="{{$prforms->pr_id}}">
        <div class="form-row">
            <div class="form-group col-md-6">
                <p for="department" style="font-size: 18px;">Department: </p>
                <input type="text" class="form-control" id="department" name="department" value="{{$prforms->department}}" style="background-color: #fff;" readonly>
            </div>
            <div class="form-group col-md-6">
                <p for="project" style="font-size: 18px;">To be used in <i style="font-size: 12px;">(Project Name)</i> :</p>
                <input type="text" class="form-control" id="project" name="project" value="{{$prforms->project}}" style="background-color: #fff;" readonly>
            </div>
        </div><br>
        <div class="form-row">
            <div class="form-group col-md-12">
                <p for="purpose" style="font-size: 18px;">Specific Purpose or Usage: </p>
                <input type="text" class="form-control" id="purpose" name="purpose" value="{{$prforms->purpose}}" style="background-color: #fff;" readonly>
            </div>
        </div>
    </div>
    @else
    <h4 class="text-center">No Product Found</h4>
    @endif
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
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
                            <th>Action</th>
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
                            <td>
                                <span style="cursor: pointer; color: #51cbce;" class="editData" data-content="Edit" rel="popover" data-placement="bottom">
                                    <i class="fas fa-edit" style="font-size: 20px;"></i>
                                </span>&nbsp;
                                <span style="cursor: pointer; color:red;" class="deleteData" data-content="Delete" rel="popover" data-placement="bottom">
                                    <i class="fas fa-trash" style="font-size: 20px;"></i>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-success btn-sm" id="showAdd"><i class="fas fa-cart-plus"></i>&nbsp; Add Product</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_form" onsubmit="return false;">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product">Product</label>
                                <input type="text" class="form-control" id="edit_product" name="edit_product">
                                <small id="err_product" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" id="edit_unit" name="edit_unit">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control" id="edit_quantity" name="edit_quantity">
                                <small id="err_quantity" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="edit_price" name="edit_price">
                                <small id="err_price" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="edit_remarks" name="edit_remarks"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="text" class="form-control" id="edit_totalCurrency" style= "background-color: #fff;" value="" readonly>
                                <input type="hidden" class="form-control" id="edit_total" style= "background-color: #fff;" value="" name="edit_total" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Reason for rejecting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reason_form" onsubmit="return false;">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id="reason_id" name="reason_id">
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <textarea type="text" class="form-control" id="reason" name="reason" required></textarea>
                        <small id="e_reason" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="reasonChanges">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="form_product" name="form_product" onsubmit="return false;">
    {{csrf_field()}}
    {{method_field('POST')}}
    <input type="hidden" id="prform_id" name="prform_id" value="">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="product">Product</label>
                        <input type="text" class="form-control" id="product" name="product">
                        <small id="e_product" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="">
                        <small id="e_quantity" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" value="">
                        <small id="e_price" class="form-text text-muted"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks" name="remarks"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="totalCurrency" style= "background-color: #fff;" value="" readonly>
                        <input type="text" class="form-control" id="total" style= "background-color: #fff;" name="total" value="" hidden>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success" id="addProduct"><i class="fas fa-cart-plus"></i>&nbsp; Add</button>
                <button type="button" class="btn btn-danger" id="cancelChanges"><i class="fas fa-window-close"></i>&nbsp; Cancel</button>
              </div>
        </div>
    </div>
</form>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">PRF Attachment:</h5>
              </div>
            <div class="card-body">
                <div class="row">
                    @foreach($attachments as $attachment)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="d-none">
                                {{$ext = pathinfo(asset('storage/attachments/'.$attachment->attach_path), PATHINFO_EXTENSION)}}
                            </div>
                            @if( $ext == 'jpg' ||  $ext == 'jpeg' ||  $ext == 'tiff' ||  $ext == 'gif' ||  $ext == 'png')
                                <img class="card-img-top" src="{{asset('storage/attachments/'.$attachment->attach_path)}}">
                            @else
                                <img class="card-img-top" src="{{asset('images/attachment.png')}}" href="{{asset('storage/attachments/'.$attachment->attach_path)}}">
                            @endif
                            <div class="card-body" style="height: 150px;">
                                <input type="hidden" id="attach-id{{$attachment->attach_id}}" name="attach-id" value="{{$attachment->attach_id}}">
                                <input type="hidden" id="attach-path{{$attachment->attach_id}}" name="attach-path" value="{{$attachment->attach_path}}">
                                <p class="card-text">{{$attachment->attach_name}}</p>
                                <button type="button" id="{{$attachment->attach_id}}" class="btn btn-danger attachDelete" style="position: absolute; bottom: 0;"><i class="fas fa-trash"></i> Delete</a>
                            </div>
                          </div>
                    </div>
                    @endforeach
                </div>
                <form id="delete-attachment" name="delete-attachment" method="DELETE">
                    @csrf
                    <input type="hidden" id="attachment-id" name="attachment-id" value="">
                    <input type="hidden" id="attachment-path" name="attachment-path" value="">
                </form>
            </div>
            <div class="card-footer">
                <form method="POST" id="edit-attachment" name="edit-attachment" enctype="multipart/form-data">
                    <input type="hidden" id="pr-id" name="pr-id" value="{{$prforms->pr_id}}">
                        <div class="file-loading">
                            <input id="attachments" name="attachments[]" type="file" multiple accept="application/pdf, image/*">
                        </div>
                    <button type="button" id="save-attachment" class="btn btn-success" style="display: none; margin-top : 5px;">
                        <i class="fas fa-save"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Grand Total:</h4>
        </div>
        <div class="card-body">
            <form id="status">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <input type="hidden" id="status_id" name="status_id" value="">
            </form>
          <div class="text-center">
            <h1><span>&#8369; </span><span id="grandTotal">0.00</span></h1>
            <button type="button" class="btn btn-primary" id="approve_btn"><i class="fas fa-thumbs-up"></i>&nbsp; Approve</button>
            <button type="button" class="btn btn-danger" id="remove_btn"><i class="fas fa-thumbs-down"></i>&nbsp; Reject</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form id="delete_product" style="display: none;">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <input type="hidden" id="delete_id" name="delete_id">
  </form>

@endsection

@section('scripts')
<script type="text/javascript">

    function grandTotal(){
        var grand = 0;
        
        $('.total').each(function(i, e){
            var amount = $(this).val()-0;
            grand += amount;
        });
        
        $('#grandTotal').html(grand).formatCurrency({symbol: ''});
    }

    function press(){
        $('#form_product').on('keyup', '#quantity, #price, #remarks', function(){
            let quantity = $('#quantity').val();
            let price = $('#price').val();
            let total = (price * quantity);
            $('#total').val(total);
            $('#totalCurrency').val(total).formatCurrency({symbol : '₱ '});
            
        });

    }
    $('#quantity').numeric();
    $('#price').numeric();
    $('.editData').popover({ trigger: "hover focus"});
    $('.deleteData').popover({ trigger: "hover focus"});
    $('#form_product').hide();
    $('.price-currency').formatCurrency({symbol : ''});

    $('.total-currency').formatCurrency({symbol : '₱ '});

    grandTotal();

    $('#approve_btn').on('click', function(){
        let pr_id = $('#pr_id').val();
        $('#status_id').val(pr_id);
        let status_id = $('#status_id').val();
        let requestor = $('#requestor').val();
        $('.overlay').show();
        $.ajax({
            url: "{{route('admin.approve')}}",
            type: "PUT",
            data: $('#status').serialize(),
            success: function(){
                $('.overlay').hide();
                swal("Success", "Successfully Approved", "success").then(function(){
                    swal({
                        title: "View PDF",
                        text: "Would you like to print this request?",
                        icon: "info",
                        buttons: true,
                        closeOnClickOutside: false
                    }) 
                    .then((willDelete) => {
                        if (willDelete) {
                            window.open("/print/"+pr_id+"/"+requestor+"", "_blank");
                            $('.overlay').show();
                            window.location.href = "{{route('admin-pending')}}";
                        } else {
                            $('.overlay').show();
                            window.location.href = "{{route('admin-pending')}}";
                        }
                    });
                });  
            },
            error: function(){
                $('.overlay').hide();
                swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
            }
        });
    });

    $('#remove_btn').on('click', function(){

        $('#reasonModal').modal('show');
        let pr_id = $('#pr_id').val();
        $('#reason_id').val(pr_id);
        let reason_id = $('#reason_id').val();

    });

    $('#showAdd').on('click', function(){
        let pr_id = $('#pr_id').val();
        $('#saveChanges').show();
        $('#form_product').show();
        $('#product').focus();
        $('#prform_id').val(pr_id);
      });

    $('.editData').on('click', function(){
        $('#edit_quantity').numeric();
        $('#edit_price').numeric();

        $('#editModal').modal('show');
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $('#edit_id').val(data[0]);
        $('#edit_product').val(data[2]);
        $('#edit_quantity').val(data[3]);
        $('#edit_unit').val(data[4]);
        $('#edit_price').val(data[5]);
        $('#edit_total').val(parseFloat($('#edit_quantity').val()) * parseFloat($('#edit_price').val()));
        $('#edit_totalCurrency').val(data[6]).formatCurrency({symbol : '₱ '});
        $('#edit_remarks').val(data[7]);

        $('#edit_form').on('keyup', '#edit_quantity, #edit_price, #edit_remarks', function(){
            
            let quantity = $('#edit_quantity').val();
            let price = $('#edit_price').val();
            let total = (price * quantity);
            $('#edit_total').val(total);
            $('#edit_totalCurrency').val(total).formatCurrency({symbol : '₱ '});
            
        });

    });

    $('#cancelChanges').on('click', function(){
        $('#form_product').find(':input').val('');
        $('#form_product').hide();
    });

    press();

    $('#form_product').on('submit', function(){
        
        let pr_id = $('#pr_id').val();
        let product = $('#product').val();
        let quantity = $('#quantity').val();
        let price = $('#price').val();
        let totalCurrency = $('#totalCurrency').val();
        let productStatus = false;
        let quantityStatus = false;
        let priceStatus = false;
        
        
        if(product == ""){
            $('#product').addClass('border-danger');
            $('#e_product').html('<strong><span class="text-danger">Product is required</span></strong>');
            productStatus = false;
        } else {
            $('#product').removeClass('border-danger');
            $('#e_product').html('');
            productStatus = true;
        }
        
        if(quantity == ""){
            $('#quantity').addClass('border-danger');
            $('#e_quantity').html('<strong><span class="text-danger">Quantity is required</span></strong>');
            quantityStatus = false;
        } else {
            $('#quantity').removeClass('border-danger');
            $('#e_quantity').html('');
            quantityStatus = true;
        }
        
        if(price == ""){
            $('#price').addClass('border-danger');
            $('#e_price').html('<strong><span class="text-danger">Price is required</span></strong>');
            priceStatus = false;
        } else {
            $('#price').removeClass('border-danger');
            $('#e_price').html('');
            priceStatus = true;
        }
        
        if((productStatus && quantityStatus && priceStatus) == true){
            
            $('#addProduct').prop("disabled", true);
            $('#prform_id').val(pr_id);
            $('.overlay').show();
            $.ajax({
                url : "{{route('admin.add')}}",
                type: "POST",
                data: $('#form_product').serialize(),
                success: function(){
                    $('.overlay').hide();
                    swal('Success', "Added Successfully", "success").then(function(){
                        $('.overlay').show();
                        location.reload();
                    });
                },
                error: function(){
                    $('.overlay').hide();
                    swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error").then(function(){
                        $('#addProduct').removeAttr('disabled');
                    });
                }
            });
            
        }
    });

    $('#saveChanges').on('click', function(e){
        
        let e_product = $('#edit_product').val();
        let e_quantity = $('#edit_quantity').val();
        let e_price = $('#edit_price').val();
        let e_totalCurrency = $('#edit_totalCurrency').val();
        let e_productStatus = false;
        let e_quantityStatus = false;
        let e_priceStatus = false;
        let e_totalCurrenyStatus = false;

        if(e_product == ""){
            $('#edit_product').addClass('border-danger');
            $('#err_product').html('<strong><span class="text-danger">Product is required</span></strong>');
            e_productStatus = false;
        } else {
            $('#edit_product').removeClass('border-danger');
            $('#err_product').html('');
            e_productStatus = true;
        }
        
        if(e_quantity == ""){
            $('#edit_quantity').addClass('border-danger');
            $('#err_quantity').html('<strong><span class="text-danger">Quantity is required</span></strong>');
            e_quantityStatus = false;
        } else {
            $('#edit_quantity').removeClass('border-danger');
            $('#err_quantity').html('');
            e_quantityStatus = true;
        }
        
        if(e_price == ""){
            $('#edit_price').addClass('border-danger');
            $('#err_price').html('<strong><span class="text-danger">Price is required</span></strong>');
            e_priceStatus = false;


        } else {
            $('#edit_price').removeClass('border-danger');
            $('#err_price').html('');
            e_priceStatus = true;
        }

        if((e_productStatus && e_quantityStatus && e_priceStatus) == true){
            $('.overlay').show();
            $.ajax({
                url: "{{route('admin.save')}}",
                type: "PUT",
                data: $('#edit_form').serialize(),
                success: function(){
                    location.reload();
                },
                error: function(){
                    $('.overlay').hide();
                    swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
                }
            });
        }
    });

    $('.deleteData').on('click', function(){
        if ($('.key').length <= 1){
            swal("Error", "You can't delete the last product left", "error");
        } else {
            
            let tr = $(this).closest('tr');
            let data = tr.children('td').map(function(){
                return $(this).text();
            }).get();
            
            $('#delete_id').val(data[0]);
            $('.overlay').show();
            $.ajax({
                url: "{{route('admin.delete')}}",
                type: "DELETE",
                data: $('#delete_product').serialize(),
                success: function(){
                    location.reload();
                },
                error: function(){
                    $('.overlay').hide();
                    swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
                }
            });
            
        }
    });
    $('#reasonChanges').on('click', function(){
        if($('#reason').val() == ''){
            $('#reason').addClass('border-danger');
            $('#e_reason').html('<strong><span class="text-danger">Reason is required</span></strong>');
        } else {
            
            $('.overlay').show();
            $.ajax({
                url: "{{route('admin.remove')}}",
                type: "PUT",
                data: $('#reason_form').serialize(),
                success: function(){
                    $('.overlay').hide();
                    swal("Success", "Successfully Rejected", "success").then(function(){
                        $('.overlay').show();
                        window.location.href = "{{route('admin-pending')}}";
                    }); 
                },
                error: function(){
                    $('.overlay').hide();
                    swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
                }
            });
        }
    });
    $(window).on('load', function() {
        $(".overlay").fadeOut(200);
    });

    $('img').EZView();

    $("#attachments").on('click', function(){

        $('#save-attachment').fadeIn(2000);

    });

    $("#attachments").fileinput({
        theme : "fas",
        dropZoneEnabled: false,
        'showUpload': false,
        showCaption: false,
        autoReplace: true,
        overwriteInitial: true,
        showUploadedThumbs: false,
        initialPreviewShowDelete: false,
        browseLabel: "Add Attachment",
        maxFilePreviewSize: 40000,
        maxFileSize: 40000
    });

    $('.attachDelete').on('click', function(){

        let pr_id = $(this).attr('id');
        let attach_id = $('#attach-id'+pr_id+'').val();
        let attach_path = $('#attach-path'+pr_id+'').val();
        $('#attachment-id').val(attach_id);
        $('#attachment-path').val(attach_path);

        $('.overlay').show();
        $.ajax({
            url : "{{ route('admin-delete.attachment') }}",
            type : "DELETE",
            data : $('#delete-attachment').serialize(),
            success : function (){
                location.reload();
            },
            error : function (){
                $('.overlay').hide();
                swal('Error', "Something went wrong, Please try again", "error").then(function(){
                    $('#addProduct').removeAttr('disabled');
                });
            }
        })
    });

    $('.fileinput-remove').on('click', function(){

        $('#save-attachment').hide();

    });

    $('#save-attachment').on('click', function(){
        let attachData = new FormData($('#edit-attachment')[0]);
        $('.overlay').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin-store.attachment') }}",
            type: "POST",
            data: attachData,
            contentType : false,
            processData : false,
            cache : false,
            success: function(){
                location.reload();
            },
            error: function(){
                swal('Error', "Something went wrong, Please try again", "error");
            }
        });
    });
    
</script>
@endsection
