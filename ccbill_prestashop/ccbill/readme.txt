=== Plugin Name ===
Contributors: CCBill
Tags: CCBill, payment, gateway, PrestaShop

Accept CCBill payments on your PrestaShop website.

== Description ==

The CCBill payment gateway plugin for PrestaShop allows you to easily configure and accept CCBill payments on your PrestaShop web store.  This module is compatible with Prestashop 1.7+.

== Installation ==

Installation involves the following steps:
* Copying the CCBill module files into your PrestaShop installation
* Configuring your CCBill account for use with PrestaShop
* Configuring the module with your CCBill account information

** Installing via File Upload**

The CCBill PrestaShop module is installed by uploading ccbill.zip via the Prestashop module upload interface.
  
In the left menu of your PrestaShop admin interface, hover over "Modules" and select "Modules and Services."  Select "Upload a Module" near the top and select ccbill.zip.

When the upload is complete, a confirmation message will display, along with a link to configure the module options.


**Configuring your CCBill Account**

Before using the plugin, it’s necessary to configure a few things in your CCBill account.  
Please ensure the CCBill settings are correct, or the payment module will not work.

**Enabling Dynamic Pricing**

Please work with your CCBill support representative to activate "Dynamic Pricing" for your account.  
You can verify that dynamic pricing is active by selecting "Feature Summary" under the 
"Account Info" tab of your CCBill admin menu.  Dynamic pricing status appears at the 
bottom of the "Billing Tools" section.

**Creating a Salt / Encryption Key**

A "salt" is a string of random data used to make your encryption more secure.  
You must contact CCBill Support to generate your salt.  Once set, it will be 
visible under the "Advanced" section of the "Sub Account Admin" menu.  It will 
appear in the "Encryption Key" field of the "Upgrade Security Setup Information" 
section.

**Disabling User Management**

Since this account will be used for dynamic pricing transactions rather than 
managing user subscription, user management must be disabled.
In your CCBill admin interface, navigate to "Sub Account Admin" and select 
"User Management" from the left menu.  
Select "Turn off User Management" in the top section.  
Under "Username Settings," select "Do Not Collect Usernames and Passwords."

**Creating a New Billing Form**

The billing form is the CCBill form that will be displayed to customers after 
they choose to check out using CCBill.  The billing form accepts customer 
payment information, processes the payment, and returns the customer to your 
PrestaShop store where a confirmation message is displayed.

*Important*
CCBill provides two types of billing forms.  FlexForms is our newest (and recommended) system, but standard forms are still supported.  Please choose a form type and proceed according to the section for Option 1 or Option 2, according to your selection.

**Option 1: Creating a New Billing Form - FlexForms**
Note: Skip this section if using standard forms

To create a FlexForm form for use with Prestashop, first ensure "all" is selected in the top Client Account dropdown.   FlexForms are not specific to sub accounts, and cannot be managed when a sub account is selected.

Navigate to the FlexSystems tab in the top menu bar and select "FlexForms Payment Links."  All existing forms will be displayed in a table.

Click the "Add New" button in the upper-left to create a new form.

The New Form dialog displays.  

*Payment Flow Name*
At the top, enter a name for the new payment flow (this will be different than the form name, as a single form can be used in multiple flows).  

*Form Name*
Under Form Name, enter a name for the form.

*Dynamic Pricing*
Under Pricing, check the box to enable dynamic pricing.

*Layout*
Select your desired layout, and save the form.

*Edit the Flow*
Click the arrow button to the left of your new flow to view the details.

Under the green Approve arrow, click the square to modify the action.

*Approval URL*
In the left menu, select "A URL."

Select "Add A New URL" and enter the base URL for your Prestashop store, followed by: 

/order-confirmation

For example, if your Prestashop store is located at http://www.test.com, the Approval URL would be:

http://www.test.com/order-confirmation

*URL Name*
Enter a name for this URL.  This should be a descriptive name such as "Prestashop Checkout Success."

*Redirect Time*
Select a redirect time of 1 second using the slider at the bottom and save the form.

*Promote to Live*
Click the "Promote to Live" button to enable your new form to accept payments.

*Note the Flex ID*
Make note of the Flex ID: this value will be entered into the form name when completing the configuration in Prestashop.

** WebHooks (FlexForms Only) **
Note: Skip this section if using standard forms

As a final step for configuring a FlexForm, select the sub account to be used with Prestashop from the top Client Account dropdown.  

Navigate to the Account Info tab in the top menu bar and select "Sub Account Admin."

Select "Webhooks" from the left menu, then select "Add" to add a new webhook.

*Webhook Succes URL*
Under Webhook URL, enter the base URL for your store, followed by: 

