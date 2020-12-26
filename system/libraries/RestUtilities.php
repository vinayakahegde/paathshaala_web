<?php

/**
 * Description of RestUtilities
 *
 * @author vinayakahegde
 */

include "RestRequest.php";

class RestUtilities {
    public static function getRequestParams( $allow_multipart=false ){  //return success and data
        // get our verb 
        error_log("user : " . $_SERVER['PHP_AUTH_USER'] );
        error_log("pwd  : " . $_SERVER['PHP_AUTH_PW'] );
        $request_params = array();
        $request_params['success'] = false;
        $request_params['data'] = array();
        $request_params['request_uri'] = '';
        $request_params['request_method'] = '';
        $request_params['msg'] = '';
        
        if( !isset($_SERVER['PHP_AUTH_USER']) || trim( $_SERVER['PHP_AUTH_USER'] ) != _REST_API_AUTH_USERNAME ||
                !isset($_SERVER['PHP_AUTH_PW']) || trim( $_SERVER['PHP_AUTH_PW'] ) != _REST_API_AUTH_PASSWORD ){
            error_log("Could not authenticate the request" );
            $request_params['msg'] = 'Could not authenticate the request';
            return $request_params;
        }
        
        if(isset($_SERVER['CONTENT_TYPE'])) {
            $content_type = trim($_SERVER['CONTENT_TYPE']);
            if( $allow_multipart ){
                error_log("allow multipart");
                if( strpos( $content_type, 'application/json' ) === false &&
                        strpos( $content_type, 'multipart/form-data' ) === false /*$content_type !== "application/json"*/ ){
                    error_log("Only JSON/multipart input is accepted : content type :: " . $content_type );
                    $request_params['msg'] = 'Only JSON/multipart input is accepted';
                    return $request_params;
                }
            } else {
                error_log("not allow multipart");
                if( strpos( $content_type, 'application/json' ) === false  /*$content_type !== "application/json"*/ ){
                    error_log("Only JSON input is accepted : content type :: " . $content_type );
                    $request_params['msg'] = 'Only JSON input is accepted';
                    return $request_params;
                }
            }
        }
        
        if( isset( $_SERVER['REQUEST_URI'] ) ){
            $request_params['request_uri'] = trim( $_SERVER['REQUEST_URI'] );
        }
        
        if( isset( $_SERVER['REQUEST_METHOD'] ) ){
            $request_params['request_method'] = trim( strtolower($_SERVER['REQUEST_METHOD'] ));
        } 

        switch ($request_params['request_method'])  
        {  
            // gets are easy...  
            case 'get':  
                $data = $_GET; 
                error_log("in get :: " );
                if( isset($_SERVER['QUERY_STRING']) && strlen( trim( $_SERVER['QUERY_STRING'] ) ) > 0 ){
                    parse_str( trim($_SERVER['QUERY_STRING']), $request_params['data'] );
                }
                $request_params['success'] = true;
                break;  
            // so are posts  
            case 'post':  
                if( !$allow_multipart ){
                    $data = $_POST; 
                    $body = file_get_contents("php://input");
                    error_log("Request body :: " . print_r( $body, true ) );
                    $body_params = json_decode( trim($body));
                    $parameters = array();
                    if($body_params) {
                        foreach($body_params as $param_name => $param_value) {
                            $parameters[$param_name] = $param_value;
                        }
                        $request_params['data'] = $parameters;
                    }
                    $request_params['success'] = true;
                } else {
                    $request_params['data'] = $_POST;
                    $request_params['success'] = true;
                }
                break;  
            // here's the tricky bit... 
            default :
                $request_params['msg'] = 'Only GET and POST allowed.';
                break;
            /*case 'put':  
                // basically, we read a string from PHP's special input location,  
                // and then parse it out into an array via parse_str... per the PHP docs:  
                // Parses str  as if it were the query string passed via a URL and sets  
                // variables in the current scope.  
                parse_str(file_get_contents('php://input'), $put_vars);  
                $data = $put_vars;  
                break;*/  
        }
        
        return $request_params;
            
    }  
  
    public static function sendResponse($status = 200, $body = '', $content_type = 'application/json'){  
        $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtilities::getStatusCodeMessage($status);  
        // set the status  
        header($status_header);  
        // set the content type  
        header('Content-type: ' . $content_type);  

        // pages with body are easy  
        if($body != '')  
        {  
            // send the body  
            echo $body;  
            exit;  
        }  
        // we need to create the body if none is passed  
        else  
        {  
            // create some body messages  
            $message = '';  

            // this is purely optional, but makes the pages a little nicer to read  
            // for your users.  Since you won't likely send a lot of different status codes,  
            // this also shouldn't be too ponderous to maintain  
            switch($status)  
            {  
                case 401:  
                    $message = 'You must be authorized to view this page.';  
                    break;  
                case 404:  
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';  
                    break;  
                case 500:  
                    $message = 'The server encountered an error processing your request.';  
                    break;  
                case 501:  
                    $message = 'The requested method is not implemented.';  
                    break;  
            }  

            // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")  
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];  

            // this should be templatized in a real-world solution  
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">  
                        <html>  
                            <head>  
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">  
                                <title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>  
                            </head>  
                            <body>  
                                <h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>  
                                <p>' . $message . '</p>  
                                <hr />  
                                <address>' . $signature . '</address>  
                            </body>  
                        </html>';  

            echo $body;  
            exit;  
        }  
    }  
  
    public static function getStatusCodeMessage($status)  
    {  
        // these could be stored in a .ini file and loaded  
        // via parse_ini_file()... however, this will suffice  
        // for an example  
        $codes = Array(  
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',  
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported'  
        );  
  
        return (isset($codes[$status])) ? $codes[$status] : '';  
    } 

    public static function getPostParams(){
        $requestParams = RestUtilities::getRequestParams();
        if( !$requestParams['success'] ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : ' . $requestParams['msg'] . '" }' );
            return false;
        } 
        
        if( trim($requestParams['request_method']) === 'get' ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : Only POST requests allowed." }' );
            return false;
        }
        
        return $requestParams;
    }
    
    public static function getMultipartPostParams(){
        $requestParams = RestUtilities::getRequestParams(true);
        if( !$requestParams['success'] ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : ' . $requestParams['msg'] . '" }' );
            return false;
        } 
        
        if( trim($requestParams['request_method']) === 'get' ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : Only POST requests allowed." }' );
            return false;
        }
        
        return $requestParams;
    }
    
    public static function getGetParams(){
        $requestParams = RestUtilities::getRequestParams();
        if( !$requestParams['success'] ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : ' . $requestParams['msg'] . '" }' );
            return false;
        } 
        
        if( trim($requestParams['request_method']) === 'post' ){
            RestUtilities::sendResponse( 500, 
                        '{"success": "false", "error" : "Internal Server Error. Error : Only GET requests allowed." }' );
            return false;
        }
        
        return $requestParams;
    }
    
    public static function escapeParamQuotes( $str ){
        $esc_str = str_replace( '"', '\"', $str );
        return $esc_str;
    }
}  
