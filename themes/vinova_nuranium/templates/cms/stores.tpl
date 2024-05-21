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
* Do not edit or add to this file if you wish to upgrade PrestaSfachop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2017 PrestaShop SA
    * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
{extends file='page.tpl'}

{block name='page_title'}
    {l s='Our stores' d='Shop.Theme.Cms'}
{/block}

{block name='page_content_container'}
    <div class="col">
        <h2 class="contactH1 mb-10 mt-40"> {l s='OÙ NOUS' d='Shop.Theme.Catalog'}
            &nbsp;<strong>{l s='Trouver' d='Shop.Theme.Catalog'}</strong></h2>
        <h3 style="color:#585858;font-size:20px;text-align:center;font-weight:400;margin-bottom:50px">
            {l s='Retrouvez l’agence Nety et le revendeur le plus proche de vous !' d='Shop.Theme.Catalog'}</h3>
    </div>

    <form action="{$urls.pages.stores}" method="post" class="filterContainer">
        {* <div id="ToastStore">Aucun boutiques trouvé.</div> *}
        {* Confirmation Button
        <button class="filterBtn" type="submit" onclick="applyFilter">{l s='Done' d='messages'}</button>*}
        <div class="mb-xs-20">
            <h4 style="color:black;font-weight:600; margin: 5px 10px; "> {l s='Gouvernerat' d='Shop.Theme.Catalog'}</h4>
            <div class="filterItem">
                <input required id="gouvernoratid" class="" name="selectedGov" />
            </div>
        </div>
        {* Search Input*}
        <div class="mb-xs-20">
            <h4 style="color:black;font-weight:600 ;margin: 5px 10px;">{l s='Search' d='Shop.Theme.Catalog'}</h4>
            <div class="d-flex">
                <input type="text" class="select-title filterItem1 " value="" id="Search" name="Search" />
                <button id="submitFilter" name="submitFilter" class="filterBtn mb-xs-10  mr-10 " type="button"
                    onclick="FilterStores()">
                    <i class="material-icons zoom-in">search</i>
                    {* {l s='Done' d='messages'} *}
                </button>
            </div>
        </div>
        <div class="btnIcons">
            <button id="submitFilter" name="submitFilter" class="filterBtn mb-xs-10  mr-10 d-none" type="button"
                onclick="FilterStores()">
                <i class="material-icons zoom-in">search</i>
                {* {l s='Done' d='messages'} *}
            </button>
            <!-- ml-md-10 -->
            <button id="location" name="location" class="filterBtn  mb-xs-10 d-none" type="button" onclick="getLocation()">
                <i class="material-icons">room</i>
                {* {l s='Done' d='messages'} *}
            </button>
        </div>
    </form>
    <div id="storeInfoMaps" class="storeInfoMaps">
        {* List of stores *}
        <div class="storeContainer col-md-4 col-xl-3 " data-bs-spy="scroll" data-bs-target="#navbar-scrollspy"
            data-bs-offset="0" tabindex="0">
            <div class="col" id="listestore"></div>
        </div>
        <div class="storeMaps col-md-8 col-xl-9">
            {* stores in map *}
            <div class=" w-100">
                <div id="map-canvas"> </div>
            </div>
        </div>

    </div>

{/block}



{block name='hook_before_body_closing_tag'}
    <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmRdfSENCwul5MMzXv8NohYuz6CIzrdZU&libraries=marker,places&v=beta">
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">    </script>
    <script src="/js/stores.js" type="text/javascript"></script>    


    <script type="text/javascript">
        var Tous = '{l s="Tous" d="Shop.Theme.Catalog"}';
        var Ariana = '{l s="Ariana" d="Shop.Theme.Catalog"}';
        var BenArous = '{l s="Ben Arous" d="Shop.Theme.Catalog"}';
        var Beja = '{l s="Béja" d="Shop.Theme.Catalog"}';
        var Bizerte = '{l s="Bizerte" d="Shop.Theme.Catalog"}';
        var Gabès = '{l s="Gabès" d="Shop.Theme.Catalog"}';
        var Gafsa = '{l s="Gafsa" d="Shop.Theme.Catalog"}';
        var Jendouba = '{l s="Jendouba" d="Shop.Theme.Catalog"}';
        var Kairouan = '{l s="Kairouan" d="Shop.Theme.Catalog"}';
        var Kasserine = '{l s="Kasserine" d="Shop.Theme.Catalog"}';
        var Kébili = '{l s="Kébili" d="Shop.Theme.Catalog"}';
        var Kef = '{l s="Kef" d="Shop.Theme.Catalog"}';
        var Mahdia = '{l s="Mahdia" d="Shop.Theme.Catalog"}';
        var Manouba = '{l s="Manouba" d="Shop.Theme.Catalog"}';
        var Médenine = '{l s="Médenine" d="Shop.Theme.Catalog"}';
        var Monastir = '{l s="Monastir" d="Shop.Theme.Catalog"}';
        var Nabeul = '{l s="Nabeul" d="Shop.Theme.Catalog"}';
        var Sfax = '{l s="Sfax" d="Shop.Theme.Catalog"}';
        var SidiBouzid = '{l s="Sidi Bouzid" d="Shop.Theme.Catalog"}';
        var Siliana = '{l s="Siliana" d="Shop.Theme.Catalog"}';
        var Sousse = '{l s="Sousse" d="Shop.Theme.Catalog"}';
        var Tataouine = '{l s="Tataouine" d="Shop.Theme.Catalog"}';
        var Tozeur = '{l s="Tozeur" d="Shop.Theme.Catalog"}';
        var Tunis = '{l s="Tunis" d="Shop.Theme.Catalog"}';
        var Zaghouan = '{l s="Zaghouan" d="Shop.Theme.Catalog"}';
        var noStore ='{l s='Aucune boutique trouvé.'  d="Shop.Theme.Catalog"}';
        var Address = '{l s="Address" d="Shop.Theme.Catalog"}';
    </script>

{/block}