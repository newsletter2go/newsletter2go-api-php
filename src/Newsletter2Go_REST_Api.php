<?php

/**
 * For API Documentation see https://docs.newsletter2go.com
 **/

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
        $this->user_email    = $userEmail;
        $this->user_pw       = $userPassword;
    }

    /**
     * @throws \Exception
     */
    public function auth()
    {
        $this->getToken();
    }
    
    public function setSSLVerification($enable)
    {
        $this->sslVerification = $enable;
    }

    /**
     * @throws \Exception
     */
    private function getToken()
    {
        
        $endpoint = "/oauth/v2/token";
        
        $data = array(
            "username" => $this->user_email,
            "password" => $this->user_pw,
            "grant_type" => static::GRANT_TYPE
        
        );
        
        $response = $this->_curl('Basic ' . base64_encode($this->user_auth_key), $endpoint, $data, "POST");
        
        if (isset($response->error)) {
            throw new \Exception("Authentication failed: " . $response->error);
        }
        
        $this->access_token  = property_exists($response, 'access_token') ? $response->access_token : null;
        $this->refresh_token = property_exists($response, 'refresh_token') ? $response->refresh_token : null;
        
    }

    /**
     * getListDetails
     * https://docs.newsletter2go.com/?version=latest#2b0496e8-e75a-48d5-a8e4-2baff95af7bf
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getListDetails($listId)
    {
        $endpoint = "/lists/$listId";
        $data     = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * createList
     * https://docs.newsletter2go.com/?version=latest#364131ba-fd20-444a-b029-e53a5a89546d
     * @param string $name
     * @param boolean $uses_econda
     * @param boolean $uses_googleanalytics
     * @param boolean $has_opentracking
     * @param boolean $has_clicktracking
     * @param boolean $has_conversiontracking
     * @param string $imprint
     * @param string $header_from_email
     * @param string $header_from_name
     * @param string $header_reply_email
     * @param string $header_reply_name
     * @param string $tracking_url
     * @param string $landingpage
     * @param boolean $use_ecg_list
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function createList($name, $uses_econda, $uses_googleanalytics, $has_opentracking, $has_clicktracking, $has_conversiontracking, $imprint, $header_from_email, $header_from_name, $header_reply_email, $header_reply_name, $tracking_url, $landingpage, $use_ecg_list)
    {
        $endpoint = "/lists";
        
        $data = array(
            "name" => $name,
            "uses_econda" => $uses_econda,
            "uses_googleanalytics" => $uses_googleanalytics,
            "has_opentracking" => $has_opentracking,
            "has_clicktracking" => $has_clicktracking,
            "has_conversiontracking" => $has_conversiontracking,
            "imprint" => $imprint,
            "header_from_email" => $header_from_email,
            "header_from_name" => $header_from_name,
            "header_reply_email" => $header_reply_email,
            "header_reply_name" => $header_reply_name,
            "tracking_url" => $tracking_url,
            "landingpage" => $landingpage,
            "use_ecg_list" => $use_ecg_list
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * updateList
     * https://docs.newsletter2go.com/?version=latest#80247ee2-dda3-4793-b15a-905af57af154
     * @param string $listId
     * @param string $name
     * @param boolean $uses_econda
     * @param boolean $uses_googleanalytics
     * @param boolean $has_opentracking
     * @param boolean $has_clicktracking
     * @param boolean $has_conversiontracking
     * @param string $imprint
     * @param string $header_from_email
     * @param string $header_from_name
     * @param string $header_reply_email
     * @param string $header_reply_name
     * @param string $tracking_url
     * @param string $landingpage
     * @param boolean $use_ecg_list
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateList($listId, $name, $uses_econda, $uses_googleanalytics, $has_opentracking, $has_clicktracking, $has_conversiontracking, $imprint, $header_from_email, $header_from_name, $header_reply_email, $header_reply_name, $tracking_url, $landingpage, $use_ecg_list)
    {
        $endpoint = "/lists/$listId";
        
        $data = array(
            "name" => $name,
            "uses_econda" => $uses_econda,
            "uses_googleanalytics" => $uses_googleanalytics,
            "has_opentracking" => $has_opentracking,
            "has_clicktracking" => $has_clicktracking,
            "has_conversiontracking" => $has_conversiontracking,
            "imprint" => $imprint,
            "header_from_email" => $header_from_email,
            "header_from_name" => $header_from_name,
            "header_reply_email" => $header_reply_email,
            "header_reply_name" => $header_reply_name,
            "tracking_url" => $tracking_url,
            "landingpage" => $landingpage,
            "use_ecg_list" => $use_ecg_list
        );
        
        return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }

    /**
     * deleteList
     * https://docs.newsletter2go.com/?version=latest#80247ee2-dda3-4793-b15a-905af57af154
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteList($listId)
    {
        $endpoint = "/lists/$listId";
        
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }

    /**
     * getRecipients
     * https://docs.newsletter2go.com/?version=latest#c97c941a-267c-4afb-80e9-d45b0572b19d
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getRecipients()
    {
        
        $endpoint = "/recipients";
        
        $data = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * getRecipient
     * https://docs.newsletter2go.com/?version=latest#6c7853a8-978c-4d48-8d97-b5a921d6e287
     * @param string $recipientId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getRecipient($recipientId)
    {
        
        $endpoint = "/recipients/$recipientId";
        
        $data = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * updateRecipientList
     * https://docs.newsletter2go.com/?version=latest#9eb0eccc-8c3c-4a59-90e5-547031fe55a2
     * @param string $listId
     * @param string $email
     * @param string $phone
     * @param string $gender
     * @param string $first_name
     * @param string $last_name
     * @param boolean $is_unsubscribed
     * @param boolean $is_blacklisted
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateRecipientList($listId, $email, $phone, $gender, $first_name, $last_name, $is_unsubscribed, $is_blacklisted)
    {
        
        $endpoint = "/recipients";
        
        $data = array(
            "list_id" => $listId,
            "email" => $email,
            "phone" => $phone,
            "gender" => $gender,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "is_unsubscribed" => $is_unsubscribed,
            "is_blacklisted" => $is_blacklisted
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * deleteRecipientsFromList
     * https://docs.newsletter2go.com/?version=latest#b84956c5-93ef-48a4-9e1d-7f13306dbffd
     * @param string $listId
     * @param string $recipientId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteRecipientsFromList($listId, $recipientId)
    {
        $endpoint = "/lists/$listId/recipients/$recipientId";
        
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }


    /**
     * updateRecipients
     * https://docs.newsletter2go.com/?version=latest#b16f71d0-0d63-4df0-a750-7dc4e8515bcc
     * @param string $listId
     * @param string $email
     * @param string $phone
     * @param string $gender
     * @param string $first_name
     * @param string $last_name
     * @param boolean $is_unsubscribed
     * @param boolean $is_blacklisted
     * @param string $filter
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateRecipients($listId, $email, $phone, $gender, $first_name, $last_name, $is_unsubscribed, $is_blacklisted, $filter)
    {
        isset($filter) ? $endpoint = "/lists/$listId/recipients?_filter=" . $filter : $endpoint = "/lists/$listId/recipients";
        
        $data = array(
            "email" => $email,
            "phone" => $phone,
            "gender" => $gender,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "is_unsubscribed" => $is_unsubscribed,
            "is_blacklisted" => $is_blacklisted
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * updateRecipient
     * https://docs.newsletter2go.com/?version=latest#6f4acfc5-649a-4345-9456-6cad24fa9fee
     * @param string $listId
     * @param string $recipientId
     * @param string $email
     * @param string $phone
     * @param string $gender
     * @param string $first_name
     * @param string $last_name
     * @param boolean $is_unsubscribed
     * @param boolean $is_blacklisted
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateRecipient($listId, $recipientId, $email, $phone, $gender, $first_name, $last_name, $is_unsubscribed, $is_blacklisted)
    {
        $endpoint = "/lists/$listId/recipients/$recipientId";
        
        $data = array(
            "email" => $email,
            "phone" => $phone,
            "gender" => $gender,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "is_unsubscribed" => $is_unsubscribed,
            "is_blacklisted" => $is_blacklisted
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * getSegmentsList
     * https://docs.newsletter2go.com/?version=latest#bef8c5b0-c961-41d8-9a77-2d6eb0ea526e
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getSegmentsList($listId)
    {
        
        $endpoint = "/lists/$listId/groups";
        
        $data = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * createSegment
     * https://docs.newsletter2go.com/?version=latest#170ef0ae-10c5-4bc1-a658-750dad70c452
     * @param string $listId
     * @param string $name
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function createSegment($listId, $name)
    {
        $endpoint = "/groups";
        
        $data = array(
            "name" => $name,
            "list_id" => $listId,
            "is_dynamic" => false
        );
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * createDynamicSegment
     * https://docs.newsletter2go.com/?version=latest#9e4c105f-23de-4fc0-8ebd-da2a4e8c1998
     * @param string $listId
     * @param string $name
     * @param string $filter
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function createDynamicSegment($listId, $name, $filter)
    {
        $endpoint = "/groups";
        
        $data = array(
            "name" => $name,
            "list_id" => $listId,
            "is_dynamic" => true,
            "filter" => $filter
        );
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * updateSegment
     * https://docs.newsletter2go.com/?version=latest#dc96fd1b-9664-4bf9-8f03-891216999de1
     * @param string $segmentId
     * @param string $name
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateSegment($segmentId, $name)
    {
        
        $endpoint = "/groups/$segmentId";
        
        $data = array(
            "name" => $name
        );
        
        return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }

    /**
     * deleteSegment
     * https://docs.newsletter2go.com/?version=latest#c28c7c5b-f3d0-4d35-be6e-eacd6b83495c
     * @param string $segmentId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteSegment($segmentId)
    {
        
        $endpoint = "/groups/$segmentId";
        
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }

    /**
     * getRecipientSegment
     * https://docs.newsletter2go.com/?version=latest#0f795e20-e225-4633-81cb-8c0165dea3e3
     * @param string $listId
     * @param string $segmentId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getRecipientSegment($listId, $segmentId)
    {
        
        $endpoint = "/lists/$listId/groups/$segmentId/recipients";
        
        $data = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * addRecipientSegment
     * https://docs.newsletter2go.com/?version=latest#e2b73d08-b635-4028-8397-9687f32e2be2
     * @param string $listId
     * @param string $segmentId
     * @param string $recipientId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function addRecipientSegment($listId, $segmentId, $recipientId)
    {
        $endpoint = "/lists/$listId/groups/$segmentId/recipients/$recipientId";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
        
    }

    /**
     * deleteRecipientsSegment
     * https://docs.newsletter2go.com/?version=latest#d9e629cc-aa41-45b3-83a9-f99756f606a3
     * @param $listId
     * @param string $segmentId
     * @param string $recipientId
     * @param string $filter
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteRecipientsSegment($listId, $segmentId, $filter)
    {
        
        $endpoint = "/lists/$listId/groups/$segmentId/recipients?_filter=$filter";
        
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
        
    }

    /**
     * getAttributesList
     * https://docs.newsletter2go.com/?version=latest#186844bb-9313-4935-96f8-9336f654aaf7
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getAttributesList($listId)
    {
        
        $endpoint = "/lists/$listId/attributes";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * getAttributeDetails
     * https://docs.newsletter2go.com/?version=latest#b8a4f83b-1e17-4f6c-922e-afcdadc3dd2d
     * @param string $attributeId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getAttributeDetails($attributeId)
    {
        
        $endpoint = "/attributes/$attributeId";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * createAttributeList
     * https://docs.newsletter2go.com/?version=latest#19dfd182-e8b2-4561-91fe-a4d1a31b11dc
     * @param string $listId
     * @param string $name
     * @param string $display
     * @param string $type
     * @param string $sub_type
     * @param boolean $is_enum
     * @param boolean $is_public
     * @param boolean $is_multiselect
     * @param string $html_element_type
     * @param boolean $is_global
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function createAttributeList($listId, $name, $display, $type, $sub_type, $is_enum, $is_public, $is_multiselect, $html_element_type, $is_global)
    {
        $endpoint = "/attributes";
        $data     = array(
            "list_ids" => $listId,
            "name" => $name,
            "display" => $display,
            "type" => $type,
            "sub_type" => $sub_type,
            "is_enum" => $is_enum,
            "is_public" => $is_public,
            "is_multiselect" => $is_multiselect,
            "html_element_type" => $html_element_type,
            "is_global" => $is_global,
            "default_value" => ""
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * updateAttribute
     * https://docs.newsletter2go.com/?version=latest#23e37d1d-f8aa-48a1-9093-b9f29195085d
     * @param string $listId
     * @param string $attributeId
     * @param string $attributename
     * @param string $value
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateAttribute($listId, $attributeId, $attributename, $value)
    {
        
        $endpoint = "/attributes/$attributeId";
        
        $data = array(
            "list_ids" => $listId,
            $attributename => $value
            
        );
        
        return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }

    /**
     * deleteAttribute
     * https://docs.newsletter2go.com/?version=latest#ccc3735c-106a-4c47-9725-2ed6302ac10a
     * @param string $listId
     * @param string $attributeId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteAttribute($listId, $attributeId)
    {
        $endpoint = "/lists/$listId/attributes/$attributeId";
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }

    /**
     * getMailingsList
     * https://docs.newsletter2go.com/?version=latest#d45a8153-1081-4ee6-a779-6a245d484746
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getMailingsList($listId)
    {
        
        $endpoint = "/lists/$listId/newsletters";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * getMailing
     * https://docs.newsletter2go.com/?version=latest#75083638-39a1-4cdf-a307-4e7708e8da76
     * @param string $newsletterId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getMailing($newsletterId)
    {
        
        $endpoint = "/newsletters/$newsletterId";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * getMailingVersions
     * https://docs.newsletter2go.com/?version=latest#3bfd595a-d46c-4695-9681-aea918f22e9a
     * @param string $newsletterId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getMailingVersions($newsletterId)
    {
        
        $endpoint = "/newsletters/$newsletterId/versions";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * createMailing
     * https://docs.newsletter2go.com/?version=latest#b6908876-23a9-4edc-a15f-edf5d9337085
     * @param string $listId
     * @param string $type
     * @param string $name
     * @param boolean $has_open_tracking
     * @param boolean $has_click_tracking
     * @param boolean $has_conversion_tracking
     * @param $subject
     * @param $header_from_email
     * @param $header_from_name
     * @param $header_reply_email
     * @param $header_reply_name
     * @param null $html
     * @param null $json
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function createMailing($listId, $type, $name, $has_open_tracking, $has_click_tracking, $has_conversion_tracking, $subject, $header_from_email, $header_from_name, $header_reply_email, $header_reply_name, $html = null, $json = null)
    {
        if (!in_array($type, array(
            "transaction",
            "default",
            "doi"
        ))) {
            throw new \Exception("Mailing type not supported");
        }
        $endpoint = "/lists/$listId/newsletters";
        
        $data = array(
            "type" => $type,
            "name" => $name,
            "has_open_tracking" => $has_open_tracking,
            "has_click_tracking" => $has_click_tracking,
            "has_conversion_tracking" => $has_conversion_tracking,
            "subject" => $subject,
            "header_from_email" => $header_from_email,
            "header_from_name" => $header_from_name,
            "header_reply_email" => $header_reply_email,
            "header_reply_name" => $header_reply_name
        );
        
        if (isset($html)) {
            $data['html'] = $html;
        }
        if (isset($json)) {
            $data['json'] = $json;
        }
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * sendTest
     * https://docs.newsletter2go.com/?version=latest#1df37c76-18ee-434f-bb1c-445a7e2f872f
     * @param string $newsletterId
     * @param string $address
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function sendTest($newsletterId, $address)
    {
        
        $endpoint = "/newsletters/$newsletterId/sendtest";
        
        $data = array(
            'contexts' => array(
                0 => array(
                    'recipient' => array(
                        "email" => $address
                    )
                )
            )
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }

    /**
     * sendOneTimeMailing
     * https://docs.newsletter2go.com/?version=latest#ba16af5b-06fa-4c10-94cd-8f54cec5a316
     * @param string $newsletterId
     * @param string $time
     * @param string $groupIds
     * @param string $recipientIds
     * @param string $listId
     * @param boolean $state
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function sendOneTimeMailing($newsletterId, $time, $groupIds, $recipientIds, $listId, $state)
    {
        $endpoint = "/newsletters/$newsletterId/sendtest";
        
        $data = array(
            'scheduled' => $time,
            'group_ids' => $groupIds,
            'recipient_ids' => $recipientIds,
            'list_id' => $listId,
            'list_selected' => $state
        );
        
        return $this->curl($endpoint, $data, static::METHOD_POST);
        
    }

    /**
     * sendTransactional
     * https://docs.newsletter2go.com/?version=latest#d39fb18d-bf1f-4255-be78-36f327023b0a
     * @param string $newsletterId
     * @param string $time
     * @param string $address
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function sendTransactional($newsletterId, $time, $address)
    {
        $endpoint = "/newsletters/$newsletterId/send";
        
        $data = array(
            'scheduled' => $time,
            'contexts' => array(
                0 => array(
                    'recipient' => array(
                        "email" => $address
                    )
                )
            )
        );
        return $this->curl($endpoint, $data, static::METHOD_POST);
    }


    /**
     * updateMailing
     * https://docs.newsletter2go.com/?version=latest#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param   $listId
     * @param   $name
     * @param   $isDeleted
     * @param   $has_open_tracking
     * @param boolean $has_click_tracking
     * @param boolean $has_conversion_tracking
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateMailing($listId, $name, $isDeleted, $has_open_tracking, $has_click_tracking, $has_conversion_tracking, $has_google_analytics_tracking, $subject, $header_from_email, $header_from_name, $header_reply_email, $header_reply_name)
    {
        
        $endpoint = "/newsletters/{{newsletter_id}}";
        
        $data = array(
            "name" => $name,
            "is_deleted" => $isDeleted,
            "has_open_tracking" => $has_open_tracking,
            "has_click_tracking" => $has_click_tracking,
            "has_conversion_tracking" => $has_conversion_tracking,
            "has_google_analytics_tracking" => $has_google_analytics_tracking,
            "subject" => $subject,
            "header_from_email" => $header_from_email,
            "header_from_name" => $header_from_name,
            "header_reply_email" => $header_reply_email,
            "header_reply_name" => $header_reply_name
        );
        
        
        return $this->curl($endpoint, $data, static::METHOD_PATCH);
    }

    /**
     * getSpecificMailingReports
     * https://docs.newsletter2go.com/?version=latest#6d5ffa40-7180-4646-b92b-59baf1c94d1f
     * @param string $newsletterId
     * @param string $filter
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getSpecificMailingReports($newsletterId, $filter)
    {
        
        isset($filter) ? $endpoint = "/newsletters/$newsletterId/reports?_filter=" . $filter : $endpoint = "/newsletters/$newsletterId/reports";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * getForm
     * https://docs.newsletter2go.com/?version=latest#4daba842-cc75-45e1-a822-05334f87ebed
     * @param string $formId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getForm($formId)
    {
        
        $endpoint = "/forms/generate/$formId";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * getCompany
     * https://docs.newsletter2go.com/?version=latest#d9b2e7cc-1145-4b04-be6f-ee1e88000646
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getCompany()
    {
        
        $endpoint = "/companies";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * get all users in this account
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getUsers()
    {
        
        $endpoint = "/users";
        
        $data = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }

    ////////

    /**
     * get all newsletters in a list
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getNewsletters($listId)
    {
        $endpoint = "/lists/$listId/newsletters";
        $data     = array(
            "_expand" => true
        );
        return $this->curl($endpoint, $data);
    }

    /**
     * get all templates in a list
     * @param string $listId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getTemplates($listId)
    {
        $endpoint = "/lists/$listId/templates";
        $data     = array(
            "_expand" => true,
            "_filter" => "type=='custom',type=='premium'"
        );
        
        return $this->curl($endpoint, $data);
    }

    /**
     * Get a single template templates in a list
     * @param string $listId
     * @param string $templateId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function getTemplate($listId, $templateId)
    {
        $endpoint = "/lists/$listId/templates/$templateId";
        $data     = array(
            "_expand" => true
        );
        
        return $this->curl($endpoint, $data);
    }


    /**
     * Update the HTML of an existing newsletter
     * https://docs.newsletter2go.com/#76993cf1-63df-4bb9-89ee-393d2e8593f3
     * @param string $html
     * @return \stdClass
     *
     * @throws \Exception
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
     * @return \stdClass
     *
     * @throws \Exception
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
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function updateNewsletter($newsletterId, $name, $subject, $html)
    {
        $endpoint = "/newsletters/$newsletterId";
        
        return $this->curl($endpoint, array(
            "name" => $name,
            "subject" => $subject,
            "html" => $html
        ), static::METHOD_PATCH);
    }

    /**
     * delete a newsletter
     * @param string $newsletterId
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function deleteNewsletter($newsletterId)
    {
        $endpoint = "/newsletters/$newsletterId";
        
        return $this->curl($endpoint, array(), static::METHOD_DELETE);
    }

    /**
     * get all lists
     * https://docs.newsletter2go.com/#!/List/getLists
     * @return \stdClass
     *
     * @throws \Exception
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
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function setTransactionalState($newsletterId, $state)
    {
        
        $endpoint = "/newsletters/$newsletterId";
        
        return $this->curl($endpoint, array(
            "state" => $state
        ), static::METHOD_PATCH);
        
    }

    /**
     * Send a newsletter
     * https://docs.newsletter2go.com/#!/Newsletter/sendNewsletter
     * @param string $newsletterId defines the newsletter that should be sent
     * @param array $recipient_data data of recipients
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function sendNewsletter($newsletterId, $recipient_data)
    {
        
        $endpoint = "/newsletters/$newsletterId/send";
        
        return $this->curl($endpoint, $recipient_data, static::METHOD_POST);
        
    }

    /**
     * @param $email
     * @param $first_name
     * @param $last_name
     * @param string $gender
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function addRecipient($email, $first_name, $last_name, $gender = '')
    {
        if (!in_array($gender, array(
            '',
            'm',
            'f'
        ))) {
            throw new \Exception("gender value not supported");
        }
        $endpoint = "/recipients";
        return $this->curl($endpoint, array(
            "email" => $email,
            "gender" => $gender,
            "first_name" => $first_name,
            "last_name" => $last_name
        ), static::METHOD_POST);
    }

    /**
     * @param string $code the form-subscribe-code. it is displayed when creating a subscribe-form in your account settings
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @param string $gender
     * @return \stdClass
     *
     * @throws \Exception
     */
    public function addRecipientViaForm($code, $email, $first_name, $last_name, $gender = '')
    // sends a confirmation mail
    {
        if (!in_array($gender, array(
            '',
            'm',
            'f'
        ))) {
            throw new \Exception("gender value not supported");
        }
        if (!is_string($code)) {
            throw new \Exception("form-subscribe-code not given");
        }
        $endpoint = "/forms/submit/$code";
        return $this->curl($endpoint, array(
            "recipient" => array(
                "email" => $email,
                "gender" => $gender,
                "first_name" => $first_name,
                "last_name" => $last_name
            )
        ), static::METHOD_POST);
    }
    
    
    /**
     * @param $endpoint string the endpoint to call (see docs.newsletter2go.com)
     * @param $data array tha data to submit. In case of POST and PATCH its submitted as the body of the request. In case of GET and PATCH it is used as GET-Params. See docs.newsletter2go.com for supported parameters.
     * @param string $type GET,PATCH,POST,DELETE
     * @return \stdClass
     *
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

    /**
     * @param $authorization
     * @param $endpoint
     * @param $data
     * @param string $type
     * @return bool|mixed|string
     * @throws \Exception
     */
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
                $parsed_url = parse_url($endpoint, PHP_URL_QUERY);
                $has_get_params = !empty($parsed_url);
                $get_params = ($has_get_params ? '&' : "?") . http_build_query($data);
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
        
        if (isset($json_decoded)) {
            return $json_decoded;
        } else {
            return $response; // for pdf download
        }
    }
}
