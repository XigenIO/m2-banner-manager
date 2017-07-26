<?php
namespace Xigen\Bannermanager\Block\Adminhtml\Banners\Edit;

/**
 * Adminhtml blog post edit form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    protected $adminHelper;
    protected $dataHelper;
    protected $slider_collection;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Xigen\Bannermanager\Helper\Data $dataHelper,
        \Xigen\Bannermanager\Helper\Admin $adminHelper,
        \Xigen\Bannermanager\Model\Resource\Slider\Collection $slider_collection,
        array $data = []
    ) {
        $this->slider_collection = $slider_collection;
        $this->adminHelper = $adminHelper;
        $this->dataHelper = $dataHelper;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_form');
        $this->setTitle(__('Banner Information'));
    }

    protected function getSliderIds(){

      $sliderIds = [];

      $sliders = $this->slider_collection;

      //->addFieldToFilter('is_active', 1)

      foreach ($sliders as $slider) {

        $sliderIds[$slider->getId()] = $slider->getTitle();

      }

      return $sliderIds;

    }//getSliderIds

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Ashsmith\Blog\Model\Post $model */
        $model = $this->_coreRegistry->registry('banner');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'enctype'=>'multipart/form-data', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('main_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Banner Information'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Enable'),
                'title' => __('Enable'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        $fieldset->addField(
            'slider_id',
            'select',
            [
                'label' => __('Slider'),
                'title' => __('Slider'),
                'name' => 'slider_id',
                'required' => true,
                'options' => $this->getSliderIds()
            ]
        );




        $fieldset->addField(
            'image',
            'image',
            [
                'label' => __('Image'),
                'title' => __('Image'),
                'name'  => 'image',
                'type'  => 'image'
            ]
        );




        $fieldset->addField(
            'title',
            'text',
            [
              'name' => 'title',
              'label' => __('Banner Title'), 'title' => __('Banner Title'), 'required' => true]
        );

        $fieldset->addField(
            'show_title',
            'select',
            [
                'label' => __('Show Title?'),
                'title' => __('Show Title?'),
                'name' => 'show_title',
                'required' => true,
                'options' => $this->adminHelper->getYesNo()
            ]
        );

        $fieldset->addField(
            'link',
            'text',
            [
                'name' => 'link',
                'label' => __('URL Key'),
                'title' => __('URL Key'),
                'required' => true,
                //'class' => 'validate-xml-identifier'
            ]
        );

        /*$fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );*/
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField(
            'caption',
            'editor',
            [
                'name' => 'caption',
                'label' => __('Content'),
                'title' => __('Content'),
                'style' => 'height:36em',
                'required' => true
            ]
        );

        if ($model->getId()) {

            if($image = $model->getImage()){

              $imagefieldset = $form->addFieldset(
                  'image_fieldset',
                  ['legend' => __('Image Preview'), 'class' => 'fieldset-wide']
              );

              $mediaUrl = $this->dataHelper->getImageUrl($image);

              $imagefieldset->addField(
                  'preview-image',
                  'note',
                  [
                    'label' => __('Image'),
                    'name' => 'preview-image',
                    'after_element_html' => '<img src="' . $mediaUrl . '" title="' . $mediaUrl . '"/>',
                    'style' => 'display:none'

                  ]
                );


            }

            $fieldset->addField('entity_id', 'hidden', ['name' => 'id']);
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
