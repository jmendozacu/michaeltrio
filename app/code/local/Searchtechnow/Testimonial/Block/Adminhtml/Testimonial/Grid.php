<?php
class Searchtechnow_Testimonial_Block_Adminhtml_Testimonial_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonialGrid');
        // This is the primary key of the database
        $this->setDefaultSort('update_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('testimonial/testimonial')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('testimonial')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));
		
		$this->addColumn('author', array(
            'header'    => Mage::helper('testimonial')->__('Author'),
            'align'     =>'left',
            'index'     => 'author',
        ));
 
        $this->addColumn('title', array(
            'header'    => Mage::helper('testimonial')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
		
		$this->addColumn('title', array(
            'header'    => Mage::helper('testimonial')->__('Date Of Testimonial'),
            'align'     =>'left',
            'index'     => 'date_of_testimonial',
        ));
 
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('testimonial')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',
            'index'     => 'created_time',
        ));
 
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('testimonial')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',            
            'index'     => 'update_time',
        ));   
 
 
        $this->addColumn('status', array( 
            'header'    => Mage::helper('testimonial')->__('Status'),
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
