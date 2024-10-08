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

            <input type="hidden" id="counters" value="{{ isset($product_record) ? count($product_record) : 1 }}" />
            <div class="mainadd_yarn_box attributes3" id="attributes3">
                <!-- Existing vendor box -->
                    <?php 
                    if(@$product_record){
                        $i=0;
                    foreach($product_record as $key=>$product){ ?>
                        
                    <div class="main_add_yarn_box mt-3">
                    
                        <div class="attri3 new3" id="new3">
                            <input type="hidden" name="hidden_counter[{{ $key+1 }}]" id="hidden_counter{{ $key+1 }}" class="form-control hidden_counters" value="{{ $key+1 }}">
                                
                            <!-- Vendor Row -->
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Vendor Name</p>
                                        <select name="yarn_vendor_id[{{ $key+1 }}]" id="yarn_vendor_id{{ $key+1 }}" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                            <option value="">--Select--</option> 
                                            <?php foreach($getVendors as $getVendor){?>
                                                <option value="{{ $getVendor->id }}" {{ $product->yarn_vendor_id == $getVendor->id ? 'selected' : '' }}>{{ $getVendor->name }}</option>
                                            <?php }?>
                                                    
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Vendor Yarn Name</p>
                                        <input type="text" name="vendor_yarn_name[{{ $key+1 }}]" value="{{ $product->vendor_yarn_name }}" id="vendor_yarn_name{{ $key+1 }}" class="vendoryarnname" placeholder="Enter Yarn Name">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Denier</p>
                                        <input type="text" name="denier[{{ $key+1 }}]" value="{{ $product->denier }}" id="denier{{ $key+1 }}" class="deniers" placeholder="Enter Denier">
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-4">
                                    <div class="delete_btn">
                                        <a href="javascript:void(0)" class="add_form_btn dark-btn" onclick="add3()">  
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-3"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>
                                        Add</a>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="delete_btn">

                                        <input type="hidden" name="product_id[{{ $key+1 }}]" id="product_id{{ $key+1 }}" class="form-control product_ids" value="{{ $product->id }}" >
                                
                                        <a href="javascript:void(0)" class="inner_delete_btn" onclick="remove3(this);">
                                            <img src="{{ url('public/admin/images/delete_icon.svg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Vendor Detail Table -->
                            <div class="renewal_table add_yarn_table">
                                <div class="table-responsive" style="min-height:auto">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="first_radius small_name">#</th>
                                                <th scope="col">Shade No.</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">MOQ</th>  
                                                <th scope="col" class="last_radius">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attributes2" class="attributes2">
                                            
                                            @php
                                                $product_items = \App\Models\YarnProductVendorDetail::where('yarn_product_vendor_id', $product->id)->where('yarn_product_id', $id)->where('is_deleted',0)->get();
                                            @endphp
                                            <input type="hidden" class="counts" value="{{ isset($product_items) ? count($product_items) : 1 }}" />
                                            @if(isset($product_items))
                                            @foreach($product_items as $key1 => $item)
                                            <tr class="vendor-detail-row attri2 new2">
                                                <td>
                                                    <div class="input_box normal_text counter2">
                                                        <input type="text" name="display_item[{{ $key+1 }}][{{ $key1+1 }}]" id="display_item{{ $key+1 }}{{ $key1+1 }}" value="{{ $item->display_order }}" class="display_items">
                                                    </div>
                                                </td>
                                                            
                                                <td> 
                                                    <div class="input_box">
                                                        <input type="text" name="shade_no[{{ $key+1 }}][{{ $key1+1 }}]" id="shade_no{{ $key+1 }}{{ $key1+1 }}" value="{{ $item->shade_no }}" class="shadeno" placeholder="ST1965">
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="color[{{ $key+1 }}][{{ $key1+1 }}]" id="color{{ $key+1 }}{{ $key1+1 }}" value="{{ $item->color }}" class="colors" placeholder="Red">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="number" name="moq[{{ $key+1 }}][{{ $key1+1 }}]" id="moq{{ $key+1 }}{{ $key1+1 }}" value="{{ $item->moq }}" class="moqs" placeholder="Enter minimum quantity">
                                                    </div>
                                                </td> 
                                                
                                                <td class="action_td">

                                                    <div class="d-flex align-items-center"> 

                                                        <a href="javascript:void(0)" class="add2 add_form_btn dark-btn  me-4" onclick="add2(this);" id="add-row" title="add">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>Add
                                                        </a>

                                                        <input type="hidden" name="product_item_id[{{ $key+1 }}][{{ $key1+1 }}]" id="product_item_id{{ $key+1 }}{{ $key1+1 }}" value="{{ $item->id }}" class="form-control product_itemid">

                                                        <a href="javascript:void(0)" class="remove_vendor_detail remove2" onclick="remove2(this);">
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
                            <input type="hidden" class="form-control product_recordid" name="product_record_id[1]" id="product_record_id0" value=""> 
                        </div>
                    </div>    
                    <?php $i++;}} else{?>
                    <div class="main_add_yarn_box mt-3">  

                        <div class="attri3 new3" id="new3">
                            <input type="hidden" name="hidden_counter[1]" id="hidden_counter" class="form-control hidden_counters" value="1">
                                
                            <!-- Vendor Row -->
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Vendor Name</p>
                                        <select name="yarn_vendor_id[1]" id="yarn_vendor_id1" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                            <option value="">--Select--</option> 
                                            <?php foreach($getVendors as $getVendor){?>
                                                <option value="{{ $getVendor->id }}">{{ $getVendor->name }}</option>
                                            <?php }?>
                                                    
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Vendor Yarn Name</p>
                                        <input type="text" name="vendor_yarn_name[1]" value="" id="vendor_yarn_name1" class="vendoryarnname" placeholder="Enter Yarn Name">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Denier</p>
                                        <input type="text" name="denier[1]" value="" id="denier1" class="deniers" placeholder="Enter Denier">
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-4">
                                    <div class="delete_btn">
                                        <a href="javascript:void(0)" class="add_form_btn dark-btn" onclick="add3();">  
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>
                                        Add</a>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="product_id[1]" id="product_id1" class="form-control product_ids" value="" >
                            </div>
                            <!-- Vendor Detail Table -->
                            <div class="renewal_table add_yarn_table">
                                <div class="table-responsive" style="min-height:auto">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="first_radius small_name">#</th>
                                                <th scope="col">Shade No.</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">MOQ</th>  
                                                <th scope="col" class="last_radius">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attributes2" class="attributes2">
                                            <input type="hidden" class="counts" value='1' />
                                                
                                            <tr class="vendor-detail-row attri2 new2">
                                                <td>
                                                    <div class="input_box normal_text counter2">
                                                        <input type="text" name="display_item[1][1]" id="display_item11" value="1" class="display_items">
                                                    </div>
                                                </td>
                                                            
                                                <td> 
                                                    <div class="input_box">
                                                        <input type="text" name="shade_no[1][1]" id="shade_no11" value="" class="shadeno" placeholder="ST1965">
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="color[1][1]" id="color11" value="" class="colors" placeholder="Red">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="number" name="moq[1][1]" id="moq11" value="" class="moqs" placeholder="Enter minimum quantity">
                                                    </div>
                                                </td> 
                                                
                                                <td class="action_td">
                                                    
                                                        <input type="hidden" name="product_item_id[1][1]" id="product_item_id11" value="" class="form-control product_itemid">
                                                                
                                                    <div class="d-flex align-items-center"> 
                                                        <a href="javascript:void(0)" class="add2 add_form_btn dark-btn" onclick="add2(this);" id="add-row" title="add">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>
                                                            </svg>
                                                            Add
                                                        </a>
                                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            <input type="hidden" class="form-control product_recordid" name="product_record_id[1]" id="product_record_id0" value=""> 
                        </div>
                    
                    </div>
                    <?php }?> 
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

    function add3() {
       
        var counters=parseInt($("#counters").val())+1;
        
        var html="";
        html+='<div class="main_add_yarn_box mt-3">';
        html+='<div class="attri3 new3" id="new3">';
        html+='<input type="hidden" name="hidden_counter['+counters+']" id="hidden_counter'+counters+'" class="form-control hidden_counters" value="'+counters+'">';     
       
        html+='<div class="row">';
        html+='<div class="col-lg-3">';
        html+='<div class="input_box">';
        html+='<p>Vendor Name</p>';
        html+='<select name="yarn_vendor_id['+counters+']" id="yarn_vendor_id'+counters+'" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select vendor" required>';
        html+='<option value="">--Select--</option>';
        <?php foreach($getVendors as $getVendor){?>
        html+='<option value="{{ $getVendor->id }}">{{ $getVendor->name }}</option>';
       <?php }?>
                             
        html+='</select>'; 
        html+='</div>';
        html+='</div>'; 
        html+='<div class="col-lg-3">';
        html+='<div class="input_box">';
        html+='<p>Vendor Yarn Name</p>';
        html+='<input type="text" name="vendor_yarn_name['+counters+']" value="" id="vendor_yarn_name'+counters+'" class="vendoryarnname" placeholder="Enter Yarn Name">';
        html+='</div>';
        html+='</div>';
        html+='<div class="col-lg-3">';
        html+='<div class="input_box">';
        html+='<p>Denier</p>';
        html+='<input type="text" name="denier['+counters+']" value="" id="denier'+counters+'" class="deniers" placeholder="Enter Denier">';
        html+='</div>';
        html+='</div>';
        html+='<div class="col-lg-2 mt-4">';
        html+='<div class="delete_btn">';
        html+='<a href="javascript:void(0)" class="add_form_btn dark-btn" onclick="add3()">';
        html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">';
        html+='<path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>';
        html+='</svg>Add</a>';
        html+='</div>';
        html+='</div>';
            
        html+='<input type="hidden" name="product_id['+counters+']" id="product_id'+counters+'" class="form-control product_ids" value="" >';
        html+='</div>';
        html+='<div class="renewal_table add_yarn_table">';
        html+='<div class="table-responsive" style="min-height:auto">';
            html+='<table class="table">';
                html+='<thead>';
                    html+='<tr>';
                        html+='<th scope="col" class="first_radius small_name">#</th>';
                        html+='<th scope="col">Shade No.</th>';
                        html+='<th scope="col">Color</th>';
                        html+='<th scope="col">MOQ</th>';
                        html+='<th scope="col" class="last_radius">Action</th>';
                    html+='</tr>';
                html+='</thead>';
                html+='<tbody id="attributes2" class="attributes2">';
                    html+='<input type="hidden" class="counts" value="1" />';
                     
                    html+='<tr class="vendor-detail-row attri2 new2">';
                        html+='<td>';
                            html+='<div class="input_box normal_text counter2">';
                                html+='<input type="text" name="display_item['+counters+'][1]" id="display_item'+counters+'1" value="1" class="display_items">';
                            html+='</div>';
                        html+='</td>';
                                    
                        html+='<td>';
                            html+='<div class="input_box">';
                                html+='<input type="text" name="shade_no['+counters+'][1]" id="shade_no'+counters+'1" value="" class="shadeno" placeholder="ST1965">';
                            html+='</div>';
                        html+='</td>';
                       
                        html+='<td>';
                            html+='<div class="input_box">';
                                html+='<input type="text" name="color['+counters+'][1]" id="color'+counters+'1" value="" class="colors" placeholder="Red">';
                            html+='</div>';
                        html+='</td>';
                        
                        html+='<td>';
                            html+='<div class="input_box">';
                                html+='<input type="number" name="moq['+counters+'][1]" id="moq'+counters+'1" value="" class="moqs" placeholder="Enter minimum quantity">';
                            html+='</div>';
                        html+='</td>'; 
                        
                        html+='<td class="action_td">';
                            
                             html+='<input type="hidden" name="product_item_id['+counters+'][1]" id="product_item_id'+counters+'1" value="" class="form-control product_itemid">';
                                       
                            html+='<div class="d-flex align-items-center">'; 
                                html+='<a href="javascript:void(0)" class="add2 add_form_btn dark-btn" onclick="add2(this);" id="add-row" title="add">';
                                    html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">';
                                        html+='<path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>';
                                    html+='</svg>Add';
                                html+='</a>';
                                           
                                
                            html+='</div>';
                       html+='</td>';
                    html+='</tr>';
                    
                html+='</tbody>';
            html+='</table>';
            
        html+='</div>';
        html+='</div>';
        html+='<input type="hidden" class="form-control product_recordid" name="product_record_id['+counters+']" id="product_record_id'+counters+'" value="">'; 
        html+='</div>';
        html+='</div>';
        $("#attributes3").append(html);
        $("#counters").val(counters);
       
        $('.xx').select2();
        $('.xxxx').select2();
        reset();
        
    }

    
    function reset(){
        var i = 1;
        $('.new3').each(function(j) {
            $(this).find('.hidden_counters').attr("name", `hidden_counter[${i}]`);
            $(this).find('.hidden_counters').val(i);
            $(this).find('.product_ids').attr("name", `product_id[${i}]`);
            $(this).find('.yarn_vendorid').attr("name", `yarn_vendor_id[${i}]`);
            $(this).find('.vendoryarnname').attr("name", `vendor_yarn_name[${i}]`);
            $(this).find('.deniers').attr("name", `denier[${i}]`);
            reset_child($(this),i);
            i = i + 1;
            
        });
    }
    
    function reset_child(element,i){
        var datas=element.find('.table tr.attri2');
            var j=1;
            datas.each(function() {
                $(this).find("td:eq(0) input").prop('name', 'display_item[' + i + ']['+j+']');
               // $(this).find("td:eq(0) input").val(j);
                $(this).find("td:eq(1) input").prop('name', 'shade_no[' + i + ']['+j+']');
                $(this).find("td:eq(2) input").prop('name', 'color[' + i + ']['+j+']');
                $(this).find("td:eq(3) input").prop('name', 'moq[' + i + ']['+j+']');
                $(this).find("td:eq(4) input").prop('name', 'product_item_id[' + i + ']['+j+']');
                j=j+1;
            });
    }
    
    function remove3(element) {
        var h=$(element);
    
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
                var prodid = h.prev('input').val();
                if(prodid != "undefined"){
                    $.ajax({
                        url:"{{ url('admin/product/deletevendor') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{prodid:prodid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            //alert(h.prev('input').val());
                            element.closest("div.main_add_yarn_box").remove();
                            var counters=parseInt($("#counters").val())-1;
                            $("#counters").val(counters);
                        
                            reset();
                        }else{
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Some Error Occurred", "Message")
                        }
                        },1000);
                        }
                    })
                }else{
                    Command: toastr["error"]("Deleted Successfully", "Message")
                    //alert(h.prev('input').val());
                    element.closest("div.main_add_yarn_box").remove();
                    var counters=parseInt($("#counters").val())-1;
                    $("#counters").val(counters);
                    reset();
                }
                
            } else {
                    swal("Your record is safe!");
                }
        }); 
    }


    function add2(element){
        //var counts=$("#counters").val();
       
        var adds=$(element);
        var counts=parseInt(adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".hidden_counters").val());
        var counters=parseInt(adds.parent().parent().parent().parent().find(".counts").val())+1;
        var html="";
        html+='<tr class="vendor-detail-row attri2 new2">';
            html+='<td>';
                html+='<div class="input_box normal_text counter2">';
                    html+='<input type="text" name="display_item['+counts+']['+counters+']" id="display_item'+counts+''+counters+'" value="' + counters + '" class="display_items">';
                html+='</div>';
            html+='</td>';
                        
            html+='<td>';
                html+='<div class="input_box">';
                    html+='<input type="text" name="shade_no['+counts+']['+counters+']" id="shade_no'+counts+''+counters+'" value="" class="shadeno" placeholder="ST1965">';
                html+='</div>';
            html+='</td>';
           
            html+='<td>';
                html+='<div class="input_box">';
                    html+='<input type="text" name="color['+counts+']['+counters+']" id="color'+counts+''+counters+'" value="" class="colors" placeholder="Red">';
                html+='</div>';
            html+='</td>';
            
            html+='<td>';
                html+='<div class="input_box">';
                    html+='<input type="number" name="moq['+counts+']['+counters+']" id="moq'+counts+''+counters+'" value="" class="moqs" placeholder="Enter minimum quantity">';
                html+='</div>';
            html+='</td>';
            
            html+='<td class="action_td">';
                
                html+='<input type="hidden" name="product_item_id['+counts+']['+counters+']" id="product_item_id'+counts+''+counters+'" value="" class="form-control product_itemid">';
                           
                html+='<div class="d-flex align-items-center">'; 
                
                    html+='<a href="javascript:void(0)" class="add2 add_form_btn dark-btn me-4" onclick="add2(this);" id="add-row" title="add">';
                        html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">';
                            html+='<path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>';
                        html+='</svg>Add';
                    html+='</a>';
                              
                    html+='<a href="javascript:void(0)" class="remove_vendor_detail remove2" onclick="remove2(this);">';
                        html+='<svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">';
                            html+='<path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>';
                        html+='</svg>';
                    html+='</a>'; 
                    
                html+='</div>';
            html+='</td>';
        html+='</tr>';
        adds.parent().parent().parent().parent().parent().find('.attributes2').append(html);
        adds.parent().parent().parent().parent().find(".counts").val(counters);
        $('.xxxx').select2();
        reset_child(adds.parent().parent().parent().parent().parent().parent().parent().parent(),counts);
    }
    
    
    function remove2(element) {
        var mains=$(element).parent().parent().parent().parent().parent().parent().parent().parent();
        
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
                var adds=$(element);
                //alert(adds.prev('input').val());
                var itemid = adds.prev('input').val();
                alert(itemid);
                if (!itemid) { // Check if itemid is undefined or empty
                    Command: toastr["error"]("Deleted Successfully", "Message");
                    var counters = parseInt(adds.parent().parent().parent().parent().find(".counts").val()) - 1;
                    adds.parent().parent().parent().parent().find(".counts").val(counters);
                    element.closest(".attri2").remove();
                    reset_child(mains, mains.find(".hidden_counters").val());
                } else {
                    $.ajax({
                        url:"{{ url('admin/product/deletevendordetail') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{itemid:itemid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            var counters=parseInt(adds.parent().parent().parent().parent().find(".counts").val())-1;
                            adds.parent().parent().parent().parent().find(".counts").val(counters);
                            element.closest(".attri2").remove();
                            reset_child(mains,mains.find(".hidden_counters").val());
                        
                        }else{
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Some Error Occurred", "Message")
                        }
                        },1000);
                        }
                    })
                }
            } else {
                    swal("Your record is safe!");
                }
        });
    }

</script>


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

</script>


@endsection