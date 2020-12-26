<?php
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once $DOC_ROOT . "/" . _AWS_LIB_PATH . "aws-autoloader.php";
require_once $DOC_ROOT . "/system/libraries/AwsAccessCredentials.php";

class AwsSNS {
    
    public $instance = FALSE;
    
    public function __construct() {
        $credentialsObj = new AwsAccessCredentials();
        $credentials = $credentialsObj->getAwsCredentials();
        $this->instance = Aws\Sns\SnsClient::factory([
            'version' => _AWS_SNS_VERSION,
            'region'  => _AWS_SNS_REGION,
            'credentials' => [
                'key'    => $credentials['access_id_key'],
                'secret' => $credentials['secret_access_key'],
                'token'  => $credentials['session_token'],
            ],
        ]);

        return $this->instance;
    }
    
    public function isSNSAvailable(){
        if( $this->instance === FALSE ){
            return false;
        }
        return true;
    }
    
    public function getAndroidEndPoints($platformAppArn){
        $androidEndPoints = $this->instance->listEndpointsByPlatformApplication(
                            array( 'PlatformApplicationArn' => $platformAppArn )
                        );
        
        return $androidEndPoints;
    }
    
    public function createAndroidPlatformApplication(){
        $result = $this->instance->createPlatformApplication(array(
                        'Name' => _AWS_SNS_ANDROID_APP_NAME,
                        'Platform' => _AWS_SNS_ANDROID_PLATFORM_NAME,
                        'Attributes' => array(
                            'PlatformCredential' => _AWS_SNS_ANDROID_API_KEY
                        ),
                    ));
        
        $platformApplicationArn = "";
        if( isset($result['PlatformApplicationArn']) ){
            $platformApplicationArn = trim($result['PlatformApplicationArn']);
        }
        
        return $platformApplicationArn;
    }
    
    public function createApplePlatformApplication(){
        
    }
    
    public function createPlatformEndpoint( $platformApplicationArn, $token, $user_id ){
        $result = $this->instance->createPlatformEndpoint(array(
                        'PlatformApplicationArn' => $platformApplicationArn,
                        'Token' => $token,
                        'CustomUserData' => $user_id,
                        'Attributes' => array(
                            'CustomUserData' => $user_id,
                            'Token' => $token,
                            'Enabled' => 'true'
                        ),
                    ));
        
        $endpointArn = "";
        if( isset($result['EndpointArn']) ){
            $endpointArn = trim($result['EndpointArn']);
        }
        
        return $endpointArn;
    }
    
    public function createTopic( $topic_name = _AWS_SNS_ANDROID_TOPIC_NAME ){
        $result = $this->instance->createTopic(array(
                        'Name' => $topic_name,
                    ));
        
        $topicArn = "";
        if( isset($result['TopicArn']) ){
            $topicArn = trim($result['TopicArn']);
        }
        
        return $topicArn;
    }
    
    public function subscribeToTopic($topic_arn, $endpoint_arn){
        $result = $this->instance->subscribe(array(
                        'TopicArn' => $topic_arn,
                        'Protocol' => _AWS_SNS_ANDROID_SUBSCRIBE_PROTOCOL,
                        'Endpoint' => $endpoint_arn,
                    ));
        
        $subscriptionArn = "";
        if( isset($result['SubscriptionArn']) ){
            $subscriptionArn = trim($result['SubscriptionArn']);
        }
        
        return $subscriptionArn;
    }
    
    public function confirmSubscription($topic_arn, $token){
        $result = $this->instance->confirmSubscription(array(
                        'TopicArn' => $topic_arn,
                        'Token' => $token,
                        'AuthenticateOnUnsubscribe' => _AWS_SNS_ANDROID_UNSUBSCRIBE_AUTHENTICATE
                    ));
        
        $subscriptionArn = "";
        if( isset($result['SubscriptionArn']) ){
            $subscriptionArn = trim($result['SubscriptionArn']);
        }
        
        return $subscriptionArn;
    }
        
