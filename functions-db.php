<?php

require_once('config.php');
require_once('functions.php');
require_once('functions-db.php');

if(!empty($_POST['action'])){
	call_user_func($_POST['action']);	
 }


function insert(){
	 global $db;
     $sql_statement="INSERT INTO contacts (name, phone) VALUES ('".$_POST['name']."', '".$_POST['phone']."')";
	 return db_execute($sql_statement);
}

function update(){
	
	global $db;
    $sql_statement = "UPDATE contacts SET name='".$_POST['name']."', phone='".$_POST['phone']."' WHERE id='".$_POST['id']."' ";
	return db_execute($sql_statement);
}

function deleteUser(){
	global $db;
	if(isset($_POST['id']) && isset($_POST['id']) != "")
{
  
    // get user id
    $user_id = $_POST['id'];

    // delete User
    $query = "DELETE FROM contacts WHERE id = '$user_id'";
    return db_execute($query);
  }
}

function get_all_contacts_dropdown(){
	
	global $db;
    $query = "SELECT * FROM contacts";

	if (!$result = mysqli_query($db,$query)) {
       // exit(mysqli_error());
    }
	$html='';

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	$number = 1;
    	while($row = mysqli_fetch_assoc($result))
    	{
				$html.='<div class="checkbox">';
				$html.='<label>';
				$html.='<input type="checkbox" name="contacts" class="check" value="'.$row['phone'].'">'.$row['name'].'<'.$row['phone'].'>';
				$html.='</label>';
				$html.='</div>';
		}
	}else{
		    $html="<strong>No records found...</strong>";
	}
	return $html;
}



function readUserDetails(){
	global $db;
	if(isset($_POST['id']) && isset($_POST['id']) != "")
		{
			// get User ID
			$user_id = $_POST['id'];

			// Get User Details
			$query = "SELECT * FROM contacts WHERE id = '$user_id'";
			if (!$result = mysqli_query($db,$query)) {
				exit(mysql_error());
			}
			$response = array();
			if(mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$response = $row;
				}
			}
			else
			{
				$response['status'] = 200;
				$response['message'] = "Data not found!";
			}
			// display JSON data
			echo json_encode($response);
		}
		else
		{
			$response['status'] = 200;
			$response['message'] = "Invalid Request!";
		}
	
}


function readRecords(){
	global $db;

$data = '<table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>phone</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>';



	$query = "SELECT * FROM contacts";

	if (!$result = mysqli_query($db,$query)) {
       // exit(mysqli_error());
     }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	$number = 1;
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$number.'</td>
				<td>'.$row['name'].'</td>
				<td>'.$row['phone'].'</td>
				<td>
					<button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Update</button>
				</td>
				<td>
					<button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button>
				</td>
    		</tr>';
    		$number++;
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="6">Records not found!</td></tr>';
    }

    $data .= '</table>';
    echo $data;	
	
}

function insert_sms($message){
	 global $db;
	 $insert_message = mysqli_real_escape_string($db, $message);
	 $sql_statement="INSERT INTO sms_transactions (sms_message,sms_date,sms_completed) VALUES ('". $insert_message."',NOW(),0)";
	 return  db_execute($sql_statement);	 
}

function db_execute($sql_statement){
	
	global $db;
	if(mysqli_query($db,$sql_statement)){
		return  200;
	}else{
		  return 100;
	}

}

function getUserPhone($theid){
	global $db;
	$query = "SELECT phone FROM  contacts where id = " . $theid;
    $result = mysqli_query($db,$query);
	$row = mysqli_fetch_assoc($result);
    return $row['phone'];
}

function getMaxSmsID(){
	global $db;
	$query = "SELECT max(idsms_transactions) as uid FROM  sms_transactions";
    $result = mysqli_query($db,$query);
	$row = mysqli_fetch_assoc($result);
    return $row['uid'];
}

function checkAppointment(){
	global $db;
	$query = "SELECT sms_completed as completed FROM  sms_transactions where idsms_transactions = " . $_GET['sms_id'];
    $result = mysqli_query($db,$query);
	$row = mysqli_fetch_assoc($result);
    return $row['completed'];
}

function updateAppointment(){
	global $db;
	$query = "UPDATE sms_transactions set sms_completed = 1 where idsms_transactions = " . $_GET['sms_id'];
    $result = mysqli_query($db,$query);
	//$row = mysqli_fetch_assoc($result);
    //return $row['completed'];
}

/**
 *
 * Grab all the contacts from the DB
 *
 * @return string HTML list of all cohntacts
 */

function get_all_contacts(){
	
	global $db;
    $query = "SELECT * FROM contacts";
	$result = mysqli_query($db,$query);
	$html='';

	
    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	$number = 1;
    	while($row = mysqli_fetch_assoc($result))
    	{
				$html.='<div class="checkbox">';
				$html.='<label>';
				$html.='<input type="checkbox" name="contacts" class="check" value="'.$row['id'].'">'.$row['name'].'<'.$row['phone'].'>';
				$html.='</label>';
				$html.='</div>';
		}
	}else{
		    $html="<strong>No records found...</strong>";
	}
	return $html;
}


?>