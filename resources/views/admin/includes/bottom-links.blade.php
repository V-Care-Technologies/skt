<script src="{{ url('public/admin/js/jquery.min.js') }}"></script>
<script src="https://tarwalas.in/myts/public/admin/js/metisMenu.min.js"></script>
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
<script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
  </script>
