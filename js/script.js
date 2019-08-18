//Send Message

function sendMessage() {
	 $('.msg').html('');
	 $(this).attr('disabled',true);
    // get values
	var selected = new Array();
	
    var message = $("#message").val();
		 $("input:checkbox[name=contacts]:checked").each(function() {
			   selected.push($(this).val());
		  });

	 if(message==''){
		 $('.msg').html('<div class="alert alert-danger">Message body can not be balnk!</div>');
		  $(this).attr('disabled',false);
		 return false;
	 }
	 else if(selected.length==0){
		 $('.msg').html('<div class="alert alert-danger">Please select phone number using checkbox!</div>');
		  $(this).attr('disabled',false);
		 return false;
	 }else{
		 $('.msg').html('<div class="alert alert-warning">Please wait..</div>');
	 }		 

		// Add record
		$.post(site_url+"functions.php", {
			message: message,
			contacts: selected,
			action: 'send_message',
			date: $("#datepicker-day").val(),
			time: $("#thetime").val()
		}, function (data, status) {
			data = JSON.parse(data);
			//console.log(data);
			if(data.status=="fail"){
				  var msg='('+data.not_sent.length+')'+' phone numbers were not delivered!'+'<br>';
				  msg = msg+''+data.msg_err
				 jQuery('.msg').html('<div class="alert alert-danger">'+msg+'</div>');
			}else{
				var msg='('+data.sent.length+')'+' phone numbers were successfully delivered!';
				 jQuery('.msg').html('<div class="alert alert-success">'+msg+'</div>');
			}
			 $(this).attr('disabled',false);
		});
		return false;
}



// Add Record
function addRecord() {
    // get values
    var name = $("#name").val();
    var phone = $("#phone").val();
	
	 if(name==''){
		 $('.msg_frm').html('<div class="alert alert-danger">Please enter name!</div>');
		 return false;
	 }
	 else if(phone==''){
		 $('.msg_frm').html('<div class="alert alert-danger">Please enter phone number!</div>');
		 return false;
	 }else{
		 $('.msg_frm').html('<div class="alert alert-warning">Please wait..</div>');
	 }	

    // Add record
    $.post(site_url+"functions.php", {
        name: name,
        phone: phone,
		action: 'save_phone_entry'
    }, function (data, status) {
        // close the popup
        // read records again
		 if(data==200){
			 $('.msg_frm').html('<div class="alert alert-success">Contact added!</div>'); 
		 }else{
			  $('.msg_frm').html('<div class="alert alert-danger">contact failed to add, Please try again!</div>');
		 }
		
        readRecords();
		setTimeout(function(){
			location.reload();			
		},500);

        // clear fields from the popup
        $("#name").val("");
        $("#phone").val("");
    });
	return false;
}

// READ records
function readRecords() {

    $.get(site_url+"functions.php?action=readRecords", {}, function (data, status) {
        $(".records_content").html(data);
    });
}


function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete User?");
    if (conf == true) {
        $.post(site_url+"/functions.php", {
                id: id,
				action:'deleteUser'
            },
            function (data, status) {
                // reload Users by using readRecords();
               if(data==200){
					 $('.msg_frm').html('<div class="alert alert-success">Contact updated!</div>'); 
				 }else{
					  $('.msg_frm').html('<div class="alert alert-danger">contact failed to add, Please try again!</div>');
				 }
            // reload Users by using readRecords();
            readRecords();
			setTimeout(function(){
				location.reload();			
			},500);
            }
        );
    }
	return false;
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post(site_url+"functions.php", {
            id: id,
			action:'readUserDetails'
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_name").val(user.name);
            $("#update_phone").val(user.phone);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var name = $("#update_name").val();
    var phone = $("#update_phone").val();

    // get hidden field value
    var id = $("#hidden_user_id").val();
	
		
	 if(name==''){
		 $('.msg_frm').html('<div class="alert alert-danger">Please enter name!</div>');
		 return false;
	 }
	 else if(phone==''){
		 $('.msg_frm').html('<div class="alert alert-danger">Please enter phone number!</div>');
		 return false;
	 }else{
		 $('.msg_frm').html('<div class="alert alert-warning">Please wait..</div>');
	 }	

    // Update the details by requesting to the server using ajax
    $.post(site_url+"functions.php", {
            id: id,
            name: name,
            phone: phone,
			action: 'save_phone_entry'
        },
        function (data, status) {
            // hide modal popup
				 if(data==200){
					 $('.msg_frm').html('<div class="alert alert-success">Contact updated!</div>'); 
				 }else{
					  $('.msg_frm').html('<div class="alert alert-danger">contact failed to add, Please try again!</div>');
				 }
            // reload Users by using readRecords();
            readRecords();
			setTimeout(function(){
				location.reload();			
			},500);
        }
    );
		return false;
}

$(document).ready(function () {
    // READ recods on page load
	readRecords(); // calling function
	
		$("#checkAll").click(function () {
			$(".check").prop('checked', $(this).prop('checked'));
		});

		jQuery( "#datepicker-day" ).datepicker();
	    jQuery( "#datepicker-day" ).datepicker("setDate", "10w+1");
	
});





