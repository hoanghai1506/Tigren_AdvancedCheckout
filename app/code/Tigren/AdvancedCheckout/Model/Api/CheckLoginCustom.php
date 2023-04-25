<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */




namespace Tigren\AdvancedCheckout\Model\Api;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Controller\Result\JsonFactory as JsonResultFactory;
use Magento\Customer\Model\Session as CustomerSession;
class CheckLoginCustom {
    protected $context;
    protected $accountManagement;
    protected $jsonResultFactory;
    protected $customerSession;

    public function __construct(
        Context $context,
        AccountManagementInterface $accountManagement,
        JsonResultFactory $jsonResultFactory,
        CustomerSession $customerSession
    ) {
        $this->context = $context;
        $this->accountManagement = $accountManagement;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->customerSession = $customerSession;
    }

    public function CheckLoginCustom($username , $password)
    {

        try {
            // Try to authenticate the customer
            $customer = $this->accountManagement->authenticate($username, $password);
            if ($customer) {
               return 'User is logged in.';
            } else {
                return 'User is not logged in.';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
