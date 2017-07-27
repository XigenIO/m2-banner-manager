<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /*
         * Drop tables if exists
         */
        $installer->getConnection()->dropTable($installer->getTable('xigen_bannermanager_slider'));
        $installer->getConnection()->dropTable($installer->getTable('xigen_bannermanager_banner'));

        /*
         * Create table xigen_bannermanager_slider
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('xigen_bannermanager_slider')
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Slider ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Slider title'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Slider position'
        )->addColumn(
            'show_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => true, 'default' => '1'],
            'Show Title'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true],
            'Store Id'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Slider status'
        )->addColumn(
            'sort_type',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true],
            'Sort type'
        )->addColumn(
            'style_slide',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Slider style'
        )->addColumn(
            'url_view',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Slider url view'
        )->addIndex(
            $installer->getIdxName('xigen_bannermanager_slider', ['position']),
            ['position']
        )->addIndex(
            $installer->getIdxName('xigen_bannermanager_slider', ['style_slide']),
            ['style_slide']
        )->addIndex(
            $installer->getIdxName('xigen_bannermanager_slider', ['status']),
            ['status']
        );
        $installer->getConnection()->createTable($table);
        /*
         * End create table xigen_bannermanager_slider
         */

        /*
         * Create table xigen_bannermanager_banner
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('xigen_bannermanager_banner')
        )->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'show_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => true, 'default' => '1'],
            'Show Title'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Banner name'
        )->addColumn(
            'order_banner',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true, 'default' => 0],
            'Banner order'
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true],
            'Slider Id'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Banner status'
        )->addColumn(
            'click_url',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => ''],
            'Banner click url'
        )->addColumn(
            'target',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true, 'default' => '0'],
            'Banner target'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner image'
        )->addColumn(
            'image_alt',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner image alt'
        )->addColumn(
            'caption',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => true, 'default' => ''],
            'Banner caption'
        )->addIndex(
            $installer->getIdxName('xigen_bannermanager_banner', ['slider_id']),
            ['slider_id']
        )->addIndex(
            $installer->getIdxName('xigen_bannermanager_banner', ['status']),
            ['status']
        );
        $installer->getConnection()->createTable($table);
        
        /*
         * End create table xigen_bannermanager_banner
         */
        
        $installer->endSetup();
    }
}
