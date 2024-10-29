<?php

declare(strict_types=1);

namespace Magelearn\DynamicPageList\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class DynamicRows extends AbstractFieldArray
{
    /**
     * @var CmsPageOptions
     */
    private $cmsPageRenderer;
    
    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('cms_page', [
            'label' => __('CMS Page'),
            'renderer' => $this->getCmsPageRenderer()
        ]);
        $this->addColumn('custom_text', [
            'label' => __('Custom Text'),
            'class' => 'required-entry'
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Row');
    }
    
    /**
     * Get CMS Page renderer
     *
     * @return CmsPageOptions
     * @throws LocalizedException
     */
    private function getCmsPageRenderer()
    {
        if (!$this->cmsPageRenderer) {
            $this->cmsPageRenderer = $this->getLayout()->createBlock(
                CmsPageOptions::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
                );
        }
        return $this->cmsPageRenderer;
    }
    
    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizException
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $options = [];
        $cmsPage = $row->getCmsPage();
        if ($cmsPage) {
            $options['option_' . $this->getCmsPageRenderer()->calcOptionHash($cmsPage)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}