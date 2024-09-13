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
                        <input type="text" name="gst_main" id="gst" value="{{ $gst }}" placeholder="Enter GST (%)" >
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
                        @if($images)
                        <img src="{{asset('/public/fabric_product/').'/'.$images}}" id="img" style="height: 80px;"/>
                        @endif
                        <input type="hidden" name="images_hidden" value="{{$images}}"/>
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
                                        <th scope="col">Process</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Rate</th> 
                                        <th scope="col">GST (%)</th> 
                                        <th scope="col">Timeline</th>  
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
                                                <select name="process[{{ $key1+1 }}]"  id="shade_no{{ $key1+1 }}" class="form-control process xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                <option value="">--Select--</option> 
                                                <?php foreach($fabric_process as $fabric_proc){?>
                                                    <option value="{{ $fabric_proc->id }}" {{ $item->process_id == $fabric_proc->id ? 'selected' : '' }}>{{ $fabric_proc->title }}</option>
                                                <?php }?>
                                                </select> 
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="input_box">
                                                <select name="fabric_process_vendor[{{ $key1+1 }}]" id="fabric_process_vendor{{ $key1+1 }}" class="form-control fabric_process_vendor xx mySelect2">
                                                <option value="">--Select--</option>     
                                                <?php foreach($fabric_process_vendors as $fabric_process_vendor){?>
                                                        <option value="{{ $fabric_process_vendor->id }}" {{ $item->process_vendor_id == $fabric_process_vendor->id ? 'selected' : '' }}>{{ $fabric_process_vendor->name }}</option>
                                                    <?php }?> 
                                                </select> 
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="rate[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->rate }}" class="rate" placeholder="Enter Rate">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="gst[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->gst }}" class="gst" placeholder="Enter GST">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="timeline[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->timeline }}" class="timeline" placeholder="Enter Timeline">
                                            </div>
                                        </td> 
                                        
                                        <td class="action_td">

                                            <div class="d-flex align-items-center"> 

                                                <a href="javascript:void(0)" class="add2 add_form_btn dark-btn me-2" onclick="add2(this);" id="add-row" title="add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"></path></svg>Add
                                                </a>

                                                <input type="hidden" name="product_process_id[{{ $key1+1 }}]" id="product_process_id{{ $key1+1 }}" value="{{ $item->id }}" class="form-control product_process_id">

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
                                                <input type="text" name="display_item[0]" id="display_item10" value="1" class="display_items">
                                            </div>
                                        </td>
                                                    
                                        <td> 
                                            <div class="input_box">
                                                <select name="process[0]" id="process0" class="form-control process xx mySelect" data-validate="required" data-message-required="Select process" required>
                                                    <option value="">--Select--</option> 
                                                    <?php foreach($fabric_process as $fabric_proc){?>
                                                        <option value="{{ $fabric_proc->id }}" >{{ $fabric_proc->title }}</option>
                                                    <?php }?>
                                                </select> 
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="input_box">
                                                <select name="fabric_process_vendor[0]" id="fabric_process_vendor0" class="form-control fabric_process_vendor xx mySelect" >
                                                    <option value="">--Select--</option> 
                                                    <?php foreach($fabric_process_vendors as $fabric_process_vendor){?>
                                                        <option value="{{ $fabric_process_vendor->id }}" >{{ $fabric_process_vendor->name }}</option>
                                                    <?php }?>
                                                </select> 
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="rate[0]" id="rate0" value="" class="rate" placeholder="Enter Rate">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="gst[0]" id="gst0" value="" class="gst" placeholder="Enter GST">
                                            </div>
                                        </td> 
                                        <td>
                                            <div class="input_box">
                                                <input type="number" name="timeline[0]" id="timeline0" value="" class="timeline" placeholder="Enter Timeline">
                                            </div>
                                        </td> 
                                        <td class="action_td">
                                            
                                            <input type="hidden" name="product_process_id[0]" id="product_process_id0" value="" class="form-control product_process_id">
                                                        
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

                <div class="mainadd_yarn_box attributes1" id="attributes1">
                    <!-- Existing vendor box -->
                    
                    <div class="main_add_yarn_box mt-3">  

                        <div class="attri1 new1" id="new1">
                               
                            <!-- Vendor Row -->
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Vendor Name</p>
                                        <select name="fabric_weaver_vendor_id[1]" id="fabric_weaver_vendor_id1" class="form-control fabric_weaver_vendor_id xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                            <option value="">--Select--</option> 
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Vendor Fabric Product Name</p>
                                        <input type="text" name="vendor_fabric_product_name[1]" value="" id="vendor_fabric_product_name1" class="vendor_fabric_product_name" placeholder="Enter Product Name">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Product Design Name</p>
                                        <input type="text" name="product_design_name[1]" value="" id="product_design_name1" class="product_design_name" placeholder="Enter Design Name">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Product Design Photo</p>
                                        <input type="file" name="product_design_photo[1]" value="" id="product_design_photo1" class="product_design_photo" placeholder="Enter Photo">
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-4">
                                    <div class="delete_btn">
                                        <a href="javascript:void(0)" class="add_form_btn dark-btn" onclick="add3(this);">  
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/></svg>
                                        Add</a>
                                    </div>
                                </div>
                                <div class="col-lg-2 mt-4">
                                    <div class="delete_btn">
                                        <a href="javascript:void(0)" class="remove_vendor_detail remove3 d-none" onclick="remove3(this);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>    
                                <input type="hidden" name="counters[1]" id="counters1" class="form-control counters" value="1" >
                                <input type="hidden" name="product_id[1]" id="product_id1" class="form-control product_ids" value="" >
                            </div>
                            <div class="row">
                                <h2>Yarn Costing</h2>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Total Card</p>
                                        <input type="text" name="total_card[1]" value="" id="total_card1" class="total_card" placeholder="Enter Total Card">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Avg Peak</p>
                                        <input type="text" name="avg_peak[1]" value="" id="avg_peak1" class="avg_peak" placeholder="Enter Avg Peak">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Size</p>
                                        <input type="text" readonly name="size[1]" value="" id="size1" class="size" placeholder="Enter Size">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Panna</p>
                                        <input type="text" name="panna[1]" value="" id="panna1" class="panna" placeholder="Enter Panna">
                                    </div>
                                </div>
                            </div>
                            <!-- Vendor Detail Table -->
                            <div class="renewal_table add_yarn_table">
                                <h2>WARP</h2>
                                <div class="table-responsive" style="min-height:auto">
                                    <table class="table tb_warp">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="first_radius small_name">#</th>
                                                <th scope="col">Yarn</th>
                                                <th scope="col">Denier</th>
                                                <th scope="col">Taar</th> 
                                                <th scope="col">Wt</th> 
                                                <th scope="col">Rate</th> 
                                                <th scope="col">Costing</th>  
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
                                                        <select name="yarn_product_id_warp[1]" id="yarn_product_id_warp1" class="form-control yarn_product_id_warp xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                            <option value="">--Select--</option> 
                                                        </select> 
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="denier_warp[1][1]" id="denier_warp11" value="" class="denier_warp" placeholder="Denier">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="taar_warp[1][1]" id="taar_warp11" value="" class="taar_warp" placeholder="Enter Taar">
                                                    </div>
                                                </td> 
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="wt_warp[1][1]" id="wt_warp11" value="" class="wt_warp" placeholder="Wt" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="rate_warp[1][1]" id="rate_warp11" value="" class="rate_warp" placeholder="Rate">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="cost_warp[1][1]" id="cost_warp11" value="" class="cost_warp" placeholder="Cost">
                                                    </div>
                                                </td>
                                                <td class="action_td">
                                                    
                                                        <input type="hidden" name="product_item_id[1][1]" id="product_item_id11" value="" class="form-control product_itemid">
                                                                
                                                    <div class="d-flex align-items-center"> 
                                                        <a href="javascript:void(0)" class="add2 add_form_btn dark-btn" onclick="add4(this);" id="add-row" title="add">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>
                                                            </svg>
                                                            Add
                                                        </a>
                                                                    
                                                    </div>
                                                    <div class="col-lg-2 mt-4">
                                                        <div class="delete_btn">
                                                            <a href="javascript:void(0)" class="remove_vendor_detail remove4 d-none" onclick="remove4(this);">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                                    <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>   
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr class="vendor-detail-row">
                                                <td>
                                                    Total
                                                </td>
                                                            
                                                <td> 
                                                    
                                                </td>
                                                
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    
                                                </td> 
                                                <td>
                                                    <input type="text" name="total_wt_warp[1][1]" id="total_wt_warp11" value="1" readonly class="total_wt_warp">
                                                </td>
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="total_costing_warp[1][1]" id="total_costing_warp11" value="1" readonly class="total_costing_warp">
                                                </td>
                                                <td >

                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                </div>
                            </div>
                            <div class="renewal_table add_yarn_table">
                                <h2>WEFT</h2>
                                <div class="table-responsive" style="min-height:auto">
                                    <table class="table tb_weft">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="first_radius small_name">#</th>
                                                <th scope="col">Yarn</th>
                                                <th scope="col">Denier</th>
                                                <th scope="col">Peak</th> 
                                                <th scope="col">Wt</th> 
                                                <th scope="col">Rate</th> 
                                                <th scope="col">Costing</th>  
                                                <th scope="col" class="last_radius">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attributes3" class="attributes3">
                                            <input type="hidden" class="counts" value='1' />
                                                
                                            <tr class="vendor-detail-row attri3 new3">
                                                <td>
                                                    <div class="input_box normal_text counter2">
                                                        <input type="text" name="display_item[1][1]" id="display_item11" value="1" class="display_items">
                                                    </div>
                                                </td>
                                                            
                                                <td> 
                                                    <div class="input_box">
                                                        <select name="yarn_product_id_weft[1]" id="yarn_product_id_weft1" class="form-control yarn_product_id_weft xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                            <option value="">--Select--</option> 
                                                        </select> 
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="denier_weft[1][1]" id="denier_weft11" value="" class="denier_weft" placeholder="Denier">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="peak_weft[1][1]" id="peak_weft11" value="" class="peak_weft" placeholder="Peak">
                                                    </div>
                                                </td> 
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="wt_weft[1][1]" id="wt_weft11" value="" class="wt_weft" placeholder="Wt">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="rate_weft[1][1]" id="rate_weft11" value="" class="rate_weft" placeholder="Rate">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input_box">
                                                        <input type="text" name="costing_weft[1][1]" id="costing_weft11" value="" class="costing_weft" placeholder="Costing">
                                                    </div>
                                                </td>
                                                <td class="action_td">
                                                    
                                                        <input type="hidden" name="product_item_id[1][1]" id="product_item_id11" value="" class="form-control product_itemid">
                                                                
                                                    <div class="d-flex align-items-center"> 
                                                        <a href="javascript:void(0)" class="add2 add_form_btn dark-btn" onclick="add5(this);" id="add-row" title="add">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="me-2">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.333 3.333a1.333 1.333 0 0 1 1.333 -1.333h3.68a1.333 1.333 0 0 1 1.041 0.5l0.933 1.167H13.333a1.333 1.333 0 0 1 1.333 1.333V12.667a1.333 1.333 0 0 1 -1.333 1.333H2.667a1.333 1.333 0 0 1 -1.333 -1.333zm6.667 2.667a0.667 0.667 0 0 1 0.667 0.667v1.333h1.333a0.667 0.667 0 0 1 0 1.333h-1.333v1.333a0.667 0.667 0 0 1 -1.333 0v-1.333H6a0.667 0.667 0 0 1 0 -1.333h1.333v-1.333a0.667 0.667 0 0 1 0.667 -0.667" fill="#f9d27e"/>
                                                            </svg>
                                                            Add
                                                        </a>
                                                                    
                                                    </div>
                                                    <div class="col-lg-2 mt-4">
                                                        <div class="delete_btn">
                                                            <a href="javascript:void(0)" class="remove_vendor_detail remove5 d-none" onclick="remove5(this);">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                                    <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>   
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr class="vendor-detail-row">
                                                <td>
                                                    Total
                                                </td>
                                                            
                                                <td> 
                                                    
                                                </td>
                                                
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    
                                                </td> 
                                                <td>
                                                    <input type="text" name="total_wt_weft[1][1]" id="total_wt_weft11" value="1" readonly class="total_wt_weft">
                                                </td>
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="total_costing_weft[1][1]" id="total_costing_weft11" value="1" readonly class="total_costing_weft">
                                                </td>
                                                <td >

                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Warp Wt</p>
                                        <input type="text" name="warp_wt[1]" value="" id="warp_wt1" class="warp_wt" placeholder="Warp Wt">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Warp Costing</p>
                                        <input type="text" name="warp_costing[1]" value="" id="warp_costing1" class="warp_costing" readonly placeholder="Warp Costing">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Weft Wt</p>
                                        <input type="text" name="weft_wt[1]" value="" id="weft_wt1" class="weft_wt" placeholder="Weft Wt">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Weft Costing</p>
                                        <input type="text" name="weft_costing[1]" value="" id="weft_costing1" class="weft_costing" readonly placeholder="Weft Costing">
                                    </div>
                                </div>
                                
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Total Wt</p>
                                        <input type="text" name="tot_wt_l[1]" value="" id="tot_wt_l1" readonly class="tot_wt_l" placeholder="Enter Size">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input_box">
                                        <p>Total Costing</p>
                                        <input type="text" readonly name="total_costing[1]" value="" id="total_costing1" class="total_costing" placeholder="Total Costing">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Avg Yarn Price</p>
                                        <input type="text" readonly name="avg_yarn_price[1]" value="" id="avg_yarn_price1" class="avg_yarn_price" placeholder="Avg Yarn Price">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Total Wt</p>
                                        <input type="text" readonly name="total_wt[1]" value="" id="total_wt1" class="total_wt" placeholder="Total Wt">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Actual Wt</p>
                                        <input type="text" readonly name="actual_wt[1]" value="" id="actual_wt1" class="actual_wt" placeholder="Actual Wt">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h2>Labour</h2>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Labour Rate</p>
                                        <input type="text" name="labour_rate[1]" value="" id="labour_rate1" class="labour_rate" placeholder="Enter Labour Rate">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Avg Peak</p>
                                        <input type="text" name="avg_peak_l[1]" value="" id="avg_peak_l1" class="avg_peak_l" readonly placeholder="Enter Avg Peak">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Size</p>
                                        <input type="text" name="size_l[1]" value="" id="size_l1" readonly class="size_l" placeholder="Enter Size">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Majuri</p>
                                        <input type="text" readonly name="majuri[1]" value="" id="majuri1" class="majuri" placeholder="Enter Majuri">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Labour Cost</p>
                                        <input type="text" readonly name="labour_cost[1]" value="" id="labour_cost1" class="labour_cost" placeholder="Enter Labour Cost">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h2>Process</h2>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Process</p>
                                        <input type="text" name="process[1]" value="" id="process1" readonly class="process" placeholder="Enter Process">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Size</p>
                                        <input type="text" name="size_p[1]" value="" id="size_p1" readonly class="size_p" placeholder="Enter Size">
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Process Cost</p>
                                        <input type="text" name="process_cost[1]" value="" id="process_cost1"  class="process_cost" readonly placeholder="Enter Process Cost">
                                    </div>
                                </div>                                                              
                            </div>
                            <div class="row">
                                <h2>Wastage</h2>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Total Cost</p>
                                        <input type="text" name="tot_cost[1]" value="" id="tot_cost1" readonly class="tot_cost" placeholder="Enter Total Cost">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Wastage in %</p>
                                        <input type="text" name="wastage_per[1]" value="" id="wastage_per1" class="wastage_per" placeholder="Enter Wastage in %">
                                    </div>
                                </div>  
                                <div class="col-lg-4">
                                    <div class="input_box">
                                        <p>Wastage Amount</p>
                                        <input type="text" name="wastage_amt[1]" value="" id="wastage_amt1"  class="wastage_amt" placeholder="Enter Wastage Amt">
                                    </div>
                                </div>                                                              
                            </div>
                            <div class="row">
                                <h2>Summary</h2>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Total Yarn Cost</p>
                                        <input type="text" name="tot_yarn_cost[1]" value="" id="tot_yarn_cost1" readonly class="tot_yarn_cost" placeholder="Total Yarn Cost">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Total Labour Cost</p>
                                        <input type="text" name="tot_labour_cost[1]" value="" id="tot_labour_cost1" class="tot_labour_cost" readonly placeholder="Total Labour Cost">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Total Process Cost</p>
                                        <input type="text" name="tot_process_cost[1]" value="" id="tot_process_cost1" readonly class="tot_process_cost" placeholder="Total Process Cost">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Wastage Amount</p>
                                        <input type="text" readonly name="tot_wastage_cost[1]" value="" id="tot_wastage_cost1" class="tot_wastage_cost" placeholder="Total Wastage Cost">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input_box">
                                        <p>Final Costing</p>
                                        <input type="text" readonly name="final_costing[1]" value="" id="final_costing1" class="final_costing" placeholder="Final Costing">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control product_recordid" name="product_record_id[1]" id="product_record_id0" value=""> 
                        </div>
                    
                    </div>
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
    update_yarn_costing();
    update_warp_total();
    update_weft_total();
    $(document).on('keyup', '.total_card', function(e) {
        update_yarn_costing();
    });

    $(document).on('keyup', '.rate', function(e) {
        update_yarn_costing();
    });

    $(document).on('keyup', '.avg_peak', function(e) {
        update_yarn_costing();
    });

    $(document).on('keyup', '.labour_rate', function(e) {
        update_yarn_costing();
    });

    $(document).on('keyup', '.wastage_per', function(e) {
        update_yarn_costing();
    });

    $(document).on('keyup', '.taar_warp', function(e) {
        update_warp_total();
    });

    $(document).on('keyup', '.denier_warp', function(e) {
        update_warp_total();
    });

    $(document).on('keyup', '.rate_warp', function(e) {
        update_warp_total();
    });

    $(document).on('keyup', '.peak_weft', function(e) {
        update_weft_total();
    });

    $(document).on('keyup', '.denier_weft', function(e) {
        update_weft_total();
    });

    $(document).on('keyup', '.rate_weft', function(e) {
        update_weft_total();
    });

    $(document).on('keyup', '.panna', function(e) {
        update_weft_total();
    });

    function add2(element){
        //var counts=$("#counters").val();
       
        var adds=$(element);

        var row1 = $(".new:last");
        row1.clone(true,true).appendTo("#attributes").find("input,select,textarea").val("");        
            
        reset_child(adds.parent().parent().parent().parent().parent().parent().parent().parent());
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
                    
                    element.closest(".attri").remove();
                    reset_child(mains);
                } else {
                    $.ajax({
                        url:"{{ url('admin/fabricproduct/deletepodetail') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{id:itemid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            
                            element.closest(".attri").remove();
                            reset_child(mains);
                        
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

    function reset_child(element){
        var datas=element.find('.table tr.attri');
        var j=0;
        var count=datas.length;            
        datas.each(function() {
            if(count<2){
                $(this).find("a.remove2").addClass('d-none');
            }else{
                $(this).find("a.remove2").removeClass('d-none');
            }
            $(this).find("td:eq(0) input").prop('name', 'display_item['+j+']');
            
            $(this).find("td:eq(1) select").prop('name', 'process['+j+']');
            $(this).find("td:eq(2) input").prop('name', 'fabric_process_vendor['+j+']');
            $(this).find("td:eq(3) input").prop('name', 'rate['+j+']');
            $(this).find("td:eq(5) input").prop('name', 'timeline['+j+']');
            $(this).find("td:eq(4) input").prop('name', 'gst['+j+']');
            $(this).find("td:eq(6) input").prop('name', 'product_process_id['+j+']');
            j=j+1;
            $(this).find("td:eq(0) input").val(j);
        });
        update_yarn_costing();
    }
    

    function add3(element){
        //var counts=$("#counters").val();
       
        var adds=$(element);

        var row1 = $(".main_add_yarn_box:last");
        row1.clone(true,true).appendTo("#attributes1").find("input,select,textarea").val("");        
            
        reset_child3(adds.parent().parent().parent().parent().parent().parent().parent().parent());
    }
        
    function remove3(element) {
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
                    
                    element.closest(".main_add_yarn_box").remove();
                    reset_child3(mains);
                } else {
                    $.ajax({
                        url:"{{ url('admin/fabricproduct/deletepodetail') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{id:itemid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            
                            element.closest(".main_add_yarn_box ").remove();
                            reset_child(mains);
                        
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

    function reset_child3(element){
        var datas=element.find('.main_add_yarn_box');
        
        var i=0;
        var count=datas.length;            
        datas.each(function() { 
            if(count<2){
                $(this).find("a.remove3").addClass('d-none');
            }else{
                $(this).find("a.remove3").removeClass('d-none');
            }
            $(this).find('.counters').attr("name", `counters[${i}]`);
            $(this).find('.counters').val(i);
            // $(this).find('.product_ids').attr("name", `product_id[${i}]`);
            // $(this).find('.display_prods').attr("name", `display_prod[${i}]`);
            // //$(this).find('.display_prods').val(i);
            // $(this).find('.locate').attr("name", `location[${i}]`);
            // $(this).find('.categoryid').attr("name", `category_id[${i}]`);
            // $(this).find('.modelid').attr("name", `model_id[${i}]`);
            // $(this).find('.moduleid').attr("name", `module_id[${i}]`);
            
            reset_child4($(this),i);
            reset_child5($(this),i);

            i=i+1;
        });
        update_yarn_costing();
    }
    
    function add4(element){
        //var counts=$("#counters").val();
       
        var adds=$(element);
        var tbody= adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".attributes2");
        var row1 = adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".new2:last");
        row1.clone(true,true).appendTo(tbody).find("input,select,textarea").val("");        
        var counts=parseInt(adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".counters").val());
         
        reset_child4(adds.parent().parent().parent().parent().parent().parent().parent().parent(),counts);
    }
        
    function remove4(element) {
        var mains=$(element).parent().parent().parent().parent().parent().parent().parent().parent();
        var counts=parseInt(mains.find(".counters").val());    
       
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
                    
                    element.closest(".attri2").remove();
                    reset_child4(mains,counts);
                } else {
                    $.ajax({
                        url:"{{ url('admin/fabricproduct/deletepodetail') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{id:itemid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            
                            element.closest(".attri").remove();
                            reset_child4(mains,counts);
                        
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

    function reset_child4(element,i){
        console.log(i);
        var datas=element.find('.table tr.attri2');
        var j=0;
        var count=datas.length;            
        datas.each(function() {
            if(count<2){
                $(this).find("a.remove4").addClass('d-none');
            }else{
                $(this).find("a.remove4").removeClass('d-none');
            }
            $(this).find("td:eq(0) input").prop('name', 'display_item['+i+']['+j+']');
            
            $(this).find("td:eq(1) select").prop('name', 'yarn_product_id_warp['+i+']['+j+']');
            $(this).find("td:eq(2) input").prop('name', 'denier_warp['+i+']['+j+']');
            $(this).find("td:eq(3) input").prop('name', 'taar_warp['+i+']['+j+']');
            $(this).find("td:eq(4) input").prop('name', 'wt_warp['+i+']['+j+']');
            $(this).find("td:eq(5) input").prop('name', 'rate_warp['+i+']['+j+']');
            $(this).find("td:eq(6) input").prop('name', 'costing_warp['+i+']['+j+']');
            $(this).find("td:eq(7) input").prop('name', 'product_process_id['+i+']['+j+']');
            j=j+1;
            $(this).find("td:eq(0) input").val(j);
        });
        update_warp_total();
    }
    
    function add5(element){
        //var counts=$("#counters").val();
       
        var adds=$(element);
        var tbody= adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".attributes3");
        var row1 = adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".new3:last");
        row1.clone(true,true).appendTo(tbody).find("input,select,textarea").val("");        
        var counts=parseInt(adds.parent().parent().parent().parent().parent().parent().parent().parent().find(".counters").val());       
        reset_child5(adds.parent().parent().parent().parent().parent().parent().parent().parent(),counts);
    }
        
    function remove5(element) {
        var mains=$(element).parent().parent().parent().parent().parent().parent().parent().parent();
        var counts=parseInt(mains.find(".counters").val());
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
                    
                    element.closest(".attri3").remove();
                    reset_child5(mains,counts);
                } else {
                    $.ajax({
                        url:"{{ url('admin/fabricproduct/deletepodetail') }}",
                        method:"POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{id:itemid},
                        beforeSend: function(){
                            $('.overlay-wrapper').show();  
                        },
                        success(response){
                        setTimeout(function(){    
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            $('.overlay-wrapper').hide(); 
                            Command: toastr["error"]("Deleted Successfully", "Message")
                            
                            element.closest(".attri").remove();
                            reset_child(mains,counts);
                        
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

    function reset_child5(element,i){
        var datas=element.find('.table tr.attri3');
        var j=0;
        var count=datas.length;            
        datas.each(function() {
            if(count<2){
                $(this).find("a.remove5").addClass('d-none');
            }else{
                $(this).find("a.remove5").removeClass('d-none');
            }
            $(this).find("td:eq(0) input").prop('name', 'display_item['+i+']['+j+']');
            
            $(this).find("td:eq(1) select").prop('name', 'yarn_product_id_weft['+i+']['+j+']');
            $(this).find("td:eq(2) input").prop('name', 'denier_weft['+i+']['+j+']');
            $(this).find("td:eq(3) input").prop('name', 'peak_weft['+i+']['+j+']');
            $(this).find("td:eq(4) input").prop('name', 'wt_weft['+i+']['+j+']');
            $(this).find("td:eq(5) input").prop('name', 'rate_weft['+i+']['+j+']');
            $(this).find("td:eq(6) input").prop('name', 'costing_weft['+i+']['+j+']');
            $(this).find("td:eq(7) input").prop('name', 'product_process_id['+i+']['+j+']');
            j=j+1;
            $(this).find("td:eq(0) input").val(j);
        });
        update_weft_total();
    }
    

    function update_yarn_costing(){
        var sum = 0;
        var sumprocess=0

        $('.attri').each(function(){
            //var sum = 0;
            var rate = $(this).find('.rate').val();       
            if(rate!=''){
                sumprocess = parseFloat(rate)+parseFloat(sumprocess);
            }

        });
        $(".process").val(sumprocess.toFixed(2));

        $('.main_add_yarn_box').each(function() {
            var tot_card = parseFloat($(this).find('.total_card').val());
            var avg_peak = parseFloat($(this).find('.avg_peak').val());
            if(avg_peak>0){
                $(this).find('.size').val(((tot_card/avg_peak)/39.37).toFixed(2));
            }else{
                $(this).find('.size').val(0);
            }
            var labour_rate = parseFloat($(this).find('.labour_rate').val());  

            $(this).find('.size_l').val($(this).find('.size').val());   
            $(this).find('.avg_peak_l').val(avg_peak);   

            $(this).find('.majuri').val(((tot_card/39.37)*labour_rate).toFixed(2)); 
            $(this).find('.labour_cost').val($(this).find('.majuri').val()); 
            
            $(this).find('.size_p').val($(this).find('.size').val()); 
            
            process_cost=sumprocess*(parseFloat($(this).find('.size').val())); 
            $(this).find('.process_cost').val(process_cost.toFixed(2));
            var tot_cost=process_cost+parseFloat($(this).find('.majuri').val())+parseFloat($(this).find('.total_costing').val());
            $(this).find('.tot_cost').val(tot_cost.toFixed(2));

            var wastage_per=parseFloat($(this).find('.wastage_per').val());
            var wastage_amt=((wastage_per*tot_cost)/100).toFixed(2);
            
            $(this).find('.wastage_amt').val(wastage_amt);

            var final_cost=parseFloat(wastage_amt)+parseFloat(process_cost)+parseFloat(tot_cost)+parseFloat($(this).find('.labour_cost').val());
            
            $(this).find('.tot_yarn_cost').val($(this).find('.total_costing').val());
            $(this).find('.tot_labour_cost').val($(this).find('.labour_cost').val());
            $(this).find('.tot_process_cost').val(process_cost);
            $(this).find('.tot_wastage_cost').val(wastage_amt);            
            $(this).find('.final_costing').val(final_cost.toFixed(2));
        });       
        update_warp_total();
        update_weft_total();
    }

    function update_warp_total()
    {    
        var sum = 0;
        var sumcost = 0;
        $('.tb_warp').each(function() {
            var size = $(this).parent().parent().parent().find('.size').val();

            $(this).find('.attri2').each(function(){
                //var sum = 0;
                var denier_warp = $(this).find('.denier_warp').val();
                var taar_warp = $(this).find('.taar_warp').val();
                var rate_warp = $(this).find('.rate_warp').val();

                var wt=(denier_warp*taar_warp*size)/9000000;
                var cost=rate_warp*wt;
                $(this).find('.wt_warp').val(wt.toFixed(2));
                $(this).find('.cost_warp').val(cost.toFixed(2));

                           
                if(wt!=''){
                    sum = parseFloat(wt)+parseFloat(sum);
                }

                if(cost!=''){
                    sumcost = parseFloat(cost)+parseFloat(sumcost);
                }
            });
            
            $(this).find('.total_wt_warp').val(sum.toFixed(2));
            $(this).find('.total_costing_warp').val(sumcost.toFixed(2));
            $(this).parent().parent().parent().find('.warp_wt').val(sum.toFixed(2));
            $(this).parent().parent().parent().find('.warp_costing').val(sumcost.toFixed(2));
            $(this).parent().parent().parent().find('.tot_wt_l').val((parseFloat($(this).parent().parent().parent().find('.warp_wt').val())+parseFloat($(this).parent().parent().parent().find('.weft_wt').val())).toFixed(2));
            $(this).parent().parent().parent().find('.total_costing').val((parseFloat($(this).parent().parent().parent().find('.warp_costing').val())+parseFloat($(this).parent().parent().parent().find('.weft_costing').val())).toFixed(2));
            $(this).parent().parent().parent().find('.avg_yarn_price').val($(this).parent().parent().parent().find('.total_costing').val());
            $(this).parent().parent().parent().find('.total_wt').val($(this).parent().parent().parent().find('.tot_wt_l').val());
            $(this).parent().parent().parent().find('.actual_wt').val($(this).parent().parent().parent().find('.total_costing').val());
        });
        
        
        
    }


    function update_weft_total()
    {    
        var sum = 0;
        var sumcost = 0;
        $('.tb_weft').each(function() {
            var size = $(this).parent().parent().parent().find('.size').val();
            var panna = $(this).parent().parent().parent().find('.panna').val();
            $(this).find('.attri3').each(function(){
                //var sum = 0;
                var denier_weft = $(this).find('.denier_weft').val();
                var peak_weft = $(this).find('.peak_weft').val();
                var rate_weft = $(this).find('.rate_weft').val();

                var wt=(denier_weft*peak_weft*size*panna)/9000000;
                var cost=rate_weft*wt;
                $(this).find('.wt_weft').val(wt.toFixed(2));
                $(this).find('.costing_weft').val(cost.toFixed(2));

                           
                if(wt!=''){
                    sum = parseFloat(wt)+parseFloat(sum);
                }

                if(cost!=''){
                    sumcost = parseFloat(cost)+parseFloat(sumcost);
                }
            });
            
            $(this).find('.total_wt_weft').val(sum.toFixed(2));
            $(this).find('.total_costing_weft').val(sumcost.toFixed(2));
            $(this).parent().parent().parent().find('.weft_wt').val(sum.toFixed(2));
            $(this).parent().parent().parent().find('.weft_costing').val(sumcost.toFixed(2));
            $(this).parent().parent().parent().find('.tot_wt_l').val((parseFloat($(this).parent().parent().parent().find('.warp_wt').val())+parseFloat($(this).parent().parent().parent().find('.weft_wt').val())).toFixed(2));
            $(this).parent().parent().parent().find('.total_costing').val((parseFloat($(this).parent().parent().parent().find('.warp_costing').val())+parseFloat($(this).parent().parent().parent().find('.weft_costing').val())).toFixed(2));
            $(this).parent().parent().parent().find('.avg_yarn_price').val($(this).parent().parent().parent().find('.total_costing').val());
            $(this).parent().parent().parent().find('.total_wt').val($(this).parent().parent().parent().find('.tot_wt_l').val());
            $(this).parent().parent().parent().find('.actual_wt').val($(this).parent().parent().parent().find('.total_costing').val());
        });        
        
        
    }

</script>



@endsection