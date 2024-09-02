@extends('admin.layouts.app')
@section('page_title', 'Rola outward')
@section('rola_system_select', 'active')
@section('rola_outward_select', 'inner_active')

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
        <h2><a href="{{ url('admin/rolaoutward') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
        @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Rola Outward</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
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
                        <p>Challan No<span class="text-danger small">*</span></p>
                        <input type="text" name="challan_no" id="challan_no" value="{{ $challan_no }}" placeholder="Enter challan no" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Challan Date<span class="text-danger small">*</span></p>
                        <input type="date" name="challan_date" value="{{ $challan_date }}" placeholder="Enter challan date" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Qty<span class="text-danger small">*</span></p>
                        <input type="text" name="qty" id="qty" value="{{ $qty }}" placeholder="Enter qty" >
                    </div>
                </div>
                

                
            </div>
            
            <div class="row">
          
               
                
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Remarks<span class="text-danger small">*</span></p>
                        <input type="text" name="remarks" id="remarks" value="{{ $remarks }}" placeholder="Enter remarks">
                    </div>
                </div>
                                
                
            </div>
            <input type="hidden" name="id" id="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/rolaoutward') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="dark-btn">Save</button>
            </div>
        </form>
    </div>                
</div>



@endsection

@section('delscript')
<script>
$(document).ready(function() {
    
    $(document).on("change", "#yarn_vendor_id", function() {
        var id = $(this).val();  // Correctly get the `data-id` attribute
        
            $.ajax({
            url:"{{ url('admin/yarnbill/getYarnPO') }}",
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{id:id},
            // beforeSend: function(){
            //     $('.overlay-wrapper').show();  
            // },
            success(response){
              
            var obj =  JSON.parse(response);
            if(obj.status=="1"){
                
                // Set the selected options
                $('#bill_firm_id').html(obj.firm);
                $('#po_no').html(obj.data).trigger('change');
            
            }
            
            }
        })
        
    });

 
    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/rolaoutward/manage-rolaoutward-process') }}",
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
                        window.location.href = "{{ url('admin/rolaoutward') }}";
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



</script>



@endsection