<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 11/7/15
 * Time: 10:51 AM
 */
class Trd_Forms_Block_AppointmentGrid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        // $this->setDefaultSort('COLUMN_ID');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('trd_forms/contact')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'width' => '50px',
                'index' => 'name'
            )
        );

        $this->addColumn('email',
            array(
                'header'=> $this->__('Email'),
                'width' => '50px',
                'index' => 'email'
            )
        );

        $this->addColumn('contact',
            array(
                'header'=> $this->__('Contact'),
                'width' => '50px',
                'index' => 'contact'
            )
        );

        $this->addColumn('date',
            array(
                'header'=> $this->__('Date'),
                'width' => '50px',
                'index' => 'date'
            )
        );

        $this->addColumn('time',
            array(
                'header'=> $this->__('Time'),
                'width' => '50px',
                'index' => 'time'
            )
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));
        
        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
       return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

        protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('trd_forms/contact')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> $this->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }
    }
