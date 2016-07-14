<?php

class Searchtechnow_Testimonial_Block_Index extends Mage_Core_Block_Template {

    protected $_pagesCount = null;
    protected $_currentPage = null;
    protected $_itemsOnPage = 5;
    protected $_itemsLimit;
    protected $_pages;
    protected $_displayPages = 5;

//    public function __construct() {
//        parent::__construct();
//        $collection = Mage::getModel('testimonial/testimonial')->getCollection();
//        $this->setCollection($collection);
//    }

    protected function _construct() {
        $this->_currentPage = $this->getRequest()->getParam('page');
        if (!$this->_currentPage) {
            $this->_currentPage = 1;
        }

        $itemsPerPage = 5;
        if ($itemsPerPage > 0) {
            $this->_itemsOnPage = $itemsPerPage;
        }
    }
	

    public function getTestimonialList() {
	
        $collection = Mage::getModel('testimonial/testimonial')->getCollection()
		              ->addFieldToFilter('status', '1')
		              ->setOrder('date_of_testimonial', 'DESC');

        if ($this->_itemsLimit != null && $this->_itemsLimit < $collection->getSize()) {
            $this->_pagesCount = ceil($this->_itemsLimit / $this->_itemsOnPage);
        } else {
            $this->_pagesCount = ceil($collection->getSize() / $this->_itemsOnPage);
        }
        for ($i = 1; $i <= $this->_pagesCount; $i++) {
            $this->_pages[] = $i;
        }
        $this->setLastPageNum($this->_pagesCount);

        $offset = $this->_itemsOnPage * ($this->_currentPage - 1);
        if ($this->_itemsLimit != null) {
            $_itemsCurrentPage = $this->_itemsLimit - $offset;
            if ($_itemsCurrentPage > $this->_itemsOnPage) {
                $_itemsCurrentPage = $this->_itemsOnPage;
            }
            $collection->getSelect()->limit($_itemsCurrentPage, $offset);
        } else {
            $collection->getSelect()->limit($this->_itemsOnPage, $offset);
        }
        return $collection;
    }

    public function isFirstPage() {
        if ($this->_currentPage == 1) {
            return true;
        }
        return false;
    }

    public function isLastPage() {
        if ($this->_currentPage == $this->_pagesCount) {
            return true;
        }
        return false;
    }

    public function isPageCurrent($page) {
        if ($page == $this->_currentPage) {
            return true;
        }
        return false;
    }

    public function getPageUrl($page) {
        return $this->getUrl('*', array('page' => $page));
    }

    public function getNextPageUrl() {
        $page = $this->_currentPage + 1;
        return $this->getPageUrl($page);
    }

    public function getPreviousPageUrl() {
        $page = $this->_currentPage - 1;
        return $this->getPageUrl($page);
    }
    

    public function getPages() {
        $collection = Mage::getModel('testimonial/testimonial')->getCollection()
		              ->addFieldToFilter('status', '1')
		              ->setOrder('date_of_testimonial', 'DESC')
		               ;
        $pages = array();
        if ($this->_pagesCount <= $this->_displayPages) {
            $pages = range(1, $this->_pagesCount);
        } else {
            $half = ceil($this->_displayPages / 2);
            if ($this->_currentPage >= $half && $this->_currentPage <= $this->_pagesCount - $half) {
                $start = ($this->_currentPage - $half) + 1;
                $finish = ($start + $this->_displayPages) - 1;
            } elseif ($this->_currentPage < $half) {
                $start = 1;
                $finish = $this->_displayPages;
            } elseif ($this->_currentPage > ($this->_pagesCount - $half)) {
                $finish = $this->_pagesCount;
                $start = $finish - $this->_displayPages + 1;
            }

            $pages = range($start, $finish);
        }
        return $pages;
//return $this->_pages;
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'testimonial.pager');
        //$pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

//    public function getPagerHtml() {
//        return $this->getChildHtml('pager');
//    }

    public function getPagerHtml($collection = 'null') {
        $html = false;
        if ($collection == 'null')
            return;
        if ($collection->count() > $this->_itemPerPage) {
            $curPage = $this->getRequest()->getParam('p');
            $pager = (int) ($collection->count() / $this->_itemPerPage);
            $count = ($collection->count() % $this->_itemPerPage == 0) ? $pager : $pager + 1;
            $url = $this->getPagerUrl();
            $start = 1;
            $end = $this->_pageFrame;

            $html .= '<ol>';
            if (isset($curPage) && $curPage != 1) {
                $start = $curPage - 1;
                $end = $start + $this->_pageFrame;
            } else {
                $end = $start + $this->_pageFrame;
            }
            if ($end > $count) {
                $start = $count - ($this->_pageFrame - 1);
            } else {
                $count = $end - 1;
            }

            for ($i = $start; $i <= $count; $i++) {
                if ($i >= 1) {
                    if ($curPage) {
                        $html .= ($curPage == $i) ? '<li class="current">' . $i . '</li>' : '<li><a href="' . $url . '?p=' . $i . '">' . $i . '</a></li>';
                    } else {
                        $html .= ($i == 1) ? '<li class="current">' . $i . '</li>' : '<li><a href="' . $url . '?p=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }

            $html .= '</ol>';
        }

        return $html;
    }

    public function getCollection() {
        $limit = 10;
        $curr_page = 1;

        if (Mage::app()->getRequest()->getParam('p')) {
            $curr_page = Mage::app()->getRequest()->getParam('p');
        }

//Calculate Offset
        $offset = ($curr_page - 1) * $limit;

        $collection = Mage::getModel('testimonial/testimonial')->getCollection()
                ->addFieldToFilter('status', 1)
				->setOrder('date_of_testimonial', 'DESC');

        $collection->getSelect()->limit($limit, $offset);

        return $collection;
    }

    public function getCollectiontest($collection = 'null') {
        if ($collection != 'null') {
            $page = $this->getRequest()->getParam('p');
            if ($page)
                $this->_curPage = $page;

            $collection->setCurPage($this->_curPage);
            $collection->setPageSize($this->_itemPerPage);
            return $collection;
        }
    }
	
		public function getTotalTestimonial()
	{
		$collection = Mage::getModel('testimonial/testimonial')->getCollection()
		->addFieldToFilter('status', '1')
		->setOrder('date_of_testimonial', 'DESC');
		return count($collection);
	}

//    public function getPagerUrl() {   // You need to change this function as per your url.
//        $cur_url = mage::helper('core/url')->getCurrentUrl();
//        $new_url = preg_replace('/\&p=.*/', '', $cur_url);
//
//        return $new_url;
//    }
}
