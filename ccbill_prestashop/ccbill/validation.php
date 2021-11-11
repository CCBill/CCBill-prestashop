<?php
/**
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement.
*
* You must not modify, adapt or create derivative works of this source code
*
*  @author    CCBill
*  @copyright 2014-2021 CCBill
*  @license   LICENSE.txt
*  @description: CCBill controller
*
*  CCBill principles:
*
*  Step 1: On the payment page/step, the customer
*          clicks the CCBill button which is transmitting a form to CCBill
*  Step 2: The order's parameters are sent to CCBill,  including
*          the billing address to pre-fill a maximum of
*          values/fields for the customer
*  Step 3: At the CCBill form, the customer can proceed to payment
*          by entering payment information (Credit Card)
*  Step 4: The transaction success or failure is sent back from CCBill
*          using the CCBillValidationModuleFrontController controller
*          (Method paymentStandard())
*  This step is also called IPN ("Instant Payment Notification")
*  Step 5: The customer is seeing the payment confirmation on CCBill
*          and is redirected to order confirmation page
*/

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');



class CCBillValidation extends CCBill
{

    public function initContent()
    {
        $this->ccbill = new CCBill();
        $this->paymentStandard();
    }

    private function paymentStandard()
    {
    }
}// end CCBillValidation

$validation = new CCBillValidation();
$validation->initContent();
