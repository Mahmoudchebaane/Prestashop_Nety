<div class="topProfile">
    <div id="identity-link" style="display: flex; justify-content: space-between;align-items: center;"
        {if $page.page_name == 'identity'} class="active" {/if} href="{$urls.pages.identity}">

       

        {if $page.page_name == 'identity'}
            <span class="link-name" id="idenLink">{l s='Password' d='Shop.Forms.Labels'}</span>
            <button id='identityBtn' class="SubscriptionBtn" onclick="backToidentity()"
                >{l s='Back to personal data' d='Shop.Theme.CustomerAccount'}</button>
 
        <span class="link-name" id="passLink">  {l s='Modifier mes informations' d='Shop.Theme.Customeraccount'}</span>
            <button id='PassBtn' class="SubscriptionBtn" onclick="changePass()"
                >{l s='Change password' d='Shop.Forms.CustomerAccount'}</button>


                {else}
                <span class="link-name"> {block name='page_title'}{/block}</span>
           
        {/if}


        {*  <a class="" href="{$link->getPageLink('index', true, null, 'mylogout')|escape:'html'}" rel="nofollow">
                 {l s='Sign out' d='Shop.Theme.Actions'} 
                <i class="zmdi zmdi-power" style="font-size: 35px;"></i>
            </a>
            <div class="spanContainer">
                <i class="material-icons">&#xE853;</i>
                <span class="welcomeSpan">{l s='Welcome' d='Shop.Theme.Customeraccount'}</span>
                <span class="userName">
                    {$customer.firstname}&nbsp;{$customer.lastname}
                     <div class="dropdown">
                        <button class="dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {$customer.firstname}&nbsp;{$customer.lastname}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="{$link->getPageLink('index', true, null, 'mylogout')|escape:'html'}"
                                rel="nofollow">{l s='Sign out' d='Shop.Theme.Actions'}
                            </a>
                        </div>
                    </div>
                </span>
            </div>

        </span> *}

    </div>
</div>