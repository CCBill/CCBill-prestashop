<?php
/**
* 2014-2019 CCBill
*
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
*  Description: CCBill payments module
*  @license   LICENSE.txt
* International Registered Trademark & Property of CCBill
*/

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined('_PS_VERSION_')) {
    exit;
}// end if

class CCBill extends PaymentModule
{

    public function __construct()
    {
        $this->name       = 'ccbill';
        $this->version    = '5.2.0';
        $this->author     = 'CCBill';
        $this->className  = 'CCBill';
        $this->tab        = 'payments_gateways';
        $this->module_key = 'cc17be558545b96b063a7cbe8c5ac2b5';
        $this->is_eu_compatible = 1;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->controllers = array('payment', 'validation');

        $this->currencies = true;
        $this->currencies_mode = 'radio';

        parent::__construct();

        // $this->_shop_country = new Country((int)Configuration::get('PS_SHOP_COUNTRY_ID'));
        $this->displayName = 'CCBill';
        $this->description = 'Accept credit card payments using CCBill';
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details?');

        $this->context->smarty->assign('base_dir', __PS_BASE_URI__);
    }// end construct

    /**
     * CCBill installation process:
     *
     * Step 1 - Pre-set Configuration option values
     * Step 2 - Install the module and create a database table to store transaction details
     *
     * @return boolean Installation result
     */
    public function install()
    {
        // Install default
        if (!parent::install()) {
            return false;
        }

        // Create Statuses
        if (!$this->createOrderStatuses()) {
            return false;
        }

        // Registration hook
        if (!$this->registrationHook()) {
            return false;
        }

        if (!Configuration::updateValue('CCBILL_ENABLED', 1)
          || !Configuration::updateValue('CCBILL_TITLE', 'Pay via credit card with CCBill')
          || !Configuration::updateValue('CCBILL_CLIENT_ACCOUNT_NO', '')
          || !Configuration::updateValue('CCBILL_CLIENT_SUBACCOUNT_NO', '')
          || !Configuration::updateValue('CCBILL_SALT', '')
          || !Configuration::updateValue('CCBILL_FORM_NAME', '')
          || !Configuration::updateValue('CCBILL_IS_FLEXFORM', 1)
          || !Configuration::updateValue('CCBILL_CURRENCY_CODE', '')
        ) {
            return false;
        }

        return true;
    }// end install

    /**
     * [registrationHook description]
     * @return [type] [description]
     */
    private function registrationHook()
    {

        if (!$this->registerHook('paymentOptions')
          || !$this->registerHook('paymentReturn')
          || !$this->registerHook('displayAdminOrder')
          || !$this->registerHook('header')
          || !$this->registerHook('displayOrderConfirmation')
          || !$this->registerHook('displayBackOfficeHeader')
          || !$this->registerHook('displayFooterProduct')
        ) {
            return false;
        }// end if

        return true;
    }// end registrationHook

    private function createOrderStatuses()
    {
        if (!(Configuration::get(CCBILL_CONFIG_ORDER_AUTH) > 0)) {
            $orderState = new OrderState();
        } else {
            $orderState = new OrderState((int)Configuration::get(CCBILL_CONFIG_ORDER_AUTH));
        }

        $orderState->name = array();

        foreach (Language::getLanguages() as $language) {
            $orderState->name[$language['id_lang']] = 'Payment authorized CCBill';
        }// end for

        $orderState->module_name = $this->name;
        $orderState->send_email = false;
        $orderState->color = '#337ab7';
        $orderState->hidden = false;
        $orderState->delivery = false;
        $orderState->logable = false;
        $orderState->invoice = false;

        if ($orderState->id > 0) {
            $orderState->save();
            $createOrder = true;
        } else {
            $createOrder = $orderState->add();
        }// end if/else

        if ($createOrder) {
            Configuration::updateValue(CCBILL_CONFIG_ORDER_AUTH, $orderState->id);
        } else {
            return false;
        }// end if/else

        return true;
    }// end createOrderStatuses

