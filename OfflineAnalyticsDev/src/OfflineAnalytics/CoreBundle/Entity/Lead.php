<?php
namespace OfflineAnalytics\CoreBundle\Entity;
/**
 * Description of Lead
 *
 * @author Luis Bosquez <luisdbosquez@gmail.com>
 */
class Lead {
    public $id;
    public $date;
    public $values = array();
    
    function __construct($id, $date, $values)
    {
        $this->id = $id;
        $this->values = $values;
        $this->date = $date;
    }
}

?>
