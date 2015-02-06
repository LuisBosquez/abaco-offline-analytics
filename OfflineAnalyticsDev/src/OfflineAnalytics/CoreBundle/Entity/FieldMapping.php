<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of FieldMapping
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
class FieldMapping {
    public $id;
    public $crm;
    public $fieldname;
    public $parameter;
    public $isRequired;
    
    function __construct($id, $crm, $fieldname, $parameter, $isRequired) {
        $this->id = $id;
        $this->crm = $crm;
        $this->fieldname = $fieldname;
        $this->parameter = $parameter;
        $this->isRequired = $isRequired;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFieldname() {
        return $this->fieldname;
    }

    public function setFieldname($fieldname) {
        $this->fieldname = $fieldname;
    }

    public function getParameter() {
        return $this->parameter;
    }

    public function setParameter($parameter) {
        $this->parameter = $parameter;
    }

    public function getIsRequired() {
        return $this->isRequired;
    }

    public function setIsRequired($isRequired) {
        $this->isRequired = $isRequired;
    }



}

?>
