<?php
declare(strict_types=1);

namespace Magelearn\DynamicPageList\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

class CmsPageOptions extends Select
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        $this->setClass('required-entry validate-select');
        if (!$this->getOptions()) {
            $this->setOptions($this->getCmsPageOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get CMS pages options
     *
     * @return array
     */
    private function getCmsPageOptions(): array
    {
        $collection = $this->collectionFactory->create();
        $options = [];
        
        $options[] = ['label' => __('-- Please Select --'), 'value' => ''];
        
        foreach ($collection as $page) {
            $options[] = [
                'label' => $page->getTitle(),
                'value' => $page->getId()
            ];
        }
        
        return $options;
    }
}