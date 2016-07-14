<?php

class Searchtechnow_Stnpromotion_Block_Adminhtml_Stnpromotion_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('stnpromotionGrid');
        // This is the primary key of the database
        $this->setDefaultSort('update_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('stnpromotion/stnpromotion')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('promotion_id', array(
            'header' => Mage::helper('stnpromotion')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'promotion_id',
        ));

        $this->addColumn('promotion_text', array(
            'header' => Mage::helper('stnpromotion')->__('Promotion Text'),
            'align' => 'left',
            'index' => 'promotion_text',
        ));


        $this->addColumn('short_order', array(
            'header' => Mage::helper('stnpromotion')->__('Short Order'),
            'width' => '150px',
            'index' => 'short_order',
        ));

        $this->addColumn('created_time', array(
            'header' => Mage::helper('stnpromotion')->__('Creation Time'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'datetime',
            'index' => 'created_time',
        ));

        $this->addColumn('update_time', array(
            'header' => Mage::helper('stnpromotion')->__('Update Time'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'datetime',
            'index' => 'update_time',
        ));


        $this->addColumn('status', array(
            'header' => Mage::helper('stnpromotion')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}
