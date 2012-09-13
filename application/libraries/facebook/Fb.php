<?php
    include_once("facebook.php");
    
    Class Fb
    {
        private static $facebook;
        private static $initialized = false;
        private static $CI;
        
        private static function initialize()
        {
            if (self::$initialized)
                return;
    
            self::$facebook = new Facebook(array(
                'appId'  => '178386398905478',
                'secret' => '92147a9f7bce3da8cf409c8ab2997185',
                'cookie' => true
            ));
            self::$initialized = true;
            
            self::$CI = & get_instance();
        }
        
        public static function get()
        {
            self::initialize();
            return self::$facebook;
        }
        
        public static function api($api, $access_token='')
        {
            self::initialize();
            
            $response = null;
            
            try
            {
            	if ($access_token != '')
	               self::$facebook->setAccessToken($access_token);
                
                $response = self::$facebook->api($api);
            }
            catch (FacebookApiException $e)
            {
                echo "Fb error";
                exit;
            }
            
            return $response;
        }
    }
    
?>
