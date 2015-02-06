<?php
namespace OfflineAnalytics\CoreBundle\Modules\LeadRetrievalModule;
class SalesforceCrmConnect
{
    public static function login($pathToWsdl, $username, $password, $securityToken)
    {
        $builder = new \Phpforce\SoapClient\ClientBuilder(
            $pathToWsdl,
            $username,
            $password,
            $securityToken
          );
        
        $client = $builder->build();
        return $client;
    }
    
    public static function getLeads($client)
    {
        $results = $client->query('select * from Lead limit 5');
        foreach ($results as $lead) {
            echo 'Last modified: ' . $account->SystemModstamp->format('Y-m-d H:i:') . "\n";
        }
    }
    
}

?>

