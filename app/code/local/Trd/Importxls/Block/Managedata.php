<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/3/15
 * Time: 1:25 PM
 */
class Trd_Importxls_Block_Managedata extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'trd_importxls';
        $this->_controller      = 'managedata';
        $this->_headerText      = $this->__('Manage Diamonds');
        $this->_addButtonLabel  = $this->__('Add New Diamond');
        parent::__construct();
            }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

