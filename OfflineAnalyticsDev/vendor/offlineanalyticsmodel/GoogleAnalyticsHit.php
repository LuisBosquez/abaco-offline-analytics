<?php
namespace OfflineAnalyticsModel;
    class GoogleAnalyticsHit
    {
        public $data = Array();
        
        public function __construct($_trackingId, $_clientId, $_hitType)
        {
            $data['v'] = 1;
            $data['tid'] = $_trackingId;
            $data['cid'] = $_clientId;
            $data['t'] = $_hitType;
        }
        
        public function getPayloadData()
        {
            $this->data;
        }
    }
     
   class PageViewHit extends GoogleAnalyticsHit
    {
        public function __construct($_trackingId, $_clientId, $_hostname, $_page, $_title)
        {
            parent::__construct($_trackingId, $_clientId, 'pageview');
            $data['dh'] = $_hostname;
            $data['dp'] = $_page;
            $data['dt'] = $_title; 
        }
    }
?>
