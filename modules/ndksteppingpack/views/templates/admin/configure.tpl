{*
*  Tous droits réservés NDKDESIGN
*
*  @author    Hendrik Masson <postmaster@ndk-design.fr>
*  @copyright Copyright 2013 - 2017 Hendrik Masson
*  @license   Tous droits réservés
*}

<prestashop-accounts></prestashop-accounts>
<div id="ps-billing"></div>
<div id="ps-modal"></div>
<div id="prestashop-cloudsync"></div>
{if $accountIsLinked}
<div class="panel" id="module-config">
	<h3><i class="icon icon-credit-card"></i> {l s='Ndk Stepping Pack' mod='ndksteppingpack'}</h3>
	<h4><i class="icon icon-tags"></i> {l s='List your packs' mod='ndksteppingpack'}</h4>
	<p>
		{l s='Here is an url to list your packs' mod='ndksteppingpack'} <br/>
		{l s='You can add it to your menu or to a banner to promote it.' mod='ndksteppingpack'}<br/>
		<a class="button" target="_blank" href="{$base_url|escape:'htmlall':'UTF-8'}index.php?fc=module&module=ndksteppingpack&controller=list">{$base_url|escape:'htmlall':'UTF-8'}index.php?fc=module&module=ndksteppingpack&controller=list</a>
	</p>
	<br/><br/>
	<h4><i class="icon icon-tags"></i> {l s='Purge unused packs' mod='ndksteppingpack'}</h4>
	<p>
		{l s='Here is an url to purge unused packs' mod='ndksteppingpack'} <br/>
		{l s='It will delete products and customization generated by module, which have not been ordered, and older than 3 days' mod='ndksteppingpack'}<br/>
		{l s='You can add it to your crontab to automate the process' mod='ndksteppingpack'}
		<a class="button" target="_blank" href="{$base_url|escape:'htmlall':'UTF-8'}/modules/ndksteppingpack/purgeVirtualsProducts.php">{$base_url|escape:'htmlall':'UTF-8'}/modules/ndksteppingpack/purgeVirtualsProducts.php</a>
	</p>
	<br/><br/>
</div>
{/if}

<script src="{$urlAccountsCdn|escape:'htmlall':'UTF-8'}" rel=preload></script>
<script src="{$urlBilling|escape:'htmlall':'UTF-8'}" rel=preload></script>
<script src="{$urlCloudsync|escape:'htmlall':'UTF-8'}"></script>

<script>

	/*********************
	* PrestaShop Account *
	* *******************/
	window?.psaccountsVue?.init();
	setTimeout(() => {
		disableConfigForm()
	}, 200);
	// Check if Account is associated before displaying Billing component
	if(window.psaccountsVue.isOnboardingCompleted() == true)
	{		
		  /*********************
			* PrestaShop Billing *
			* *******************/
			window.psBilling.initialize(window.psBillingContext.context, '#ps-billing', '#ps-modal', (type, data) => {
				  // Event hook listener
				  switch (type) {
				// Hook triggered when PrestaShop Billing is initialized
					  case window.psBilling.EVENT_HOOK_TYPE.BILLING_INITIALIZED:
						  console.log('Billing initialized', data);
						  break;
				// Hook triggered when the subscription is created or updated
					  case window.psBilling.EVENT_HOOK_TYPE.SUBSCRIPTION_UPDATED:
						  console.log('Sub updated', data);
						  hasSubscription = true;
						  disableConfigForm(true);
						  break;
				// Hook triggered when the subscription is cancelled
					  case window.psBilling.EVENT_HOOK_TYPE.SUBSCRIPTION_CANCELLED:
						  console.log('Sub cancelled', data);
						  disableConfigForm();
						  break;
				  }
			});
			
			// CloudSync
			  const cdc = window.cloudSyncSharingConsent;
			
			  cdc.init('#prestashop-cloudsync');
			  cdc.on('OnboardingCompleted', (isCompleted) => {
				console.log('OnboardingCompleted', isCompleted);
			  });
			  cdc.isOnboardingCompleted((isCompleted) => {
				console.log('Onboarding is already Completed', isCompleted);
			  });
	}
	
	function disableConfigForm(enable = false) {
		var moduleForm = document.getElementById('module_form');
		if(!hasSubscription && !enable){
			if (moduleForm) {
				moduleForm.classList.add("disabled-form");
				console.log("disable")
			}
		}
		else{
			if (moduleForm) {
				moduleForm.classList.remove("disabled-form");
				console.log("disable")
			}
		}
		
	}
</script>
<script src="{$urlCloudsync|escape:'htmlall':'UTF-8'}"></script>

