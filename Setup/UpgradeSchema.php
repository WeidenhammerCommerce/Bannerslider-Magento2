<?php

namespace Magestore\Bannerslider\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '2.0.0') < 0) {

            // Get module table
            $sliderTable = $setup->getTable('magestore_bannerslider_slider');

            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($sliderTable) == true) {

                // Add new field
                $columns = [
                    'website_id' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'website id',
                    ]
                ];
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($sliderTable, $name, $definition);
                }
            }
        }

        if (version_compare($context->getVersion(), '2.0.1') < 0) {

            $bannerTable = $setup->getTable('magestore_bannerslider_banner');
            if ($setup->getConnection()->isTableExists($bannerTable) == true) {
                $columnsBanner = [
                    'tablet_image' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Banner Image for Tablets',
                    ],
                    'mobile_image' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Banner Image for Phones',
                    ],
                    'disclaimer' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Disclaimer',
                    ]
                ];
                $connection = $setup->getConnection();
                foreach ($columnsBanner as $name => $definition) {
                    $connection->addColumn($bannerTable, $name, $definition);
                }
            }
        }

            $setup->endSetup();
    }
}