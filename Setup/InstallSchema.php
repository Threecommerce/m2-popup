<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('threecommerce_popup')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('3comm_popup')
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                    'ID'
                )
                ->addColumn(
                    'store',
                    Table::TYPE_TEXT,
                        255,
                    ['nullable' => false, 'unsigned' => true],
                    'Store ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Name'
                )
                ->addColumn(
                    'contenuto',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Content'
                )
                ->addColumn(
                    'css',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'css'
                )
                ->addColumn(
                    'mostra_in_pagina',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Show in Page'
                )
                ->addColumn(
                    'timing',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Timing'
                )
                ->addColumn(
                    'mostra_da',
                    Table::TYPE_DATE,
                    null,
                    ['nullable' => true],
                    'Show From Date'
                )
                ->addColumn(
                    'mostra_a',
                    Table::TYPE_DATE,
                    null,
                    ['nullable' => true],
                    'Show To Date'
                )
                ->addColumn(
                    'attivo',
                    Table::TYPE_INTEGER,
                    1,
                    ['nullable' => false, 'default' => '0'],
                    'Active (0/1)'
                )
                ->setComment('Popup Table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
