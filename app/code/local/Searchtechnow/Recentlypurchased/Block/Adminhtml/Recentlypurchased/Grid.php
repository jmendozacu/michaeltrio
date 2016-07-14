<?php
class Searchtechnow_Recentlypurchased_Block_Adminhtml_Recentlypurchased_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('recentlypurchasedGrid');
        // This is the primary key of the database
        $this->setDefaultSort('update_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('recentlypurchased/recentlypurchased')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('product_id', array(
            'header'    => Mage::helper('recentlypurchased')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'product_id',
        ));
 
        $this->addColumn('title', array(
            'header'    => Mage::helper('recentlypurchased')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
 
        
        $this->addColumn('shape', array(
            'header'    => Mage::helper('recentlypurchased')->__('Shape'),
            'width'     => '150px',
            'index'     => 'shape',
        ));
		
		$this->addColumn('price', array(
            'header'    => Mage::helper('recentlypurchased')->__('Price'),
            'width'     => '150px',
            'index'     => 'price',
        ));        
 
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('recentlypurchased')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',
            'index'     => 'created_time',
        ));
 
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('recentlypurchased')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',            
            'index'     => 'update_time',
        ));   
 
 
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('recentlypurchased')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
 
 
}
