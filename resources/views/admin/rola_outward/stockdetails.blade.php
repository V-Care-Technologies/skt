@extends('admin.layouts.app')
@section('page_title', 'Rola Stock')
@section('rola_system_select', 'active')
@section('rola_stock_select', 'inner_active')

@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2>@yield('page_title')</h2>
    </div>
    
    <div class="main_table_card">
        <div class="row">
            <div class="col-6">
                <h4>Inward</h4>
                <div class="renewal_table">
                    <div class="table-responsive" style="min-height:auto">
                        <table class="table" id="example1">
                            <thead>
                                <tr>
                                    <th scope="col" class="first_radius small_name">#</th>     
                                    <th scope="col">Challan No</th>
                                    <th scope="col">Challan Date</th>                            
                                    <th scope="col">Vendor</th>
                                    <th scope="col" class="last_radius">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($inward as $list)
                                
                                <tr>
                                    <td>
                                        <p class="normal_text">{{ $i }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->challan_no }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->challan_date }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->name }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->qty }}</p>
                                    </td>
                                
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
            <div class="col-6">
            <h4>Outward</h4>
                <div class="renewal_table">
                    <div class="table-responsive" style="min-height:auto">
                        <table class="table" id="example1">
                            <thead>
                                <tr>
                                    <th scope="col" class="first_radius small_name">#</th>     
                                    <th scope="col">Challan No</th>
                                    <th scope="col">Challan Date</th>                            
                                    <th scope="col">Vendor</th>
                                    <th scope="col" class="last_radius">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($outward as $list)
                                
                                <tr>
                                    <td>
                                        <p class="normal_text">{{ $i }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->challan_no }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->challan_date }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->name }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->qty }}</p>
                                    </td>
                                
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('modals')

@endsection


@section('delscript')
   

 @endsection
