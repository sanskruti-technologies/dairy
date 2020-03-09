/**
 * File : publishers.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author sheetal panchal
 */



$(document).ready(function(){


 jQuery.validator.addMethod("checkEmailExists", function(value, element)
       {
           var response = false;
           var oldId=$("#oldId").val();
           var post_url_check_email_franchise = baseURL +"user/checkEmailExists";
           
           $.ajax({
                  type: "POST",
                  url: post_url_check_email_franchise,
                  data: {email : value,oldId:oldId},
                  dataType: "json",
                  async: false
           }).done(function(result){
                
                    response = result;
             
           });
           return response;
       }, "Email already taken.");
  
  


  $('#form_iconic_validation').validate({
            errorElement: 'span', 
            errorClass: 'error', 
            focusInvalid: false, 
            ignore: "",
            rules: {
                firstName: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true, 
					checkEmailExists:true
					//remote : { url : baseURL + "checkEmailExists", type :"post"}
                },
			
            },

            invalidHandler: function (event, validator) {
				//display error alert on form submit    
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-with-icon').children('i');
                var parent = $(element).parent('.input-with-icon');
                icon.removeClass('fa fa-check').addClass('fa fa-exclamation');  
                parent.removeClass('success-control').addClass('error-control');  
            },

            highlight: function (element) { // hightlight error inputs
				var parent = $(element).parent();
                parent.removeClass('success-control').addClass('error-control'); 
            },

            unhighlight: function (element) { // revert the change done by hightlight
                
            },

            success: function (label, element) {
                var icon = $(element).parent('.input-with-icon').children('i');
				var parent = $(element).parent('.input-with-icon');
                icon.removeClass("fa fa-exclamation").addClass('fa fa-check');
				parent.removeClass('error-control').addClass('success-control'); 
            },

            submitHandler: function (form) {
            form.submit();
            }
       
        });
         $('.select2', "#form_iconic_validation").change(function () {
            $('#form_iconic_validation').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
	


});




