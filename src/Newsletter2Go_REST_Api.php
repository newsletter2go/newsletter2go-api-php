<?php

/**
 * For API Documentation see https://docs.newsletter2go.com
 */

namespace NL2GO;


class Newsletter2Go_REST_Api
{

    const GRANT_TYPE = "https://nl2go.com/jwt";
    const BASE_URL = "https://api.newsletter2go.com";

    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PATCH = "PATCH";
    const METHOD_DELETE = "DELETE";

    private $user_email = "email";
    private $user_pw = "password";
    private $user_auth_key = "authkey";

    private $access_token = "";
    private $refresh_token = "";

    private $sslVerification = true;


    function __construct($authKey, $userEmail, $userPassword)
    {
        $this->user_auth_key = $authKey;
        $this->user_email = $userEmail;
        $this->user_pw = $userPassword;
    }
    
    public function auth(){
    	$this->getToken();
    	
    }

    public function setSSLVerification($enable) {
        $this->sslVerification = $enable;
    }

    private function getToken()
    {

        $endpoint = "/oauth/v2/token";

        $data = array(
            "username"   => $this->user_email,
            "password"   => $this->user_pw,
            "grant_type" => static::GRANT_TYPE

        );

        $response = $this->_curl('Basic ' . base64_encode($this->user_auth_key), $endpoint, $data, "POST");
    
        if (isset($response->error)) {
            throw new \Exception("Authentication failed: " . $response->error);
        }

        $this->access_token = $response->access_token;
        $this->refresh_token = $response->refresh_token;
        

    }

    /**
     * get all users in this account
     * @return stdClass
     */
    public function getUsers()
    {

        $endpoint = "/users";

        $data = array(
            "_expand" => true
        );

        return $this->curl($endpoint, $data);
    }

    /**
     * get all newsletters in a list
     * @param string $listId
     * @return stdClass
     */
    public function getNewsletters($listId)
    {
        $endpoint = "/lists/$listId/newsletters";
        $data = array(
        		"_expand" => true
        );
        return $this->curl($endpoint, $data);
    }
    
    /**
     * get all templates in a list
     * @param string $listId
     * @return stdClass
     */
    public function getTemplates($listId)
    {
    	$endpoint = "/lists/$listId/templates";
    	$data = array(
    			"_expand" => true,
    			"_filter" => "type=='custom',type=='premium'"
    	);
    
    	return $this->curl($endpoint, $data);
    }
    
    /**
     * Get a single template templates in a list
     * @param string $listId
     * @param string $templateId
     * @return stdClass
     */
    public function getTemplate($listId, $templateId)
    {
    	$endpoint = "/lists/$listId/templates/$templateId";
    	$data = array(
    			"_expand" => true,
    	);
    
    	return $this->curl($endpoint, $data);
    }
    
    
	/**
	 * create a new newsletter
	 * https://docs.newsletter2go.com/#!/Newsletter/createNewsletter
	 * @param string $listId
	 * @param string $type can be 'default','transaction','doi'
	 * @param string $name the name of the newsletter
	 * @param string $header_from the from e-mail address
	 * @param string $subject the subject of the newsletter
	 * @param string $html you can pass html directly
	 * @param string $json or you can pass json, which you can get from an existing template/mailing 
	 * @throws \Exception
	 * @return stdClass
	 */
    public function createNewsletter($listId, $type, $name, $header_from, $subject, $html = null, $json = null)
    {
        if (!in_array($type, array("transaction", "default", "doi"))) {
            throw new \Exception("Mailing type not supported");
        }
        $endpoint = "/lists/$listId/newsletters";

        $data = array(
        		"type" => $type, 
        		"name" => $name, 
        		"subject" => $subject,        
        		"header_from_email" => $header_from
        );
        if(isset($html)){
        	$data['html'] = $html;
        }
        if(isset($json)){
        	$data['json'] = $json;
        }
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }
    
    /**
     * Update the HTML of an existing newsletter
     * https://docs.newsletter2go.com/#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param string $html
     * @return stdClass
     */
    public function updateHTML($newsletterId, $html = null)
    {
    	
    	$endpoint = "/newsletters/$newsletterId";
    
    	$data = array(
    			"html" => $html    			
    	);

    
    	return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }
    
