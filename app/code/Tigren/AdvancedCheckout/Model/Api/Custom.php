<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */


namespace Tigren\AdvancedCheckout\Model\Api;


use Magento\Checkout\Model\Cart;
use Magento\Quote\Model\QuoteRepository;
use Tigren\AdvancedCheckout\Api\CustomInterface;

class Custom implements CustomInterface {
    protected $cart;
    protected $quoteRepository;



    public function __construct(
        Cart $cart,
        QuoteRepository $quoteRepository
    ) {
        $this->cart = $cart;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @inheritdoc
     */

    public function Deletecart() {
        try {
            $cartId = $this->cart->getQuote()->getId();
            $this->cart->truncate();
            $this->quoteRepository->delete($this->quoteRepository->get($cartId));

            return 'Cart has been cleared.';
        } catch ( \Exception $e ) {
            return $e->getMessage();
        }

    }


}
