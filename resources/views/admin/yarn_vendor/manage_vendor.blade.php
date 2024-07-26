@extends('admin.layouts.app')
@section('page_title', 'Yarn Vendor')
@section('yarn_purchase_system_select', 'active')
@section('yarn_vendor_select', 'inner_active')

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
        <h2><a href="{{ route('admin.vendor') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Vendor</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Code<span class="text-danger small">*</span></p>
                        <input type="text" name="code" value="{{ $code }}" placeholder="Enter Code" readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Vendor Name<span class="text-danger small">*</span></p>
                        <input type="text" name="name" value="{{ $name }}" placeholder="Enter Vendor Name" data-validate="required" required  data-message-required="Please Enter Vendor Name">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>GST Number</p>
                        <input type="text" name="gst_number" value="{{ $gst_number }}" placeholder="Enter GST Number" data-validate="minlength[15],maxlength[15]"  data-message-minlength="Enter 15 digits" data-message-maxlength="Enter 15 digits">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Mobile No.<span class="text-danger small">*</span></p>
                        <input type="number" name="mobile" value="{{ $mobile }}" placeholder="Enter Mobile No." data-validate="number,required,minlength[10],maxlength[10]" required  data-message-required="Please Enter Mobile No." @if($id != '0'){{"readonly"}}@endif>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Email Id</p>
                        <input type="email" name="email" value="{{ $email }}" placeholder="Enter Email">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Mobile No.<span class="text-danger small">(Payment FollowUp)</span></p>
                        <input type="number" name="pay_followup_mobile" value="{{ $pay_followup_mobile }}" placeholder="Enter Mobile No." data-validate="number,minlength[10],maxlength[10]">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Mobile No.<span class="text-danger small">(Po FollowUp)</span></p>
                        <input type="number" name="po_followup_mobile" value="{{ $po_followup_mobile }}" placeholder="Enter Mobile No." data-validate="number,minlength[10],maxlength[10]">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Payment Terms</p>
                        <input type="number" name="payment_terms" value="{{ $payment_terms }}" placeholder="Count with Cleared Payents" data-validate="number">
                        <span class="text-danger small">DAYS</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Active</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Inactive</option>  
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Freight Rate</p>
                        <input type="number" name="freight" value="{{ $freight }}" placeholder="Enter Freight Rate" >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Billing Through</p>
                        <select name="billing_through"  class="mySelect2 col model_select">
                            <option value="1" @if($billing_through == "1"){{"selected"}}@endif>Agency</option> 
                            <option value="2" @if($billing_through == "2"){{"selected"}}@endif>Agent</option>
                            <option value="3" @if($billing_through == "3"){{"selected"}}@endif>Broker</option> 
                            <option value="4" @if($billing_through == "4"){{"selected"}}@endif>Direct</option>  
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="main_map_box mb-3">
                        <div id="map" style="width: 100%; height: 380px;"></div>
                    </div>
                </div>
                <input type="hidden" id="lat_long" name="lat_long" value="{{ $lat_long }}">
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Address</p>
                        <span class="location_icon"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" id="address" name="address" value="{{ $address }}" placeholder="Search Location" class="input_icon">
                    </div>
                </div>
                

                <div class="firm_section">
                    <div class="d-flex justify-content-between form_inner_heading">
                        <h2>Other Firms</h2>
                        <a href="javascript:void(0)" class="dark-btn add_row_firm">+ Add other firm</a>
                    </div>
                    <div class="firm_body">
                        @foreach($getfirms as $key1 => $getfirm)
                        <div class="firm_row">
                            <input type="hidden" name="firm_ids[]" value="{{ $getfirm->id }}">
                            <div class="row align-items-center">
                                <div class="col-lg-1">
                                    <div class="firm_number">{{ $key1 + 1 }}</div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Vendor</p>
                                        <input type="text" name="firm_vendor[]" value="{{ $getfirm->vendor_name }}" placeholder="Enter Vendor">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>GST Number</p>
                                        <input type="text" name="firm_gst[]" value="{{ $getfirm->gst }}" placeholder="Enter GST Number" data-validate="minlength[15],maxlength[15]"  data-message-minlength="Enter 15 digits" data-message-maxlength="Enter 15 digits">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="delete_icon_td d-flex justify-content-end pe-3">
                                        <a href="javascript:void(0)" class="delete_icon remove_row_firm" data-id="{{ $getfirm->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28" viewBox="0 0 27 28" fill="none">
                                                <path d="M3.375 7.08838H5.625M5.625 7.08838H23.625M5.625 7.08838V22.8384C5.625 23.4351 5.86205 24.0074 6.28401 24.4294C6.70597 24.8513 7.27826 25.0884 7.875 25.0884H19.125C19.7217 25.0884 20.294 24.8513 20.716 24.4294C21.1379 24.0074 21.375 23.4351 21.375 22.8384V7.08838H5.625ZM9 7.08838V4.83838C9 4.24164 9.23705 3.66935 9.65901 3.24739C10.081 2.82543 10.6533 2.58838 11.25 2.58838H15.75C16.3467 2.58838 16.919 2.82543 17.341 3.24739C17.7629 3.66935 18 4.24164 18 4.83838V7.08838M11.25 12.7134V19.4634M15.75 12.7134V19.4634" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between form_inner_heading mb-4">
                        <h2>Broker</h2> 
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input_box">
                                <p>Company Name</p>
                                <input type="text" name="broker_company" value="{{ $broker_company }}" placeholder="Enter Company Name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input_box">
                                <p>Name</p>
                                <input type="text" name="broker_name" value="{{ $broker_name }}" placeholder="Enter Enter name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input_box">
                                <p>Mobile No.</p>
                                <input type="number" name="broker_mobile" value="{{ $broker_mobile }}" placeholder="Enter mobile no." data-validate="minlength[10],maxlength[10]">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input_box">
                                <p>GST Number</p>
                                <input type="text" name="broker_gst" value="{{ $broker_gst }}" placeholder="Enter GST Number" data-validate="minlength[15],maxlength[15]">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input_box">
                                <p>Email ID</p>
                                <input type="email" name="broker_email" value="{{ $broker_email }}" placeholder="Enter Email ID">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ route('admin.vendor') }}" class="cancel-btn">Cancel</a>
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
            url:"{{ route('vendor.manage-vendor-process') }}",
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

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYWJkZWFsaTcyIiwiYSI6ImNsN2J6ZWh4eDE3OXgzcW84d2VxbWRpM24ifQ.RnphYbegeMvk3I1fjTqY5g';

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        //style: 'mapbox://styles/mapbox/satellite-v9',
        center: [72.8311, 21.1702],
        zoom: 7
    });

    // Initialize marker
    var marker = new mapboxgl.Marker();

    // Function to set marker and update input field
    function setMarkerAndInput(lng, lat) {
        // Update input field for latitude and longitude
        $('#lat_long').val(lat + ',' + lng);

        // Set marker position
        marker.setLngLat([lng, lat]).addTo(map);

        // Get address from coordinates using reverse geocoding
        getAddressFromCoordinates(lng, lat);
    }

    // Function to update the zoom level input field
    // function updateZoomLevel() {
    //     $('#map_zoom_level').val(map.getZoom().toFixed(2)); // Set zoom level to 2 decimal places
    // }

    // Function to get address from coordinates
    function getAddressFromCoordinates(lng, lat) {
        var geocodingUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + lng + ',' + lat + '.json?access_token=' + mapboxgl.accessToken;

        $.get(geocodingUrl, function(data) {
            if (data && data.features && data.features.length > 0) {
                var address = data.features[0].place_name;
                $('#address').val(address);
            } else {
                $('#address').val('Address not found');
            }
        });
    }

    // Check if lat_long value exists initially
    var latLongValue = $('#lat_long').val();
    if (latLongValue) {
        var coordinates = latLongValue.split(',');
        var lng = parseFloat(coordinates[1]);
        var lat = parseFloat(coordinates[0]);

        // Set marker and input field from existing lat_long value
        setMarkerAndInput(lng, lat);

        // Center map on marker
        map.setCenter([lng, lat]);
    }

    // Map click event
    map.on('click', function(e) {
        var lng = e.lngLat.lng.toFixed(6);
        var lat = e.lngLat.lat.toFixed(6);

        // Set marker and update input field on map click
        setMarkerAndInput(lng, lat);
    });

    // Map zoom event
    // map.on('zoom', function() {
    //     updateZoomLevel(); // Update zoom level input field on zoom change
    // });

    // Initialize zoom level input field on load
    //updateZoomLevel();

</script>


@endsection