<?php
/*
 * This example shows, how to send a transactional mailing which was created before in the Newsletter2Go UI.
 */
namespace NL2GO;

require_once __DIR__ . '../../vendor/autoload.php';

//TODO
$authKey = "your auth key here";
$userEmail = "login email address";
$userPassword = "login password";


$api = new Newsletter2Go_REST_Api($authKey, $userEmail, $userPassword);
$api->setSSLVerification(false);

$lists = $api->getLists();
var_dump($lists);

//TODO
$currentListId = "put a list id here";

/*
 * First, you will have to create a new TRANSACTIONAL mailing. 
 * We recommend that you create that transactional mailing through our UI in order to take full advantage 
 * of our powerful newsletter builder. 
 * This way, we will automatically create cross-client optimized and responsive HTML. 
 * You can use placeholders for personalisation directly in the newsletter mailing, e.g. {{ recipient.date_purchase }}
 * Yet another advantage lies in the possibility for other users (e.g. the marketing team) 
 * to change the layout or the content of the mailing later, without having to contact the developer (you).
 */


//get this mailing
$newsletters = $api->getNewsletters($currentListId);
var_dump($newsletters);

//TODO
$newsletter_id = "put the newsletter id of your transactional mailing here";

//set this transactional mailing to active
$result = $api->setTransactionalState($newsletter_id, "active");
//var_dump($result);


//recipient Infos:
$data = array(
		"contexts" => array(
						array(			
								"recipient" => array(
									"email" => "abc@example.org",
									"date_purchase" => "27.04.2017"	#the placeholder in your created Mailing should look like {{ recipient.date_purchase }}				
								)
								/*
								 * If this recipient does not exist in your current list (addressbook), it will not be added to it.
								 * If this recipient already exists in your current list and you dont provide data for the personalization here (e.g. date_purchase),
								 * we try to get it from the recipient data which is stored in the list.
								 */
						),
					),
			);



//send newsletter
$result = $api->sendNewsletter($newsletter_id, $data);
var_dump($result);


