@extends('admin.layouts.app')
@section('page_title', 'Yarn Inward')
@section('yarn_purchase_system_select', 'active')
@section('yarn_inward_select', 'inner_active')

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
        <h2><a href="{{ url('admin/yarninward') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            Update Yarn Inward</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>PO Number<span class="text-danger small">*</span></p>
                        <input type="text" name="po_inward_no" value="{{ $po_number }}" placeholder="Enter po number" readonly>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Challan Name</p>
                        <select name="challan_id" id="yarn_challan_id" class="form-control yarn_challanid xx mySelect2" data-validate="required" data-message-required="Select challan name" required>
                            <option value="">--Select--</option> 
                            <?php foreach($firms as $firm){?>
                                <option value="{{ $firm->id }}" @if($firm->id == $challan_id){{"selected"}}@endif>{{ $firm->vendor_name }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Challan No<span class="text-danger small">*</span></p>
                        <input type="text" name="challan_no" id="challan_no" value="{{ $challan_no }}" placeholder="Enter challan_no" >
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
                        <p>Received Date<span class="text-danger small">*</span></p>
                        <input type="date" name="received_date" value="{{ $received_date }}" placeholder="Enter received date" >
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Vendor Name</p>
                        <input type="text" name="yarn_vendor_name" id="yarn_vendor_name" value="{{$yarn_vendor_name}}" placeholder="Enter Yarn Vendor" readonly>
                        <input type="hidden" name="yarn_vendor_id" id="yarn_vendor_id" value="{{$yarn_vendor_id}}" placeholder="Enter Yarn Vendor" readonly>
                    </div>
                </div> 

                
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Yarn</p>
                        <input type="text" name="yarn_name" id="yarn_name" value="{{$yarn_name}}" placeholder="Enter Yarn" readonly>
                        <input type="hidden" name="yarn_id" id="yarn_id" value="{{$yarn_id}}" placeholder="Enter Yarn" readonly>
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
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Done</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Issue</option>   
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Yarn Inward Format</p>
                        <select name="yarn_inward"  class="mySelect2 col model_select">
                            <option value="1" @if($yarn_type == "1"){{"selected"}}@endif>Rola</option> 
                            <option value="2" @if($yarn_type == "2"){{"selected"}}@endif>Spools</option> 
                            <option value="3" @if($yarn_type == "3"){{"selected"}}@endif>Cops</option>   
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
            <div class="row">
            
                @if(count($inward_det)>0)
                <div class="renewal_table add_yarn_table">
                    <div class="table-responsive" style="min-height:auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="first_radius small_name">#</th>
                                    <th scope="col">Shade No.</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Challan Qty</th>
                                    <th scope="col">Inward Qty</th>
                                    <th scope="col">Wt diff</th>
                                    <th scope="col">Wt diff %</th>  
                                    <th scope="col">Color Issue</th>
                                    <th scope="col">Wt Issue</th>
                                    <th scope="col">Wt % Issue</th>  
                                    <th scope="col" class="last_radius">Status</th>
                                </tr>
                            </thead>
                            <tbody id="attributes" class="attributes">
                                @if(count($inward_det)>0)
                                @foreach($inward_det as $key1 => $item)
                                <tr class="vendor-detail-row attri new">
                                    <td>
                                        <div class="input_box normal_text counter2">
                                            <input type="text" name="display_item[{{ $key1+1 }}]" id="display_item{{ $key1+1 }}" value="{{ $key1+1 }}" class="display_items">
                                        </div>
                                    </td>
                                                
                                    <td> 
                                        <div class="input_box">
                                            <input type="text" readonly name="shade_no[{{ $key1+1 }}]" id="shade_no{{ $key1+1 }}" value="{{ $item->shade_no }}" class="shade_no" placeholder="#0000000">
                                            <input type="hidden" readonly name="yarn_product_vendor_detail_id[{{ $key1+1 }}]" id="yarn_product_vendor_detail_id{{ $key1+1 }}" value="{{ $item->yarn_product_vendor_detail_id }}" class="yarn_product_vendor_detail_id" placeholder="#0000000">
                                            <input type="hidden" readonly name="yarn_po_detail_id[{{ $key1+1 }}]" id="yarn_po_detail_id{{ $key1+1 }}" value="{{ $item->yarn_po_detail_id }}" class="yarn_po_detail_id" placeholder="#0000000">
                                            <input type="hidden" readonly name="inward_detail_id[{{ $key1+1 }}]" id="inward_detail_id{{ $key1+1 }}" value="{{ $item->id }}" class="inward_detail_id" placeholder="">
                                            
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="input_box">
                                            <input type="text" readonly name="color[{{ $key1+1 }}]" id="color{{ $key1+1 }}" value="{{ $item->color }}" class="colors" placeholder="Red">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <input type="number" readonly name="qty[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->qty }}" class="qty" placeholder="Enter quantity">
                                            
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="input_box">
                                            <input type="number"  name="challan_qty[{{ $key1+1 }}]" id="challan_qty{{ $key1+1 }}" value="{{ $item->challan_qty }}" class="challan_qty" placeholder="Enter challan quantity">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <input type="number"  name="inward_qty[{{ $key1+1 }}]" id="inward_qty{{ $key1+1 }}" value="{{ $item->inward_qty }}" class="inward_qty" placeholder="Enter inward quantity">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <input type="number" readonly  name="weight_diff[{{ $key1+1 }}]" id="wt_diff{{ $key1+1 }}" value="{{ $item->weight_diff }}" class="wt_diff" placeholder="Enter wt diff">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <input type="number" readonly  name="weight_diff_per[{{ $key1+1 }}]" id="wt_diff_per{{ $key1+1 }}" value="{{ $item->weight_diff_per }}" class="wt_diff_per" placeholder="Enter wt diff per">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <select name="color_issue[{{ $key1+1 }}]"  class="mySelect2 col model_select">
                                                <option value="2" @if($item->color_issue == "2"){{"selected"}}@endif>No</option>
                                                <option value="1" @if($item->color_issue == "1"){{"selected"}}@endif>Yes</option> 
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <select name="weight_issue[{{ $key1+1 }}]"  class="mySelect2 col model_select">
                                                <option value="2" @if($item->weight_issue == "2"){{"selected"}}@endif>No</option>
                                                <option value="1" @if($item->weight_issue == "1"){{"selected"}}@endif>Yes</option> 
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <select name="weight_per_issue[{{ $key1+1 }}]"  class="mySelect2 col model_select">
                                                <option value="2" @if($item->weight_per_issue == "2"){{"selected"}}@endif>No</option>
                                                <option value="1" @if($item->weight_per_issue == "1"){{"selected"}}@endif>Yes</option> 
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <select name="status_child[{{ $key1+1 }}]"  class="mySelect2 col model_select">   
                                                <option value="1" @if($item->status == "1"){{"selected"}}@endif>Yes</option>                                             
                                                <option value="2" @if($item->status == "2"){{"selected"}}@endif>No</option>  
                                            </select>
                                        </div>
                                    </td>
                                   
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>                
              
                @endif                          
                    
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Total Qty<span class="text-danger small">*</span></p>
                        <input type="text" name="tot_qty" id="tot_qty" value="{{ $tot_qty }}" readonly placeholder="Enter Qty">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Rate<span class="text-danger small">*</span></p>
                        <input type="text" readonly name="rate" id="rate" value="{{ $rate }}" placeholder="Enter rate">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Total Amount<span class="text-danger small">*</span></p>
                        <input type="text" name="tot_amt" id="tot_amt" value="{{ $tot_amt }}" readonly placeholder="Enter Amount">
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
                        <p>Denier Issue</p>
                        <select name="denier_issue"  class="mySelect2 col model_select">
                            <option value="2" @if($denier_issue == "2"){{"selected"}}@endif>No</option>  
                            <option value="1" @if($denier_issue == "1"){{"selected"}}@endif>Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Packaging Issue</p>
                        <select name="packaging_issue"  class="mySelect2 col model_select">
                            <option value="2" @if($packaging_issue == "2"){{"selected"}}@endif>No</option>  
                            <option value="1" @if($packaging_issue == "1"){{"selected"}}@endif>Yes</option>  
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Coning Issue</p>
                        <select name="coning_issue"  class="mySelect2 col model_select"> 
                            <option value="2" @if($coning_issue == "2"){{"selected"}}@endif>No</option> 
                            <option value="1" @if($coning_issue == "1"){{"selected"}}@endif>Yes</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <input type="hidden" name="yarn_po_id" id="yarn_po_id" value="{{$yarn_po_id}}"/> 
            <input type="hidden" name="id" id="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/yarninward') }}" class="cancel-btn">Cancel</a>
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
            url:"{{ url('admin/yarninward/manage-inward-process') }}",
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
                        window.location.href = "{{ url('admin/yarninward') }}";
                }
                else {
                    Command: toastr["error"](obj.message, "Message")	
                    $('.overlay-wrapper').hide();
                }
                },1000);
            }
        })	
	})  
    

    $(document).on('keyup', '.challan_qty', function(e) {
        calc($(this));
    });

    $(document).on('keyup', '.inward_qty', function(e) {
        calc($(this));
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

function calc(thiss)
{
    var mains=thiss.parent().parent().parent();
    var c_qty=mains.find("input.challan_qty").val();
    var i_qty=mains.find("input.inward_qty").val();
    var wt=parseFloat(c_qty)-parseFloat(i_qty);
    mains.find("input.wt_diff").val(wt);
    var wt_per=(parseFloat(wt)/parseFloat(c_qty))*100;
    mains.find("input.wt_diff_per").val(wt_per);
    
}



</script>



@endsection