function preview_image(event) 
{
   var reader = new FileReader();
   reader.onload = function()
   {
    var output = document.getElementById('output_image');
    output.src = reader.result;
   }
   reader.readAsDataURL(event.target.files[0]);
}

$( function() {
    $("#sortable").sortable();
    $("#sortable").disableSelection();
  } );

$( function() {
    $( "#dob" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1972:2011'
    });
  } );

function submitForm(){
  
 var validator = $("#my_form_id").validate({
   errorClass: "my-error-class",
   validClass: "my-valid-class",
  rules: 
  {                
      FirstName: {
   required: true,
   },
      LastName: {
    required: true,
   },
      user_no: {
    required: true,
  },
      user_city: {
    required: true,
  },
      user_dob: {
    required:true,
  },
    user_mobile_no: {
    required: true,
  },
      user_email:
    {
    required: true,
    email: true,
   },
      'user_lang[]': {
    required: true,
   },
      user_img:{
    required: true,
   },
},                                
     messages: {
     FirstName: " Please enter first name",
     LastName: " Please enter last name",
     user_no: " Please enter user no",
     user_city: " please enter city",
     user_dob: " Please enter Date of Birth",
     user_mobile_no: " Please enter mobile no",
     user_email: {
      required: "Enter your Email",
      email: "Please enter a valid email address.",
     },
     'user_lang[]':" <br>Please select aleast one language<br>",
     user_img: " Please select the image",
     },
    submitHandler: function(form) 
    {
      var form_data = new FormData($('form')[0]);
          form_data.append("action", "insert_ajax_request");
          // form_data.append("action", "update_ajax_request");
       $.ajax({ 
         data: form_data,
         type: 'post',
         url: ajaxurl,
         processData: false,
         contentType: false,
         // stringyfy before passing
          success: function(data){  
              $('#message').fadeIn().html(data);
              setTimeout(function() {
              $('#message').fadeOut("slow");
              }, 4000 );  
          },
          error: function(data) { 
              alert('error'); 
    }        
      });
                
     }
 });
}

function updateForm(){
  
 var validator = $("#my_form_id").validate({
   errorClass: "my-error-class",
   validClass: "my-valid-class",
  rules: 
  {                
      FirstName: {
   required: true,
   },
      LastName: {
    required: true,
   },
      user_no: {
    required: true,
  },
      user_city: {
    required: true,
  },
      user_dob: {
    required:true,
  },
    user_mobile_no: {
    required: true,
  },
      user_email:
    {
    required: true,
    email: true,
   },
      'user_lang[]': {
    required: true,
   },
},                                
     messages: {
     FirstName: " Please enter first name",
     LastName: " Please enter last name",
     user_no: " Please enter user no",
     user_city: " please enter city",
     user_dob: " Please enter Date of Birth",
     user_mob: " Please enter mobile no",
     user_email: {
      required: "Enter your Email",
      email: "Please enter a valid email address.",
     },
     'user_lang[]':" <br>Please select aleast one language<br>",
     },
 });
}


jQuery(document).ready(function($){

  var mediaUploader;

  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#image').val(attachment.url);
       $('#output_image').attr('src',attachment.url).css('width=25');
    });
    // Open the uploader dialog
    mediaUploader.open();
  });

});


jQuery(document).ready(function($) {
 
    // We'll pass this variable to the PHP function example_ajax_request
    $(".delbutton").click(function(){
    //Save the link in a variable called element
    var element = $(this);
    //Find the id of the link that as clicked
    var del_id = element.attr('id');
    var $ele = $(this).parent().parent();
    //Built a url to send
    var info = {"id" : del_id };
      if(confirm("Are you sure you want to delete this Record?")) {
        $.ajax({
          type: "POST",
          url: ajaxurl,
          data: {
            'action': 'delete_ajax_request',info
        },
          success: function(html){
            // alert(data);
             $ele.fadeOut().remove();
          }
        });
        // $(this).parents(".ffui-media-item").animate({ backgroundColor: "#fbc7c7" }, "fast")
        //   .animate({ opacity: "hide" }, "slow");
      }
    return false;
  });
              
});