<?php
//AwsAccessCredentials
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once $DOC_ROOT . "/" . _AWS_LIB_PATH . "aws-autoloader.php";
require_once $DOC_ROOT . "/system/libraries/AwsAccessCredentials.php";

class AwsS3{
    
    public $instance = FALSE;
    
    public function __construct() {
        $credentialsObj = new AwsAccessCredentials();
        $credentials = $credentialsObj->getAwsCredentials();
        $this->instance = new Aws\S3\S3Client([
            'version' => _AWS_S3_VERSION,
            'region'  => _AWS_S3_REGION,
            'credentials' => [
                'key'    => $credentials['access_id_key'],
                'secret' => $credentials['secret_access_key'],
                'token'  => $credentials['session_token'],
            ],
        ]);

        return $this->instance;
    }
    
    public function isS3Available(){
        if( $this->instance === FALSE ){
            return false;
        }
        return true;
    }
    
    public function setKey( $key_name, $key_value ){
        $result = $this->instance->putObject([
                        'Bucket' => _AWS_S3_BUCKET_NAME,
                        'Key'    => $key_name,
                        'Body'   => $key_value
                    ]);
        
        if( isset($result['@metadata']) && isset($result['@metadata']['statusCode'])
                && $result['@metadata']['statusCode'] == 200 ) {
            
            return true;
        }
        
        return false;
    }
    
    public function getKey( $key_name ){
        $result = $this->instance->getObject([
                        'Bucket' => _AWS_S3_BUCKET_NAME,
                        'Key'    => $key_name
                    ]);
        
        error_log("body as str : " . $result['Body']->__toString());
        return $result['Body'];
    }
    
    public function deleteKey( $key_name ){
        $result = $this->instance->deleteObject(array(
                        'Bucket' => _AWS_S3_BUCKET_NAME,
                        'Key'    => $key_name
                    ));
        
        error_log("deleteKey res : " . print_r($result, true));
    }
    
}

?>