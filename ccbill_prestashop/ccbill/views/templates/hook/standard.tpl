{*
**
**  @author CCBill <consumersupport@ccbill.com>
**  @copyright  2014-2021 CCBill
**
**  Description: CCBill controller
**
*}
<div class="row">
  <div class="col-xs-12 col-md-6" style="padding-left: 50px;">
    <form id="ccBillForm" action="{$ccbill_action|escape:'htmlall':'UTF-8'}" method="post">
    	<p class="payment_module" stlye="text-align: left;">
    	  <a href="javascript:void(0);" onclick="document.getElementById('ccBillForm').submit();">
      		<input type="hidden" name="cmd" value="_cart" />
      		<input type="hidden" name="upload" value="1" />
      		<input type="hidden" name="charset" value="utf8" />

      		<input type="hidden" name="clientAccnum"  value="{$ccbill_client_account_no|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="clientSubacc"  value="{$ccbill_client_subaccount_no|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="currencyCode"  value="{$ccbill_currency_code|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="formName"      value="{$ccbill_form_name|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="{$periodVarName|escape:'htmlall':'UTF-8'}"    value="{$billing_period_in_days|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="{$priceVarName|escape:'htmlall':'UTF-8'}"     value="{$form_price|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="formDigest"    value="{$form_digest|escape:'htmlall':'UTF-8'}" />

      		<input type="hidden" name="customer_fname"  value="{$ccbill_billing_address->firstname|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="customer_lname"  value="{$ccbill_billing_address->lastname|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="address1"        value="{$ccbill_billing_address->address1|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="address2"        value="{$ccbill_billing_address->address2|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="city"            value="{$ccbill_billing_address->city|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="state"           value="{$ccbill_billing_address->state->iso_code|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="zipcode"         value="{$ccbill_billing_address->postcode|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="country"         value="{$ccbill_billing_address->country->iso_code|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="email"           value="{$ccbill_customer->email|escape:'htmlall':'UTF-8'}" />
      		<input type="hidden" name="zc_orderid" value="{$cart->id|intval};{if isset($cart->id_shop)}{$cart->id_shop|intval}{else}0{/if}" />
      		<!-- input type="hidden" name="ccbill_notify_url" value="{$ccbill_notify_url|escape:'htmlall':'UTF-8'}" -->

      		<input type="hidden" name="bn" value="PrestashopUS_Cart" />
      		<input id="ccbill-standard-btn" type="image" name="submit" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/logo.png" alt="{l s='Pay with credit card via CCBill' mod='ccbill'}" style="vertical-align: middle; margin-right: 10px;" />
    	  </a>
    	</p>
    </form>
  </div>
</div>
