$(".toggle-password").click(function() {  
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find(".password");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
  });
  
  
  $('.nav-btn').on('click', function() {
    $('.page-container').toggleClass('sidebar_collapsed');
  });
  
  
  $('.map_view').on('click', function() { 
    $('.review_section').addClass('d-none');
  }); 
  
  $('.del_popup').click(function(){
    swal({
      title: 'Are you sure?', 
      text: "Once deleted, you will not be able to recover this!", 
      confirmButtonText: 'Confirm',
      cancelButtonColor: '#FD841F',
      showCancelButton: true,
  }).then(function() {
      swal(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      );
  })

})
  
  /* Variables */
  var row = $(".attri");
  
  function addRow() {
  row.clone(true, true).appendTo("#attributes");
  }
  
  function removeRow(button) {
  button.closest(".attri").remove();
  }
  
  $('#attributes .attri:first-child').find('.remove').hide();
   
  $(".add").on('click', function () {
  addRow();  
  if($("#attributes .attri").length > 1) { 
    $(".remove").show();
  }
  });
  $(".remove").on('click', function () {
  if($("#attributes .attri").length  == 1) { 
    $(".remove").hide();
  } else {
    removeRow($(this));
    
    if($("#attributes .attri").length  == 1) {
        $(".remove").hide();
    }
  }
  });
   
  $('#menu').metisMenu();
  
  
  
  $(document).ready(function(){
    $(".loader_btn").click(function(e){
    $('.overlay-wrapper').show();
    setTimeout(function() {
         $(".overlay-wrapper").hide();
     }, 2000);
    })
  }); 
   
  // custom searchbar
  $(document).ready(function () {
    var table =  $('#example').DataTable( {
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
         dom: 'Blfrtip', 
         buttons: [
             'excelHtml5'
         ]
       });
       $('#customSearch').on( 'keyup', function () { 
         table.search( this.value ).draw();
       })
       $(".btn-excel").on("click", function() {
         $(".buttons-excel").trigger("click");
      });
   });
      
  
  // $('.mySelect2').select2({});
  
    
  $('.model_select').select2({  dropdownParent: $('#exampleModal') });
  $('.mySelect2').select2({});
   $("input[type=file]").change(function (e) {
     $(this).parents(".uploadFile").find(".filename").text(e.target.files[0].name);
  }); 
  
  
  
  // Toast
  $(document).ready(function() {
    toastr.options = {
      'closeButton': true,
      'debug': false,
      'newestOnTop': false,
      'progressBar': true,
      'positionClass': 'toast-top-right',
      'preventDuplicates': false,
      'showDuration': '1000',
      'hideDuration': '1000',
      'timeOut': '5000',
      'extendedTimeOut': '1000',
      'showEasing': 'swing',
      'hideEasing': 'linear',
      'showMethod': 'fadeIn',
      'hideMethod': 'fadeOut',
    }
  });
  const successmsg=  {
    title: "Success",
    message: "This is Success Message"
  };
  const infomsg=  {
    title: "Info",
    message: "This is Info Message"
  };
  const errormsg=  {
    title: "Error",
    message: "This is Error Message"
  };
  const warningmsg=  {
    title: "Warning",
    message: "This is Warning Message"
  };
  // Toast Type
  $('#success').click(function(event) {
    toastr.success(successmsg.message , successmsg.title);
  });
  $('#info').click(function(event) {
    toastr.info(infomsg.message , infomsg.title)
  });
  $('#error').click(function(event) {
    toastr.error(errormsg.message , errormsg.title)
  });
  $('#warning').click(function(event) {
    toastr.warning(warningmsg.message , warningmsg.title)
  });
   
  
  


  function update_payemnt_status(id){
    var check=confirm('Are your sure?');
    var payment_status=jQuery('#payment_status').val();
    if(check==true){
      window.location.href='../update-payemnt-status/'+payment_status+'/'+id;
    }
  }
  
  function update_order_status(id){
    var check = confirm('Are you sure?');
    if(check) {
        var order_status = jQuery('#order_status_' + id).val();
        window.location.href = '../update-order-status/' + order_status + '/' + id;
    }
}