<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface {
    private $eavSetupFactory;

    public function __construct( EavSetupFactory $eavSetupFactory ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {
        $eavSetup = $this->eavSetupFactory->create( [ 'setup' => $setup ] );

        if ( version_compare( $context->getVersion(), '2.0.1', '<' ) ) {
            $eavSetup->addAttribute(
                Product::ENTITY,
                'allow_multi_order',
                [
                    'type'                    => 'int',
                    'backend'                 => '',
                    'frontend'                => '',
                    'label'                   => 'Allow Multi-Order',
                    'input'                   => 'boolean',
                    'class'                   => '',
                    'source'                  => Boolean::class,
                    'global'                  => ScopedAttributeInterface::SCOPE_STORE,
                    'visible'                 => true,
                    'required'                => true,
                    'user_defined'            => false,
                    'default'                 => 0,
                    'searchable'              => false,
                    'filterable'              => false,
                    'comparable'              => false,
                    'visible_on_front'        => false,
                    'used_in_product_listing' => true,
                    'is_filterable_in_grid'   => true,
                    'is_used_in_grid'         => true,
                    'is_filterable'           => true,
                    'apply_to'                => 'simple,configurable,virtual,bundle,downloadable'
                ]
            );
        }
    }
}
