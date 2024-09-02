@extends('admin.layouts.app')
@section('page_title', 'Yarn Bill')
@section('yarn_purchase_system_select', 'active')
@section('yarn_bill_select', 'inner_active')

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
        <h2><a href="{{ url('admin/yarnbill') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
        @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Yarn Bill</h2>
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
                        <p>PO Number</p>
                        <select name="po_no" id="po_no" class="form-control po_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                            <option value="">--Select--</option> 
                        </select> 
                        <input type="hidden" name="yarn_po_id" id="yarn_po_id" value="{{ $yarn_po_id }}" />
                        <input type="hidden" name="yarn_po_no" id="yarn_po_no" />
                    </div>
                </div> 

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Bill Name</p>
                        <select name="bill_firm_id" id="bill_firm_id" class="form-control yarn_challanid xx mySelect2" data-validate="required" data-message-required="Select challan name" required>
                            <option value="">--Select--</option> 
                           
                        </select> 
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Bill No<span class="text-danger small">*</span></p>
                        <input type="text" name="bill_no" id="bill_no" value="{{ $bill_no }}" placeholder="Enter bill_no" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Bill Date<span class="text-danger small">*</span></p>
                        <input type="date" name="bill_date" value="{{ $bill_date }}" placeholder="Enter bill date" >
                    </div>
                </div>

                

                
            </div>
            <hr/>
            <div class="row add_yarn_table">
            
                               
                               
                    
            </div>
            <hr/>
            <div class="row">
            <div class="col-lg-3">
                    <div class="input_box">
                        <p>Bill Rate<span class="text-danger small">*</span></p>
                        <input type="text" name="bill_rate" id="bill_rate" value="{{ $bill_rate }}" placeholder="Enter bill Rate" >
                    
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Total<span class="text-danger small">*</span></p>
                        <input type="text" readonly id="tot_amt" name="tot_amt" value="{{ $tot_amt }}" placeholder="Enter Total" >
                    </div>
                </div>
               

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Done</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Issue</option>   
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Remarks<span class="text-danger small">*</span></p>
                        <input type="text" name="remarks" id="remarks" value="{{ $remarks }}" placeholder="Enter remarks">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Bill Rate Issue</p>
                        <select name="bill_rate_issue"  class="mySelect2 col model_select">
                            <option value="2" @if($bill_rate_issue == "2"){{"selected"}}@endif>No</option>  
                            <option value="1" @if($bill_rate_issue == "1"){{"selected"}}@endif>Yes</option>
                        </select>
                    </div>
                </div>
                
                
            </div>
            <input type="hidden" name="id" id="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/yarnbill') }}" class="cancel-btn">Cancel</a>
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
        var pid='{{$yarn_po_id}}';
        var fid='{{$bill_firm_id}}';
            $.ajax({
            url:"{{ url('admin/yarnbill/getYarnPO') }}",
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{id:id,pid:pid,fid:fid},
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

    $(document).on("change", "#po_no", function() {
        $('.add_yarn_table').html('');
        var id=$(this).val();
        var bill_id=$("#id").val();
        $("#yarn_po_no").val($(this).find(':selected').data('id'));
        $.ajax({
            url:"{{ url('admin/yarnbill/getChallanDetails') }}",
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{id:id,bill_id:bill_id},
            // beforeSend: function(){
            //     $('.overlay-wrapper').show();  
            // },
            success(response){
              
            var obj =  JSON.parse(response);
            if(obj.status=="1"){
                // Set the selected options
                //$('.shade_no').html(obj.data);
                $('.add_yarn_table').html(obj.data);
                calc();
            
            }
            
            }
        })
    });

    $(document).on("change",".inward_id", function(){
        calc()
    })
    $('#yarn_vendor_id').trigger('change');
    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/yarnbill/manage-bill-process') }}",
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
                        window.location.href = "{{ url('admin/yarnbill') }}";
                }
                else {
                    Command: toastr["error"](obj.message, "Message")	
                    $('.overlay-wrapper').hide();
                }
                },1000);
            }
        })	
	})  
    

    $(document).on('keyup', '#bill_rate', function(e) {
        calc();
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



});

function calc()
{
    var checkboxes = $('.inward_id:checked'); // Select checked checkboxes
     var qty=0;   
     checkboxes.each(function() {
        qt=$(this).parent().parent().parent().find('.qty').val();
        qty += parseFloat(qt);
        //checkedValues.push(checkbox.value); // Push the value of each checked checkbox into the array
    });
    $('#tot_amt').val(parseFloat($('#bill_rate').val())*parseFloat(qty));
    // var mains=thiss.parent().parent().parent();
    // var c_qty=mains.find("input.challan_qty").val();
    // var i_qty=mains.find("input.inward_qty").val();
    // var wt=parseFloat(c_qty)-parseFloat(i_qty);
    // mains.find("input.wt_diff").val(wt);
    // var wt_per=(parseFloat(wt)/parseFloat(c_qty))*100;
    // mains.find("input.wt_diff_per").val(wt_per);
    
}



</script>



@endsection