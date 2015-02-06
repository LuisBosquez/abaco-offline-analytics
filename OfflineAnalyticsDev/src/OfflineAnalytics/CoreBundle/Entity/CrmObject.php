<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
class CrmObject 
{
    public $id;
    public $client;
    public $type;
    public $url;
    public $trackingId;
    public $lastRetrieved;
    public $date_fieldname;
    public $cid_fieldname;
    public $isActive;
    
    public $accounts;
    public $statusMappings;
    public $fieldMappings;
    
    //public $wsdl;
    
    function __construct($id, $client, $type, $url, $trackingId, $lastRetrieved, $date_fieldname, $cid_fieldname, $isActive) {
        $this->id = $id;
        $this->client = $client;
        $this->type = $type;
        $this->url = $url;
        $this->trackingId = $trackingId;
        $this->lastRetrieved = $lastRetrieved;
        $this->isActive = $isActive;
        $this->accounts = array();
        
        $this->date_fieldname = $date_fieldname;
        $this->cid_fieldname = $cid_fieldname;
        $this->statusMappings = array();
        $this->fieldMappings = array();
    }
    
    function addAccount($account)
    {
        if(ISSET($account))
        {
            array_push($this->accounts, $account);
        }
    }
    
    function addWsdl($wsdl)
    {
        if(ISSET($wsdl))
        {
            array_push($this->wsdl, $wsdl);
        }
    }
    
    function getDefaultAccount()
    {
        if(count($this->accounts) > 0)
        {
            return $this->accounts[0];
        }
        return null;
    }
    
    function addStatusMapping($statusMapping)
    {
        if(ISSET($statusMapping))
        {
            array_push($this->statusMappings, $statusMapping);
        }
    }
    
    function getStatusMapping()
    {
        return $this->statusMappings;
    }
    
    function addFieldMapping($fieldMapping)
    {
        if(ISSET($fieldMapping))
        {
            array_push($this->fieldMappings, $fieldMapping);
        }
    }
    
    function getFieldMappings()
    {
        return $this->fieldMappings;
    }
    
    function getFieldsFromFieldMappings()
    {
        $result = array();
        
        foreach($this->fieldMappings as $fieldMapping)
        {
            array_push($result,$fieldMapping->fieldname);
        }
        
        return $result;
    }
}

?>
