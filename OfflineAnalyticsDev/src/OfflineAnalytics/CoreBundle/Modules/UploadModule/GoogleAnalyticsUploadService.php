<?php
namespace OfflineAnalytics\CoreBundle\Modules\UploadModule;
    class GoogleAnalyticsUploadService
    {
        public static $googleAnalyticsUrl = "http://www.google-analytics.com/collect";
        
        public static function uploadHit($googleAnalyticsHit)
        {
            $googleAnalyticsUrl = "http://www.google-analytics.com/collect";
            $data = $googleAnalyticsHit->getPayloadData();
            $content = http_build_query($data);
            
            $requestHeaders = array(
                "Content-type: application/x-www-form-urlencoded",
                "Accept: application/json",
                sprintf('Content-Length: %d', strlen($content))
            );
            print_r($data);
            $options = array(
                'http' => array(
                    'header'  => implode("\r\n", $requestHeaders),
                    'method'  => 'POST',
                    'content' => $content,
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($googleAnalyticsUrl, false, $context);
            
            print_r("Sent. ".$result);
        }
    }
       
?>
