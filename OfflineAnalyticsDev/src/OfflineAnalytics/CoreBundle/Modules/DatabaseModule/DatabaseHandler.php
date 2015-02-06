<?php
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
namespace OfflineAnalytics\CoreBundle\Modules\DatabaseModule;

use OfflineAnalytics\CoreBundle\Entity\Client;
use OfflineAnalytics\CoreBundle\Entity\CrmObject;
use OfflineAnalytics\CoreBundle\Entity\CrmAccount;
use OfflineAnalytics\CoreBundle\Entity\StatusMapping;
use OfflineAnalytics\CoreBundle\Entity\FieldMapping;
use \PDO;

class DatabaseHandler 
{
    public static $hostname = "us-cdbr-azure-west-b.cleardb.com";
    public static $username = "b250dd54974739";
    public static $password = "d8db4c2c";
    public static $dbname = "AbacoOfflineAnalyticsAdmin";
    public static $dbh;
    
    public static function init()
    {
        try 
        {
            self::$dbh = new PDO("mysql:host=".self::$hostname.";dbname=".self::$dbname, self::$username, self::$password);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        };
    }
    public static function getClientById($client_id)
    {
    	$result = null;
    	$data = null;
    	if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT clients.client_id, clients.client_name, clients.client_isActive, clients.client_lastRetrieved FROM clients WHERE clients.client_id=".$client_id.";")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["client_id"]) || !ISSET($row["client_name"]))
            {
                continue;
            }
	        $result = new Client($row["client_id"], $row["client_name"], $row["client_isActive"],$row["client_lastRetrieved"]);
	    }
	    return $result;
    }
    public static function getAllClients()
    {
        $result = array();
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT clients.client_id, clients.client_name, clients.client_isActive FROM clients;")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["client_id"]) || !ISSET($row["client_name"]))
            {
                continue;
            }
            
            $c = new Client($row["client_id"], $row["client_name"], $row["client_isActive"]);
            
            self::getCrmForClient($c);
            array_push($result, $c);
        }
        return $result;
    }
    
    public static function getActiveClients()
    {
        $result = array();
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT clients.client_id, clients.client_name, clients.client_lastRetrieved FROM clients WHERE clients.client_isActive = 1;")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["client_id"]) || !ISSET($row["client_name"]))
            {
                continue;
            }
            
            $c = new Client($row["client_id"], $row["client_name"], 1, $row["client_lastRetrieved"]);
            
            self::getCrmForClient($c);
            array_push($result, $c);
        }
        return $result;
    }
    
    public static function getCrmForClient($client)
    {
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("select client_crm.crm_id, client_crm.crm_type, client_crm.crm_url, client_crm.crm_trackingId, client_crm.crm_lastRetrieved, client_crm.crm_date_fieldname, client_crm.crm_cid_fieldname, client_crm.crm_isActive FROM client_crm WHERE client_crm.client_id =".$client->id.";")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["crm_id"]) || !ISSET($row["crm_type"]) || !ISSET($row["crm_url"]) || !ISSET($row["crm_isActive"]))
            {
                continue;
            }
            $crm = new CrmObject($row["crm_id"], $client, $row["crm_type"], $row["crm_url"], $row["crm_trackingId"], $row["crm_lastRetrieved"], $row["crm_date_fieldname"], $row["crm_cid_fieldname"], $row["crm_isActive"]);
            self::getCrmAccountsForCrm($crm);
            self::getFieldMappingsForCrm($crm);
            self::getStatusMappingsForCrm($crm);
            
            $client->addCrmObject($crm);
        }
    }
    
    public static function getCrmAccountsForCrm($crm)
    {
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT crm_accounts.crm_id, crm_accounts.account_id, 
                                        crm_accounts.account_username, crm_accounts.account_password FROM crm_accounts 
                                        WHERE crm_id = ".$crm->id.";")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["crm_id"]) || !ISSET($row["account_id"]) || !ISSET($row["account_password"]) || !ISSET($row["account_username"]))
            {
                continue;
            }
            $account = new CrmAccount($row["account_id"], $crm, $row["account_username"], $row["account_password"]);
            $crm->addAccount($account);
        }
    }
    
    public static function getFieldMappingsForCrm($crm)
    {
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT 
                                        crm_fieldMappings.crm_id, 
                                        crm_fieldMappings.fieldmappings_id, 
                                        crm_fieldMappings.fieldmappings_crm_fieldname, 
                                        crm_fieldMappings.fieldmappings_ga_parameter,
                                        crm_fieldmappings.fieldmappings_isRequired
                                        FROM crm_fieldmappings 
                                        WHERE crm_id = ".$crm->id.";")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        foreach($data as $row)
        {
            if(!ISSET($row["crm_id"]) || !ISSET($row["fieldmappings_id"]) || !ISSET($row["fieldmappings_crm_fieldname"]) || !ISSET($row["fieldmappings_ga_parameter"])|| !ISSET($row["fieldmappings_isRequired"]))
            {
                continue;
            }
            $fieldMapping = new FieldMapping($row["fieldmappings_id"], $crm, $row["fieldmappings_crm_fieldname"], $row["fieldmappings_ga_parameter"], $row["fieldmappings_isRequired"]);
            $crm->addFieldMapping($fieldMapping);
        }
    }
    
    public static function getStatusMappingsForCrm($crm)
    {
        if(ISSET(self::$dbh))
        {
            $data = self::$dbh->query("SELECT 
                                        crm_statusMappings.crm_id, 
                                        crm_statusMappings.statusmappings_id, 
                                        crm_statusMappings.statusmappings_status, 
                                        crm_statusMappings.statusmappings_flag
                                        FROM crm_statusMappings
                                        WHERE crm_id = ".$crm->id.";")->fetchAll();
        }
        if(count($data) < 1)
        {
            return null;
        }
        
        foreach($data as $row)
        {
            if(!ISSET($row["statusmappings_id"]) || !ISSET($row["crm_id"]) || !ISSET($row["statusmappings_status"]) || !ISSET($row["statusmappings_flag"]))
            {
                continue;
            }
            $statusMapping = new StatusMapping($row["statusmappings_id"], $crm, $row["statusmappings_status"], $row["statusmappings_flag"]);
            $crm->addStatusMapping($statusMapping);
        }
    }

}
?>
