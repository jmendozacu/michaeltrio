<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 10/3/15
 * Time: 1:25 PM
 */
class Trd_Importxls_Block_Managedata_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel(){
        return Mage::registry('managedata_model');
    }

    protected function _getHelper(){
        return Mage::helper('trd_importxls');
    }

    protected function _getModelTitle(){
        return '';
    }

    protected function _prepareForm()
    {
        $model  = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => $this->_getHelper()->__("$modelTitle Information"),
            'class'     => 'fieldset-wide',
        ));

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', array(
                'name' => $modelPk,
            ));
        }

        $fieldset->addField('supplier', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'supplier',
            'label'     => $this->_getHelper()->__('Supplier'),
            'title'     => $this->_getHelper()->__('supplier'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('cert_url', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'cert_url',
            'label'     => $this->_getHelper()->__('Cert Url'),
            'title'     => $this->_getHelper()->__('Cert Url'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('diamonds_model', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'diamonds_model',
            'label'     => $this->_getHelper()->__('Diamonds Model'),
            'title'     => $this->_getHelper()->__('diamonds model'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('diamonds_price', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'diamonds_price',
            'label'     => $this->_getHelper()->__('Diamonds Price'),
            'title'     => $this->_getHelper()->__('diamonds Price'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('price_per_carat', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'price_per_carat',
            'label'     => $this->_getHelper()->__('Price Per Carat'),
            'title'     => $this->_getHelper()->__('price per carat'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('diamonds_weight', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'diamonds_weight',
            'label'     => $this->_getHelper()->__('Diamonds Weight'),
            'title'     => $this->_getHelper()->__('diamonds weight'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('shape', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'shape',
            'label'     => $this->_getHelper()->__('Shape'),
            'title'     => $this->_getHelper()->__('shape'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('carat', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'carat',
            'label'     => $this->_getHelper()->__('Carat'),
            'title'     => $this->_getHelper()->__('carat'),
            'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('color', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'color',
            'label'     => $this->_getHelper()->__('Color'),
            'title'     => $this->_getHelper()->__('color'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('clarity', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'clarity',
            'label'     => $this->_getHelper()->__('Clarity'),
            'title'     => $this->_getHelper()->__('clarity'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('cut', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'cut',
            'label'     => $this->_getHelper()->__('Cut'),
            'title'     => $this->_getHelper()->__('cut'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('report_no', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'report_no',
            'label'     => $this->_getHelper()->__('Report No'),
            'title'     => $this->_getHelper()->__('report no'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('cert', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'cert',
            'label'     => $this->_getHelper()->__('Cert'),
            'title'     => $this->_getHelper()->__('cert'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('polish', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'polish',
            'label'     => $this->_getHelper()->__('Polish'),
            'title'     => $this->_getHelper()->__('polish'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('symmetry', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'symmetry',
            'label'     => $this->_getHelper()->__('Symmetry'),
            'title'     => $this->_getHelper()->__('symmetry'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('fluorescence', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'fluorescence',
            'label'     => $this->_getHelper()->__('Fluorescence'),
            'title'     => $this->_getHelper()->__('fluorescence'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('depth', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'depth',
            'label'     => $this->_getHelper()->__('Depth'),
            'title'     => $this->_getHelper()->__('depth'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('table_field', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'table_field',
            'label'     => $this->_getHelper()->__('Table'),
            'title'     => $this->_getHelper()->__('table'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('girdle', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'girdle',
            'label'     => $this->_getHelper()->__('Girdle'),
            'title'     => $this->_getHelper()->__('girdle'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('measurement_1', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'measurement_1',
            'label'     => $this->_getHelper()->__('Measurement 1'),
            'title'     => $this->_getHelper()->__('measurement_1'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('measurement_2', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'measurement_2',
            'label'     => $this->_getHelper()->__('Measurement 2'),
            'title'     => $this->_getHelper()->__('measurement_2'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));

        $fieldset->addField('measurement_3', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'measurement_3',
            'label'     => $this->_getHelper()->__('Measurement 3'),
            'title'     => $this->_getHelper()->__('measurement_3'),
            //'required'  => true,
            'class'     => 'datamange-element',
        ));
//          // custom renderer (optional)
//          $renderer = $this->getLayout()->createBlock('Block implementing Varien_Data_Form_Element_Renderer_Interface');
//          $field->setRenderer($renderer);

//      // New Form type element (extends Varien_Data_Form_Element_Abstract)
//        $fieldset->addType('custom_element','MyCompany_MyModule_Block_Form_Element_Custom');  // you can use "custom_element" as the type now in ::addField([name], [HERE], ...)


        if($model){
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
