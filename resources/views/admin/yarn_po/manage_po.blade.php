@extends('admin.layouts.app')
@section('page_title', 'Yarn PO')
@section('yarn_purchase_system_select', 'active')
@section('yarn_po_select', 'inner_active')

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
            @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Yarn PO</h2>
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
                                    <th scope="col">Shade No.</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Qty</th>  
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
                                            <select name="shade_no[0]" id="shade_no1" class="form-control shade_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                                                
                                            </select> 
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="input_box">
                                            <input type="text" name="color[0]" readonly id="color11" value="" class="colors" placeholder="Red">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_box">
                                            <input type="number" name="qty[0]" id="qty1" value="" class="qty" placeholder="Enter quantity">
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
                        <input type="text" name="rate" id="rate" value="{{ $rate }}" placeholder="Enter rate">
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
                        <p>Delivery Address<span class="text-danger small">*</span></p>
                        <input type="text" name="del_address" id="del_add" value="{{ $del_address }}" placeholder="Enter delivery Address">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Remarks<span class="text-danger small">*</span></p>
                        <input type="text" name="remarks" id="remarks" value="{{ $remarks }}" placeholder="Enter remarks">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/yarnpo/manage-po') }}" class="cancel-btn">Cancel</a>
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
            url:"{{ url('admin/yarnpo/manage-po-process') }}",
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
                        window.location.href = "{{ url('admin/yarnpo') }}";
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
        var id=$(this).val();
        var vid=$("#yarn_vendor_id").val();
        var poid=$("#id").val();
        $.ajax({
            url:"{{ url('admin/yarnpo/getYarnDetails') }}",
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{id:id,vid:vid,poid:poid},
            // beforeSend: function(){
            //     $('.overlay-wrapper').show();  
            // },
            success(response){
              
            var obj =  JSON.parse(response);
            console.log(obj.data);
            if(obj.status=="1"){
                
                // Set the selected options
                //$('.shade_no').html(obj.data);
                $('#attributes').html(obj.data);
            
            }
            
            }
        })
    });


    $(document).on("change", ".shade_no", function() {
        var adds=$(this).parent().parent().parent();
        adds.find('.colors').val($(this).find(':selected').data('color'));
    });

    $(document).on('keyup', '.qty', function(e) {
        update_amounts();
    });

    $(document).on('keyup', '#rate', function(e) {
        update_amounts();
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


    $('#yarn_vendor_id').trigger('change');

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
                        url:"{{ url('admin/yarnpo/deletepodetail') }}",
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
            
            $(this).find("td:eq(1) select").prop('name', 'shade_no['+j+']');
            $(this).find("td:eq(2) input").prop('name', 'color['+j+']');
            $(this).find("td:eq(3) input").prop('name', 'qty['+j+']');
            $(this).find("td:eq(4) input").prop('name', 'po_detail_id['+j+']');
            j=j+1;
            $(this).find("td:eq(0) input").val(j);
        });
        update_amounts();
    }
    

    

function update_amounts()
{
  
    var sum = 0;
    $('#attributes .attri').each(function() {
        var qty = $(this).find('.qty').val();
        
       if(qty!=''){
        sum = parseFloat(qty.replace(/,/g, ''))+parseFloat(sum);
       }

        
    });
    var rate=$("#rate").val();
    
    var totsamt = parseFloat(sum) * parseFloat(rate);
    $("#tot_qty").val(sum.toFixed(2));
     
    $("#tot_amt").val(totsamt.toFixed(2));
       
    
}



</script>



@endsection