<?php

class Trd_Diamond_Model_Observer {

    // Change Price for Diamond Product
    public function modifyAttrs(Varien_Event_Observer $obs)
    {
        // Get the quote item
        $item = $obs->getQuoteItem();
        // Ensure we have the parent item, if it has one
        $item = ( $item->getParentItem() ? $item->getParentItem() : $item );

        $product = $item->getProduct();
        $attributeSetName = Mage::getModel('eav/entity_attribute_set')->load($product->getAttributeSetId())->getAttributeSetName();

        if ($product->getId() == Mage::registry('temp_prod_id')) {
            $importXlsModel = Mage::registry('diamond_current_model');
            // Load the custom price
            $price = $importXlsModel->getDiamondsPrice();
            $img_name = strtolower($importXlsModel->getShape()) . '_t.jpg';
            $img_path = 'media/wysiwyg/icotheme/diamonds_pics/' . $img_name;

            // Set the custom price
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->setCustomProductName($importXlsModel->getDiamondsName());
            $item->setCustomProductImage($img_path);
            $item->setImportxlsId(Mage::registry('importxls_id'));
            // Enable super mode on the product.
            $item->getProduct()->setIsSuperMode(true);
        } else if ($attributeSetName == 'ring') {
            $diamondId = Mage::getSingleton('core/session')->getChoiseDiamond();
            $model = Mage::getModel('trd_importxls/importxls')->load($diamondId);
            $origPrice = $item->getProduct()->getPrice();
            $finalPrice = (int) $origPrice + (int) $model->getDiamondsPrice();
            // Set the custom price
            $item->setCustomPrice($finalPrice);
            $item->setOriginalCustomPrice($finalPrice);
            $item->setImportxlsId($diamondId);
            $item->getProduct()->setIsSuperMode(true);
        }

        return $this;
    }

    public function deleteDiamonAfterPlace(Varien_Event_Observer $obs)
    {
        $order = $obs->getEvent()->getOrder();
        $quote = $order->getQuote();
        $tempProdId = Mage::getModel('trd_diamond/diamondprod')->load(1);
        $isDiamondProduct = false;
        $importXlsId = false;

        foreach ($quote->getAllItems() as $item) {
            $product = $item->getProduct();
            if ($product->getId() == $tempProdId->getProductId()) {
                $isDiamondProduct = true;
                $importXlsId = $item->getImportxlsId();
            }
        }

        if ($isDiamondProduct && $importXlsId) {
            $model = Mage::getModel('trd_importxls/importxls')->load($importXlsId);
            try {
                $model->delete();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
}