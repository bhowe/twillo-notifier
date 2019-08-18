<?php 
require_once('config.php');
require_once('functions.php');
require_once('functions-db.php');

include('gmail_notifer.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the schedule</title>

    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="bootstrap-3.3.5-dist/css/bootstrap.css?ver=<?php echo time();?>"/>
</head>
<body>


<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
            
<?php

if (checkAppointment() == 0){
    echo "Great you have the appointment see you then.";
    updateAppointment();
    include('gmail_notifer.php');
       
}else{

    echo "Sorry the appointment has already been booked.";
    //its already complete
}
//first person here gets it
//check to see if the SMS is marked complete, if not do it
//if it is display error message

?>
            
            
        
        </div>





							  <?php 
							  
							 // echo get_all_contacts(); 
							  
							  ?>
							</div>
>
</div>
<!-- /Content Section -->





<!-- Jquery JS file -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>

<!-- Bootstrap JS file -->
<script type="text/javascript" src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script>
var site_url = '<?php echo $site_url; ?>';
</script>

<!-- Custom JS file -->
<script type="text/javascript" src="js/script.js?ver=<?php echo time();?>"></script>
</body>
</html>
