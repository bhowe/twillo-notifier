<?php

require_once('config.php');
require_once('functions.php');
require_once('functions-db.php');

require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

$absolute_url = full_url( $_SERVER );

if(!empty($_REQUEST['action'])){

	call_user_func($_REQUEST['action']);	
 }

 /**
 *
 * Log a message to a fileL 
 *
 * */

function  log_message($message)
{
//Something to write to txt log
$log  = $message . "\n\10\n\10";
//Save string to log, use FILE_APPEND to append.
file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
}

/**
 *
 * Send the message via twillo
 *
 * @return array of status of transactions
 * */


function send_message(){
	// Require the bundled autoload file - the path may need to change
	// based on where you downloaded and unzipped the SDK
	
	global $sid;
	global $token;
	global $from;
	global $message;
	global $buy_link;


		$client = new Client($sid, $token);
		$to='';
		$response = array();
		insert_sms($message);
		// Use the client to do fun stuff like send text messages!
		$sms_id = getMaxSmsID();
		$the_date = $_REQUEST['date'];
		$the_time = $_REQUEST['time'];

		if(!empty($_REQUEST['contacts'])){
			foreach($_REQUEST['contacts'] as $contactid){
			$number = getUserPhone($contactid);
			$to='+1'.$number;	
			try {
				
					 $client->messages->create(
					$to,
					array(
						'from' => $from,					
						'body' => $message . " " . $the_date . " at  " . $the_time . "  Click the link to schedule now " .$buy_link ."id=". $contactid ."&sms_id=". $sms_id 
					  )
					);	
					 $response['sent'][]= $to;
			} catch (TwilioException $e ) { 
				$response['not_sent'][]= $to;
				$response['status']='fail';				$response['msg_err']=$e->getMessage();
			}	 		
			} 
      }else{
			$response['status']='fail';
		}
		if(!empty($response['sent'])){
			$response['status']='success';
		}
		
		echo json_encode($response);
		die;
}

/*=====================================================  Twilo API Functions===================*/

//Encrypt Function
function doEncrypt($encrypt){

	global $crypt_key;
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $crypt_key, $encrypt, MCRYPT_MODE_ECB, $iv);
	$encode = base64_encode($passcrypt);
	
	return $encode;
}

//Decrypt Function
function doDecrypt($decrypt){
	global $crypt_key;
	
	$decoded = base64_decode($decrypt);
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $crypt_key, $decoded, MCRYPT_MODE_ECB, $iv);
	
	return str_replace("\\0", '', $decrypted);
}

function full_url( $s, $use_forwarded_host = false )
{
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}




/**
 *
 * Get times as option-list.
 *
 * @return string List of times
 */
function get_times( $default = '19:00', $interval = '+30 minutes' ) {

    $output = '';

    $current = strtotime( '00:00' );
    $end = strtotime( '23:59' );

    while( $current <= $end ) {
        $time = date( 'h.i A', $current );
        $sel = ( $time == $default ) ? ' selected' : '';

        $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
        $current = strtotime( $interval, $current );
    }

    return $output;
}

/**
 *
 * Get the origin URL 
 *
 * @return string the url
 * */

function url_origin( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

?>