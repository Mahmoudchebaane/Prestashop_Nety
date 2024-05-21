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

					{* Bloc left *}
					<div class="leftSide">
						<div class='firstBloc'>
							<h1>{l s='Bienvenue' d='Shop.Theme.Customeraccount'}</h1>
							<h2>{l s='dans votre espace client' d='Shop.Theme.Customeraccount'}</h2>
							<p>
								{l s='L’espace client vous permet de consulter vos données personnelles, payer vos facture, passer vos réclamation...' d='Shop.Theme.Customeraccount'}
							</p>
							<a href="/">{l s='Revenir au site' d='Shop.Theme.Customeraccount'}</a>
						</div>
						<img src="/img/cms/cnx.png" class='imgLeft'>
					</div>
					{* Choose subscription type *}
					<div class='authOptions' id="authOptions">
						<div style="padding: 0 20px;">
							<h2>{l s='Création d’un compte My Nety' d='Shop.Theme.Customeraccount'}</h2>
							<p> {l s='Créez un compte my Nety et accédez à votre espace client.' d='Shop.Theme.Customeraccount'}
							</p>
						</div>
						<div class="option-group">
							<div class="option-container">
								<input class="option-input" id="email" type="radio" name="options" />
								<input class="option-input" id="contrat" type="radio" name="options" />
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
							<button class="nextBtn"
								onclick="secondStep()">{l s='Suivant' d='Shop.Theme.Customeraccount'}</button>
							<a class="backLink"
								href="/connexion">{l s='You already have an account? Log In' d='Shop.Theme.Customeraccount'}</a>
						</div>
					</div>
					{* Retreive personnal information  *}
					<div class='recuperation align-items-center' id="recuperation">
						<div>
							<div>
								<h2>{l s='Création d’un compte My Nety' d='Shop.Theme.Customeraccount'}</h2>
								<p> {l s="Pour s'inscrire, veuillez saisir les informations suivants :" d='Shop.Theme.Customeraccount'}
							</div>
							<div class='w-100' style="padding: 50px 0;">
								<div class='d-flex  flex-column  '>
									<label class='inputLabel'> {l s='CIN/Code contrat' d='Shop.Theme.Customeraccount'}</label>
									<input name="identifiant" class="inputField">
								</div>
								<div class='d-flex flex-column '>
									<label class='inputLabel'> {l s='Tél Fixe' d='Shop.Theme.Customeraccount'}</label>
									<input name="Tel" class="inputField">
								</div>
							</div>
							<div class="d-flex align-items-center flex-column">
								<div class=" footerBtn">

									<button class="SubscriptionBtn" id="confirmbtn"
										onclick="thirdstep()">{l s='Récuperer vos paramètres' d='Shop.Theme.Customeraccount'}</button>
									<button class="prevBtn"
										onclick="prevStep()">{l s='Cancel' d='Shop.Theme.Customeraccount'}</button>
								</div>
								<a class="backLink"
									href="/connexion">{l s='You already have an account? Log In' d='Shop.Theme.Customeraccount'}</a>
							</div>

						</div>
					</div>
					{* confirm by sms *}
					<div class="block-form-login " id="SMS">
						<section class="register-form  ">
							<h2>{l s='Saisissez le code qui vous a été envoyé par SMS.' d='Shop.Theme.Customeraccount'}</h2>
							{* <p class="text-center mb-5">{l s='Insert your account information:' d='Shop.Theme.Customeraccount'} *}
							</p>
							<input id="submit" name="submit" type="submit" value="Submit" class="hidden" />
							<div class="mt-35">
								<div class="col codeverifciation py-4 ">
									<div class="row">
										<label
											class="col font-size-16 font-weight-bold">{l s='Code de confirmation' d='Shop.Theme.Customeraccount' }
										</label>
									</div>
			
									<div class="d-flex flex-column">
										{* <small	class="font-size-14 text-muted mt-8  ">{l s='Saisissez le code qui vous a été envoyé par SMS.' d='Shop.Theme.Customeraccount' }</small> *}

										<input name="codemobile" type="number" required length="6" class="inputField " />
										<span id="sms_error" class="has-error"> </span>
										<input id="submitCode" name="submitCode" class="SubscriptionBtn " type="button"
											style="width:120px; margin-top: 20px"
											value="{l s='Confirm' d='Shop.Theme.Customeraccount' }" />

										{* onclick="fourthStep()" *}
									</div>
									<div class="row m-2 w-100">
										<u id="renvoyersms"
											class="d-none text-primary">{l s='Renvoyer le code' d='Shop.Theme.Customeraccount' }</u>
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
					<div class="block-form-login " id="SubscriptionForm">

						<section class="register-form  ">
							<div class="page_title_account text-center">{l s='Create an account' d='Shop.Theme.Customeraccount'}
							</div>
							<p class="text-center mb-5">{l s='Insert your account information:' d='Shop.Theme.Customeraccount'}
							</p>
							{render file='customer/_partials/customer-form.tpl' ui=$register_form}
						</section>
					</div>
					{* Subscribe using email *}
					{block name='register_form_container'}
						{$hook_create_account_top nofilter}
						{* <div class="block-form-login " id="SubscriptionEmail">
							<section class="register-form">
								<div class="page_title_account text-center">{l s='Create an account' d='Shop.Theme.Customeraccount'}
								</div>
								<p class="text-center mb-5">{l s='Insert your account information:' d='Shop.Theme.Customeraccount'}
								</p>
								{render file='customer/_partials/customer-form.tpl' ui=$register_form}
							</section>
						</div> *}
						<div class="block-form-login" id="SubscriptionEmail">
							<section class="register-form" style="width:70%">
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
		<script src="/js/registration.js" type="text/javascript"></script>
		<script type="text/javascript">
			var chooseOption = '{l s=' Choose one of the given option to continue' d='Shop.Theme.Customeraccount'}';
			var echec = '{l s='Echec' d='Shop.Theme.Customeraccount'}';
			// var codeadresseError = '{l s="Veuillez cliquer sur votre emplacement sur la carte." d='Shop.Theme.Customeraccount' }';
			// var formatInvalid = '{l s="Format invalide , Seuls les chiffres positifs sont acceptés" d='Shop.Theme.Customeraccount' }';
			// var IdentifiantExist = '{l s="Identifiant déja utilisé" d='Shop.Theme.Customeraccount'}';
			// var ValidFile = '{l s="Veuillez entrer un fichier valid: types autorisés ( image / pdf)" d='Shop.Theme.Customeraccount' }';
			// var Letters = '{l s="Seuls les lettres et les chiffres  sont acceptés" d='Shop.Theme.Customeraccount'}';
			// // var positifLetter= '{l s="Format invalide , Seuls les chiffres positifs sont acceptés" d='Shop.Theme.Customeraccount' }';
			var MsgError = '{l s="une erreur se produite" d='Shop.Theme.Customeraccount'}'
			var MsgExpire = '{l s="Code de vérification expiré" d='Shop.Theme.Customeraccount'}'
			var MsgInvalid = '{l s="Code de vérification invalid" d='Shop.Theme.Customeraccount'}'
			var MsgValid = '{l s="Code de vérification valid" d='Shop.Theme.Customeraccount'}'
		</script>
	{/block}
</body>

</html>