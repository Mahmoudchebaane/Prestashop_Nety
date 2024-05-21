{extends file='layouts/layout-both-columns.tpl'}

{block name='header'}
	{include file='_partials/header.tpl'}
{/block}
{block name='left_column'}{/block}
{block name='right_column'}{/block}

{block name='breadcrumb'}
	<div class="pageheader "> </div>
{/block}

 {block name='content_wrapper'}
	 <div id="content-wrapper" class="js-content-wrapper content-only">
	 	<div class="TopPageAbout mb-40">
	 		<div class="BgTop">
	 			<h1 class="Page_title">
	 				<span
	 					style="color:#FDEC25;font-size:65px;font-weight: 600;text-transform: uppercase;">{l s='CONTACTEZ' d="Shop.Theme.Cms"}&nbsp;</span>
	 				<span
	 					style="color:white;font-size:65px;font-weight: 600;text-transform: uppercase;">{l s='NOUS' d="Shop.Theme.Cms"}</span>
	 			</h1>
	 			<p><img src="/img/cms/contact.png" alt="page contact"></p>
	 		</div>
	 	</div>



		{block name='content'}
			{include file='_partials/breadcrumb.tpl'}
			<section id="content" class="contactForm2">
				<div class="col-md-9 ">
					<h2 class="contactH1">{l s='Avez-vous des questions?' d='Shop.Theme.Cms' }
					</h2>

					{if Module::isEnabled('customcontactus')}
						{widget name="customcontactus"}
					{else}
						{widget name="contactform"}
					{/if}

		 		</div>
		 		<div class="col-md-9">
		 			<h2 class="contactH1">{l s='Contact service client' d='Shop.Theme.Cms' }</h2>
		 			{* Contact <strong>service client</strong> *}
		 			<div class="listLine">
		 				<div class="serviceInfo">
		 					<img class=" " alt="commercial service" width="" height="" src="/modules/jscomposer/uploads/Plan-de-travail-3-5.png">
		 					<span>{l s='Service Commerciale' d='Shop.Theme.Cms' }</span>
		 					<p>70 751 851</p>
		 				</div>
		 				<div class="serviceInfo d-none hidden">
		 					<img class=" vc_box_border_grey " alt="marketing service" width="" height=""
		 						src="/modules/jscomposer/uploads/Plan-de-travail-2-5.png">
		 					<span>{l s='Service Marketing' d='Shop.Theme.Cms' }</span>
		 					<p>1111111</p>
		 				</div>
		 				<div class="serviceInfo">
		 					<img class=" vc_box_border_grey " alt="technical service" width="" height=""
		 						src="/modules/jscomposer/uploads/Plan-de-travail-1-7.png">
		 					<span>{l s='Service Technique' d='Shop.Theme.Cms' }</span>
		 					<p>70 751 851</p>
		 				</div>
		 				<div class="serviceInfo d-none hidden">
		 					<img class=" vc_box_border_grey " alt="Financial service" width="" height=""
		 						src="/modules/jscomposer/uploads/Web-1920-1-9.png">
		 					<span>{l s='Service Financier' d='Shop.Theme.Cms' }</span>
		 					<p>1111111</p>
		 				</div>
		 			</div>
		 		</div>

				<div class="col-md-9 mt-30">
					<div class="block-title d-flex align-items-center justify-content-center">
						{* <img src="/img/cms/Icon%20Inscription.png" alt="newsletters" width="82" height="81"> *}
						<h1 class="contactH1 mb-0">
							<strong>{l s='Newsletter subscription' d='Modules.Emailsubscription.Shop'}</strong>
						</h1>
					</div>
					<div class="block-description mb-30">
						<p class="pt-20">{l s='Newsletter' d='Modules.Emailsubscription.Shop' }</p>
					</div>
					<div class="block_newsletter">
						{include file='module:ps_emailsubscription/views/templates/hook/ps_emailsubscription.tpl' conditions='Inscrivez-vous gratuitement à la Newsletter et recevez en exclusivité nos dernières
			   nouveautés' msg='' value =''}
					</div>
				</div>
			</section>

		{/block}
		{hook h="displayContentWrapperBottom"}
	</div>
{/block}

{block name='footer'}{/block}