    /**
     * CCBill uninstallation process:
     *
     * Step 1 - Remove Configuration option values from database
     * Step 2 - Remove the database containing the transaction details (optional, must be done manually)
     * Step 3 - Uninstall the module
     *
     * @return boolean Uninstallation result
     */
    public function uninstall()
    {
        $keys_to_uninstall = array(
          'CCBILL_ENABLED',
          'CCBILL_TITLE',
          'CCBILL_CLIENT_ACCOUNT_NO',
          'CCBILL_CLIENT_SUBACCOUNT_NO',
          'CCBILL_SALT',
          'CCBILL_FORM_NAME',
          'CCBILL_IS_FLEXFORM',
          'CCBILL_CURRENCY_CODE'
        );

        $result = true;

        foreach ($keys_to_uninstall as $key_to_uninstall) {
            $result &= Configuration::deleteByName($key_to_uninstall);
        }// end foreach

        return $result && parent::uninstall();
    }// end uninstall

    public function getContent()
    {
        /* Loading CSS and JS files */
        // 2013-11-8 add 1.4 support
        if (isset($this->context->controller)) {
            $this->context->controller->addCSS(
                array($this->_path.'views/css/ccbill.css')
            );// end addCSS

            $this->context->controller->addJS(
                array(
                    _PS_JS_DIR_.'jquery/jquery-ui-1.8.10.custom.min.js',
                    $this->_path.'js/ccbill.js'
                )
            );// end addJS
        }// end if

        // Update the configuration option values

        $canSave = Tools::getValue('can_save');

        if (!empty($canSave) && $canSave == "true") {
            $this->saveSettings();

            if (!empty($this->validation)) {
                unset($this->_validation[count($this->validation)-1]);
            }// end if

            // Check that all required fields have been filled
            if (Tools::strlen(Configuration::get('CCBILL_CLIENT_ACCOUNT_NO')) < 6) {
                $this->_error[] = $this->l('Please enter your 6-digit CCBill account number.');
            }// end if

            if (Tools::strlen(Configuration::get('CCBILL_CLIENT_SUBACCOUNT_NO')) < 4) {
                $this->_error[] = $this->l('Please enter your 4-digit CCBill sub account number.');
            }// end if

            if (Tools::strlen(Configuration::get('CCBILL_SALT')) < 6) {
                $this->_error[] = $this->l('Please enter your CCBill salt.');
            }// end if

            if (Tools::strlen(Configuration::get('CCBILL_FORM_NAME')) < 1) {
                $this->_error[] = $this->l('Please enter your CCBill form name.');
            }// end if

            if (Tools::strlen('' . Configuration::get('CCBILL_CURRENCY_CODE')) < 3) {
                $this->_error[] = $this->l('Please enter your CCBill currency code.');
            }// end if
        }// end if

        $cartId = null;

        if ($this->context != null && $this->context->cart != null) {
            $cartId = $this->context->cart->id;
        }// end if

        $this->context->smarty->assign(
            array(
                'ccbill_form_link' => './index.php?tab=AdminModules&configure=ccbill&token='
                                    . Tools::getAdminTokenLite('AdminModules')
                                    . '&tab_module='.$this->tab.'&module_name=ccbill',
                'ccbill_ssl' => Configuration::get('PS_SSL_ENABLED'),
                'ccbill_validation' => (empty($this->_validation) ? false : $this->_validation),
                'ccbill_error' => (empty($this->_error) ? false : $this->_error),
                'ccbill_warning' => (empty($this->_warning) ? false : $this->_warning),
                'ccbill_order_id' => $cartId,
                'ccbill_configuration' => Configuration::getMultiple(
                    array(
                        'CCBILL_CLIENT_ACCOUNT_NO',
                        'CCBILL_CLIENT_SUBACCOUNT_NO',
                        'CCBILL_SALT',
                        'CCBILL_FORM_NAME',
                        'CCBILL_IS_FLEXFORM',
                        'CCBILL_CURRENCY_CODE',
                        'CCBILL_ENABLED'
                    )
                ),
                'ccbill_js_files' => stripcslashes('"'.$this->_path.'js/ccbill.js'.'"')
            )
        );

        return $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
    }// end getContent

    /*
     * CCBill configuration section - Basic settings
     */

