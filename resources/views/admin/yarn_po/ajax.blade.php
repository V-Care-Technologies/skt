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

                <a href="javascript:void(0)" class="add2 add_form_btn dark-btn  me-2" onclick="add2(this);" id="add-row" title="add">
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
  
    @else
    
                        
        <tr class="vendor-detail-row attri new">
            <td>
                <div class="input_box normal_text counter2">
                    <input type="text" name="display_item[0]" id="display_item11" value="1" class="display_items">
                </div>
            </td>
                        
            <td> 
                <div class="input_box">

                <select name="shade_no[0]" id="shade_no1" class="form-control shade_no xx mySelect2" data-validate="required" data-message-required="Select vendor" required>
                    <option value="">--Select--</option> 
                    <?php foreach($products as $product){?>
                        <option value="{{ $product->id }}" data-color="{{$product->color}}" >{{ $product->shade_no }}</option>
                    <?php }?>
                            
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
           
    @endif