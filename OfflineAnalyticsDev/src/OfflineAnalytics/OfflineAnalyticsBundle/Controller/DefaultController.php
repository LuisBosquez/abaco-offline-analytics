<?php
namespace OfflineAnalytics\OfflineAnalyticsBundle\Controller;
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use OfflineAnalytics\CoreBundle\Modules\LeadRetrievalModule\SugarCrmConnect;
use OfflineAnalytics\CoreBundle\Modules\DatabaseModule\DatabaseHandler;
use OfflineAnalytics\CoreBundle\Entity\GoogleAnalyticsHit;
use OfflineAnalytics\CoreBundle\Modules\UploadModule\GoogleAnalyticsUploadService;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $response = new Response();
        
        //GoogleAnalyticsUploadService::uploadHit($hit);
        //$leads = "";
        //$client = \OfflineAnalytics\OfflineAnalyticsBundle\Model\SugarCrmConnect::connect("http://elcrmdeluis.azurewebsites.net/");
        //$client =  SugarCrmConnect::connect("http://elcrmdeluis.azurewebsites.net/");
        //$login_result = SugarCrmConnect::login($client, "abaco", "lol");
        //$leads = SugarCrmConnect::getLeads($login_result, $client, "2012-01-01","UA-47238186-1");
        
        DatabaseHandler::init();
        $result = DatabaseHandler::getActiveClients();
        if(!ISSET($result))
        {
            die("No hay clientes registrados.");
        }
        echo "<br/><h2>Array de clientes registrados:</h2><p>";
        print_r($result);
        echo "</p><br/>";
        
        foreach($result as $client)
        {
            if($client->isActive == 0)
            {
                continue;
            }
            foreach($client->crmObjects as $crm)
            {
                $leads_array = $this->retrieveLeads($crm);
//                $this->uploadLeads($leads_array, $crm);
                
            }
        }
       
        return $response->setContent('');
    }
    
    public function retrieveLeads($crm)
    {
        $leads_array = array();
        if(strcmp($crm->type,"SugarCrm") == 0)
        {
            $fieldsToRetrieve = $crm->getFieldsFromFieldMappings();
            SugarCrmConnect::setCidFieldname($crm->cid_fieldname);
            SugarCrmConnect::setDateFieldname($crm->date_fieldname);
            $sugar_client = SugarCrmConnect::connect($crm->url);
            $account = $crm->getDefaultAccount();
            $login_result = SugarCrmConnect::login($sugar_client, $account->username, $account->password);
            $leads_array = SugarCrmConnect::getLeads($login_result, $sugar_client, $crm->lastRetrieved, $fieldsToRetrieve);
        }
        
        return $leads_array;
    }
    
    public function uploadLeads($leads_array, $crm)
    {
        foreach($leads_array as $lead)
        {
            GoogleAnalyticsUploadService::uploadHit(new GoogleAnalyticsHit($crm->trackingId, $lead->values[$crm->cid_fieldname], "pageview"));
        }
    }
    
}
