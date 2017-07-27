<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\Slider\Edit\Tab;

use Xigen\Bannermanager\Model\Status;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    const FIELD_NAME_SUFFIX = 'slider';

    /**
     * @var \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory
     */
    protected $_fieldFactory;

    /**
     * @var \Xigen\Bannermanager\Helper\Data
     */
    protected $_bannermanagerHelper;

    /**
     * Constructor
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Xigen\Bannermanager\Helper\Data $bannermanagerHelper
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Xigen\Bannermanager\Helper\Data $bannermanagerHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_bannermanagerHelper = $bannermanagerHelper;
        $this->_fieldFactory = $fieldFactory;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $slider = $this->getSlider();
        $isElementDisabled = true;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        /*
         * declare dependence
         */
        // dependence block
        $dependenceBlock = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Form\Element\Dependence'
        );

        // dependence field map array
        $fieldMaps = [];

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Group Information')]);

        if ($slider->getId()) {
            $fieldset->addField('slider_id', 'hidden', ['name' => 'slider_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );
        
        $fieldMaps['store_ids'] = $fieldset->addField(
            'store_id',
            'multiselect',
            [
                'name'     => 'store_ids',
                'label'    => __('Store Views'),
                'title'    => __('Store Views'),
                'required' => true,
                'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
                'disabled' => false,
            ]
        );

        $fieldMaps['show_title'] = $fieldset->addField(
            'show_title',
            'select',
            [
                'label' => __('Show Title'),
                'title' => __('Show Title'),
                'name' => 'show_title',
                'options' => Status::getAvailableStatuses(),
                'disabled' => false,
            ]
        );

        $fieldMaps['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Slider Status'),
                'title' => __('Slider Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
                'disabled' => false,
            ]
        );

        $fieldMaps['style_slide'] = $fieldset->addField(
            'style_slide',
            'select',
            [
                'label' => __('Select Slider Mode'),
                'name' => 'style_slide',
                'values' => $this->_bannermanagerHelper->getStyleSlider(),
            ]
        );

        $fieldMaps['sort_type'] = $fieldset->addField(
            'sort_type',
            'select',
            [
                'label' => __('Sort type'),
                'name' => 'sort_type',
                'values' => [
                    [
                        'value' => \Xigen\Bannermanager\Model\Slider::SORT_TYPE_RANDOM,
                        'label' => __('Random'),
                    ],
                    [
                        'value' => \Xigen\Bannermanager\Model\Slider::SORT_TYPE_ORDERLY,
                        'label' => __('Orderly'),
                    ],
                ],
            ]
        );

        $fieldMaps['position'] = $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Position'),
                'title' => __('Position'),
                'values' => $this->_bannermanagerHelper->getBlockIdsToOptionsArray(),
            ]
        );

        /*
         * Add field map
         */
        foreach ($fieldMaps as $fieldMap) {
            $dependenceBlock->addFieldMap($fieldMap->getHtmlId(), $fieldMap->getName());
        }

        /*
         * add child block dependence
         */
        $this->setChild('form_after', $dependenceBlock);

        $defaultData = [
            'width' => 400,
            'height' => 200,
        ];

        if (!$slider->getId()) {
            $slider->setStatus($isElementDisabled ? Status::STATUS_ENABLED : Status::STATUS_DISABLED);
            $slider->addData($defaultData);
        }

        if ($slider->hasData('position')) {
            $slider->setPositionCustom($slider->getPosition());
        }

        $form->setValues($slider->getData());
        $form->addFieldNameSuffix(self::FIELD_NAME_SUFFIX);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    /**
     * get dependency field.
     * @return Magento\Config\Model\Config\Structure\Element\Dependency\Field 
     */
    public function getDependencyField($refField, $negative = false, $separator = ',', $fieldPrefix = '')
    {
        return $this->_fieldFactory->create(
            ['fieldData' => ['value' => (string)$refField, 'negative' => $negative, 'separator' => $separator], 'fieldPrefix' => $fieldPrefix]
        );
    }

    public function getSlider()
    {
        return $this->_coreRegistry->registry('slider');
    }

    public function getPageTitle()
    {
        return $this->getSlider()->getId() ? __("Edit Slider '%1'", $this->escapeHtml($this->getSlider()->getTitle())) : __('New Group');
    }

    /**
     * Prepare label for tab.
     * @return string
     */
    public function getTabLabel()
    {
        return __('Group Information');
    }

    /**
     * Prepare title for tab.
     * @return string
     */
    public function getTabTitle()
    {
        return __('Group Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
