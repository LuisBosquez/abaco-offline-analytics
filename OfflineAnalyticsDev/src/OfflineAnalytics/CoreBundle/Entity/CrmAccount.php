<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of CrmAccount
 *
 * @author Luis Bosquez
 */
class CrmAccount {
    public $id;
    public $crm;
    public $username;
    public $password;
    
    function __construct($id, $crm, $username, $password) 
    {
        $this->id = $id;
        $this->crm = $crm;
        $this->username = $username;
        $this->password = $password;
    }
}

?>
