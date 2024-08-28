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

                <a href="javascript:void(0)" class="add2" onclick="add2(this);" id="add-row" title="add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="me-3">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 5C2 4.46957 2.21071 3.96086 2.58579 3.58579C2.96086 3.21071 3.46957 3 4 3H9.52C9.81977 3.00004 10.1157 3.06746 10.3859 3.19728C10.6561 3.3271 10.8936 3.51599 11.081 3.75L12.481 5.5H20C20.5304 5.5 21.0391 5.71071 21.4142 6.08579C21.7893 6.46086 22 6.96957 22 7.5V19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V5ZM12 9C12.2652 9 12.5196 9.10536 12.7071 9.29289C12.8946 9.48043 13 9.73478 13 10V12H15C15.2652 12 15.5196 12.1054 15.7071 12.2929C15.8946 12.4804 16 12.7348 16 13C16 13.2652 15.8946 13.5196 15.7071 13.7071C15.5196 13.8946 15.2652 14 15 14H13V16C13 16.2652 12.8946 16.5196 12.7071 16.7071C12.5196 16.8946 12.2652 17 12 17C11.7348 17 11.4804 16.8946 11.2929 16.7071C11.1054 16.5196 11 16.2652 11 16V14H9C8.73478 14 8.48043 13.8946 8.29289 13.7071C8.10536 13.5196 8 13.2652 8 13C8 12.7348 8.10536 12.4804 8.29289 12.2929C8.48043 12.1054 8.73478 12 9 12H11V10C11 9.73478 11.1054 9.48043 11.2929 9.29289C11.4804 9.10536 11.7348 9 12 9Z" fill="#f9d27e"></path>
                    </svg>Add
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
                    <a href="javascript:void(0)" class="add2" onclick="add2(this);" id="add-row" title="add">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="me-3">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 5C2 4.46957 2.21071 3.96086 2.58579 3.58579C2.96086 3.21071 3.46957 3 4 3H9.52C9.81977 3.00004 10.1157 3.06746 10.3859 3.19728C10.6561 3.3271 10.8936 3.51599 11.081 3.75L12.481 5.5H20C20.5304 5.5 21.0391 5.71071 21.4142 6.08579C21.7893 6.46086 22 6.96957 22 7.5V19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V5ZM12 9C12.2652 9 12.5196 9.10536 12.7071 9.29289C12.8946 9.48043 13 9.73478 13 10V12H15C15.2652 12 15.5196 12.1054 15.7071 12.2929C15.8946 12.4804 16 12.7348 16 13C16 13.2652 15.8946 13.5196 15.7071 13.7071C15.5196 13.8946 15.2652 14 15 14H13V16C13 16.2652 12.8946 16.5196 12.7071 16.7071C12.5196 16.8946 12.2652 17 12 17C11.7348 17 11.4804 16.8946 11.2929 16.7071C11.1054 16.5196 11 16.2652 11 16V14H9C8.73478 14 8.48043 13.8946 8.29289 13.7071C8.10536 13.5196 8 13.2652 8 13C8 12.7348 8.10536 12.4804 8.29289 12.2929C8.48043 12.1054 8.73478 12 9 12H11V10C11 9.73478 11.1054 9.48043 11.2929 9.29289C11.4804 9.10536 11.7348 9 12 9Z" fill="#f9d27e"></path>
                        </svg>Add
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