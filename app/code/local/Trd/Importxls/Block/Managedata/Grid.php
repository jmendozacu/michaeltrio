<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/3/15
 * Time: 1:25 PM
 */
class Trd_Importxls_Block_Managedata_Grid extends Mage_Adminhtml_Block_Widget_Grid {

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
        $collection = Mage::getModel('trd_importxls/importxls')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

      $this->addColumn('diamonds_model',
         array(
             'header'=> $this->__('Model'),
             'width' => '50px',
             'index' => 'diamonds_model'
         )
      );

      $this->addColumn('diamonds_price',
         array(
             'header'=> $this->__('Price'),
             'width' => '50px',
             'index' => 'diamonds_price'
         )
      );

      $this->addColumn('diamonds_weight',
         array(
             'header'=> $this->__('Weight'),
             'width' => '50px',
             'index' => 'diamonds_weight'
         )
      );

      $this->addColumn('shape',
         array(
             'header'=> $this->__('Shape'),
             'width' => '50px',
             'index' => 'shape'
         )
      );

      $this->addColumn('carat',
         array(
             'header'=> $this->__('Carat'),
             'width' => '50px',
             'index' => 'carat'
         )
      );

      $this->addColumn('color',
         array(
             'header'=> $this->__('Color'),
             'width' => '50px',
             'index' => 'color'
         )
      );

      $this->addColumn('clarity',
         array(
             'header'=> $this->__('Clarity'),
             'width' => '50px',
             'index' => 'clarity'
         )
      );

      $this->addColumn('cut',
         array(
             'header'=> $this->__('Cut'),
             'width' => '50px',
             'index' => 'cut'
         )
      );

      $this->addColumn('polish',
         array(
             'header'=> $this->__('Polish'),
             'width' => '50px',
             'index' => 'polish'
         )
      );


      $this->addColumn('symmetry',
         array(
             'header'=> $this->__('Symmetry'),
             'width' => '50px',
             'index' => 'symmetry'
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
        $modelPk = Mage::getModel('trd_importxls/importxls')->getResource()->getIdFieldName();
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
