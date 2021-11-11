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
*/

class CCBillValidationModuleFrontController extends ModuleFrontController
{
    /**
    * @see FrontController::initContent()
    */
    public function initContent()
    {
        $this->ccbill = new CCBill();
        parent::initContent();
        $this->paymentStandard();
    }// end initContent

    private function log($message)
    {
        $logIsActive = false;

        if (!$logIsActive) {
            return false;
        }// end if/else

        if (!isset($this->logWritten)) {
            $this->logWritten = true;
            file_put_contents(
                "ccbill_log.txt",
                "\r\n\r\n\r\n=============== " . date("Y-m-d | h:i:sa") . " ==========\r\n\r\n",
                FILE_APPEND
            );
        }// end if

        file_put_contents("ccbill_log.txt", "\r\n" . $message, FILE_APPEND);
    }// end log

    private function getQsv($name)
    {
        $rVal = '';

        // $usePost = true; // this will always be true in production

        // if ($usePost) {
        //if (Tools::getValue($name)) {
            $rVal = Tools::getValue($name);
        //}// end if
        // } else {
        //    if ($_GET[$name] != null) {
        //        $rVal = $_GET[$name];
        //    }// end if
        // }// end if/else

        return $rVal;
    }// end getQsv

    private function responseDigestIsValid($subscriptionId, $responseDigest, $isFlexForm)
    {
        if (Tools::strlen($subscriptionId . '') < 1 || Tools::strlen($responseDigest . '') < 1) {
            return false;
        }// end if

        $salt = Configuration::get('CCBILL_SALT');

        $debugString = "\r\nattempting to validate response digest.  " .
            "subscriptionId: " . $subscriptionId . "; " .
            "responseDigest: " . $responseDigest . "; " .
            "isFlexForm: " . $isFlexForm . "; ";

        // If using FlexForms, remove leading zeroes from subscription id before computing the hash
        if ($isFlexForm) {
            $subscriptionId = ltrim($subscriptionId, '0');
        }// end if

        $stringToHash = $subscriptionId . 1 . $salt;

        $myDigest = md5($stringToHash);

        $debugString .= "trimmed subscriptionId: " . $subscriptionId . "; " .
            "myDigest: " . $myDigest . "; ";

        $this->log($debugString);

        if ($myDigest == $responseDigest) {
            return true;
        }// end if

        return false;
    }// end responseDigestIsValid

    private function paymentStandard()
    {
        $this->log("paymentStandard begin");

        $context = Context::getContext();

        $success = false;

        $qAction = Tools::getValue('Action');

        $isFlexForm       = Configuration::get('CCBILL_IS_FLEXFORM') == 'yes';

        $qSubscriptionId = Tools::getValue('subscription_id');

        $qResponseDigest = Tools::getValue('responseDigest');

        $this->log("qAction:" . $qAction);
        $this->log("subscription ID length:" . Tools::strlen($qSubscriptionId . ''));

        if ((!empty($qAction) && $qAction == 'Approval_Post') ||
            Tools::strlen($qSubscriptionId . '') > 0) {
            // Validate the response digest
            $success = $this->responseDigestIsValid($qSubscriptionId, $qResponseDigest, $isFlexForm);
        }// end if
        /*
        $myLogMessage = 'HTTP VARS: ';

        $keys = array_keys($_POST);

        foreach ($keys as &$key) {
            $myLogMessage .= $key . ' = ' . Tools::getValue($key) . '; ';
        }// end while

        PrestaShopLogger::addLog($myLogMessage, 1);
        */
        /*
        * Step 2 - Check the "custom" field returned by
        * CCBill (it should contain both the
        * Cart ID and the Shop ID, e.g. "42;1")
        */
        $zcOrderId = $this->getQsv('zc_orderid');

        $successText = "failure";

        if ($success) {
            $successText = "success";
        }// end if

        $this->log("zcOrderId:" . $zcOrderId);
        $this->log("success:" . $successText);

        $context = Context::getContext();
        $shop = -1;

        if (strpos($zcOrderId, ';') > 0) {
            $custom = explode(';', $zcOrderId);

            $zcOrderId = $custom[0];
            $shop = new Shop((int)$custom[1]);
            $context->shop = $shop;
        }// end if

        $errors = array();

        // PrestaShopLogger::addLog('zcOrderId = ' . $zcOrderId, 1);

        if (!isset($zcOrderId)) {
            PrestaShopLogger::addLog('Invalid value for the "custom" field', 1);
            $errors[] = $this->ccbill->l('Invalid value for the "custom" field');
        } else {
            // PrestaShopLogger::addLog('OK', 1);

            /*
            * Step 3 - Check the shopping cart, the currency used
            * to place the order and the amount really
            * paid by the customer
            */


            $cart = new Cart((int)$zcOrderId);
            $context->cart = $cart;

            if (!Validate::isLoadedObject($cart)) {
                $errors[] = $this->ccbill->l('Invalid Cart ID');
            } else {
                $totalAmount = $context->cart->getOrderTotal(true);

                $ccbillTotalAmount = $this->getQsv('initialPrice');

                $this->log("totalAmount:" . $totalAmount);
                $this->log("ccbillTotalAmount:" . $ccbillTotalAmount);
/*
                // Ensure the cart amount matches the billed amount
                if (((float)$totalAmount) != ((float)$ccbillTotalAmount)) {
                    PrestaShopLogger::addLog('Invalid amount', 1);
                    $errors[] = $this->ccbill->l('Invalid amount');
                } else {
*/
                if ($success) {
                    $order_status = Configuration::get('PS_OS_PAYMENT');

                    // Create an order if it doesn't already exist
                    if ($cart->OrderExists()) {
                        $this->log("Order exists");
                        $this->log("A");

                        $order = new Order((int)Order::getOrderByCartId($cart->id));

                        if ($order->current_state == $order_status) {
                            $this->log("No status update necessary");
                        } else {
                            $this->log("Updating existing order status");

                            $new_history = new OrderHistory();
                            $new_history->id_order = (int)$order->id;
                            $new_history->changeIdOrderState((int)$order_status, $order, true);
                            $new_history->addWithemail(true);
                        }// end if/else
                    } else {
                        $this->log("B");

                        $customer = new Customer((int)$cart->id_customer);
                        $context->customer = $customer;

                        if ($this->ccbill->validateOrder(
                            (int)$cart->id,
                            (int)Configuration::get('CCBILL_CONFIG_ORDER_AUTH'),
                            (float)$ccbillTotalAmount,
                            $this->ccbill->displayName,
                            null,
                            array('transaction_id' => $qSubscriptionId),
                            null,
                            false,
                            $customer->secure_key
                        )) {
                            $this->log("Order validated");

                            $newOrderId = (int)Order::getOrderByCartId((int)$cart->id);

                            $order = new Order($newOrderId);

                            $this->log("New Order: " . json_encode($order));

                            $new_history = new OrderHistory();
                            $new_history->id_order = (int)$order->id;
                            $new_history->changeIdOrderState((int)$order_status, $order, true);
                            $new_history->addWithemail(true);
                        } else {
                            $this->log("Order not validated");
                        }// end if/else
                    }// end if order exists for cart
                } else {
                    $order_status = Configuration::get('PS_OS_ERROR');
                }// end if/else success
                /* Important: we need to send back "OK" to CCBill */
            }// end if/else
        }
        die('OK');
    }// end paymentStandard
}// end class
