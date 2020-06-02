@extends('layouts.prf')

@section('content')

<form method="POST" autocomplete="off" onsubmit="return false" id="insert_product">
  <div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
  </div>
  @csrf
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Total</th>
                <th>Remarks</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div class="text-center">
            <button type="button" class="btn btn-success btn-sm" id="showAdd"><i class="fas fa-cart-plus"></i>&nbsp; Add Product</button>
          </div>
        </div>
      </div>
      <div id="pr_form">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="product">Product</label>
                  <input type="text" class="form-control" id="product">
                  <small id="e_product" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="unit">Unit</label>
                  <input type="text" class="form-control" id="unit">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="text" class="form-control" id="quantity" value="">
                  <small id="e_quantity" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="text" class="form-control" id="price" value="">
                  <small id="e_price" class="form-text text-muted"></small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                  <label for="remarks">Remarks</label>
                  <input type="text" class="form-control" id="remarks" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="total">Total</label>
                  <input type="text" class="form-control" id="totalCurrency" style= "background-color: #fff;" value="" readonly>
                  <input type="text" class="form-control" id="total" style= "background-color: #fff;" value="" hidden>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-primary" id="editChanges"><i class="fas fa-edit"></i>&nbsp; Save</button>
            <button type="button" class="btn btn-success" id="saveChanges"><i class="fas fa-cart-plus"></i>&nbsp; Add</button>
            <button type="button" class="btn btn-danger" id="cancelChanges"><i class="fas fa-window-close"></i>&nbsp; Cancel</button>
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
              <div class="text-center">
                <h1><span>&#8369; </span><span id="grandTotal">0.00</span></h1>
                <button type="button" class="btn btn-primary" id="submit_btn"><i class="fas fa-save"></i>&nbsp; Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">To complete, please fill up this form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department">
          </div>
          <div class="form-group">
            <label for="project">To be used in <i>(Project Name)</i> :</label>
            <input type="text" class="form-control" id="project" name="project">
            <small id="e_project" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="purpose">Specific Purpose or Usage:</label>
            <textarea type="text" class="form-control" id="purpose" name="purpose"></textarea>
          </div>
          <div class="form-group">
            <label for="send-attachment">Send Attachment:</label>
            <div class="file-loading">
              <input id="attachments" name="attachments[]" type="file" multiple accept="application/pdf, image/*">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submit_pr">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>

<input type="hidden" id="editRow" value="">

@endsection

