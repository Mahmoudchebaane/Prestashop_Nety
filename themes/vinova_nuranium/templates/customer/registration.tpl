{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<!DOCTYPE html>
<html lang="{$language.iso_code}">

<head>
	{block name='head'}
		{include file='_partials/head.tpl'}
	{/block}
	<title>{block name='head_seo_title'}{l s='Register' d='Shop.Theme.Customeraccount'}{/block}</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	{* {block name='page_title'}
		{l s='Create an account' d='Shop.Theme.Customeraccount'}
	{/block} *}
</head>

<body id="{$page.page_name}"
	class="{$page.body_classes|classnames}{if isset($novconfig.novthemeconfig_mode_layout) && $novconfig.novthemeconfig_mode_layout == 'boxed'} layout-boxed{/if}{if isset($class_homepage) && $class_homepage} {$class_homepage}{/if}">
	{block name='hook_after_body_opening_tag'}
		{hook h='displayAfterBodyOpeningTag'}
	{/block}
	<main id="main-site" class="w-100 h-100">

		{block name='page_content'}
			<div class="cnxPage">
				{block name='page_content'}
					{block name='register_form_container'}
						{$hook_create_account_top nofilter}
						{* Bloc left *}
						<div class="leftSide ">
							<div class='firstBloc'>
								<h1>{l s='Bienvenue' d='Shop.Theme.Customeraccount'}</h1>
								<h2>{l s='dans votre espace client' d='Shop.Theme.Customeraccount'}</h2>
								<p>{l s='L’espace client vous permet de consulter vos données personnelles, payer vos facture, passer vos réclamation...' d='Shop.Theme.Customeraccount'}
								</p>
								<a href="/">{l s='Revenir au site' d='Shop.Theme.Customeraccount'}</a>
							</div>
							<div class='imgLeft'>
								<img src="/img/cms/cnx.png" class="h-100" style="object-fit: contain">
							</div>
						</div>
						{* Choose subscription type *}
						{* <div class='authOptions {if $register_form_errors} d-none {/if}' id="authOptions"> *}
						<div class='authOptions {if $register_form_errors} d-none {/if}' id="authOptions">
							<div class="py-20">
								<h2>{l s='Création d’un compte My Nety' d='Shop.Theme.Customeraccount'}</h2>
								<p> {l s='Créez un compte my Nety et accédez à votre espace client.' d='Shop.Theme.Customeraccount'}
								</p>
							</div>
							<div id='notification' class="notification"></div>
							<form method="post" action="" id='optionsChoose'>
								<div class="option-group">
									<div class="option-container">
										<input class="option-input" id="email" type="radio" name="options" value="1" />
										<input class="option-input" id="contrat" type="radio" name="options" value="2" />


										<label class="option" for="email">
											<span class="option__indicator"></span>
											<span class="option__label">
												{l s='En utilisant votre Email' d='Shop.Theme.Customeraccount'}
												<p>{l s=' Créez un compte à partir de votre Adresse email et votre mot de passe' d='Shop.Theme.Customeraccount'}
												</p>
											</span>
										</label>

										<label class="option" for="contrat"> <span class="option__indicator"></span> <span
												class="option__label">
												{l s='A partir de votre Contrat Nety' d='Shop.Theme.Customeraccount'}
												<p>{l s='Créez un compte à partir de votre Code contrat et votre CIN' d='Shop.Theme.Customeraccount'}
												</p>
											</span>
										</label>
									</div>
								</div>
								<div class="footerBtn">
									<input type="hidden" name="submitCreate2" value="1">
									<button class="nextBtn" id="nextBtn" onclick=""
										type="button">{l s='Suivant' d='Shop.Theme.Customeraccount'}</button>
									<a class="backLink"
										href="/connexion">{l s='You already have an account? Log In' d='Shop.Theme.Customeraccount'}</a>
								</div>
							</form>
						</div>
						{* Retreive personnal information  *}
						<div class='recuperation {if $register_form_errors} d-none {/if} align-items-center block-form-login'
							id="recuperation">
							<div class="login-form">
								<div>
									<h2>{l s='Création d’un compte My Nety' d='Shop.Theme.Customeraccount'}</h2>
									{* <p> {l s="Pour s'inscrire, veuillez saisir les informations suivants :" d='Shop.Theme.Customeraccount'} *}
								</div>
								<div class='w-100' style="padding: 50px 0;">
									<div class='d-flex  flex-column  '>
										<label class='inputLabel'> {l s='CIN/carte séjour' d='Shop.Theme.Customeraccount'}</label>
										<input name="identifiant" class="inputField">
										<div id='errorIdent' style='color: red'></div>
									</div>
									<div class='d-flex flex-column '>
										<label class='inputLabel'> {l s='Tél Fixe' d='Shop.Theme.Customeraccount'}</label>
										<input name="num_fixe" class="inputField">
										<div id='errorFixe' style='color: red'></div>
									</div>
									<div id='errorRegister'
										style='color: red; padding-top: 20px;display: flex; justify-content: flex-end;'></div>
								</div>
								<div class="d-flex align-items-center flex-row-reverse w-100">
									<div class=" footerBtn" style="width: 100%;">
										<button class="SubscriptionBtn" id="confirmbtn"
											onclick="getAbonnCRM()">{l s='Récuperer vos paramètres' d='Shop.Theme.Customeraccount'}</button>
										{* <button class="prevBtn mt-sm-20"
											onclick="prevStep()">{l s='Cancel' d='Shop.Theme.Customeraccount'}</button> *}
									</div>
									<a class="backLink"
										href="{$urls.pages.authentication}">{l s='You already have an account? Log In' d='Shop.Theme.Customeraccount'}</a>
								</div>

							</div>
						</div>
						{* confirm by sms *}
						<div class="block-form-login " id="SMS">
							<section class="register-form login-form">
								<h2>{l s='Saisissez le code qui vous a été envoyé par SMS.' d='Shop.Theme.Customeraccount'}</h2>
								{* <p class="text-center mb-5">{l s='Insert your account information:' d='Shop.Theme.Customeraccount'} *}

								<input id="submit" name="submit" type="submit" value="Submit" class="hidden" />
								<div class="w-100">
									<div class="codeverifciation py-4 ">
										<input id="num_mobile" name="num_mobile" class="hidden" />
										<label class="inputLabel">{l s='Verification code' d='Shop.Theme.Customeraccount' }</label>
										<div class="d-flex flex-column">
											{* <small	class="font-size-14 text-muted mt-8  ">{l s='Saisissez le code qui vous a été envoyé par SMS.' d='Shop.Theme.Customeraccount' }</small> *}
											<input name="codemobile" type="number" required length="6" class="inputField " />
											<span id="sms_error" class="has-error"> </span>
											<div
												style="display: flex;align-items: center;margin-top: 20px;justify-content: space-between;">
												<div class="w-100">
													<u id="renvoyersms" class=" text-primary backLink"
														style="color: #444 !important; text-decoration: none !important">{l s='Renvoyer le code' d='Shop.Theme.Customeraccount' }</u>
												</div>
												<input id="submitCode" name="submitCode" class="SubscriptionBtn " type="button"
													style="width:120px; " value="{l s='Confirm' d='Shop.Theme.Customeraccount' }" />

											</div>
											{* onclick="fourthStep()" *}
										</div>

									</div>
								</div>
								<div class="footerBtn">
									{* <button class="SubscriptionBtn"
									onclick="fourthStep()">{l s='Verifier' d='Shop.Theme.Customeraccount'}</button> *}
									{* <input onclick="fourthStep()" id="submitCode" name="submitCode"
									class="SubscriptionBtn btn  mb-5 ml-auto btn-next nextBtn ml-5" type="button"
									value="{l s='Send' d='Shop.Theme.Customeraccount' }" /> *}

								</div>
							</section>
						</div>
						{* Subscribtion form *}
						<div class="block-form-login {if $register_form_errors} d-flex {/if}" id="SubscriptionForm">
							<section class="register-form" style="width: 100%;">
								<div class="page_title_account text-center">{l s='Create an account' d='Shop.Theme.Customeraccount'}
								</div>
								<p class="text-center mb-5">{l s='Insert your account information:' d='Shop.Theme.Customeraccount'}
								</p>
								{render file='customer/_partials/customer-form.tpl' ui=$register_form}
							</section>
						</div>
					{/block}
				{/block}
			</div>
		{/block}
	</main>
	{block name='hook_before_body_closing_tag'}

		<script type="text/javascript">
			console.log($(this).submit())
			var testEmail = document.getElementById('email').checked;
			var testContrat = document.getElementById('contrat').checked
			var notif = document.getElementById('notification')
			var nextBtn = document.getElementById('nextBtn')
		
		
			$('input[name="options"]').change(function() {
				notif.innerHTML = ``
				document.getElementById('nextBtn').onclick = function() {
					
					if (document.getElementById('email').checked) {
					 						
						var form = document.getElementById('SubscriptionForm')
						form.style.display = 'flex'
						var authOptions = document.getElementById('authOptions')
						authOptions.style.display = 'none'	
						$(".novform-ref_client").parent().parent().remove() ;
						$(".novform-ref_abonnement").parent().parent().remove() ;
						$(".novform-num_fixe").parent().parent().remove() ;

						$("input[name='pass']").prop('required',true)
					 				
					} else if (document.getElementById('contrat').checked) {
					 				
						var form = document.getElementById('recuperation')
						form.style.display = 'flex'
						var authOptions = document.getElementById('authOptions')
						authOptions.style.display = 'none'	
						


					} else {
						notif.innerHTML = ``
						notif.innerHTML += chooseOption
					}
				}
			})
			
		</script>

		<script src="/js/registration.js" type="text/javascript"></script>

		<script type="text/javascript">
			var error ='{l s='Could you please check your data' d='Shop.Theme.Errors'}'
			var identifiant = '{l s='Identifiant' d='Shop.Theme.Customeraccount'}';
			var refAbo = '{l s='Ref abonnement' d='Shop.Theme.Customeraccount'}';
			var chooseOption = '{l s='Choose one of the given option to continue' d='Shop.Theme.Customeraccount'}';
			var echec = '{l s='Echec' d='Shop.Theme.Customeraccount'}';
			var required = '{l s='Code missing' d='Shop.Theme.Customeraccount'}';
			var MsgExpire = '{l s="Code de vérification expiré" d='Shop.Theme.Customeraccount'}'
			var MsgError = '{l s="une erreur se produite" d='Shop.Theme.Customeraccount'}'
			var MsgInvalid = '{l s="Code de vérification invalid" d='Shop.Theme.Customeraccount'}'
			var MsgValid = '{l s="Code de vérification valid" d='Shop.Theme.Customeraccount'}'
			var testFix = '{l s="Landline number invalid" d='Shop.Theme.Customeraccount'}'
			var telManq =  '{l s="Landline number required" d='Shop.Theme.Customeraccount'}'
			var IdentManq =  '{l s="Identifier required" d='Shop.Theme.Customeraccount'}'
			var IdentifiantExist = '{l s="Identifier already used" d='Shop.Theme.Customeraccount'}';
			var paraManq ='{l s="Parameters are missing." d='Shop.Theme.Customeraccount'}'
			var paraInvalid ='{l s="The value provided for landline number is not valid" d='Shop.Theme.Customeraccount'}'
			var paraError = '{l s="An error occurred there is no customer with this parameters" d='Shop.Theme.Customeraccount'}'

			function resetForm() {
				document.getElementById("customer-form").reset();
			}
		</script>


		<script>
			$("button[data-action=\"show-password\"]").on("click", function() {
				var e = $('input[name="password"]');
				if ("password" === e.attr("type")) {
					$('input[name="password"]').attr("type", "text");
				} else {
					$('input[name="password"]').attr("type", "password");
				}
			})
		</script>



	{/block}
</body>

</html>