<?php 

require_once('config.php');
require_once('functions.php');
require_once('functions-db.php');
$site_url= full_url($_SERVER);

 ?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twillo Interface</title>

    <!-- Bootstrap CSS File  -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css?ver=<?php echo time();?>"/>
	
</head>
<body>

<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>No Appointments Lost</h1>
        </div>
    </div>

    <div class="row">
	

        <div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h3>Date and Time of the Appointment</h3>
				</div>
     </div>		
		   <div class="row">
				<div class="col-md-12">
					<div class="msg"></div>						
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
					<label for="message">Date:</label>
					<input type = "text" id = "datepicker-day">
					<br />
					<label for="message">Time:</label>
					
					<select id = 'thetime' name="time"><?php echo get_times(); ?></select>
					<br />
					  <label for="message">Default Message:</label>
					  <textarea class="form-control" rows="5" name="message" id="message">Synergy Myofascial as an appointment available.</textarea>
					</div>					
				</div>
			</div>		
			
		   <div class="row">
				<div class="col-md-12">
				
					<div class="row">					
							<div class="checkbox">
								<label>
								  <input type="checkbox" class="check" id="checkAll"> Check All Contacts
								</label>
							</div>
							<div class="scrollit">		
							  <?php echo get_all_contacts(); ?>
							</div>
					</div>							
				</div>
			</div>	

		   <div class="row">
				<div class="col-md-12">
					<div class="pull-left">
						<button class="btn btn-success"  data-target="#" onclick="sendMessage()">Send Now</button>						
					</div>							
				</div>
			</div>			
       </div>
	   <div class="col-md-6">
			 <div class="row">
				<div class="col-md-12">
					<div class="pull-right">
						<button class="btn btn-success" data-toggle="modal" data-target="#add_new_record_modal">Add New Contact</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Contacts:</h3>
					<div class="records_content"></div>
				</div>
			</div>
       </div>  
	   
  </div>		

</div>
<!-- /Content Section -->

<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Record</h4>
            </div>
            <div class="modal-body">
			  <div class="row">
					<div class="col-md-12">
						<div class="msg_frm"></div>						
					</div>
				</div>

                <div class="form-group">
                    <label for="first_name">Name</label>
                    <input type="text" id="name" placeholder="Name" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="last_name">Phone</label>
                    <input type="text" id="phone" placeholder="Phone" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Add Record</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal - Update User details -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body">
			    <div class="row">
					<div class="col-md-12">
						<div class="msg_frm"></div>						
					</div>
				</div>

                <div class="form-group">
                    <label for="update_first_name">Name</label>
                    <input type="text" id="update_name" placeholder="Name" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="update_last_name">Phone</label>
                    <input type="text" id="update_phone" placeholder="Phone" class="form-control"/>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Save Changes</button>
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Jquery JS file -->
<!--<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Bootstrap JS file -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script>
var site_url = '<?php echo $site_url; ?>';
</script>


<!-- Custom JS file -->
<script type="text/javascript" src="js/script.js?ver=<?php echo time();?>"></script>
</body>
</html>