@section('scripts') 
  
  <script type="text/javascript">

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
      maxFileSize: 40000,
  });


    $('#pr_form').hide();
    
    function grandTotal(){
      var grand = 0;
      
      $('.total').each(function(i, e){
        var amount = $(this).val()-0;
        grand += amount;
      });
      
      
      $('#grandTotal').html(grand).formatCurrency({symbol: ''});
    }

    function addProducts(){
      
      let product = $('#product').val();
      let quantity = $('#quantity').val();
      let unit = $('#unit').val();
      let price = $('#price').val();
      let total = $('#total').val();
      let remarks = $('#remarks').val();
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
      
      
      count++;
        output = '<tr id="row'+count+'">';
        output += '<td>'+product+'<input type="hidden" id="product'+count+'" name="product[]" value="'+product+'" /></td>';
        output += '<td>'+quantity+'<input type="hidden" id="quantity'+count+'" name="quantity[]" value="'+quantity+'" /></td>';
        output += '<td>'+unit+'<input type="hidden" id="unit'+count+'" name="unit[]" value="'+unit+'" /></td>';
        output += '<td>'+price+'<input type="hidden" id="price'+count+'" name="price[]" value="'+price+'" /></td>';
        output += '<td>'+totalCurrency+'<input type="hidden" class="total" id="total'+count+'" name="total[]" value="'+total+'" /></td>';
        output += '<td>'+remarks+'<input type="hidden" id="remarks'+count+'" name="remarks[]" value="'+remarks+'" /></td>';
        output += '<td>'+
          '<span id="'+count+'" style="cursor: pointer; color: #51cbce;" class="editData" data-content="Edit" rel="popover" data-placement="bottom">'+
          '<i class="fas fa-edit" style="font-size: 20px;"></i>'+
          '</span>&nbsp;'+
          '<span id="'+count+'" style="cursor: pointer; color:red;" class="deleteData" data-content="Delete" rel="popover" data-placement="bottom">'+
          '<i class="fas fa-trash" style="font-size: 20px;"></i>'+
          '</span></td>';
        output += '</tr>';
              
              
              if((productStatus && quantityStatus && priceStatus) == true){
                
                $('tbody').append(output);
                $('#pr_form').find(':input').val('');
                $('#product').focus();
                $('.editData').popover({ trigger: "hover focus"});
                $('.deleteData').popover({ trigger: "hover focus"});
                grandTotal();
                
              }
          }

      $('#saveChanges').on('click', function(){
        
        addProducts();
          
      });

      $('#showAdd').on('click', function(){
        $('#saveChanges').show();
        $('#pr_form').show();
        $('#pr_form').find(':input').val('');
        $('#product').focus();
        $('#editChanges').hide();
      });

      $('#cancelChanges').on('click', function(){
        $('#pr_form').find(':input').val('');
        $('#pr_form').hide();
      });
      

    $('#editChanges').hide();
    var count = 0;

    $('#exampleModalCenterTitle').text('ADD PR');
      $('#quantity').numeric();
      $('#price').numeric();
      

      $('#pr_form').on('keyup', '#quantity, #price, #remarks', function(){
        
        let quantity = $('#quantity').val();
        let price = $('#price').val();
        let total = (price * quantity);
        $('#total').val(total);
        let totalValue = $('#total').val(); 
        $('#totalCurrency').val(totalValue).formatCurrency({symbol : '₱ '});
        
      });
       
    $('body').on('click', '.editData', function(){
        $('#pr_form')[0].scrollIntoView({
          behavior: 'smooth',
          block: 'center',
          inline: 'center'
        });
        $('#pr_form').show();
        $('#saveChanges').hide();
        $('#editChanges').show();
        $('#title').text('EDIT PR');

        let tr_id = $(this).attr('id');
        $('#editRow').val(tr_id);
              
        let tr = $(this).closest('tr');
        let data = tr.children('td').map(function(){
          return $(this).text();
        }).get();
              
        $('#product').val(data[0]);
        $('#quantity').val(data[1]);
        $('#unit').val(data[2]);
        $('#price').val(data[3]);
        $('#total').val(data[4]);
        $('#totalCurrency').val(data[4]);
        $('#remarks').val(data[5]);
              
   });
            
            
    $('body').on('click', '.deleteData', function(){
      $(this).popover('dispose');
      $(this).parent().parent().remove();
      $('#pr_form').find(':input').val('');
      $('#pr_form').hide();
      grandTotal();

    });

    $('#editChanges').on('click', function(){

      let product = $('#product').val();
      let quantity = parseFloat($('#quantity').val());
      let unit = $('#unit').val();
      let price = parseFloat($('#price').val());
      let totalString = quantity * price;
      let total = parseFloat(totalString);
      let remarks = $('#remarks').val();
      let totalCurrency = $('#totalCurrency').val();
      let row_id = $('#editRow').val();
      let editProduct = $('#product').val();
      let editQuantity = $('#quantity').val();
      let editPrice = $('#price').val();
      let productStatus = false;
      let quantityStatus = false;
      let priceStatus = false;

      if(editProduct == ""){
        $('#product').addClass('border-danger');
        $('#e_product').html('<strong><span class="text-danger">Product is required</span></strong>');
        productStatus = false;
      } else {
        $('#product').removeClass('border-danger');
        $('#e_product').html('');
        productStatus = true;
      }
      
      if(editQuantity == ""){
        $('#quantity').addClass('border-danger');
        $('#e_quantity').html('<strong><span class="text-danger">Quantity is required</span></strong>');
        quantityStatus = false;
      } else {
        $('#quantity').removeClass('border-danger');
        $('#e_quantity').html('');
        quantityStatus = true;
      }
      
      if(editPrice == ""){
        $('#price').addClass('border-danger');
        $('#e_price').html('<strong><span class="text-danger">Price is required</span></strong>');
        priceStatus = false;
      } else {
        $('#price').removeClass('border-danger');
        $('#e_price').html('');
        priceStatus = true;
      }
      
      edited = '<td>'+product+'<input type="hidden" id="product'+row_id+'" name="product[]" value="'+product+'" /></td>';
      edited += '<td>'+quantity+'<input type="hidden" id="quantity'+row_id+'" name="quantity[]" value="'+quantity+'" /></td>';
      edited += '<td>'+unit+'<input type="hidden" id="unit'+row_id+'" name="unit[]" value="'+unit+'" /></td>';
      edited += '<td>'+price+'<input type="hidden" id="price'+row_id+'" name="price[]" value="'+price+'" /></td>';
      edited += '<td>'+totalCurrency+'<input type="hidden" class="total" id="total'+row_id+'" name="total[]" value="'+total+'" /></td>';
      edited += '<td>'+remarks+'<input type="hidden" id="remarks'+row_id+'" name="remarks[]" value="'+remarks+'" /></td>';
      edited += '<td>'+
        '<span id="'+row_id+'" style="cursor: pointer; color: #51cbce;" class="editData" data-content="Edit" rel="popover" data-placement="bottom">'+
        '<i class="fas fa-edit" style="font-size: 20px;"></i>'+
        '</span>&nbsp;'+
        '<span id="'+row_id+'" style="cursor: pointer; color:red;" class="deleteData" data-content="Delete" rel="popover" data-placement="bottom">'+
        '<i class="fas fa-trash" style="font-size: 20px;"></i>'+
        '</span></td>';

        if((productStatus && quantityStatus && priceStatus) == true){
          
          $('#row'+row_id+'').html(edited);
            grandTotal();
            $('#editChanges').hide();
            $('#saveChanges').show();
            $('#pr_form').find(':input').val('');
            $('#title').text('ADD PR');
            $('#pr_form').hide();
            $('.editData').popover({ trigger: "hover focus"});
            $('.deleteData').popover({ trigger: "hover focus"});
            
        }
    });
    
    $('body').on('keydown', function(e){
      if(e.keyCode === 13) {
        if ($('#editChanges').is(':visible')){
          $('#editChanges').click();
        } else {
          $('#saveChanges').click();
        }
      }
    })
        
    $('#submit_btn').on('click', function(){
      if($('input[name="product[]"]').length <= 0){
        swal("Error", "Please add atleast one product", "error");
      } else {
        $('#modalForm').modal('show');
      }
    });

    $('#submit_pr').on('click', function(){
      
      let inputStatus = false;
      let fileStatus = false;
      
      if($('#project').val() == ""){
        
        $('#project').addClass('border-danger');
        
        $('#e_project').html('<strong><span class="text-danger">Project Name is required</span></strong>');

        $('#project')[0].scrollIntoView({
          behavior: 'smooth',
          block: 'center',
          inline: 'center'
        });
        
        inputStatus = false;
        
      } else {
        
        $('#project').removeClass('border-danger');
        
        $('#e_project').html('');
        
        inputStatus = true;
        
      }



      if((inputStatus) == true){
        
        $('#modalForm').modal('hide');
        
        $('.overlay').show();
        
        var formData = new FormData($('#insert_product')[0]);
        
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url : "{{ route('insert.products') }}",
          type : "POST",
          data: formData,
          contentType : false,
          processData : false,
          cache : false,
          success: function(e){
            var pr_id = e.pr_id;
            var requestor = e.requestor;
            $('.overlay').hide();
            swal(
            'Good job!',
            'Saved Successfully',
            'success'
            ).then(function(){
              
              swal("Would you like to view this request and send to admin ?", {
                icon: "info",
                buttons: {
                  cancel : true,
                  pdf : {
                    text : "View Request",
                    value : "pdf"
                  }
                },
              }).then((e) => {
                switch(e){
                  case "pdf" :
                  window.location.href = "/user/"+pr_id+"/"+requestor+"";
                  $('.overlay').show();
                  break;
                  
                  default :
                  window.location.href = "{{route('user-request')}}";
                  $('.overlay').show();
                }
              });
            });
          },
          error: function(e){
            $('.overlay').hide();
            swal('Error', "Something went wrong, Maybe you have been inactive for too long. Please refresh the page, thank you!", "error");
          }
        });
      }
    });

  $(window).on('load', function() {
    $(".overlay").fadeOut(200);
  });
  </script>
          
@endsection
