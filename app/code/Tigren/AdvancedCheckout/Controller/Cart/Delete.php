<?php

namespace Tigren\AdvancedCheckout\Controller\Cart;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

use Magento\Quote\Api\CartRepositoryInterface;
class Delete extends Action{
    private $cart;
    private $cartRepository;
    public function __construct(
        Context $context,
        Session $checkoutSession,
        CartRepositoryInterface $cartRepository,
        Cart $cart,
    ) {

        $this->cart            = $cart;
        $this->cartRepository  = $cartRepository;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context);

    }
    public function execute()
    {
        $customerId = $this->getRequest()->getParam('customer_id');
//        dd($customerId);
        $cart = $this->cartRepository->getForCustomer($customerId);

        if ($cart->getId()) {
            $this->cart->truncate();
            $this->cart->save();
            $this->messageManager->addSuccessMessage(__('Customer cart has been deleted.'));
        } else {
            $this->messageManager->addErrorMessage(__('Customer cart not found.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }
}
