{*
**
**  @author CCBill <consumersupport@ccbill.com>
**  @copyright  2014-2021 CCBill
**
**  Description: CCBill controller
**
*}
{if $ccbill_order.valid == 1}
<div class="conf confirmation">
	{l s='Congratulations! Your payment is pending verification, and your order has been saved under' mod='ccbill'}{if isset($ccbill_order.reference)} {l s='the reference' mod='ccbill'} <b>{$ccbill_order.reference|escape:'htmlall':'UTF-8'}</b>{else} {l s='the ID' mod='ccbill'} <b>{$ccbill_order.id|escape:'htmlall':'UTF-8'}</b>{/if}.
</div>
{else}
<div class="error">
	{l s='Unfortunately, an error occurred during the transaction.' mod='ccbill'}<br /><br />
	{l s='Please double-check your credit card details and try again. If you need further assistance, feel free to contact us anytime.' mod='ccbill'}<br /><br />
{if isset($ccbill_order.reference)}
	({l s='Your Order\'s Reference:' mod='ccbill'} <b>{$ccbill_order.reference|escape:'htmlall':'UTF-8'}</b>)
{else}
	({l s='Your Order\'s ID:' mod='ccbill'} <b>{$ccbill_order.id|escape:'htmlall':'UTF-8'}</b>)
{/if}
</div>
{/if}