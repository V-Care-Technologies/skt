@extends('admin.layouts.app')
@section('page_title', 'Fabric Product')
@section('fabric_weaver_system_select', 'active')
@section('fabric_product_select', 'inner_active')

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
        <h2><a href="{{ url('admin/fabricproduct') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
        @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Fabric Product</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Fabric Product Type</p>
                        <select name="mst_fabric_type_id" id="mst_fabric_type_id" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select Fabric Type" required>
                            <option value="">--Select--</option> 
                            <?php foreach($fabric_types as $fabric_type){?>
                                <option value="{{ $fabric_type->id }}" {{ $mst_fabric_type_id == $fabric_type->id ? 'selected' : '' }}>{{ $fabric_type->title }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>SKT Product Name</p>
                        <input type="text" name="skt_name" id="skt_name" value="{{ $skt_name }}" placeholder="Enter SKT Product Name" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>HSN Code</p>
                        <input type="text" name="hsn_code" id="hsn_code" value="{{ $hsn_code }}" placeholder="Enter HSN Code" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Weight (Before Process)</p>
                        <input type="text" name="wt_before" id="wt_before" value="{{ $wt_before }}" placeholder="Enter Weight (Before Process)" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Weight (After Process)</p>
                        <input type="text" name="wt_after" id="wt_after" value="{{ $wt_after }}" placeholder="Enter Weight (After Process)" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Panna (Before Process)</p>
                        <input type="text" name="panna_before" id="panna_before" value="{{ $panna_before }}" placeholder="Enter Panna (Before Process)" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Panna (After Process)</p>
                        <input type="text" name="panna_after" id="panna_after" value="{{ $panna_after }}" placeholder="Enter Panna (After Process)" >
                    </div>
                </div> 
                <div class="col-lg-3 cut">
                    <div class="input_box">
                        <p>Cut (Before Process)</p>
                        <input type="text" name="cut_before" id="cut_before" value="{{ $cut_before }}" placeholder="Enter Cut (Before Process)" >
                    </div>
                </div> 
                <div class="col-lg-3 cut">
                    <div class="input_box">
                        <p>Cut (After Process)</p>
                        <input type="text" name="cut_after" id="cut_after" value="{{ $cut_after }}" placeholder="Enter Cut (After Process)" >
                    </div>
                </div> 
                <div class="col-lg-3 blouse">
                    <div class="input_box">
                        <p>Blouse (Before Process)</p>
                        <input type="text" name="blouse_before" id="blouse_before" value="{{ $blouse_before }}" placeholder="Enter Blouse (Before Process)" >
                    </div>
                </div> 
                <div class="col-lg-3 blouse">
                    <div class="input_box">
                        <p>Blouse (After Process)</p>
                        <input type="text" name="blouse_after" id="blouse_after" value="{{ $blouse_after }}" placeholder="Enter Blouse (After Process)" >
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>GST (%)</p>
                        <input type="text" name="gst" id="gst" value="{{ $gst }}" placeholder="Enter GST (%)" >
                    </div>
                </div>  
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Fabric Property</p>
                        <select name="mst_fabric_property_id" id="mst_fabric_property_id" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select Fabric Property" required>
                            <option value="">--Select--</option> 
                            <?php foreach($fabric_propertys as $fabric_property){?>
                                <option value="{{ $fabric_property->id }}" {{ $mst_fabric_property_id == $fabric_property->id ? 'selected' : '' }}>{{ $fabric_property->title }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Product Photo</p>
                        <input type="file" name="images" id="images" />
                        <img src="{{$images}}" height="80px"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Active</option> 
                            <option value="1" @if($status == "0"){{"selected"}}@endif>In-Active</option>    
                        </select>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Colors</p>
                        @php $ext=explode('|',$colors);@endphp
                        
                        <select name="colors[]"   multiple="multiple" class="label_id colors xx">
                            @foreach($ext as $k=>$ex)
                                @if($ex)
                                    <option value="{{ $ex}}" selected>{{ $ex }}</option>
                                @endif
                            @endforeach
                        </select>                       
                    </div>
                </div> 
            </div>

            <div class="row">            
                @if(count($po_det)>0)
                    <div class="renewal_table add_yarn_table">
                        <div class="table-responsive" style="min-height:auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="first_radius small_name">#</th>
                                        <th scope="col">Shade No.</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Qty</th>  
                                        <th scope="col" class="last_radius"></th>
                                    </tr>
                                </thead>
                                <tbody id="attributes" class="attributes">
                                    @if(count($po_det)>0)
                                    @foreach($po_det as $key1 => $item)
                                    <tr class="vendor-detail-row attri new">
                                        <td>
                                            <div class="input_box normal_text counter2">
                                                <input type="text" name="display_item[{{ $key1+1 }}]" id="display_item{{ $key1+1 }}" value="{{ $key1+1 }}" class="display_items">
                                            </div>
                                        </td>
                                                    
                                        <td> 
                                            <div class="input_box">
                                                <select name="shade_no[{{ $key1+1 }}]" id="shade_no{{ $key1+1 }}" class="form-control shade_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                    <option value="">--Select--</option> 
                                                    <?php foreach($products as $product){?>
                                                        <option value="{{ $product->id }}" data-color="{{$product->color}}" {{ $item->yarn_product_vendor_detail_id == $product->id ? 'selected' : '' }} >{{ $product->shade_no }}</option>
                                                    <?php }?>
                                                            
                                                </select> 
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="input_box">
                                                <input type="text" readonly name="color[{{ $key1+1 }}]" id="color{{ $key1+1 }}" value="{{ $item->color }}" class="colors" placeholder="Red">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="qty[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->qty }}" class="qty" placeholder="Enter quantity">
                                            </div>
                                        </td> 
                                        
                                        <td class="action_td">

                                            <div class="d-flex align-items-center"> 

                                                <a href="javascript:void(0)" class="add2 add_form_btn dark-btn me-2" onclick="add2(this);" id="add-row" title="add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"></path></svg>Add
                                                </a>

                                                <input type="hidden" name="po_detail_id[{{ $key1+1 }}]" id="po_detail_id{{ $key1+1 }}" value="{{ $item->id }}" class="form-control po_detail_id">

                                                <a href="javascript:void(0)" class="remove_vendor_detail remove2 @if(count($po_det)<2) d-none @endif" onclick="remove2(this);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                        <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>                
                @else
                    <div class="renewal_table add_yarn_table">
                        <div class="table-responsive" style="min-height:auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="first_radius small_name">#</th>
                                        <th scope="col">Process</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Rate</th> 
                                        <th scope="col">GST (%)</th> 
                                        <th scope="col">Timeline</th>  
                                        <th scope="col" class="last_radius"></th>
                                    </tr>
                                </thead>
                                <tbody id="attributes" class="attributes">
                                        
                                    <tr class="vendor-detail-row attri new">
                                        <td>
                                            <div class="input_box normal_text counter2">
                                                <input type="text" name="display_item[0]" id="display_item11" value="1" class="display_items">
                                            </div>
                                        </td>
                                                    
                                        <td> 
                                            <div class="input_box">
                                                <select name="process[0]" id="shade_no1" class="form-control shade_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                    
                                                </select> 
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="input_box">
                                                <select name="vendor[0]" id="shade_no1" class="form-control shade_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                    
                                                </select> 
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="rate[0]" id="qty1" value="" class="qty" placeholder="Enter quantity">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="gst[0]" id="qty1" value="" class="qty" placeholder="Enter quantity">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="timeline[0]" id="qty1" value="" class="qty" placeholder="Enter quantity">
                                            </div>
                                        </td> 
                                        <td class="action_td">
                                            
                                            <input type="hidden" name="po_detail_id[0]" id="po_detail_id1" value="" class="form-control po_detail_id">
                                                        
                                            <div class="d-flex align-items-center"> 
                                                <a href="javascript:void(0)" class="add2 add_form_btn dark-btn  me-2" onclick="add2(this);" id="add-row" title="add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"></path></svg>Add
                                                </a>
                                                    
                                                <a href="javascript:void(0)" class="remove_vendor_detail remove2 d-none" onclick="remove2(this);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                        <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                @endif   
            </div>
            
            
            <input type="hidden" name="id" id="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/fabricproduct') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="dark-btn">Save</button>
            </div>
        </form>
    </div>                
</div>



@endsection

@section('delscript')
<script>
$(document).ready(function() {
    
    $('.label_id').select2({
        tags: true,
        placeholder: "Select or add a colors",
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term,
                newTag: true // add additional parameters
            }
        }
    }); 
    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/fabricproduct/manage-fabricproduct-process') }}",
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
                        window.location.href = "{{ url('admin/fabricproduct') }}";
                }
                else {
                    Command: toastr["error"](obj.message, "Message")	
                    $('.overlay-wrapper').hide();
                }
                },1000);
            }
        })	
	})  
    
    $(document).on("change", "#mst_fabric_type_id", function() {
        var id = $(this).val();  // Correctly get the `data-id` attribute
        if(id=='3'){
            $('.cut').addClass('d-none');
            $('.blouse').removeClass('d-none');
        }else if(id=='2'){
            $('.cut').addClass('d-none');
            $('.blouse').addClass('d-none');
        }else if(id=='1'){
            $('.cut').removeClass('d-none');
            $('.blouse').removeClass('d-none');
        }
     
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



</script>



@endsection