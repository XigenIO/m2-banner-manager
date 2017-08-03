<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\Banner\Edit\Tab;

use Xigen\Bannermanager\Model\Status;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;

    /**
     * slider factory.
     * @var \Xigen\Bannermanager\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * @var \Xigen\Bannermanager\Model\Banner
     */
    protected $_banner;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    protected $dateTime;
    
    /**
     * Constructor
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\DataObjectFactory $objectFactory
     * @param \Xigen\Bannermanager\Model\Banner $banner
     * @param \Xigen\Bannermanager\Model\SliderFactory $sliderFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $dateTime
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Xigen\Bannermanager\Model\Banner $banner,
        \Xigen\Bannermanager\Model\SliderFactory $sliderFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Framework\Stdlib\DateTime\Timezone $dateTime,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_banner = $banner;
        $this->_sliderFactory = $sliderFactory;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());

        \Magento\Framework\Data\Form::setFieldsetElementRenderer(
            $this->getLayout()->createBlock(
                'Xigen\Bannermanager\Block\Adminhtml\Form\Renderer\Fieldset\Element',
                $this->getNameInLayout().'_fieldset_element'
            )
        );

        return $this;
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $banner = $this->getBanner();

        if ($sliderId = $this->getRequest()->getParam('current_slider_id')) {
            $banner->setSliderId($sliderId);
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix($this->_banner->getFormFieldHtmlIdPrefix());

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Banner Information')]);

        if ($banner->getId()) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);
        }

        $elements = [];
        
        $elements['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Banner Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
            ]
        );
        
        $elements['name'] = $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );
        
        $elements['show_title'] = $fieldset->addField(
            'show_title',
            'select',
            [
                'label' => __('Show Title'),
                'title' => __('Show Title'),
                'name' => 'show_title',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $slider = $this->_sliderFactory->create()->load($sliderId);

        if ($slider->getId()) {
            $elements['slider_id'] = $fieldset->addField(
                'slider_id',
                'select',
                [
                    'label' => __('Slider'),
                    'name' => 'slider_id',
                    'values' => [
                        [
                            'value' => $slider->getId(),
                            'label' => $slider->getTitle(),
                        ],
                    ],
                ]
            );
        } else {
            $elements['slider_id'] = $fieldset->addField(
                'slider_id',
                'select',
                [
                    'label' => __('Slider'),
                    'name' => 'slider_id',
                    'values' => $banner->getAvailableSlides(),
                ]
            );
        }

        $elements['image_alt'] = $fieldset->addField(
            'image_alt',
            'text',
            [
                'title' => __('Alt Text'),
                'label' => __('Alt Text'),
                'name' => 'image_alt',
                'note' => 'Used for SEO',
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig();

        $elements['caption'] = $fieldset->addField(
            'caption',
            'editor',
            [
                'title' => __('Caption'),
                'label' => __('Caption'),
                'name' => 'caption',
                'config' => $wysiwygConfig
            ]
        );

        $elements['click_url'] = $fieldset->addField(
            'click_url',
            'text',
            [
                'title' => __('URL'),
                'label' => __('URL'),
                'name' => 'click_url',
            ]
        );

        $elements['image'] = $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Banner Image'),
                'label' => __('Banner Image'),
                'name' => 'image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );

        $elements['target'] = $fieldset->addField(
            'target',
            'select',
            [
                'label' => __('Target'),
                'name' => 'target',
                'values' => [
                    [
                        'value' => \Xigen\Bannermanager\Model\Banner::BANNER_TARGET_SELF,
                        'label' => __('Same Window'),
                    ],
                    [
                        'value' => \Xigen\Bannermanager\Model\Banner::BANNER_TARGET_PARENT,
                        'label' => __('Parent Window'),
                    ],
                    [
                        'value' => \Xigen\Bannermanager\Model\Banner::BANNER_TARGET_BLANK,
                        'label' => __('New Window'),
                    ],
                ],
            ]
        );
        
        $elements['order_banner'] = $fieldset->addField(
            'order_banner',
            'text',
            [
                'title' => __('Order'),
                'label' => __('Order'),
                'name' => 'order_banner',
            ]
        );

        $form->setValues($banner->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->_coreRegistry->registry('banner');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getBanner()->getId()
            ? __("Edit Banner '%1'", $this->escapeHtml($this->getBanner()->getName())) : __('New Banner');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Banner Information');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Banner Information');
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
