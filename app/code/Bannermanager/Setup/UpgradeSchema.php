<?php

namespace Xigen\Bannermanager\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface {

	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context){

		$setup->startSetup();


		if(version_compare($context->getVersion(), '0.0.3', '<')) {

			$table = $setup->getConnection()->newTable($setup->getTable('xigen_bannermanager_slider'))
																													->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																														'unsigned' => true,
																														'identity' => true,
																														'nullable' => false,
																														'primary'  => true,
																													], 'Slider id')
																													->addColumn('title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																														'nullable' => true,
																													], 'Slider name')
																													->addColumn('style', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																														'nullable' => true,
																													], 'Slider Style')
																													->addColumn('show_title', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																														'unsigned' => true,
																														'nullable' => true,
																														'default'  => 1,
																													], 'Show Title')
																													->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																														'default'  => 0,
																														'nullable' => false,
																													], 'Sort order')
																													->addColumn('sort', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																														'nullable' => true,
																													], 'Sort order')
																													->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
																														'nullable' => true,
																														'default'  => 'CURRENT_TIMESTAMP',
																													], 'Creation time')
																													->addColumn('is_trash', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																														'unsigned' => true,
																														'nullable' => true,
																														'default'  => 0,
																													], 'Is Trash')
																													->addColumn('category_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																													        'nullable' => true,
																													        'default' => null,
																													    ], 'Category Id')
																													->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																																	'nullable' => true,
																													     		'default' => null,
																													     ], 'Position')
																													->addColumn('page', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																													        'nullable' => true,
																													        'default' => null,
																													    	], 'Page')
																													->addColumn('is_active', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																														'unsigned' => true,
																														'nullable' => false,
																														'default'  => '1',
																													], 'Is active');

			$setup->getConnection()->addColumn($setup->getTable('xigen_bannermanager_banner'),
																													    'youtube',
																													    [
																													        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255,
																													        'nullable' => true,
																													        'default' => null,
																													        'comment' => 'Youtube'
																													    ]
																													);


			$setup->getConnection()->createTable($table);

		}

		$setup->endSetup();
	}



}
