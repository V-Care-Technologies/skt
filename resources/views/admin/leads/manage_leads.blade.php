@extends('admin.layouts.app')
@section('page_title', 'Leads')
@section('leads_select', 'active')
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
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__rendered{
        height: 100%;
    }
</style>
@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2><a href="{{ url('admin/leads') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif Leads</h2>
    </div>
    <div class="main_contact_form">
        <form action="" id="save-form" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Assign To<span class="text-danger small">*</span></p>
                        <select name="assign_to" id="assign_to" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select Users" required>
                            <option value="">--Select--</option> 
                            <?php foreach($users as $user){?>
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            <?php }?>
                                    
                        </select> 
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Next Follow Up Date<span class="text-danger small">*</span></p>
                        <input type="date" name="followup_date" value="" placeholder="Enter Next Follow Up Date" >
                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Firm Name<span class="text-danger small">*</span></p>
                        <input type="text" name="firm_name" value="{{ $firm_name }}" placeholder="Enter Firm Name" >
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Party Name<span class="text-danger small">*</span></p>
                        <input type="text" name="party_name" value="{{ $party_name }}" placeholder="Enter Party Name" data-validate="required" required  data-message-required="Please Enter Party Name">
                    </div>
                </div>
               
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Mobile No.<span class="text-danger small">*</span></p>
                        <input type="number" name="mobile_no" value="{{ $mobile_no }}" placeholder="Enter Mobile No." data-validate="number,required,minlength[10],maxlength[10]" required  data-message-required="Please Enter Mobile No." @if($id != '0'){{"readonly"}}@endif>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="input_box">
                        <p>Requirement<span class="text-danger small">*</span></p>
                        <textarea name="description">{{ $description }}</textarea> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <input type="checkbox" name="generatetask" id="generatetask" class=""/> Generate Task
                </div>
            </div>
            <div class="row d-none mt-3" id="tasks">
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Task Assign To<span class="text-danger small">*</span></p>
                        <select name="task_assign_to" id="task_assign_to" class="form-control yarn_vendorid xx mySelect2" data-validate="required" data-message-required="Select Users" required>
                            <option value="">--Select--</option> 
                            <?php foreach($users as $user){?>
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            <?php }?>                                    
                        </select> 
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Task Date<span class="text-danger small">*</span></p>
                        <input type="date" name="task_date" value="" placeholder="Enter Task Date" >
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="input_box">
                        <p>Task Label<span class="text-danger small">*</span></p>
                        <select class="form-control mySelect1" name="task_label[]" multiple="multiple">
                            <!-- Loop through designs and mark as selected if they belong to the folder -->
                            @foreach($tasks as $task)
                                <option value="{{ $task }}" >{{ $task }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ url('admin/leads') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="dark-btn">Save</button>
            </div>
        </form>
    </div>                
</div>



@endsection

@section('delscript')
<script>
    $(document).ready(function () {
  $(".mySelect1").select2({
    tags: true, // Allow new tags to be added
    createTag: function (params) {
      var term = $.trim(params.term);

      if (term === "") {
        return null;
      }

      return {
        id: term,
        text: term,
        newTag: true, // Mark this tag as new
      };
    },
  });
});

$(".mySelect1").select2();
</script>
<script>
$(document).ready(function() {
    $("#generatetask").on('change',function(){
        if(this.checked){
            $('#tasks').removeClass('d-none');
        }else{
            $('#tasks').addClass('d-none');
        }
    });
    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();		
        
        $.ajax({
            url:"{{ url('admin/leads/manage-leads-process') }}",
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
                        window.location.href = "{{ url('admin/leads') }}";
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


  
});




</script>



@endsection