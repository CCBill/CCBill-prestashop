{*
**  @author CCBill <consumersupport@ccbill.com>
**  @copyright  2014-2021 CCBill
**
**
** Description: CCBill module configuration page
**
** This template is displayed in the Back-office section of your store when you are configuring the CCBill module
** It allows you to enable CCBill on your store and to configure your credentials and preferences
**
*}

<div class="ccbill-module-wrapper">
  <style>
    .ccbill-module-wrap .ccbill-button {
    	text-align:center;
    	text-decoration: none;
    }
    .ccbill-module-wrap .ccbill-button-primary {
    	background-color:#b4d33c;
    	color:#3b433f;
    	min-width:246px;
    	display:inline-block;
    	padding:1em 1em;
    	border:0;
    	cursor:pointer;
    	text-align:center;
    	letter-spacing:.02em;
    	font-size:1.1em;
    	font-family:"Open Sans",sans-serif;
    	border-radius:.25em;
    	box-shadow:0 2px 2px 0 rgba(0,0,0,0.1),0 2px 4px 0 rgba(0,0,0,0.04);
    	text-shadow:0px 1px 1px rgba(0,0,0,0.2);
    	font-weight:bold;
    	text-decoration: none;
    }
    .ccbill-module-wrap .ccbill-main {
    	font-family:'Open Sans',sans-serif;
    	font-size:.9em;
    	padding-left:15px;
    	padding-right:15px;

    	-webkit-flex:1;
    	/* Safari 6.1+*/
    	-ms-flex:1;
    	/* IE 10 */ flex:1;
    	display:flex;
    }
    .ccbill-module-wrap .topBanner {
    	/*width:400px;*/
    	text-align:center;
    	margin-left:auto;
    	margin-right:auto;
    }
    .ccbill-module-wrap .left {
    	float:left;
    }
    .ccbill-module-wrap .right {
    	float:left;
    }
    .ccbill-module-wrap .list {
    	padding-right:15px;
    }
    .ccbill-module-wrap .valueProp {
    	display:flex;
    }
    .ccbill-module-wrap .textValue {
    	padding-left:10px;
    }
    .ccbill-module-wrap .header {
    	text-align:center;
    	padding: 0px 90px 0px 90px;
    }
    .ccbill-module-wrap .clear {
      clear: both;
    }
  </style>
  {if strlen($ccbill_configuration.CCBILL_CLIENT_ACCOUNT_NO) > 0}
	<div class="ccbill-module-wrap">
    <div id="banner">
    	<div class="topBanner" style="text-align:left">
    			<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/logo-theme11.png" width="100"></img>
    	</div>
    </div>
    <div class="ccbill-main">
    	<div class="left">
    		<div class="header" style="font-weight:bold">
    			Accept credit cards, debit cards, online checks, gift cards and bank transfers globally using CCBill – and automate your checkout.
    		</div>
    	</div>
    </div>
    		</br>
    <div class="clear"></div>
	</div>
	{/if}
	{if strlen($ccbill_configuration.CCBILL_CLIENT_ACCOUNT_NO) < 1}
	<div class="ccbill-module-wrap">
    <div id="banner">
    	<div class="topBanner" style="text-align:center">
    			<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/logo-theme11.png"></img>
    	</div>
    </div>
    <div class="ccbill-main">
    	<div class="left">

    		</br>
    		<div class="header" style="font-weight:bold">
    			Accept credit cards, debit cards, online checks, gift cards and bank transfers globally using CCBill – and automate your checkout.
    		</div>
    		</br>
    		<ol>
    			<span style="color:#057DB2;font-weight:bold;font-size:1.4em">1. Start</span> - Complete the form with your business and contact information, and submit to start your CCBill account.</br></br>
    			<span style="color:#057DB2;font-weight:bold;font-size:1.4em">2. Board</span> - Our team of processing experts will contact you to set-up your account for your specific store, and provide 24/7 support and expertise to help you get boarded and processing</br></br>
    			<span style="color:#057DB2;font-weight:bold;font-size:1.4em">3. Sell</span> - Start taking payments from customers worldwide, both online and on mobile.</br></br>
    		</ol>
    		</br>
    		<div class="ccbill-button">
    			<a href="https://www.ccbill.com/online-merchants/channel-partner-form.php?referred_by=PrestaShop&utm_campaign=Integration%20Partner%20Lead%20Modules&utm_medium=Module&utm_source=PrestaShop" class="ccbill-button ccbill-button-primary">Get Started</a>

    		</div>
    	</div>
    	<div class="right">
    		<div class="list">
    			<ul>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Complete Package of Payment Tools</span></br>
    						Merchant account, gateway, software and PCI – in one package.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Easy Access Merchant Processing</span></br>
    						No credit check, deposits or security requirements. Start without the hassle.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Eliminate Buyer Hesitation</span></br>
    						Trusted by millions of buyers worldwide, CCBill is the choice of buyers online for ease and security.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Log in and Pay</span></br>
    						CCBill Pay securely saves customer credit card info for quick access online or on mobile - from anywhere.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Automate your Billing</span></br>
    						From payment automation to live billing support, automate your checkout and manage your business better.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Protect your Business</span></br>
    						Anti-fraud tools and full-time risk expertise are included at no added cost.
    					</div>
    				</div>
    				</br>
    				<div class="valueProp">
    					<div id="arrow">
    						<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/circle-arrow.png"></img>
    					</div>
    					<div class="textValue">
    						<span style="font-weight:bold">Expand Your Sales Globally</span></br>
    						Credit cards, debit cards, prepaid cards, electronic checks, Euro Debit, bank transfers – all offered via smart auto-sensing forms.
    					</div>
    				</div>
    				</br>
    			</ul>
    		</div>
    	</div>
    </div>
    <div class="clear"></div>
	</div>
	{/if}
	{if $ccbill_validation}
		<div class="conf">
			{foreach from=$ccbill_validation item=validation}
				{$validation|escape:'htmlall':'UTF-8'}<br />
			{/foreach}
		</div>
	{/if}
	{if $ccbill_error}
		<div class="error">
			{foreach from=$ccbill_error item=error}
				{$error|escape:'htmlall':'UTF-8'}<br />
			{/foreach}
		</div>
	{/if}
	{if $ccbill_warning}
		<div class="info">
			{foreach from=$ccbill_warning item=warning}
				{$warning|escape:'htmlall':'UTF-8'}<br />
			{/foreach}
		</div>
	{/if}
	<form action="{$ccbill_form_link|escape:'htmlall':'UTF-8'}" method="post" id="ccbill_settings" class="half-form L">
		<fieldset>
			<legend><img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/settings.gif" alt="" /><span>{l s='CCBill Settings' mod='ccbill'}</span></legend>
			<div id="ccbill-basic-settings-table">
				<!--
				<label for="ccbill_enabled">{l s='Enabled:' mod='ccbill'}</label></td>
				<div class="margin-form">
					<select name="ccbill_enabled" class="input-select">
            <option value="1"{if $ccbill_configuration.CCBILL_ENABLED && $ccbill_configuration.CCBILL_ENABLED == 1}{' selected'|escape:'htmlall':'UTF-8'}{/if}>Enabled</option>
            <option value="0"{if $ccbill_configuration.CCBILL_ENABLED && $ccbill_configuration.CCBILL_ENABLED == 0}{' selected'|escape:'htmlall':'UTF-8'}{/if}>Disabled</option>
          </select>
				</div>
				-->
				<label for="ccbill_client_account_no">{l s='Client Account No:' mod='ccbill'}</label></td>
				<div class="margin-form">
					<input type="text" name="ccbill_client_account_no" class="input-text" value="{if $ccbill_configuration.CCBILL_CLIENT_ACCOUNT_NO}{$ccbill_configuration.CCBILL_CLIENT_ACCOUNT_NO|escape:'htmlall':'UTF-8'}{/if}" /> <sup>*</sup>
				</div>
				<label for="ccbill_client_subaccount_no">{l s='Client Subaccount No:' mod='ccbill'}</label></td>
				<div class="margin-form">
					<input type="text" name="ccbill_client_subaccount_no" class="input-text" value="{if $ccbill_configuration.CCBILL_CLIENT_SUBACCOUNT_NO}{$ccbill_configuration.CCBILL_CLIENT_SUBACCOUNT_NO|escape:'htmlall':'UTF-8'}{/if}" /> <sup>*</sup>
				</div>

				<label for="ccbill_salt">{l s='Salt:' mod='ccbill'}</label></td>
				<div class="margin-form">
					<input type="text" name="ccbill_salt" class="input-text" value="{if $ccbill_configuration.CCBILL_SALT}{$ccbill_configuration.CCBILL_SALT|escape:'htmlall':'UTF-8'}{/if}" /> <sup>*</sup>
				</div>
                {if $ccbill_configuration.CCBILL_IS_FLEXFORM == null || $ccbill_configuration.CCBILL_IS_FLEXFORM != 'no'}
				<label for="ccbill_form_name">{l s='Flex Form ID:' mod='ccbill'}</label></td>
                {/if}
                {if $ccbill_configuration.CCBILL_IS_FLEXFORM && $ccbill_configuration.CCBILL_IS_FLEXFORM == 'no'}
				<label for="ccbill_form_name">{l s='Form Name:' mod='ccbill'}</label></td>
                {/if}
				<div class="margin-form">
					<input type="text" name="ccbill_form_name" class="input-text" value="{if $ccbill_configuration.CCBILL_FORM_NAME}{$ccbill_configuration.CCBILL_FORM_NAME|escape:'htmlall':'UTF-8'}{/if}" /> <sup>*</sup>
				</div>


				<label for="ccbill_is_flexform">{l s='Is FlexForm:' mod='ccbill'}</label></td>
				<div class="margin-form">

					<select name="ccbill_is_flexform" class="input-select">
            <option value="no"{if $ccbill_configuration.CCBILL_IS_FLEXFORM && $ccbill_configuration.CCBILL_IS_FLEXFORM == 'no'}{' selected'|escape:'htmlall':'UTF-8'}{/if}>No (Deprecated)</option>
				    <option value="yes"{if $ccbill_configuration.CCBILL_IS_FLEXFORM == null || $ccbill_configuration.CCBILL_IS_FLEXFORM != 'no'}{' selected'|escape:'htmlall':'UTF-8'}{/if}>Yes</option>
          </select>
          <br>
          <i>Note: Only FlexForms will be supported in future versions. Classic forms are deprecated.</i>
				</div>


				<label for="ccbill_currency_code">{l s='Currency Code:' mod='ccbill'}</label></td>
				<div class="margin-form">
					<select name="ccbill_currency_code" class="input-select">
				    <option value="840"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 840}{' selected'|escape:'htmlall':'UTF-8'}{/if}>USD</option>
            <option value="978"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 978}{' selected'|escape:'htmlall':'UTF-8'}{/if}>EUR</option>
            <option value="036"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 036}{' selected'|escape:'htmlall':'UTF-8'}{/if}>AUD</option>
            <option value="124"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 124}{' selected'|escape:'htmlall':'UTF-8'}{/if}>CAD</option>
            <option value="826"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 826}{' selected'|escape:'htmlall':'UTF-8'}{/if}>GBP</option>
            <option value="392"{if $ccbill_configuration.CCBILL_CURRENCY_CODE && $ccbill_configuration.CCBILL_CURRENCY_CODE == 392}{' selected'|escape:'htmlall':'UTF-8'}{/if}>JPY</option>
				  </select>
				  <input id="can_save" name="can_save" type="hidden" value=""/>
				</div>

			</div>
			<div class="margin-form">
				<input type="submit" name="SubmitSettings" class="button" value="{l s='Save settings' mod='ccbill'}" />
			</div>
			<span class="small"><sup style="color: red;">*</sup> {l s='Required fields' mod='ccbill'}</span>
		  <script type="text/javascript">
		    {literal}
		    setTimeout(function(){document.getElementById('can_save').value = "true";}, 2000);
		    {/literal}
		  </script>
		</fieldset>
	</form>
</div>
