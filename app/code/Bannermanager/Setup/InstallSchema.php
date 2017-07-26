<?php

namespace Xigen\Bannermanager\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {

	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){

		$setup->startSetup();
		$table = $setup->getConnection()->newTable($setup->getTable('xigen_bannermanager_banner'))
												->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 6, [
																		'unsigned' => true,
																 	 	'identity' => true,
																 	 	'nullable' => false,
																 	 	'primary'  => true,],
																 	 	'Banner id')
								        ->addColumn('title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
												            'nullable' => true,],
												            'Title')
												->addColumn('show_title', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 6, [
																 		'unsigned' => true,
												         		'nullable' => true,
												      			'default'  => '1',],
														 	 			'Show Title')
								        ->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
																		'nullable' => true,
            										 		'default'  => null,],
										            		'Banner image media path')
								        ->addColumn('title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
												            'nullable' => true,],
												            'Title')
												->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, [
																		'nullable' => true,
																		'default'  => null],
																		'Banner image media path')
												->addColumn('link', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, [
																		'nullable' => true,
																		'default'  => null],
																		'Link')
												->addColumn('caption', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, [
																		'nullable' => true,
																		'default'  => null],
																		'Caption')
												->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
																		'nullable' => true,
																		'default'  => 'CURRENT_TIMESTAMP'],
																		'Creation Time')
												->addColumn('slider_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																		'nullable' => true,
																		'default'  => true],
																		'Slider id')
												->addColumn('sort_order', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
																		'nullable' => true,
																		'default'  => null],
																		'Sort Order')
												->addColumn('is_trash', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																		'unsigned' => true,
																		'nullable' => true,
																		'default'  => '0'],
																		'Is trash')
												->addColumn('is_active', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 6, [
																		'unsigned' => true,
												            'nullable' => false,
												            'default'  => '1'],
																		'Is active');

		$setup->getConnection()->createTable($table);
		$setup->endSetup();
	}



}
