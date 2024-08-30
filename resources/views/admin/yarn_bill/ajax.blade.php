
    <div class="col-lg-3">
        <div class="input_box">
            <p>PO Rate<span class="text-danger small">*</span></p>
            <input type="text" readonly name="po_rate" id="po_rate" value="{{ $po->rate }}"  >
        </div>
    </div>

    <div class="col-lg-3">
        <div class="input_box">
            <p>Yarn<span class="text-danger small">*</span></p>
            <input type="text" readonly name="yarn" value="{{ $po->skt_yarn_name }}"  >
        </div>
    </div>

    <div class="col-lg-3">
        <div class="input_box">
            <p>PO Qty<span class="text-danger small">*</span></p>
            <input type="text" readonly name="po_qty" id="po_qty" value="{{ $po->tot_qty }}"  >
        </div>
    </div>

    <div class="col-lg-3">
        <div class="input_box">
            <p>PO Total<span class="text-danger small">*</span></p>
            <input type="text" readonly name="po_tot" value="{{ $po->total_amt }}" >
        </div>
    </div>

<div class="col-lg-12">
    <div class="table-responsive" style="min-height:auto"></div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="first_radius small_name">#</th>
                    <th scope="col">Challan No</th>
                    <th scope="col">Inward Date</th>
                    <th scope="col">Challan Name</th>
                    <th scope="col">Inward Qty</th>
                    <th scope="col" class="last_radius">Status</th>
                </tr>
            </thead>
            <tbody id="attributes" class="attributes">
            <?php $i=1;$status='';?>
            @if(count($challan)>0)
                @foreach($challan as $key1 => $item)
                @if($item->status == "1")
                    @php $status="Done";@endphp 
                @elseif($item->status == "2")
                    @php $status="Issue";@endphp 
                @endif

                <tr class="vendor-detail-row attri new">
                    <td>
                        <div class="input_box normal_text counter2">
                            <input type="checkbox"  <?php if($challan_ids){ $idsArray = explode(',', $challan_ids->challan_ids); if(in_array($item->id, $idsArray)) {echo "checked";}else{ echo "";} }?> class="inward_id" name="inward_id[{{ $key1+1 }}]" value="{{ $item->id }}"/>
                        </div>
                    </td>
                    
                    <td>
                        <div class="input_box">
                            <input type="text" readonly name="challan_no[{{ $key1+1 }}]" id="color{{ $key1+1 }}" value="{{ $item->challan_no }}" class="colors" placeholder="Red">
                        </div>
                    </td>
                    <td>
                        <div class="input_box">
                            <input type="text" readonly name="r_date[{{ $key1+1 }}]" id="color{{ $key1+1 }}" value="{{ $item->received_date }}" class="colors" placeholder="Red">
                        </div>
                    </td>
                    <td>
                        <div class="input_box">
                            <input type="text" readonly name="challan_name[{{ $key1+1 }}]" id="color{{ $key1+1 }}" value="{{ $item->vendor_name }}" class="colors" placeholder="Red">
                        </div>
                    </td>
                    

                    <td>
                        <div class="input_box">
                            <input type="number" readonly name="qty[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $item->totqty }}" class="qty" placeholder="Enter quantity">
                        </div>
                    
                    </td> 
                    <td>
                    <input type="text" readonly name="status_c[{{ $key1+1 }}]" id="qty{{ $key1+1 }}" value="{{ $status }}" class="qtys" placeholder="Enter quantity">
                    </td>
                    
                    
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
            