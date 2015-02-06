<?php
namespace OfflineAnalytics\CoreBundle\Modules\LeadRetrievalModule;
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */

use OfflineAnalytics\CoreBundle\Entity\Lead;
class SugarCrmConnect
{
    private static $urlSuffix = "service/v4/soap.php?wsdl";
    private static $DATE_FIELD_NAME = "date_modified";
    private static $CID_FIELD_NAME = "lp_analytics_clientid_c";
    
    public static function setDateFieldname($date_fieldname)
    {
        self::$DATE_FIELD_NAME = $date_fieldname;
    }
    
    public static function setCidFieldname($cid_fieldname)
    {
        self::$CID_FIELD_NAME  = $cid_fieldname;;
    }
    
    public static function connect($crmHost)
    {
        $url = $crmHost.self::$urlSuffix;
        $client = new \nusoap_client($url, true);

        $err = $client->getError();

        if($err)
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            exit();
        }
        return $client;
    }
    public static function login($client, $username, $password)
    {
       $login_parameters = array(
            'user_auth' => array(
                 'user_name' => $username,
                 'password' => md5($password),
                 'version' => '1'
            ),
            'application_name' => 'SoapTest',
            'name_value_list' => array(
            ),
       );
       $login_result = $client->call('login', $login_parameters);
       if(!$login_result)
        die("Login failed.");
       return $login_result;
    } 
    public static function getLeads($login_result, $client, $last_updated, $fieldsToRetrieve)
    {
        $session_id = $login_result['id'];
        array_push($fieldsToRetrieve, self::$CID_FIELD_NAME);
        array_push($fieldsToRetrieve, self::$DATE_FIELD_NAME);
        $get_entry_list_parameters = array(
            //session id
            'session' => $session_id,
            //Módulo del cuál obtener los datos
            'module_name' => 'Leads',

            //Filtros del query "WHERE THIS=this", etc. 
            'query' => "leads.".self::$DATE_FIELD_NAME." > '".$last_updated."'",
            
            //Sort de los resultados
            'order_by' => "date_modified DESC",

            //Desde dónde comenzar los records.
            'offset' => '0',

            //Lista de parámetros. Incluir campo con clientID de Google Analytics.
            'select_fields' => $fieldsToRetrieve,

            /*
            A list of link names and the fields to be returned for each link name.
            Example: 'link_name_to_fields_array' => array(array('name' => 'email_addresses', 'value' => array('id', 'email_address', 'opt_out', 'primary_address')))
            */
            'link_name_to_fields_array' => array(
            ),

            //Limitar resultados.
            //'max_results' => '2',

            //Incluir o excluir registros eliminados.
            'deleted' => '0',

            //Si sólo los registros marcados como favoritos deben ser regresados.
            'Favorites' => false,
        );
        $get_entry_list_result = $client->call('get_entry_list', $get_entry_list_parameters);
        $leadsList = $get_entry_list_result['entry_list'];

        $leads_array = array();
        if(count($leadsList) < 1)
        {
            die("No leads found.");
        }
        foreach($leadsList as $entry)
        {
            if(count($entry['name_value_list']) != 0)
            {
                $leadValues = array();
                $date_value = null;
                foreach($entry['name_value_list'] as $nameValues)
                {
                       $leadValues[$nameValues["name"]] = $nameValues["value"];
                       if((strcmp($nameValues["name"],self::$CID_FIELD_NAME) == 0) && !ISSET($nameValues["value"]))
                       {
                           continue;
                       }
                       if(strcmp($nameValues["name"],self::$DATE_FIELD_NAME) == 0)
                       {
                           $date_value = $nameValues["value"];
                       }
                }
                if($date_value == null)
                {
                    continue;
                }
                $leadObject = new Lead($entry["id"], $date_value, $leadValues);
                echo "<br/>";
                print_r($leadObject);
                echo "<br/>";
                array_push($leads_array, $leadObject);
            }
        }
        return $leads_array;
    }     
}

?>

