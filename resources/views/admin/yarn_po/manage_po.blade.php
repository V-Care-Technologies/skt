@extends('admin.layouts.app')
@section('page_title', 'Yarn PO')
@section('yarn_purchase_system_select', 'active')
@section('yarn_po_select', 'inner_active')

<link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script> 
<style>
      body { margin: 0; padding: 0; }
      #maps { position: absolute; top: 0; bottom: 0; width: 100%; }
      .chart-container-1 {
    	height: 600px;
    	flex: 0 0 auto;
    	width:100%;
      }
</style>

@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2><a href="{{ url('admin/yarnpo') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif PO</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>PO Number<span class="text-danger small">*</span></p>
                        <input type="text" name="po_number" value="{{ $po_number }}" placeholder="Enter po number" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>PO Date<span class="text-danger small">*</span></p>
                        <input type="date" name="po_date" value="{{ $po_date }}" placeholder="Enter po date" >
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Vendor Name</p>
                        <select name="yarn_vendor_id" id="yarn_vendor_id" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                            <option value="">--Select--</option> 
                            <?php foreach($getVendors as $getVendor){?>
                                <option value="{{ $getVendor->id }}" {{ $yarn_vendor_id == $getVendor->id ? 'selected' : '' }} data-fr="{{$getVendor->freight}}">{{ $getVendor->name }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div> 

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Delivery Date<span class="text-danger small">*</span></p>
                        <input type="date" name="delivery_date" value="{{ $del_date }}" placeholder="Enter Delivery date" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Yarn</p>
                        <select name="yarn_id" id="yarn_id" class="form-control yarn_id xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                            <option value="">--Select--</option> 
                        </select> 
                    </div>
                </div> 

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Denier<span class="text-danger small">*</span></p>
                        <input type="text" name="denier" id="denier" value="{{ $denier }}" placeholder="Enter denier" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Freight Rate/kg<span class="text-danger small">*</span></p>
                        <input type="text" name="freight" id="freight" value="{{ $freight }}" placeholder="Enter freight" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>GST in %<span class="text-danger small">*</span></p>
                        <input type="text" name="gst" id="gst" value="{{ $gst }}" placeholder="Enter gst" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>HSN Code<span class="text-danger small">*</span></p>
                        <input type="text" name="hsn" id="hsn" value="{{ $hsn }}" placeholder="Enter hsn" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Pending</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Authorized</option> 
                            <option value="3" @if($status == "3"){{"selected"}}@endif>Rejected</option>   
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Yarn Inward Format</p>
                        <select name="yarn_inward"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Rola</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Spools</option> 
                            <option value="3" @if($status == "3"){{"selected"}}@endif>Cops</option>   
                        </select>
                    </div>
                </div>
            
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Rola Qty<span class="text-danger small">*</span></p>
                        <input type="text" name="rola_qty" id="rola_qty" value="{{ $rola_qty }}" placeholder="Enter rola qty">
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/manage-po') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="dark-btn">Save</button>
            </div>
        </form>
    </div>                
</div>



@endsection

@section('delscript')
<script>
$(document).ready(function() {

    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/manage-po-process') }}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                    $('.overlay-wrapper').show();  
                },
            success(response){
                setTimeout(function(){
                var obj =  JSON.parse(response);
                if(obj.status=="1"){
                        $('.overlay-wrapper').hide(); 
                        Command: toastr["success"](obj.message, "Message")
                        window.location.href = "{{ route('admin.vendor') }}";
                }
                else {
                    Command: toastr["error"](obj.message, "Message")	
                    $('.overlay-wrapper').hide();
                }
                },1000);
            }
        })	
	})  
    
    $(document).on("change", "#yarn_vendor_id", function() {
        var id = $(this).val();  // Correctly get the `data-id` attribute
        var pid='{{$yarn_id}}';
        $("#freight").val($(this).find(':selected').data('fr'));
            $.ajax({
            url:"{{ url('admin/yarnpo/getYarn') }}",
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{id:id,pid:pid},
            // beforeSend: function(){
            //     $('.overlay-wrapper').show();  
            // },
            success(response){
              
            var obj =  JSON.parse(response);
            console.log(obj.data);
            if(obj.status=="1"){
                
                // Set the selected options
                $('#yarn_id').html(obj.data).trigger('change');
            
            }
            
            }
        })
        
    });

    $(document).on("change", "#yarn_id", function() {
        $("#denier").val($(this).find(':selected').data('id'));
        $("#gst").val($(this).find(':selected').data('gst'));
        $("#hsn").val($(this).find(':selected').data('hsn'));
    });


    // Prevent form submission on Enter key press for all elements except the save button
    $('#save-form').on('keypress', function(e) {
        if (e.which === 13 && e.target.id !== 'saveButton') {
            e.preventDefault();
        }
    });

    // Allow form submission when Enter key is pressed on the save button
    $('#saveButton').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent the default action
            $('#save-form').off('submit').submit(); // Submit the form
        }
    });


    // Add new firm row
    $('.add_row_firm').on('click', function() {
        var newRow1 = `
        <div class="firm_row">
            <input type="hidden" name="firm_ids[]" value="">
            <div class="row align-items-center">
                <div class="col-lg-1">
                    <div class="firm_number"></div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Vendor</p>
                        <input type="text" name="firm_vendor[]" value="" placeholder="Enter Vendor">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>GST Number</p>
                        <input type="text" name="firm_gst[]" value="" placeholder="Enter GST Number" data-validate="minlength[15],maxlength[15]"  data-message-minlength="Enter 15 digits" data-message-maxlength="Enter 15 digits">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="delete_icon_td d-flex justify-content-end pe-3">
                        <a href="javascript:void(0)" class="delete_icon remove_row_firm" data-id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28" viewBox="0 0 27 28" fill="none">
                                <path d="M3.375 7.08838H5.625M5.625 7.08838H23.625M5.625 7.08838V22.8384C5.625 23.4351 5.86205 24.0074 6.28401 24.4294C6.70597 24.8513 7.27826 25.0884 7.875 25.0884H19.125C19.7217 25.0884 20.294 24.8513 20.716 24.4294C21.1379 24.0074 21.375 23.4351 21.375 22.8384V7.08838H5.625ZM9 7.08838V4.83838C9 4.24164 9.23705 3.66935 9.65901 3.24739C10.081 2.82543 10.6533 2.58838 11.25 2.58838H15.75C16.3467 2.58838 16.919 2.82543 17.341 3.24739C17.7629 3.66935 18 4.24164 18 4.83838V7.08838M11.25 12.7134V19.4634M15.75 12.7134V19.4634" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>`;
        $('.firm_body').append(newRow1);
        updateFirmRowNumbers();
    });

    // Remove firm row
    $(document).on('click', '.remove_row_firm', function() {
        var id = $(this).attr('data-id');
        var $rowToRemove = $(this).closest('.firm_row'); // Store reference to the row

        if (id != '') {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('admin/vendor/deletefirm') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { id: id },
                        beforeSend: function() {
                            $('.overlay-wrapper').show(); // Show loading overlay
                        },
                        success: function(response) {
                            var obj = JSON.parse(response);
                            if (obj.status == "1") {
                                $('.overlay-wrapper').hide(); // Hide loading overlay
                                toastr.info("Deleted Successfully", "Message");
                                $rowToRemove.remove(); // Remove the table row using stored reference
                                updateFirmRowNumbers(); // Update row numbers after removal
                            } else {
                                $('.overlay-wrapper').hide(); // Hide loading overlay
                                toastr.error("Failed to delete record", "Error");
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.overlay-wrapper').hide(); // Hide loading overlay
                            toastr.error("Failed to delete record", "Error");
                        }
                    });
                } else {
                    swal("Your record is safe!");
                }
            });
        } else {
            $rowToRemove.remove(); // Directly remove the row if ID is empty
            updateFirmRowNumbers(); // Update row numbers after removal
        }
    });

    // Update firm row numbers
    function updateFirmRowNumbers() {
        $('.firm_row').each(function(index) {
            $(this).find('.firm_number').text(index + 1);
        });
    }

    // Initial update of firm row numbers
    updateFirmRowNumbers();
});




</script>



@endsection