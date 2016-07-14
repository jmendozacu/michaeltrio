<?php
/**
 * Created by PhpStorm.
 * User: andreyalifirenko
 * Date: 11/7/15
 * Time: 10:51 AM
 */
class Trd_Forms_Block_AppointmentGrid_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel(){
        return Mage::registry('current_model');
    }

    protected function _getHelper(){
        return Mage::helper('trd_forms');
    }

    protected function _getModelTitle(){
        return 'Appointments';
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

        $fieldset->addField('name', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'name',
            'label'     => $this->_getHelper()->__('Name'),
            'title'     => $this->_getHelper()->__('Field name'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('email', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'email',
            'label'     => $this->_getHelper()->__('Email'),
            'title'     => $this->_getHelper()->__('Field email'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('contact', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'contact',
            'label'     => $this->_getHelper()->__('Contact'),
            'title'     => $this->_getHelper()->__('Field contact'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('date', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'date',
            'label'     => $this->_getHelper()->__('Date'),
            'title'     => $this->_getHelper()->__('Field date'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('time', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'time',
            'label'     => $this->_getHelper()->__('Time'),
            'title'     => $this->_getHelper()->__('Field time'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('text', 'text' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'text',
            'label'     => $this->_getHelper()->__('Text'),
            'title'     => $this->_getHelper()->__('Field text'),
            'required'  => true,
            //'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));
        $fieldset->addField('proposal_ring', 'select' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'proposal_ring',
            'label'     => $this->_getHelper()->__('Proposal Ring'),
            'title'     => $this->_getHelper()->__('proposal_ring'),
            'required'  => true,
            'options'   => array( 0 => 'No', 1 => 'Yes' ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));

        $fieldset->addField('wedding_ring', 'select' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'wedding_ring',
            'label'     => $this->_getHelper()->__('Wedding Ring'),
            'title'     => $this->_getHelper()->__('wedding_ring'),
            'required'  => true,
            'options'   => array( 0 => 'No', 1 => 'Yes' ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
        ));

        $fieldset->addField('other', 'select' /* select | multiselect | hidden | password | ...  */, array(
            'name'      => 'other',
            'label'     => $this->_getHelper()->__('Other'),
            'title'     => $this->_getHelper()->__('other'),
            'required'  => true,
            'options'   => array( 0 => 'No', 1 => 'Yes' ),                 // used when type = "select"
            //'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
            //'style'     => 'css rules',
            'class'     => '',
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
