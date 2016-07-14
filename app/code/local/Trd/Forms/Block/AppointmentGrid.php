<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 11/7/15
 * Time: 10:51 AM
 */
class Trd_Forms_Block_AppointmentGrid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'trd_forms';
        $this->_controller      = 'appointmentGrid';
        $this->_headerText      = $this->__('Manage Appointments');
        $this->_addButtonLabel  = $this->__('Add new Appointment');
        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

