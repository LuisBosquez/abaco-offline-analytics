<?php
namespace OfflineAnalytics\CoreBundle\Entity;

class Client
{
    public $id;
    public $name;
    public $isActive;
    public $lastRetrieved;
    
    public $crmObjects = array();
    
    public function __construct ($id, $name, $isActive, $lastRetrieved)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->lastRetrieved = $lastRetrieved;
    }
    
    public function addCrmObject($crmObject)
    {
        array_push($this->crmObjects, $crmObject);
    }
    
    public function switchActive()
    {
        if($this->isActive == 1)
        {
            $this->isActive = 0;
        }
        else
        {
            $this->isActive = 1;
        }
    }
}
?>
