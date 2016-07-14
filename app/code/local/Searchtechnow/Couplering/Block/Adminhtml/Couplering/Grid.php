<?php

class Searchtechnow_Couplering_Block_Adminhtml_Couplering_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('coupleringGrid');
        // This is the primary key of the database
        $this->setDefaultSort('update_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('couplering/couplering')->getCollection();
        //$collection->getSelect()->join('catalog_product_entity_varchar', '`catalog_product_entity_varchar`.attribute_id=71 AND `catalog_product_entity_varchar`.entity_id = `main_table`.menring' , array('models1'  => new Zend_Db_Expr('`catalog_product_entity_varchar`.value')));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('product_id', array(
            'header' => Mage::helper('couplering')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'product_id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('couplering')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        
        $this->addColumn('category_id', array(
            'header' => Mage::helper('couplering')->__('Category'),
            'align' => 'left',
            'index' => 'category_id',
            'renderer' => 'Searchtechnow_Couplering_Block_Category',
        ));

        $this->addColumn('menring', array(
            'header' => Mage::helper('couplering')->__("Men's Ring"),
            'width' => '150px',
            'index' => 'menring',
            'renderer' => 'Searchtechnow_Couplering_Block_Product',
        ));

        $this->addColumn('womenring', array(
            'header' => Mage::helper('couplering')->__("Women's Ring"),
            'width' => '150px',
            'index' => 'womenring',
            'renderer' => 'Searchtechnow_Couplering_Block_Product',
        ));

        $this->addColumn('created_time', array(
            'header' => Mage::helper('couplering')->__('Creation Time'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'datetime',
            'index' => 'created_time',
        ));

        $this->addColumn('update_time', array(
            'header' => Mage::helper('couplering')->__('Update Time'),
            'align' => 'left',
            'width' => '120px',
            'type' => 'datetime',
            'index' => 'update_time',
        ));


        $this->addColumn('status', array(
            'header' => Mage::helper('couplering')->__('Status'),
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