    public function publish($topic_arn, $target_arn, $message_json, $subject ){
        if( $topic_arn != "" ){
            $result = $this->instance->publish(array(
                            'TopicArn' => $topic_arn,
                            'Message' => $message_json,
                            'Subject' => $subject
                            //'MessageStructure' => _AWS_SNS_PUBLISH_MESSAGE_STRUCTURE
                            /*'MessageAttributes' => array(
                                // Associative array of custom 'String' key names
                                'String' => array(
                                    // DataType is required
                                    'DataType' => 'string',
                                    'StringValue' => 'string',
                                    'BinaryValue' => 'string',
                                ),
                                // ... repeated
                            ), */
                        ));
        } else if( $target_arn != "" ) {
            $result = $this->instance->publish(array(
                            'TargetArn' => $target_arn,
                            'Message' => $message_json,
                            'Subject' => $subject
                            //'MessageStructure' => _AWS_SNS_PUBLISH_MESSAGE_STRUCTURE
                        ));
        }
        
        
        $messageId = "";
        if( isset($result['MessageId']) ){
            $messageId = trim($result['MessageId']);
        }
        
        return $messageId;
    }
    
    public function setEndpointAttributes($endPointArn, $enabledFlag, $token){
        if( trim($token) != "" ){
            $result = $this->instance->setEndpointAttributes(array(
                            'EndpointArn' => $endPointArn,
                            'Attributes' => array(
                                'Token' => $token,
                                'Enabled' => $enabledFlag
                            ),
                        ));
        } else {
            $result = $this->instance->setEndpointAttributes(array(
                            'EndpointArn' => $endPointArn,
                            'Attributes' => array(
                                'Enabled' => $enabledFlag
                            ),
                        ));
        }
    }
    
    public function deleteEndpoint( $endpoint_arn ){
        $result = $this->instance->deleteEndpoint(array(
                        'EndpointArn' => $endpoint_arn,
                    ));
    }
    
    public function deletePlatformApplication( $platform_app_arn ){
        $result = $this->instance->deletePlatformApplication(array(
                        'PlatformApplicationArn' => $platform_app_arn,
                    ));
    }
    
    public function deleteTopic( $topic_arn ){
        $result = $this->instance->deleteTopic(array(
                        'TopicArn' => $topic_arn,
                    ));
    }
    
    public function unsubscribe( $subscription_arn ){
        $result = $this->instance->unsubscribe(array(
                        'SubscriptionArn' => $subscription_arn,
                    ));
    }
    
    public function listPlatformApplications( $current_token, &$next_token ){
        if( $current_token == "" ){
            $result = $this->instance->listPlatformApplications(array());
        } else {
            $result = $this->instance->listPlatformApplications(array(
                        'NextToken' => $current_token
                    ));
        }
        
        $platformApplications = $result['PlatformApplications'];
        $next_token = $result['NextToken'];
        
        return $platformApplications;
    }
    
    public function listEndpointsByPlatformApplication( $platform_application_arn, $current_token, &$next_token ){
        if( $current_token = "" ){
            $result = $this->instance->listEndpointsByPlatformApplication(array(
                        'PlatformApplicationArn' => $platform_application_arn
                    ));
        } else {
            $result = $this->instance->listEndpointsByPlatformApplication(array(
                        'PlatformApplicationArn' => $platform_application_arn,
                        'NextToken' => $current_token
                    ));
        }
        
        $endPoints = $result['Endpoints'];
        $next_token = $result['NextToken'];
        
        return $endPoints;
    }
    
    public function isEndpointAttributeEnabled( $endpointArn ){
	$result = $this->instance->getEndpointAttributes(array(
	    'EndpointArn' => $endpointArn
	));

	$endpointAttrs = $result['Attributes'];
	$endpointEnabled = trim($endpointAttrs['Enabled']);

	return $endpointEnabled;
    }

    public function getEndpointAttributes( $endpointArn ){
	$result = $this->instance->getEndpointAttributes(array(
	    'EndpointArn' => $endpointArn
	));

	$endpointAttrs = $result['Attributes'];
	return $endpointAttrs;
    }
    
    //CreatePlatformApplication : returns PlatformApplicationArn
    //createPlatformEndpoint - for each device-app in loop : returns EndpointArn
    //create topic
    //subscribe each endpoint to topic
    //confirm subscription of each end point
    //publish
    
}