    private function saveSettings()
    {
        if (Tools::strlen(Tools::getValue('ccbill_client_account_no')) != 6) {
            $this->_error[] = $this->l('Your CCBill account number is required.');
        }// end if

        if (Tools::strlen(Tools::getValue('ccbill_client_subaccount_no')) != 4) {
            $this->_error[] = $this->l('Your CCBill subaccount number is required.');
        }// end if

        if (Tools::strlen(Tools::getValue('ccbill_salt')) < 1) {
            $this->_error[] = $this->l('Your CCBill salt is required.');
        }// end if

        if (Tools::strlen(Tools::getValue('ccbill_form_name')) < 1) {
            $this->_error[] = $this->l('Your CCBill form name is required.');
        }// end if

        if (Tools::getValue('ccbill_currency_code') < 36) {
            $this->_error[] = $this->l('Your CCBill currency code is required.');
        }// end if

        $canSave = Tools::getValue('can_save');

        if (!empty($canSave) && $canSave == "true") {
            Configuration::updateValue(
                'CCBILL_CLIENT_ACCOUNT_NO',
                pSQL(Tools::getValue('ccbill_client_account_no'))
            );

            Configuration::updateValue(
                'CCBILL_CLIENT_SUBACCOUNT_NO',
                pSQL(Tools::getValue('ccbill_client_subaccount_no'))
            );

            Configuration::updateValue(
                'CCBILL_SALT',
                pSQL(Tools::getValue('ccbill_salt'))
            );

            Configuration::updateValue(
                'CCBILL_FORM_NAME',
                pSQL(Tools::getValue('ccbill_form_name'))
            );

            Configuration::updateValue(
                'CCBILL_IS_FLEXFORM',
                pSQL(Tools::getValue('ccbill_is_flexform'))
            );

            Configuration::updateValue(
                'CCBILL_CURRENCY_CODE',
                pSQL(Tools::getValue('ccbill_currency_code'))
            );
        }// end if

        if (!empty($this->_error) && !count($this->_error)) {
            $this->_validation[] = $this->l('Congratulations, your configuration was updated successfully');
        }// end if
    }// end saveSettings

    public function hookPaymentReturn()
    {
    }// end hookPaymentReturn

    public function hookPaymentOptions()
    {
        $paymentOptions = array();

        $paymentOption = new PaymentOption();

        $actionText = $this->l('Pay with credit card via CCBill');

        $paymentOption->setCallToActionText($actionText)
            ->setForm($this->generateForm());

        $paymentOptions[] = $paymentOption;

        return $paymentOptions;
    }// end hookPaymentOptions


    public function generateForm()
    {
        $html = '';

        if (!($this->context->cart->getOrderTotal(true) > 0)) {
            return "<script type=\"text/javascript\">alert('Invalid amount');</script>";
        }

        /* Display a form/button that will be sent to CCBill with the customer details */
        $billing_address = new Address((int)$this->context->cart->id_address_invoice);
        $billing_address->country = new Country((int)$billing_address->id_country);
        $billing_address->state = new State((int)$billing_address->id_state);


        $mySalt = Configuration::get('CCBILL_SALT');
        $myDigest = '';
        $billingPeriodInDays = 2;
        $myCurrencyCode = Configuration::get('CCBILL_CURRENCY_CODE');

        //$orderTotal = (float)$this->context->cart->getOrderTotal(true);
        $orderTotal = number_format($this->context->cart->getOrderTotal(true), 2, '.', '');

        $stringToHash = '' . $orderTotal
                           . $billingPeriodInDays
                           . $myCurrencyCode
                           . $mySalt;

        $myDigest = md5($stringToHash);

        $formActionUrl    = 'https://bill.ccbill.com/jpost/signup.cgi';
        $formName         = Configuration::get('CCBILL_FORM_NAME');
        $isFlexForm       = Configuration::get('CCBILL_IS_FLEXFORM') != 'no';
        $priceVarName     = 'formPrice';
        $periodVarName    = 'formPeriod';

        if ($isFlexForm) {
            $formActionUrl  = 'https://api.ccbill.com/wap-frontflex/flexforms/'
                            . $formName . '?zc_orderid=' . $this->context->cart->id;
            $priceVarName   = 'initialPrice';
            $periodVarName  = 'initialPeriod';
        }// end if

        $this->context->smarty->assign(array(
            'ccbill_action' => $formActionUrl,
            'ccbill_customer' => $this->context->customer,
            'ccbill_client_account_no' => Configuration::get('CCBILL_CLIENT_ACCOUNT_NO'),
            'ccbill_client_subaccount_no' => Configuration::get('CCBILL_CLIENT_SUBACCOUNT_NO'),
            'ccbill_form_name' => $formName,
            'ccbill_is_flexform' => $isFlexForm,
            'ccbill_currency_code' => Configuration::get('CCBILL_CURRENCY_CODE'),
            'billing_period_in_days' => $billingPeriodInDays,
            'form_price' => $orderTotal,
            'form_digest' => $myDigest,
            'priceVarName' => $priceVarName,
            'periodVarName' => $periodVarName,
            'ccbill_billing_address' => $billing_address,
            'cart' => $this->context->cart,
            'ccbill_total_tax' =>
                (float)$this->context->cart->getOrderTotal(true)
                - (float)$this->context->cart->getOrderTotal(false),
            'ccbill_cancel_url' => $this->context->link->getPageLink('order.php', ''),
            'ccbill_notify_url' => $this->getModuleLink(
                'ccbill',
                'validation',
                array('pps' => 1),
                Configuration::get('PS_SSL_ENABLED')
            ),
            'ccbill_return_url' => /*26/12/2013 fix for Backward compatibilies on confirmation page*/
            version_compare(_PS_VERSION_, '1.5', '<') ?
            (Configuration::get('PS_SSL_ENABLED') ? Tools::getShopDomainSsl(true) : Tools::getShopDomain(true)).
            __PS_BASE_URI__ . 'order-confirmation.php?id_cart='
            . (int)$this->context->cart->id . '&id_module='
            . (int)$this->id.'&key='.$this->context->customer->secure_key :
            $this->context->link->getPageLink(
                'order-confirmation.php',
                null,
                null,
                array(
                    'id_cart' => (int)$this->context->cart->id,
                    'key' => $this->context->customer->secure_key,
                    'id_module' => $this->id
                )
            ),
        ));

        $html .= $this->display(__FILE__, 'views/templates/hook/standard.tpl');

        //}

        return $html;
    }// end hookPayment

