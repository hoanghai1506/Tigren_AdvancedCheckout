<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */


namespace Tigren\AdvancedCheckout\Model\Api;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Checkout\Model\Session;
use Magento\Checkout\Model\Cart;

class CheckAllowOrder {
    protected $_resource;
    protected $_productRepository;
    protected $_searchCriteriaBuilder;

    protected $checkoutSession;

    protected $cart;

    public function __construct(
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Checkout\Model\Session $checkoutSession,
        Cart $cart
    ) {
        $this->checkoutSession       = $checkoutSession;
        $this->productRepository     = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->cart                  = $cart;
    }

    public function CheckAllowOrder( $productId ) {
        // check product in cart
//        $objectManager   = \Magento\Framework\App\ObjectManager::getInstance();

        $searchCriteria  = $this->searchCriteriaBuilder
            ->addFilter( 'entity_id', $productId )
            ->create();
        $product         = $this->productRepository->getList( $searchCriteria )->getItems();
        $product         = array_values( $product );
        $product         = $product[0]->getData( 'allow_multi_order' );
        $productInCart   = false;
        $quote = $this->checkoutSession->getQuote();
        $cartItems = $quote->getAllVisibleItems();
        foreach ( $cartItems as $item ) {
            if ( $item->getProductId() == $productId ) {
                $productInCart = true;
                break;
            }
        }
        if ( $productInCart === true ) {
            return true;
        } else {
            if ( $product == 1 ) {
                return true;
            } else {
                return false;
            }
        }
    }
}
