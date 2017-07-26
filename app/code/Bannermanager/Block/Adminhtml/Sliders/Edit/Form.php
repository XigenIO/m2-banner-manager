<?php
namespace Xigen\Bannermanager\Block\Adminhtml\Sliders\Edit;

/**
 * Adminhtml blog post edit form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    protected $adminHelper;
    protected $dataHelper;

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
        array $data = []
    ) {
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
        $this->setId('slider_form');
        $this->setTitle(__('Slider Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Ashsmith\Blog\Model\Post $model */
        $model = $this->_coreRegistry->registry('slider');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'enctype'=>'multipart/form-data', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('main_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Slider Information'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('is_active', 'select', [
            'name'     => 'is_active',
            'label'    => __('Enable'),
            'title'    => __('Enable'),
            'required' => true,
            'values'   => $this->adminHelper->getYesNo(),
            'disabled' => 0
        ]);

        $fieldset->addField('title', 'text', [
            'name'     => 'title',
            'label'    => __('Slider Title'),
            'title'    => __('Slider Title'),
            'required' => true,
            'disabled' => 0
        ]);

        $fieldset->addField('show_title', 'select', [
            'name'     => 'show_title',
            'label'    => __('Show Title'),
            'title'    => __('Show Title'),
            'required' => true,
            'values'   => $this->adminHelper->getYesNo(),
            'disabled' => 0
        ]);

        /*$fieldset->addField('style', 'select', array(
            'name'     => 'style',
            'label'    => __('Style'),
            'title'    => __('Style'),
            'required' => true,
            'values'   => $this->bannermanagerAdminHelper->getStyle(),
            'disabled' => $isElementDisabled
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => __('Store View'),
                'title' => __('Store View'),
                'required' => true,
                'values' => $this->storeSystemStore->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => $this->storeManager->getStore(true)->getId(),
            ));
        }*/

      /*  $fieldset->addField('position', 'select', [
            'name'     => 'position',
            'label'    => __('Position'),
            'title'    => __('Position'),
            'required' => true,
            'values'   => $this->adminHelper->getPostion(),
            'disabled' => 0
        ]);*/
        /*
        $fieldset->addField('page', 'select', array(
            'name'     => 'page',
            'label'    => __('Page'),
            'title'    => __('Page'),
            'required' => false,
            'values'   => $this->adminHelper->getPages(),
            'disabled' => 0
        ));
        /*
        $categoryIds = implode(",", $this->catalogResourceModelCategoryCollectionFactory->create()
             ->addFieldToFilter('level', array('gt' => 0))
             ->getAllIds());

        $fieldset->addField('category_id', 'text', array(
            'label'     => __('Categories'),
            'name'      => 'category_id',
            'disabled'  => $isElementDisabled,
            'after_element_html' =>
                '<a id="category_link" href="javascript:void(0)" onclick="toggleMainCategories()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Categories"></a>
                <div  id="categories_check">
                    <a href="javascript:toggleMainCategories(\'checkall\')">Check All</a> / <a href="javascript:toggleMainCategories(\'uncheckall\')">Uncheck All</a>
                </div>
                <div id="main_categories_select" style="display:none"></div>
                <script type="text/javascript">
                function toggleMainCategories(check){
                    var categories_select = $("main_categories_select");
                    if($("main_categories_select").style.display == "none" || (check == "checkall") || (check == "uncheckall")){
                        $("categories_check").style.display ="";
                        var url = "' . $this->getUrl('adminhtml/bannermanager_slider/chooserMainCategories') . '";
                        if(check == "checkall"){
                            $("slider_main_category_id").value = "' . $categoryIds . '";
                        }else if(check == "uncheckall"){
                            $("slider_main_category_id").value = "";
                        }
                        var params = $("slider_main_category_id").value.split(",");
                        var parameters = {"form_key": FORM_KEY,"selected[]":params };
                        var request = new Ajax.Request(url,
                            {
                                evalScripts: true,
                                parameters: parameters,
                                onComplete:function(transport){
                                    $("main_categories_select").update(transport.responseText);
                                    $("main_categories_select").style.display = "block";
                                }
                            });
                        if(categories_select.style.display == "none"){
                            categories_select.style.display = "";
                        }else{
                            categories_select.style.display = "none";
                        }
                    }else{
                        categories_select.style.display = "none";
                        $("categories_check").style.display ="none";
                    }
                };
                </script>'
        ));*/

        $fieldset->addField('sort', 'select', [
            'name'     => 'sort',
            'label'    => __('Sort Type'),
            'title'    => __('Sort Type'),
            'required' => true,
            'values'   => $this->adminHelper->getRandomOrderly(),
            'disabled' => 0
        ]);

        if ($model->getId()) {

            $fieldset->addField('entity_id', 'hidden', ['name' => 'id']);
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
