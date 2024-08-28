@extends('admin.layouts.app')
@section('page_title', 'Yarn Product')
@section('yarn_purchase_system_select', 'active')
@section('yarn_product_select', 'inner_active')

@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2><a href="{{ route('admin.product') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            Add Yarn Product</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>SKT Yarn Name<span class="text-danger small">*</span></p>
                        <input type="text" name="skt_yarn_name" value="{{ $skt_yarn_name }}" placeholder="Enter SKT Yarn Name" data-validate="required" required  data-message-required="Please Enter SKT Yarn Name">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>GST</p>
                        <input type="text" name="gst" value="{{ $gst }}" placeholder="Enter GST" data-validate="minlength[15],maxlength[15]"  data-message-minlength="Enter 15 digits" data-message-maxlength="Enter 15 digits">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>HSN Code</p>
                        <input type="text" name="hsn_code" value="{{ $hsn_code }}" placeholder="Enter HSN Code">
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
            </div>

            <div class="mainadd_yarn_box">
                <div class="main_add_yarn_box mt-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="input_box">
                                <p>Vendor Name</p>
                                <select name="yarn_vendor_id[]" class="mySelect2">  
                                    <option value="">Please Select</option> 
                                    @foreach($getVendors as $getVendor)
                                        <option value="{{ $getVendor->id }}">{{ $getVendor->name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="input_box">
                                <p>Vendor Yarn Name</p>
                                <input type="text" name="vendor_yarn_name[]" placeholder="Enter Yarn Name">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input_box">
                                <p>Denier</p>
                                <input type="text" name="denier[]" placeholder="Enter Denier">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="delete_btn">
                                <a href="javascript:void(0)" class="inner_delete_btn remove_vendor"><img src="{{ url('public/admin/images/delete_icon.svg') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="renewal_table add_yarn_table">
                        <div class="table-responsive" style="min-height:auto">
                            <table class="table vendor_detail_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="first_radius small_name">#</th>
                                        <th scope="col">Shade No.</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">MOQ</th>  
                                        <th scope="col" class="last_radius">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="vendor-detail-row">
                                        <td>
                                            <p class="normal_text">1</p>
                                        </td>
                                        <td> 
                                            <div class="input_box">
                                                <input type="text" name="shade_no[]" placeholder="ST1965">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="text" name="color[]" placeholder="Red">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="text" name="moq[]" placeholder="Enter minimum quantity">
                                            </div>
                                        </td> 
                                        <td class="action_td">
                                            <div class="d-flex align-items-center"> 
                                                <a href="javascript:void(0)" class="remove_vendor_detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-3"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="add_solution_btn">
                                <a href="javascript:void(0)" class="add_vendor_detail"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 5C2 4.46957 2.21071 3.96086 2.58579 3.58579C2.96086 3.21071 3.46957 3 4 3H9.52C9.81977 3.00004 10.1157 3.06746 10.3859 3.19728C10.6561 3.3271 10.8936 3.51599 11.081 3.75L12.481 5.5H20C20.5304 5.5 21.0391 5.71071 21.4142 6.08579C21.7893 6.46086 22 6.96957 22 7.5V19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V5ZM12 9C12.2652 9 12.5196 9.10536 12.7071 9.29289C12.8946 9.48043 13 9.73478 13 10V12H15C15.2652 12 15.5196 12.1054 15.7071 12.2929C15.8946 12.4804 16 12.7348 16 13C16 13.2652 15.8946 13.5196 15.7071 13.7071C15.5196 13.8946 15.2652 14 15 14H13V16C13 16.2652 12.8946 16.5196 12.7071 16.7071C12.5196 16.8946 12.2652 17 12 17C11.7348 17 11.4804 16.8946 11.2929 16.7071C11.1054 16.5196 11 16.2652 11 16V14H9C8.73478 14 8.48043 13.8946 8.29289 13.7071C8.10536 13.5196 8 13.2652 8 13C8 12.7348 8.10536 12.4804 8.29289 12.2929C8.48043 12.1054 8.73478 12 9 12H11V10C11 9.73478 11.1054 9.48043 11.2929 9.29289C11.4804 9.10536 11.7348 9 12 9Z" fill="#030F1A"></path>
                                    </svg>
                                    <span>Add new</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="javascript:void(0)" class="add_form_btn dark-btn add_vendor">  
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-3"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>Add new</a>
            </div>
            <input type="hidden" name="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ route('admin.product') }}" class="cancel-btn">Cancel</a>
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
            url:"{{ route('product.manage-product-process') }}",
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
                        window.location.href = "{{ route('admin.product') }}";
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

     
});


$(document).ready(function() {
    // Handle addition of new vendor detail row
    $(document).on('click', '.add_vendor_detail', function() {
        var vendorBox = $(this).closest('.main_add_yarn_box'); // Get the closest vendor box
        var newRow = vendorBox.find('.vendor-detail-row').first().clone(); // Clone the first detail row
        var rowCount = vendorBox.find('.vendor-detail-row').length + 1; // Count existing rows
        newRow.find('input').val(''); // Clear input values
        newRow.find('p.normal_text').text(rowCount); // Update row number
        newRow.find('.remove_vendor_detail').show(); // Show the remove button
        vendorBox.find('.vendor_detail_table tbody').append(newRow); // Append new row to the specific vendor box
       
    });

    // Handle removal of vendor detail row
    $(document).on('click', '.remove_vendor_detail', function() {
        var vendorBox = $(this).closest('.main_add_yarn_box'); // Get the closest vendor box
        $(this).closest('tr').remove(); // Remove the row
        // Reindex the rows after removal
        vendorBox.find('.vendor-detail-row').each(function(index) {
            $(this).find('p.normal_text').text(index + 1); // Update row numbers
        });
        // Hide delete button for the first row if it's the only remaining row
        if (vendorBox.find('.vendor-detail-row').length === 1) {
            vendorBox.find('.vendor-detail-row').first().find('.remove_vendor_detail').hide();
        }
    });

    // Handle addition of new vendor row
    $(document).on('click', '.add_vendor', function() {
        var newRow = $('.main_add_yarn_box').first().clone(); // Clone the first vendor box
        newRow.find('select').val(''); // Clear select values
        newRow.find('input').val(''); // Clear input values
        newRow.find('.remove_vendor').show(); // Show the remove button
        newRow.find('.vendor-detail-row').first().find('.remove_vendor_detail').hide(); // Hide delete button in the first detail row
        $('.mainadd_yarn_box').append(newRow); // Append new vendor box
        newRow.find('.mySelect2').select2();
    });

    // Handle removal of vendor row
    $(document).on('click', '.remove_vendor', function() {
        var vendorBox = $(this).closest('.main_add_yarn_box'); // Get the closest vendor box
        if ($('.main_add_yarn_box').length > 1) { // Ensure there is more than one vendor box
            vendorBox.remove(); // Remove the specific vendor box
        }
    });

    // Hide delete icon in the first vendor box
    $('.main_add_yarn_box').first().find('.remove_vendor').hide();

    // Hide delete icon in the first detail row of each vendor box
    $('.main_add_yarn_box').each(function() {
        $(this).find('.vendor-detail-row').first().find('.remove_vendor_detail').hide();
    });
});





</script>


@endsection