<?php
namespace OfflineAnalyticsModel;
    class GoogleAnalyticsUploadService
    {
        public static $googleAnalyticsUrl = "http://www.google-analytics.com/collect";
        
        public static function uploadHit($googleAnalyticsHit)
        {
            $googleAnalyticsUrl = "http://www.google-analytics.com/collect";
            $data = $googleAnalyticsHit->getPayloadData();
            $options = array(
                'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($googleAnalyticsUrl, false, $context);
            
            print_r("Sent. ".$result);
        }
    }
    
?>
