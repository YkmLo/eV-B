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
                'appId'  => '277019759074470',
                'secret' => 'ddcec0b3141558e73bbf4cd94dcea6dc',
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
