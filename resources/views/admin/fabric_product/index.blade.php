@extends('admin.layouts.app')
@section('page_title', 'Fabric Product')
@section('fabric_weaver_system_select', 'active')
@section('fabric_product_select', 'inner_active')

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
            <a href="{{ url('admin/fabricproduct/manage-fabricproduct') }}" class="dark-btn">+ Add Fabric Product</a>
        </div>
    </div>
    <div class="main_table_card">
        <div class="renewal_table">
            <div class="table-responsive" style="min-height:auto">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th scope="col" class="first_radius small_name">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Colors</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="last_radius">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;?>
                        @foreach($product as $list)
                        <?php $status = $list->status == "1" ? "Active" : "Inactive";?>
                        <tr>
                            <td>
                                <p class="normal_text">{{ $i }}</p>
                            </td>
                            <td class="name_box">
                                <p class="name"><img src="{{asset('/public/fabric_product/').'/'.$list->images}}" id="img" style="height: 80px;"/></p>
                            </td>
                            <td class="name_box">
                                <p class="name">{{ $list->skt_name }}</p>
                            </td>
                            <td class="name_box">
                                <p class="name">{{ $list->colors }}</p>
                            </td>
                            <td class="name_box">
                                <p class="name">{{ $list->status }}</p>
                            </td>
                           
                            <td class="action_td">
                                <div class="d-flex align-items-center">
                                    
                                    <a href="{{url('admin/fabricproduct/manage-fabricproduct/')}}/{{$list->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                            <path d="M14.1665 2.73039C14.3854 2.51153 14.6452 2.33791 14.9312 2.21946C15.2171 2.10101 15.5236 2.04004 15.8332 2.04004C16.1427 2.04004 16.4492 2.10101 16.7352 2.21946C17.0211 2.33791 17.281 2.51153 17.4998 2.73039C17.7187 2.94926 17.8923 3.2091 18.0108 3.49507C18.1292 3.78104 18.1902 4.08753 18.1902 4.39706C18.1902 4.70659 18.1292 5.01309 18.0108 5.29905C17.8923 5.58502 17.7187 5.84486 17.4998 6.06373L6.24984 17.3137L1.6665 18.5637L2.9165 13.9804L14.1665 2.73039Z" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" class="del_popup2" data-id="{{$list->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                            <path d="M2.5 5.23055H4.16667M4.16667 5.23055H17.5M4.16667 5.23055V16.8972C4.16667 17.3392 4.34226 17.7632 4.65482 18.0757C4.96738 18.3883 5.39131 18.5639 5.83333 18.5639H14.1667C14.6087 18.5639 15.0326 18.3883 15.3452 18.0757C15.6577 17.7632 15.8333 17.3392 15.8333 16.8972V5.23055H4.16667ZM6.66667 5.23055V3.56388C6.66667 3.12186 6.84226 2.69793 7.15482 2.38537C7.46738 2.07281 7.89131 1.89722 8.33333 1.89722H11.6667C12.1087 1.89722 12.5326 2.07281 12.8452 2.38537C13.1577 2.69793 13.3333 3.12186 13.3333 3.56388V5.23055M8.33333 9.39722V14.3972M11.6667 9.39722V14.3972" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
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
           
     $(document).on("click",".del_popup2",function(){
       
        var id = $(this).attr('data-id');
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
                $.ajax({
                    url:"{{ url('admin/fabricproduct/delete') }}",
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{id:id},
                    beforeSend: function(){
             	     $('.overlay-wrapper').show();  
                 	},
                    success(response){
                    setTimeout(function(){    
                    var obj =  JSON.parse(response);
                    if(obj.status=="1"){
                        $('.overlay-wrapper').hide(); 
        	    		Command: toastr["success"]("Deleted Successfully", "Message")
                         window.location.href = window.location.href;
                  
                    }
                    },1000);
                    }
                })
                } else {
                    swal("Your record is safe!");
                }
            });
        })
            
 });
            
 </script>  
 
 
   

 @endsection
