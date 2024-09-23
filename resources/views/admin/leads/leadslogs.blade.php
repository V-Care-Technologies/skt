@extends('admin.layouts.app')
@section('page_title', 'Leads')
@section('leads_system_select', 'active')
@section('leads_select', 'inner_active')


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
        <h2>@yield('page_title')</h2>
    </div>
    <div class="row align-items-center search_main_row mb-3">
        
        <div class="col-xl-9 col-md-9 col-12 right_box">
            <button type="button" id="next" class="dark-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add Next Action</button>
        </div>
    </div>
    <div class="main_contact_form">
        
            <div class="row">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Created At : <span class="text-danger small">{{date('d-m-Y',strtotime($leads->created_at))}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Firm Name : <span class="text-danger small">{{$leads->firm_name}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Party Name : <span class="text-danger small">{{$leads->party_name}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Mobile No : <span class="text-danger small">{{$leads->mobile_no}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Requirement : <span class="text-danger small">{{$leads->description}}</span></p>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Assign To : <span class="text-danger small">{{$lastlog->sname}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Next Follow Up Date : <span class="text-danger small">{{date('d-m-Y',strtotime($lastlog->followup_date))}}</span></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Conversation : <span class="text-danger small">{{$lastlog->description}}</span></p>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Entry Date : <span class="text-danger small">{{date('d-m-Y',strtotime($lastlog->dates))}}</span></p>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Entry Done By : <span class="text-danger small">{{$lastlog->cname}}</span></p>
                    </div>
                </div>
            </div>

            <div class="main_table_card">
                <div class="renewal_table">
                    <div class="table-responsive" style="min-height:auto">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col" class="first_radius small_name">#</th>
                                    <th scope="col">Entry At</th>
                                    <th scope="col">Entry By</th>
                                    <th scope="col">Assign To</th>
                                    <th scope="col">Conversation</th> 
                                    <th scope="col" class="last_radius">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($leadslogs as $list)
                            
                                <tr>
                                    <td>
                                        <p class="normal_text">{{ $i }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ date('d-m-Y',strtotime($list->dates)) }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->cname }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->sname }}</p>
                                    </td>
                                    <td class="name_box">
                                        <p class="name">{{ $list->description }}</p>
                                    </td>
                                
                                    
                                    <td class="action_td">
                                        <div class="d-flex align-items-center">                                            
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
            
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/leads') }}" class="cancel-btn">Back</a>
            </div>
      
    </div>                
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Follow Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
      <div class="modal-body">
        
            <div class="row">
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Assign To<span class="text-danger small">*</span></p>
                        <select name="assign_to" id="assign_to" class="form-control" data-validate="required" data-message-required="Select Users" required>
                            <option value="">--Select--</option> 
                            <?php foreach($users as $user){?>
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Conversation Date<span class="text-danger small">*</span></p>
                        <input type="date" name="dates" value="" placeholder="Enter Conversation Date" >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Next Follow Up Date<span class="text-danger small">*</span></p>
                        <input type="date" name="followup_date" value="" placeholder="Enter Next Follow Up Date" >
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Conversation<span class="text-danger small">*</span></p>
                        <textarea name="description"></textarea> 
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="{{$leads->id}}"/> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



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
                    url:"{{ url('admin/leads/deleteleadslogs') }}",
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
<script>
$(document).ready(function() {

    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/leads/next-followup') }}",
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
                        window.location.href = window.location.href;
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


    // Add new firm row
    $('.add_row_firm').on('click', function() {
        var newRow1 = `
        <div class="firm_row">
            <input type="hidden" name="firm_ids[]" value="">
            <div class="row align-items-center">
                <div class="col-lg-1">
                    <div class="firm_number"></div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Vendor</p>
                        <input type="text" name="firm_vendor[]" value="" placeholder="Enter Vendor">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>GST Number</p>
                        <input type="text" name="firm_gst[]" value="" placeholder="Enter GST Number" data-validate="minlength[15],maxlength[15]"  data-message-minlength="Enter 15 digits" data-message-maxlength="Enter 15 digits">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="delete_icon_td d-flex justify-content-end pe-3">
                        <a href="javascript:void(0)" class="delete_icon remove_row_firm" data-id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28" viewBox="0 0 27 28" fill="none">
                                <path d="M3.375 7.08838H5.625M5.625 7.08838H23.625M5.625 7.08838V22.8384C5.625 23.4351 5.86205 24.0074 6.28401 24.4294C6.70597 24.8513 7.27826 25.0884 7.875 25.0884H19.125C19.7217 25.0884 20.294 24.8513 20.716 24.4294C21.1379 24.0074 21.375 23.4351 21.375 22.8384V7.08838H5.625ZM9 7.08838V4.83838C9 4.24164 9.23705 3.66935 9.65901 3.24739C10.081 2.82543 10.6533 2.58838 11.25 2.58838H15.75C16.3467 2.58838 16.919 2.82543 17.341 3.24739C17.7629 3.66935 18 4.24164 18 4.83838V7.08838M11.25 12.7134V19.4634M15.75 12.7134V19.4634" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>`;
        $('.firm_body').append(newRow1);
        updateFirmRowNumbers();
    });

    // Remove firm row
    $(document).on('click', '.remove_row_firm', function() {
        var id = $(this).attr('data-id');
        var $rowToRemove = $(this).closest('.firm_row'); // Store reference to the row

        if (id != '') {
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
                        url: "{{ url('admin/vendor/deletefirm') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { id: id },
                        beforeSend: function() {
                            $('.overlay-wrapper').show(); // Show loading overlay
                        },
                        success: function(response) {
                            var obj = JSON.parse(response);
                            if (obj.status == "1") {
                                $('.overlay-wrapper').hide(); // Hide loading overlay
                                toastr.info("Deleted Successfully", "Message");
                                $rowToRemove.remove(); // Remove the table row using stored reference
                                updateFirmRowNumbers(); // Update row numbers after removal
                            } else {
                                $('.overlay-wrapper').hide(); // Hide loading overlay
                                toastr.error("Failed to delete record", "Error");
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.overlay-wrapper').hide(); // Hide loading overlay
                            toastr.error("Failed to delete record", "Error");
                        }
                    });
                } else {
                    swal("Your record is safe!");
                }
            });
        } else {
            $rowToRemove.remove(); // Directly remove the row if ID is empty
            updateFirmRowNumbers(); // Update row numbers after removal
        }
    });

    // Update firm row numbers
    function updateFirmRowNumbers() {
        $('.firm_row').each(function(index) {
            $(this).find('.firm_number').text(index + 1);
        });
    }

    // Initial update of firm row numbers
    updateFirmRowNumbers();
});




</script>



@endsection