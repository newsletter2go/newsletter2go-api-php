<?PHP

/*
// USE like this:
include_once('nl-api.php');
//$rt=$newsl->addrecipientDOI("Email", "Vorname", "Nachname", "m");
if ($rt->status<300) echo "OK:".$rt->info->count; else echo "ERR:".$rt->status;
var_dump($rt);
*/


include_once('src/Api.php');

/**********************/	
/* Addons to the API **/
/**********************/	
//
// add your login data below!
//
//
// doc: https://docs.newsletter2go.com/#!/Newsletter/createNewsletter


class nlapi extends NL2GO\Api {

    public function addrecipient($email, $first_name, $last_name, $gender='')
    {
        if (!in_array($gender, array('', 'm', 'f'))) {
            throw new \Exception("gender value not supported");
		}
        $endpoint = "/recipients";

        return $this->curl($endpoint, array("email" => $email, "gender" => $gender, "first_name" => $first_name, "last_name" => $last_name), static::METHOD_POST);
    }
	
    public function addrecipientDOI($email, $first_name, $last_name, $gender='', $code=false)
	// sends a confirmation mail
    {
        if (!in_array($gender, array('', 'm', 'f'))) {
            throw new \Exception("gender value not supported");
		}
		if ($code===false) $code='xxxxxxx-xxxxxxx-xxx'; // your code here
        $endpoint = "/forms/submit/$code";

        return $this->curl($endpoint, array("recipient" => array(/*"list_id" => $listid,*/ "email" => $email, "gender" => $gender, "first_name" => $first_name, "last_name" => $last_name)), static::METHOD_POST);
    }
	

}


/**********************/	
/*  Login data here  **/
/**********************/	
//

// Instantiate here
$newsl = new nlapi("***API-key***", "***login-email***", "***login-password***");
//var_dump($newsl);

// add recipient with email confirmation
//$rt=$newsl->addrecipientDOI("test@example.com", "Vorname", "Nachname", "f");
//var_dump($rt);

// add or update recipient WITHOUT confirmation email
//$rt=$newsl->addrecipient("test@example.com", "Vorname", "Nachname", "m");
//var_dump($rt);



/*
HTTP Status return codes

We also follow the most common HTTP status codes when outputting the API response:

2xx - Successful calls
200 - Success
201 - Created

4xx - Error codes
400 - API error - inspect the body for detailed information about what went wrong. The most common error is "code":1062, which means, that a unique constraint was hit. For example if the name of the group is already in use.
401 - Not authenticated - invalid access_token. Check if the access_token has expired or is incorrect.
403 - Access denied
404 - Call not available or no records found

5xx - API error - please contact support

echo($rt->status); 
*/




?>