    /**
     * Update subject of an existing newsletter
     * https://docs.newsletter2go.com/#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param string $subject
     * @return stdClass
     */
    public function updateSubject($newsletterId, $subject = null)
    {
    	 
    	$endpoint = "/newsletters/$newsletterId";
    
    	$data = array(
    			"subject" => $subject
    	);
    
    
    	return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }

    
    /**
     * Update name, subject or html of an existing newsletter
     * https://docs.newsletter2go.com/#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param string $newsletterId
     * @param string $name
     * @param string $subject
     * @param string $html
     * @return stdClass
     */
    public function updateNewsletter($newsletterId, $name, $subject, $html)
    {
        $endpoint = "/newsletters/$newsletterId";

        return $this->curl($endpoint, array("name" => $name, "subject" => $subject, "html" => $html), static::METHOD_PATCH);
    }

    /**
     * delete a newsletter
     * @param string $newsletterId
     * @return stdClass
     */
    public function deleteNewsletter($newsletterId)
    {
        $endpoint = "/newsletters/$newsletterId";

        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }

    /**
     * get all lists
     * https://docs.newsletter2go.com/#!/List/getLists
     * @return stdClass
     */
    public function getLists()
    {

        $endpoint = "/lists";

        $data = array(
            "_expand" => true
        );

        return $this->curl($endpoint, $data);
    }
    
    
    /**
     * If you want to send transactional newsletters, you have to activate it first
     * https://docs.newsletter2go.com/#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param string $newsletterId
     * @param string $state can be 'active' or 'inactive'
     * @return stdClass
     */
    public function setTransactionalState($newsletterId, $state){
    	
    	$endpoint = "/newsletters/$newsletterId";
    	
    	return $this->curl($endpoint, array("state" => $state), static::METHOD_PATCH);    	
    	
    }
    
    /**
     * Send a newsletter 
     * https://docs.newsletter2go.com/#!/Newsletter/sendNewsletter
     * @param string $newsletterId defines the newsletter that should be sent
     * @param array $recipient_data data of recipients
     * @return stdClass
     */
    public function sendNewsletter($newsletterId, $recipient_data){
    	
    	$endpoint = "/newsletters/$newsletterId/send";   	
    	
    	return $this->curl($endpoint, $recipient_data, static::METHOD_POST);
    	
    }

    /**
     * @param $endpoint string the endpoint to call (see docs.newsletter2go.com)
     * @param $data array tha data to submit. In case of POST and PATCH its submitted as the body of the request. In case of GET and PATCH it is used as GET-Params. See docs.newsletter2go.com for supported parameters.
     * @param string $type GET,PATCH,POST,DELETE
     * @return \stdClass
     * @throws \Exception
     */
    public function curl($endpoint, $data, $type = "GET")
    {
        if (!isset($this->access_token) || strlen($this->access_token) == 0) {
            $this->getToken();
        }
        if (!isset($this->access_token) || strlen($this->access_token) == 0) {
            throw new \Exception("Authentication failed");
        }

        $apiReponse = $this->_curl('Bearer ' . $this->access_token, $endpoint, $data, $type);

        // check if token is expired
        if (isset($apiReponse->error) && $apiReponse->error == "invalid_grant") {
            $this->getToken();
            $apiReponse = $this->_curl('Bearer ' . $this->access_token, $endpoint, $data, $type);
        }

        return $apiReponse;
    }

    private function _curl($authorization, $endpoint, $data, $type = "GET")
    {

        $ch = curl_init();

        $data_string = json_encode($data);

        $get_params = "";

        if ($type == static::METHOD_POST || $type == static::METHOD_PATCH) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  	    if ($type == static::METHOD_POST) {
	    	curl_setopt($ch, CURLOPT_POST, true);
	    }
        } else {
            if ($type == static::METHOD_GET || $type == static::METHOD_DELETE) {
                $get_params = "?" . http_build_query($data);
            } else {
                throw new \Exception("Invalid HTTP method: " . $type);
            }
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_URL, static::BASE_URL . $endpoint . $get_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: ' . $authorization,
            'Content-Length: ' . ($type == static::METHOD_GET || $type == static::METHOD_DELETE) ? 0 : strlen($data_string)
        ));


        if (!$this->sslVerification) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        $json_decoded = json_decode($response);

	if(isset($json_decoded)){
		return $json_decoded;
	}
	else{
		return $response; // for pdf download
	}
    }
}
