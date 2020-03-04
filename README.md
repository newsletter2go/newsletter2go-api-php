####
<img src="https://www.newsletter2go.ca/wp-content/uploads/sites/21/2014/06/Newsletter-Logo-quer_medium.png" width="250"/>

# newsletter2go-api-php


This PHP library is intended to be used as a facade to our API exposed services. Through this implementation, you can perform the most common operations included in our official [API documentation site.](https://docs.newsletter2go.com)


Additional Information:
- API version: 1.4
- This library follows the structure from our [Postman Collection File](https://github.com/newsletter2go/api-docs)
- You can post [any request, bug or issue](https://github.com/newsletter2go/newsletter2go-api-php/issues) or also reach us at: implementation@newsletter2go.com


## Requirements

 - PHP 5.6 >=

## Installation and Usage
### Composer

To install from the cli with [Composer](http://getcomposer.org/), simply run:

```
composer require newsletter2go/api
composer install
```
### Repository

You can also download the [standalone class](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/src/Newsletter2Go_REST_Api.php) from this repository and add it to your PHP project.


## Implementation

* This example shows how to setup your account credentials and make further API calls.
```
<?php
namespace NL2GO;

//Import the standalone class in your working directory
require_once  '/Newsletter2Go_REST_Api.php';


//Add your account credentials 
$authKey  =  "your auth key here";
$userEmail  =  "login email address";
$userPassword  =  "login password";

//Instantiate the Newsletter2Go_REST_Api 
$api  =  new  Newsletter2Go_REST_Api($authKey,  $userEmail,  $userPassword);

//Allow SSL check
$api->setSSLVerification(true);

//Retrieve and display all the contact lists stored your account
$lists  =  $api->getLists();
var_dump($lists);
```

The following are the supported Entities in this library:
 - [Lists](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Lists)
 - [Contacts](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Contacts)
 - [Segments](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Segments)
 - [Attributes](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Attributes)
 - [Campaigns](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Campaigns)
 - [Forms](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Forms)
 - [Company](https://github.com/newsletter2go/newsletter2go-api-php/blob/master/README.md#Company)

 # Lists
 - ### getListDetails()
[getListDetails() - API Documentation](https://docs.newsletter2go.com/?version=latest#2b0496e8-e75a-48d5-a8e4-2baff95af7bf)
Get all information for one specific list.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| List ID you want to get details from. |
|`stdClass`|@return stdClass| returned Object.|

 - ### createList()
[createList() - API Documentation](https://docs.newsletter2go.com/?version=latest#364131ba-fd20-444a-b029-e53a5a89546d)
_Create a new list._

| Parameter | Type  | Description |
|--|--|--|
|`$name`|@param string| List name|
|`$uses_econda`|@param boolean| Enable/Disable Encoda tracking.|
|`$uses_googleanalytics`|@param boolean|Enable/Disable Google tracking.|
|`$has_opentracking`|@param boolean| Enable/Disable tracking for E-mail opening. |
|`$has_clicktracking`|@param boolean| Enable/Disable tracking for clicks in newsletter.|
|`$has_conversiontracking`|@param boolean| Enable/Disable Conversion tracking.|
|`$imprint`|@param string| Link to company imprint.|
|`$header_from_email`|@param string| Default sender address for E-mails.|
|`$header_from_name`|@param string| Default sender name for E-mails.|
|`$header_reply_email`|@param string| Default address for replied E-mails.|
|`$header_reply_name`|@param string| Default sender name for replied E-mail.|
|`$tracking_url`|@param string| Additional URL tracking.|
|`$landingpage`|@param string| Landing page URL.|
|`$use_ecg_list`|@param boolean| Enable/Disable ECG.|
|`stdClass`|@return stdClass| returned Object.|


 - ### updateList()
[updateList() - API Documentation](https://docs.newsletter2go.com/?version=latest#80247ee2-dda3-4793-b15a-905af57af154)


| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| List ID to perform the actions on.|
|`$name`|@param string| List name.|
|`$uses_econda`|@param boolean| Enable/Disable Encoda tracking.|
|`$uses_googleanalytics`|@param boolean| Enable/Disable Google tracking.|
|`$has_opentracking`|@param boolean| Enable/Disable tracking for E-mail opening. |
|`$has_clicktracking`|@param boolean| Enable/Disable tracking for clicks in newsletter.|
|`$has_conversiontracking`|@param boolean| Enable/Disable Conversion tracking.|
|`$imprint`|@param string| Link to company imprint.|
|`$header_from_email`|@param string| Default sender address for E-mails.|
|`$header_from_name`|@param string| Default sender name for E-mails.|
|`$header_reply_email`|@param string|  Default address for replied E-mails.|
|`$header_reply_name`|@param string| Default sender name for replied E-mail.|
|`$tracking_url`|@param string| Additional URL tracking.|
|`$landingpage`|@param string|  Landing page URL.|
|`$use_ecg_list`|@param boolean|  Enable/Disable ECG.|
|`stdClass`|@return stdClass| returned Object.|


 - ### deleteList()
[deleteList() - API Documentation](https://docs.newsletter2go.com/?version=latest#80247ee2-dda3-4793-b15a-905af57af154)
Delete a specific list by its ID

> **Be careful! You're irrevocably deleting the entire list with all campaigns and contacts.**

| Parameter |Type| Description|
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`stdClass`|@return stdClass|  returned Object.|

# Contacts 
- ### getRecipients()
[getRecipients() - API Documentation](https://docs.newsletter2go.com/?version=latest#c97c941a-267c-4afb-80e9-d45b0572b19d)
Get recipients from any list.

| Parameter | Type  | Description |
|--|--|--|
|`stdClass`|@return stdClass| returned Object.|


- ### getRecipient()
[getRecipient() - API Documentation](https://docs.newsletter2go.com/?version=latest#6c7853a8-978c-4d48-8d97-b5a921d6e287)
Get the details of one recipient.

| Parameter | Type  | Description |
|--|--|--|
|`$recipientId`|@param string| description|
|`stdClass`|@return stdClass| returnedObject|


- ### updateRecipientList()
[updateRecipientList() - API Documentation](https://docs.newsletter2go.com/?version=latest#9eb0eccc-8c3c-4a59-90e5-547031fe55a2)
Create one or more recipients. If the email address already exists, the existing recipient will get updated.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| Recipient ID to perform the actions on.|
|`$email`|@param string| Recipient's e-mail.|
|`$phone`|@param string| Recipient's phone.|
|`$gender`|@param string| Recipient's gender.|
|`$first_name`|@param string| Recipient's name.|
|`$last_name`|@param string| Recipient's last name|
|`$is_unsubscribed`|@param boolean| Recipient's subscription status. |
|`$is_blacklisted`|@param boolean| Recipient's blacklist status.|
|`stdClass`|@return stdClass| returnedObject |


- ### deleteRecipientsFromList()
[deleteRecipientsFromList() - API Documentation](https://docs.newsletter2go.com/?version=latest#b84956c5-93ef-48a4-9e1d-7f13306dbffd)
Get recipients from a specific list.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$recipientId`|@param string| Recipient ID to be deleted.|
|`stdClass`|@return stdClass| returnedObject |


- ### updateRecipients()
[updateRecipients() - API Documentation](https://docs.newsletter2go.com/?version=latest#b16f71d0-0d63-4df0-a750-7dc4e8515bcc)
Update multiple / all recipients in one list.

> **Make sure to pass the `$filter` variable or  all your recipients in the list will be updated. E.g:
> /{{list_id}}/recipients?_filter=email%3DLIKE%3D%22%example%25%22**

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| List ID to perform the actions on.|
|`$email`|@param string| New e-mail address.|
|`$phone`|@param string| New phone address.|
|`$gender`|@param string| New gender.|
|`$first_name`|@param string| New name.|
|`$last_name`|@param string| New last name.|
|`$is_unsubscribed`|@param boolean| Redifine recipient's subscription status. |
|`$is_blacklisted`|@param boolean| Redifine recipient's blacklist status.|
|`$filter`|@param string| Query variable. Make sure to do URL encoding to the variable.|
|`stdClass`|@return stdClass| returnedObject |


- ### updateRecipient()
[updateRecipient() - API Documentation](https://docs.newsletter2go.com/?version=latest#6f4acfc5-649a-4345-9456-6cad24fa9fee)
_Update one recipient only by passing its `$recipientId`.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$email`|@param string| New e-mail address.|
|`$phone`|@param string| New phone address.|
|`$gender`|@param string| New gender.|
|`$first_name`|@param string| New name.|
|`$last_name`|@param string| New last name.|
|`$is_unsubscribed`|@param boolean| Redifine recipient's subscription status. |
|`$is_blacklisted`|@param boolean| Redifine recipient's blacklist status.|
|`stdClass`|@return stdClass| returnedObject |

# Segments
- ### getSegmentsList()
[getSegmentsList() - API Documentation](https://docs.newsletter2go.com/?version=latest#bef8c5b0-c961-41d8-9a77-2d6eb0ea526e)

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`stdClass`|@return stdClass| returnedObject |


- ### createSegment()
[createSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#170ef0ae-10c5-4bc1-a658-750dad70c452)

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$name`|@param string| description|
|`stdClass`|@return stdClass| returnedObject |


- ### createDynamicSegment()
[createDynamicSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#9e4c105f-23de-4fc0-8ebd-da2a4e8c1998)
The attribute  `$filter`  should be the conditions upon which the auto-update action is executed.
The attribute  `$is_dynamic`  defines wether the segment will auto-update or not.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$name`|@param string| Segment name|
|`$filter`|@param string| Conditions upon which the auto-update action is executed|
|`stdClass`|@return stdClass| returnedObject |


- ### updateSegment()
[updateSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#dc96fd1b-9664-4bf9-8f03-891216999de1)


| Parameter | Type  | Description |
|--|--|--|
|`$segmentId`|@param string| Segment ID to update.|
|`$name`|@param string|Name to be updated|
|`stdClass`|@return stdClass| returnedObject |


- ### deleteSegment()
[deleteSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#c28c7c5b-f3d0-4d35-be6e-eacd6b83495c)

| Parameter | Type  | Description |
|--|--|--|
|`$segmentId`|@param string| Segment ID to be deleted|
|`stdClass`|@return stdClass| returnedObject |


- ### getRecipientSegment()
[getRecipientSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#0f795e20-e225-4633-81cb-8c0165dea3e3)
Gets all recipients from specified segment.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$segmentId`|@param string| Segment ID to retrieve the recipients from.|
|`stdClass`|@return stdClass| returnedObject |


- ### addRecipientSegment()
[addRecipientSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#e2b73d08-b635-4028-8397-9687f32e2be2)
Add one recipient to the segment.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$segmentId`|@param string| Segment ID where the recipient will be|
|`$recipientId`|@param string| description|
|`stdClass`|@return stdClass| returnedObject |


- ### deleteRecipientsSegment()
[deleteRecipientsSegment() - API Documentation](https://docs.newsletter2go.com/?version=latest#d9e629cc-aa41-45b3-83a9-f99756f606a3)
Delete recipient from one or multiple recipients from segment. 

> **If you don't pass a `$filter`, all your recipients will be deleted from the group irrevocably.**


| Parameter | Type  | Description |
|--|--|--|
|`$segmentId`|@param string| Segment ID for deletion|
|`$recipientId`|@param string| Recipient ID to be deleted|
|`$filter`|@param string| Filter parameter for deletion|
|`stdClass`|@return stdClass| returnedObject |

# Attributes
- ### getAttributesList()
[getAttributesList() - API Documentation](https://docs.newsletter2go.com/?version=latest#186844bb-9313-4935-96f8-9336f654aaf7)
Retrieve attributes from a list.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`stdClass`|@return stdClass| returnedObject |


- ### getAttributeDetails()
[getAttributeDetails() - API Documentation](https://docs.newsletter2go.com/?version=latest#b8a4f83b-1e17-4f6c-922e-afcdadc3dd2d)
Get metadata from the attribute.

| Parameter | Type  | Description |
|--|--|--|
|`$attributeId`|@param string| Attribute ID to be retrieved.|
|`stdClass`|@return stdClass| returnedObject |


- ### createAttributeList()
[createAttributeList() - API Documentation](https://docs.newsletter2go.com/?version=latest#19dfd182-e8b2-4561-91fe-a4d1a31b11dc)
Create a new custom attribute on a given list.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| List ID to perform the actions on.|
|`$name`|@param string| Attribute name|
|`$display`|@param string| Attribute display|
|`$type`|@param string| Attribute type. |
|`$sub_type`|@param string| |
|`$is_enum`|@param boolean| Represented by a number.|
|`$is_public`|@param boolean| Visibility of the attribute.|
|`$is_multiselect`|@param boolean| Can hold multiple options.|
|`$html_element_type`|@param string| Description for HTML element.|
|`$is_global`|@param boolean| Define if this attribute should apply to all lists.|
|`stdClass`|@return stdClass| returnedObject |


- ### updateAttribute()
[updateAttribute() - API Documentation](https://docs.newsletter2go.com/?version=latest#23e37d1d-f8aa-48a1-9093-b9f29195085d)

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$attributeId`|@param string| Attribute ID to be updated.|
|`$attributename`|@param string| New attribute name.|
|`$value`|@param string| New attribute value. |
|`stdClass`|@return stdClass| returnedObject |


- ### deleteAttribute()
[deleteAttribute() - API Documentation](https://docs.newsletter2go.com/?version=latest#ccc3735c-106a-4c47-9725-2ed6302ac10a)

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string| List ID to perform the actions on.|
|`$attributeId`|@param string| Attribute ID to be deleted.|
|`stdClass`|@return stdClass| returnedObject |

# Campaigns
- ### getMailingsList()
[getMailingsList() - API Documentation](https://docs.newsletter2go.com/?version=latest#d45a8153-1081-4ee6-a779-6a245d484746)

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`stdClass`|@return stdClass| returnedObject |


- ### getMailing()
[getMailing() - API Documentation](https://docs.newsletter2go.com/?version=latest#75083638-39a1-4cdf-a307-4e7708e8da76)

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to be sent.|
|`stdClass`|@return stdClass| returnedObject |


- ### getMailingVersions()
[getMailingVersions() - API Documentation](https://docs.newsletter2go.com/?version=latest#3bfd595a-d46c-4695-9681-aea918f22e9a)

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to be retrieved.|
|`stdClass`|@return stdClass| returnedObject |


- ### createMailing()
[createMailing() - API Documentation](https://docs.newsletter2go.com/?version=latest#b6908876-23a9-4edc-a15f-edf5d9337085)
If your list has default values for `header_from_email`, `header_from_name`, `header_reply_email` and/or `header_reply_name`, those will be used in case you don't pass them in this call.

| Parameter | Type  | Description |
|--|--|--|
|`$listId`|@param string|  List ID to perform the actions on.|
|`$type`|@param string| Mailing type "default", "doi", "transactional"|
|`$name`|@param string| Name for new mailing|
|`$has_open_tracking`|@param boolean| Enabled/Disabled open tracking.|
|`$has_click_tracking`|@param boolean| Enabled/Disabled click tracking.|
|`$has_conversion_tracking`|@param boolean| Enabled/Disabled conversion tracking.|
|`stdClass`|@return stdClass| returnedObject |


- ### sendTest()
[sendTest() - API Documentation](https://docs.newsletter2go.com/?version=latest#1df37c76-18ee-434f-bb1c-445a7e2f872f)
This will send a test but leave the mailing status untouched. 
Be aware that the subject line will be prepended by `[TEST]`.

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to be tested.|
|`$address`|@param string| E-mail address where the test should arrive.|
|`stdClass`|@return stdClass| returnedObject |


- ### sendOneTimeMailing()
[sendOneTimeMailing() - API Documentation](https://docs.newsletter2go.com/?version=latest#ba16af5b-06fa-4c10-94cd-8f54cec5a316)
There are different ways to address a mailing.

-   To the whole contac list by using the  `list_id`.
-   To single segments (using the  `group_ids`  field).
-   To single recipients only (by using the  `recipient_ids`  together with the  `list_selected`  field set to  _false_) and
-   A combination of the above.

**Important**: Please take into account, that you have to set the  `list_selected`  field to  _false_, if you like to send to single recipients only or together with segments. This makes clear that the newsletter will not be sent to the whole contact list.

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to be sent.|
|`$time`|@param string| Time for execution. Please format it to ISO-8601|
|`$groupIds`|@param string| Groups (Segments) to be addressed.|
|`$recipientIds`|@param string| Individual recipient e-mails.|
|`$listId`|@param string| List ID where to be addressed.|
|`$state`|@param boolean| Active/Unactive campaign.|
|`stdClass`|@return stdClass| returnedObject |


- ### sendTransactional()
[sendTransactional() - API Documentation](https://docs.newsletter2go.com/?version=latest#d39fb18d-bf1f-4255-be78-36f327023b0a)
You can pass other data fields (such as `first_name` or custom attributes) in the `recipient` object as well and reference them in the body of the email.

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to be sent.|
|`$time`|@param string| Time for execution. Please format it to ISO-8601|
|`$address`|@param string| Individual recipient e-mail.|
|`stdClass`|@return stdClass| returnedObject |


- ### updateMailing()
[updateMailing() - API Documentation](https://docs.newsletter2go.com/?version=latest#76993cf1-63df-4bb9-89ee-393d2e8593f3)
If you want to be able to trigger automated mailings, make sure that the state is set to `active`. Use `list_selected: true` to send to the whole list, pass an array of group ids in the `group_ids` or send to individual contacts by passing an array in the `recipient_ids` parameter.

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param | Newsletter ID to be modified. |
|`$name`|@param |Updated mailing name.|
|`$isDeleted`|@param | Enabled/Disabled deletion state.|
|`$has_open_tracking`|@param | Enabled/Disabled email open tracking. |
|`$has_click_tracking`|@param boolean| Enabled/Disabled click tracking.|
|`$has_conversion_tracking`|@param boolean| Enabled/Disabled conversion tracking.|
|`stdClass`|@return stdClass| returnedObject |


- ### getSpecificMailingReports()
[getSpecificMailingReports() - API Documentation](https://docs.newsletter2go.com/?version=latest#6d5ffa40-7180-4646-b92b-59baf1c94d1f)
This call is useful for automated mailings that run every day since it returns the reports by day.

| Parameter | Type  | Description |
|--|--|--|
|`$newsletterId`|@param string| Newsletter ID to retrieve reports. |
|`$filter`|@param string| FIQL advanced filter.|
|`stdClass`|@return stdClass| returnedObject |


# Forms
- ### getForm()
[getForm() - API Documentation](https://docs.newsletter2go.com/?version=latest#4daba842-cc75-45e1-a822-05334f87ebed)

| Parameter | Type  | Description |
|--|--|--|
|`$formId`|@param string| description|
|`stdClass`|@return stdClass| returnedObject |


- ### addRecipientViaForm()
[addRecipientViaForm() - API Documentation](https://docs.newsletter2go.com/?version=latest#46cc4c57-dc6e-440c-83ec-f214f9d24a1a)

| Parameter | Type  | Description |
|--|--|--|
|`$code`|@param string| Form Id to be submitted.|
|`$email`|@param string| Recipient's e-mail.|
|`$first_name`|@param string| Recipient's name.|
|`$last_name`|@param string| Recipient's last name.|
|`$gender`|@param string| Recipient's gender.|
|`stdClass`|@return stdClass| returnedObject |

# Company

- ### getCompany()
[getCompany() - API Documentation](https://docs.newsletter2go.com/?version=latest#d9b2e7cc-1145-4b04-be6f-ee1e88000646)
Get your company details.

| Parameter | Type  | Description |
|--|--|--|
|`stdClass`|@return stdClass| returnedObject |