    /* CCBill Admin order detail hook
     *
     * @param $params Array Default PrestaShop parameters sent to the hookAdminOrder() method
     *
     * @return HTML content (Template) displaying the Transaction details and Refund form
     */

    public function hookAdminOrder($params)
    {
    }

    /* CCBill Order confirmation hook
     *
     * @param $params Array Default PrestaShop parameters sent to the hookOrderConfirmation() method
     *
     * @return HTML content (Template) displaying a confirmation or error message upon order creation
     */

    public function hookDisplayOrderConfirmation($params)
    {
        $o = null;

        $is17 = version_compare(_PS_VERSION_, '1.7', '>=');

        if (isset($params['order'])) {
            $o = $params['order'];
        }// end if

        if (isset($params['objOrder'])) {
            $o = $params['objOrder'];
        }// end if

        if ($o == null || ($o->module != $this->name)) {
            return false;
        }// end if

        if ($o != null &&
            Validate::isLoadedObject($o) &&
            isset($o->valid) &&
            version_compare(_PS_VERSION_, '1.5', '>=') &&
            isset($o->reference)) {
            $this->smarty->assign(
                'ccbill_order',
                array(
                    'id' => $o->id,
                    'reference' => $o->reference,
                    'valid' => $o->valid
                )
            );

            if ($is17) {
                return $this->context->smarty->fetch('module:ccbill/views/templates/hook/order-confirmation.tpl');
            }// end if

            return $this->display(__FILE__, 'views/templates/hook/order-confirmation.tpl');
        }// end if

        // 2013-11-8 add 1.4 support
        if (isset($params['objOrder']) &&
            Validate::isLoadedObject($params['objOrder']) &&
            isset($params['objOrder']->valid) &&
            version_compare(_PS_VERSION_, '1.5', '<')) {
            $this->smarty->assign(
                'ccbill_order',
                array('id' => $params['objOrder']->id,
                'valid' => $params['objOrder']->valid)
            );

            return $this->display(__FILE__, 'views/templates/hook/order-confirmation.tpl');
        }// end if
    }// end hookOrderConfirmation

    public function getModuleLink($module, $controller = 'default', array $params = array(), $ssl = null)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $link = Tools::getShopDomainSsl(true)._MODULE_DIR_.$module.'/'.$controller.'?'.http_build_query($params);
        } else {
            $link = $this->context->link->getModuleLink($module, $controller, $params, $ssl);
        }// end if/else

        return $link;
    }// end getModuleLink
}// end class
