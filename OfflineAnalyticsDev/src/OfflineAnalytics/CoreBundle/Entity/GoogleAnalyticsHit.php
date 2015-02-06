<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
class GoogleAnalyticsHitFactory
{
    public static function BuildHit($lead, $fieldMappings)
    {
        
    }
}

class GoogleAnalyticsHit
{
    public $data = Array();

    public function __construct($_trackingId, $_clientId, $_hitType)
    {
        $this->data['v'] = 1; 
        $this->data['tid'] = $_trackingId;
        $this->data['cid'] = $_clientId;
        $this->data['t'] = $_hitType;
    }

    public function getPayloadData()
    {
        return $this->data;
    }
}

class PageViewHit extends GoogleAnalyticsHit
{
    public function __construct($_trackingId, $_clientId, $_hostname, $_page, $_title)
    {
        parent::__construct($_trackingId, $_clientId, 'pageview');
        $this->data['dh'] = $_hostname;
        $this->data['dp'] = $_page;
        $this->data['dt'] = $_title; 
    }
}
?>
