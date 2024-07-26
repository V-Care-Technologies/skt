@extends('admin.layouts.app')
@section('page_title', 'User')
@section('user_select', 'active')


@section('content')

<div class="inner-main-content">   
    <div class="main_page_heading">
        <h2><a href="{{ route('admin.user') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
            @if($id != '0'){{"Update"}}@else{{"Add New"}}@endif User</h2>
    </div>
    <div class="main_contact_form">
        <form action="{{route('user.manage-user-process')}}" class="validate" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Full Name<span class="text-danger small">*</span></p>
                        <input type="text" name="name" value="{{ $name }}" placeholder="Enter Name" data-validate="required" required  data-message-required="Please Enter Full Name">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Mobile No.<span class="text-danger small">*</span></p>
                        <input type="text" name="phone" value="{{ $phone }}" placeholder="Enter Mobile No." data-validate="number,required,minlength[10],maxlength[10]" required  data-message-required="Please Enter Mobile No." @if($id != '0'){{"readonly"}}@endif>
                    </div>
                </div>
            
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Email Id</p>
                        <input type="email" name="email" value="{{ $email }}" placeholder="Enter Email">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Designation<span class="text-danger small">*</span></p>
                        <select name="group_id" class="mySelect2 col model_select" data-validate="required" required data-message-required="Please Select Designation">
                            <option value="">Please Select Designation</option> 
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" 
                                    @if($designation->id == $groupid) 
                                        selected 
                                    @endif>{{ $designation->description }}</option>
                            @endforeach 
                        </select> 
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Password<span class="text-danger small">@if($id == '0') * @else if want to update @endif</span></p>
                        <input type="password" name="password" placeholder="Enter password"
                        @if($id == '0')
                            data-validate="required,minlength[6]" required data-message-required="Please enter a password"
                        @endif>
                    </div>
                </div> 
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Status</p>
                        <select name="status"  class="mySelect2 col model_select">
                            <option value="1" @if($status == "1"){{"selected"}}@endif>Active</option> 
                            <option value="2" @if($status == "2"){{"selected"}}@endif>Inactive</option>  
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input_box">
                        <p>Profile</p>
                        <input type="file" name="user_image">
                        @if($user_images != "")
                        <img src="{{ url('public/user_image/' . $user_images) }}" alt="" height="30px" width="30px">
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="input_box">
                        <p>Address</p>
                        <textarea name="address" id="" placeholder="Enter full address">{{ $address }}</textarea>
                    </div>
                </div>
                
            </div>
            <input type="hidden" name="id" value="{{$id}}"/> 
            <div class="d-flex align-items-center justify-content-center mt-5 submit_row mb-5">
                <a href="{{ route('admin.user') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="dark-btn">Save</button>
            </div>
        </form>
    </div>                
</div>



@endsection

@section('delscript')
<script>
$(document).ready( function() {

    $("input[name='phone']").focusout(function() {
        var phoneNumber = $(this).val();
        getPhoneUnique(phoneNumber);
    });

});

function getPhoneUnique(phoneNumber){
    $.ajax({
        url: '{{ route('admin.check-phone') }}',
        method:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            phone: phoneNumber
        },
        success: function(response) {
            if (response.status == '1') {
                swal({
                    title: 'Do You Still Want To Continue?',
                    text: 'This phone number already exists.',
                    type: 'warning',
                    showCancelButton: true
                });
                $(".save-btn").prop("disabled", true);
            } else {
                $(".save-btn").prop("disabled", false);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // Handle error if needed
        }
    });
}

</script>
@endsection