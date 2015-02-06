<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of StatusMapping
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
class StatusMapping {
    public $id;
    public $crm;
    public $status;
    public $flag;
    
    function __construct($id, $crm, $status, $flag) {
        $this->id = $id;
        $this->crm = $crm;
        $this->status = $status;
        $this->flag = $flag;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCrm() {
        return $this->crm;
    }

    public function setCrm($crm) {
        $this->crm = $crm;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getFlag() {
        return $this->flag;
    }

    public function setFlag($flag) {
        $this->flag = $flag;
    }

}

?>
