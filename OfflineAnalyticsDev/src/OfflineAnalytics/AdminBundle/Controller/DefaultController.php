<?php

namespace OfflineAnalytics\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use OfflineAnalytics\CoreBundle\Modules\DatabaseModule\DatabaseHandler;

class DefaultController extends Controller
{
    public function indexAction()
    {	
    	DatabaseHandler::init();
        $result = DatabaseHandler::getActiveClients();
        if(!ISSET($result))
        {
        	die();
        } 
        
        return $this->render('OfflineAnalyticsAdminBundle:Default:index.html.twig', array('clients' => $result));
    }
    
    public function getClientAction($client_id)
    {
       	DatabaseHandler::init();
        $client = DatabaseHandler::getClientById($client_id);
        if(!ISSET($client))
        {
        	die("Cliente inexistente. ID: ".$client_id);
        }
        DatabaseHandler::getCrmForClient($client);
        
 	   	return $this->render('OfflineAnalyticsAdminBundle:Default:client.html.twig', array('client' => $client));
    }
}
