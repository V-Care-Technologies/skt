


<!doctype html>
<html lang="en">
   <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('public/admin/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="{{ url('public/admin/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ url('public/admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/admin/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('public/admin/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ url('public/admin/css/sweetalert2.min.css') }}">
    <title>SKT</title>

   </head>
   <body class="dash_body"> 
    <main>
        <section class="login_section position-relative"> 
            <img src="{{ url('public/admin/images/login_main_bg.svg') }}" alt="" class="login_main_bg">
           <div class="container">
              <div class="row justify-content-center">
                 <div class="col-lg-6 col-md-10 col-12 login_part">
                    <div class="">
                       <div class="logo text-center mb-5">
                          <img src="{{ url('public/admin/images/logo.png') }}">
                       </div>
                       <div class="login-form">
                          <div class="login-part">
                            <form  action="{{ route('admin.auth') }}" method="post" id="save-form" class="validate" enctype="multipart/form-data" accept-charset="utf-8" >
                                @csrf
                                <div class="form-group input_box mb-4">
                                   <p class="">Phone</p>
                                   <input type="number" name="phone" placeholder="Phone" required data-validate="required,maxlength[10],minlength[10]" data-message-required="Please Enter Phone">
                                </div>
                                <div class="form-group input_box position-relative">
                                   <p class="">Password</p>
                                   <input type="password" name="password" class="password" placeholder="Password" required data-validate="required" data-message-required="Please Enter Password" >
                                   <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="yellow-btn mt-5">Login</button>
                                </div> 
                            </form>
                          </div>
                       </div>
                    </div>
                 </div> 
              </div>
           </div> 
        </section>
    </main>
         <script src="{{ url('public/admin/js/jquery.min.js') }}"></script>
         <script src="{{ url('public/admin/js/sweetalert2.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/moment.js') }}"></script>  
         <script src="{{ url('public/admin/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/select2.min.js') }}"></script>
         <script src="{{ url('public/admin/js/jquery.multi-select.js') }}"></script>
         <script src="{{ url('public/admin/js/toastr.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/jquery.validate.min.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/validation.js') }}" type="text/javascript"></script>
         <script src="{{ url('public/admin/js/main.js') }}" type="text/javascript"></script> 

   </body>
   
</html>

