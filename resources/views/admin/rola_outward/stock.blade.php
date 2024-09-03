@extends('admin.layouts.app')
@section('page_title', 'Rola Stock')
@section('rola_system_select', 'active')
@section('rola_stock_select', 'inner_active')

@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2>@yield('page_title')</h2>
    </div>
    <div class="row align-items-center search_main_row mb-3">
        <div class="col-xl-3 col-md-3 col-12 left_box">
            <div class="searchBar position-relative">
                    <img src="{{ url('public/admin/images/search.svg') }}">
                    <input type="text" class="search_input" placeholder="Search" id="customSearch">   
            </div> 
        </div> 
        <div class="col-xl-9 col-md-9 col-12 right_box">
            <a href="{{ url('admin/rolaoutward/manage-rolaoutward') }}" class="dark-btn">+ Add Rola Outward</a>
        </div>
    </div>
    <div class="main_table_card">
        <div class="renewal_table">
            <div class="table-responsive" style="min-height:auto">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th scope="col" class="first_radius small_name">#</th>                         
                            <th scope="col">Vendor</th>
                            <th scope="col">Stock</th>
                            <th scope="col" class="last_radius">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;?>
                        @foreach($rola as $list)
                        
                        <tr>
                            <td>
                                <p class="normal_text">{{ $i }}</p>
                            </td>
                         
                            <td class="name_box">
                                <p class="name">{{ $list->name }}</p>
                            </td>
                            <td class="name_box">
                                <p class="name">{{ $list->stock }}</p>
                            </td>
                           
                            
                           
                            <td class="action_td">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('admin/rolaoutward/stockdetail')}}/{{$list->yarn_vendor_id}}"  class="view_popup2" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                            <g clip-path="url(#clip0_721_2925)">
                                            <path d="M12.787 10.2304C12.787 11.7694 11.5394 13.017 10.0004 13.017C8.46145 13.017 7.21387 11.7694 7.21387 10.2304C7.21387 8.69143 8.46145 7.44385 10.0004 7.44385C11.5394 7.44385 12.787 8.69143 12.787 10.2304Z" stroke="#667085" stroke-width="1.5"/>
                                            <path d="M15.6092 5.56896C17.2473 6.7378 18.51 8.35751 19.2439 10.2306C18.51 12.1036 17.2473 13.7233 15.6092 14.8922C13.966 16.0647 12.0167 16.7323 10.0001 16.8136C7.9835 16.7323 6.03417 16.0647 4.39095 14.8922C2.75282 13.7234 1.49017 12.1036 0.756296 10.2306C1.49017 8.35751 2.75282 6.7378 4.39095 5.56896C6.03417 4.39649 7.9835 3.72886 10.0001 3.64754C12.0167 3.72886 13.966 4.39649 15.6092 5.56896Z" stroke="#667085" stroke-width="1.5"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_721_2925">
                                            <rect width="20" height="20" fill="white" transform="translate(0 0.230469)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                   
                                   
                                </div>
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


@endsection

@section('modals')

@endsection


@section('delscript')

<script>
$(document).ready( function() {
//Delete
           
     $(document).on("click",".view_popup2",function(){
       
        var id = $(this).attr('data-id');
       
                $.ajax({
                    url:"{{ url('admin/rolaoutward/delete') }}",
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{id:id},
                    beforeSend: function(){
             	     $('.overlay-wrapper').show();  
                 	},
                    success(response){ 
                    var obj =  JSON.parse(response);
                    if(obj.status=="1"){
                        $('.overlay-wrapper').hide(); 
                    }
                  
                    }
                })
               
        })
            
 });
            
 </script>  
 
 
   

 @endsection