/module/ccbill/validation?Action=Approval_Post

For example, if your store is located at http://www.test.com, the Approval URL would be:

http://www.test.com/module/ccbill/validation?Action=Approval_Post

Select "NewSaleSuccess," then click the Update button to save the Webhook information.

*Webhook Failure URL*
Under Webhook URL, enter the base URL for your store, followed by: 

/module/ccbill/validation?Action=Denial_Post

For example, if your store is located at http://www.test.com, the Approval URL would be:

http://www.test.com/module/ccbill/validation?Action=Denial_Post

Select "NewSaleFailure," then click the Update button to save the Webhook information.

*Skip to "Configuration - Prestashop"*
Your CCBill FlexForms configuration is now complete.  

Please skip directly to the section titled "Configuration - Prestashop."

**Option 2: Creating a New Billing Form - Standard Forms**
Note: Skip this section if using FlexForms

To create a billing form for use with PrestaShop, navigate to the "Form Admin" 
section of your CCBill admin interface.  All existing forms will be displayed 
in a table.

Click "Create New Form" in the left menu to create your new form.

Select the appropriate option under "Billing Type."  (In most cases, this will 
be "Credit Card.")

Select "Standard" under "Form Type" unless you intend to customize your form.

Select the desired layout, and click "Submit" at the bottom of the page.

Your new form has been created, and is visible in the table under "View All Forms."  
In this example, our new form is named "201cc."  Be sure to note the name of 
your new form, as it will be required in the PrestaShop configuration section.


**Configuring the New Billing Form**

Click the title of the newly-created form to edit it.  In the left menu, 
click "Basic."

Under "Basic," select an Approval Redirect Time of 3 seconds, and a 
Denial Redirect Time of "Instant."


**Configuring Your CCBill Account**

In your CCBill admin interface, navigate to "Sub Account Admin" and select "Basic" from the left menu.  
Site Name

Enter the URL of your PrestaShop store under "Site Name"

*Approval URL*
Under Approval URL, enter the base URL for your PrestaShop store, followed by: 

/order-confirmation

For example, if your PrestaShop store is located at http://www.test.com, the Approval URL would be:

http://www.test.com/order-confirmation

*Denial URL*
Under Denial URL, enter the base URL for your PrestaShop store, followed by: 

/order-history

For example, if your PrestaShop store is located at http://www.test.com, the Denial URL would be:

http://www.test.com/order-history

*Redirect Time*
Select an approval redirect time of 3 seconds, and a denial redirect time of "None."

*Background Post*
While still in the "Sub Account Admin" section, select "Advanced" from the left menu.  Notice the top section titled "Background Post Information."  We will be modifying the Approval Post URL and Denial Post URL fields.

*Approval Post URL*
Under Approval Post URL, enter the base URL for your PrestaShop store, followed by: 

/module/ccbill/validation?Action=Approval_Post

For example, if your PrestaShop store is located at http://www.test.com, the Approval URL would be:

http://www.test.com/module/ccbill/validation?Action=Approval_Post

**Denial Post URL**
Under Denial Post URL, enter the base URL for your PrestaShop store, followed by: 

/module/ccbill/validation?Action=Denial_Post

For example, if your PrestaShop store is located at http://www.test.com, the Denial URL would be:

http://www.test.com/module/ccbill/validation?Action=Denial_Post

**Confirmation**

Your CCBill account is now configured. In your CCBill admin interface, navigate to "Sub Account Admin" and ensure the information displayed is correct.


**Configuration - Prestashop**

In the left menu of your PrestaShop admin interface, hover over "Modules" and select "Modules and Services."  Select "Installed Modules" from the top menu.  Scroll down to located the CCBill module and select "Configure."  The module options display.

**CCBill Options**

*Client Account Number*
Enter your CCBill client account number.

*Client SubAccount Number*
Enter your CCBill client sub-account number.

*Form Name*
Enter the name of the form created during CCBill account configuration, or FlexForm ID if using FlexForms.

*Is FlexForm*
Select "Yes" if using FlexForms.

*Currency*
Select the billing currency.  Ensure this selection matches the selection made in the "Localization -> Currencies" section of the PrestaShop administration menu.

*Salt*
Enter your salt / encryption key obtained during CCBill configuration.
Click "Update" at the bottom of the CCBill configuration section.  

**Confirmation**

You are now ready to process payments via CCBill!  Please conduct a few test transactions (using test data provided by CCBill) to ensure proper operation before enabling live billing mode in your CCBill account.



== Changelog ==

= 5.0.0 =
* Support for Prestashop 1.7

= 1.1.0 =
* Added support for FlexForms

= 1.0 =
* Initial Release

