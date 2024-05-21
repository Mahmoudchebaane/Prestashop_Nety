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
        <h1 class="contactH1 mb-10">OÙ NOUS &nbsp;<strong>Trouvez</strong></h1>
        <p style="color:#585858;font-size:20px;text-align:center;font-weight:400;margin-bottom:50px">
            Retrouvez l’agence Nety et le revendeur la plus proche de vous !</p>
    </div>

    <form action="{$urls.pages.stores}" method="post" class="filterStores">
        {* Gouvernerate filter *}
        <div class="brands-sort dropdown">
            <p>{l s='Gouvernerat' d='Shop.Theme.Catalog'}</p>
            <select id="govs" class="btn-unstyle select-title filterItem" rel="nofollow" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {* {foreach from="{$govs}" item=gov key=key}
                    <option value="{$key}">{$gov}</option>
                {/foreach} *}
            </select>
            <script>
                let data = ['Ariana', 'Béja', 'Ben Arous', 'Bizerte', 'Gabès', 'Gafsa', 'Jendouba', 'Kairouan', 'Kasserine',
                    'Kébili', 'Kef', 'Mahdia', 'Manouba', 'Médenine', 'Monastir', 'Nabeul', 'Sfax', 'Sidi Bouzid',
                    'Siliana', 'Sousse', 'Tataouine', 'Tozeur', 'Tunis', 'Zaghouan'
                ];
                let list = document.getElementById("govs");
                data.forEach((item) => {
                    let option = document.createElement("option");
                    option.innerText = item;
                    list.appendChild(option);
                });
                var selectedGov = list.options[list.selectedIndex].text;
            </script>


        </div>
        {* Search Input *}
        <div class="brands-sort dropdown">
            <p style="color:black;font-weight:600 ">{l s='Search' d='Shop.Theme.Catalog'}</p>
            <input type="text" class="btn-unstyle select-title filterItem" value="" />
        </div>
        {* Confirmation Button *}
        <button class="filterBtn" type="submit">{l s='Done' d='messages'}</button>
    </form>
    {* Carousel *}
    <section class="section-with-carousel section-with-right-offset position-relative mt-5">
        <div id="carouselExampleControls" class="carousel  slider" data-ride="carousel" data-interval="false">
            <div class=" storeContainer " role="listbox">
                {foreach $stores as $store}

                    {* {if $store.address.address2 == $gov} *}

                        {if $store.id == "1"}
                            <div class="carousel-item active">
                                <article id="store-{$store.id}" class="store-item card storeItem">
                                    <div class=" clearfix h-100">
                                        <div class="col-md-3 store-picture hidden-sm-down d-none">
                                            <img src="{$store.image.bySize.stores_default.url}" alt="{$store.image.legend}"
                                                title="{$store.image.legend}">
                                        </div>
                                        {* <p>{$stores|@json_encode}</p> *}
                                        <div class="col-md-5 col-sm-7 col-xs-12 store-description storeDescription">
                                            <h3 class="h3 card-title">{$store.name} {$store.address.address2 }</h3>
                                            <div>
                                                <table>
                                                    {if $store.email}
                                                        <tr>
                                                            <td class="storeLabel">Mail:</td>
                                                            <td class="storeInfo">{$store.email}</td>
                                                        </tr>
                                                    {/if}
                                                    {if $store.address}
                                                        <tr>
                                                            <th class="storeLabel">Adresse:</th>
                                                            <td class="storeInfo">
                                                                <!-- <address>{$store.address.formatted nofilter}</address> -->
                                                                {$store.address.address1}

                                                            </td>
                                                        </tr>
                                                    {/if}
                                                    {if $store.phone}
                                                        <tr>
                                                            <th class="storeLabel">Telephone:</th>
                                                            <td class="storeInfo">{$store.phone}</td>
                                                        </tr>
                                                    {/if}
                                                </table>
                                            </div>
                                            {* <div>
                                                {if $store.note || $store.phone || $store.fax || $store.email}
                                                    <a data-toggle="collapse" href="#about-{$store.id}" aria-expanded="false"
                                                        aria-controls="about-{$store.id}"><strong>{l s='About and Contact' d='Shop.Theme.Cms'}</strong><i
                                                            class="material-icons d-none">&#xE409;</i></a>
                                                {/if}
                                            </div> *}

                                        </div>
                                        <div class="col-md-4 col-sm-5 col-xs-12 divide-left d-none">
                                            <table>
                                                {foreach $store.business_hours as $day}
                                                    <tr>
                                                        <th>{$day.day|truncate:4:'.'}</th>
                                                        <td>
                                                            <ul>
                                                                {foreach $day.hours as $h}
                                                                    <li>{$h}</li>
                                                                {/foreach}
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            </table>
                                        </div>
                                    </div>

                                    <footer id="about-{$store.id}" class="collapse">
                                        <div class="store-item-footer divide-top">
                                            <div class="card-block">
                                                {if $store.note}
                                                    <p class="text-justify">{$store.note}
                                                    <p>
                                                    {/if}
                                            </div>
                                            <ul class="card-block">
                                                {if $store.phone}
                                                    <li><i class="material-icons">&#xE0B0;</i>{$store.phone}</li>
                                                {/if}
                                                {if $store.fax}
                                                    <li><i class="material-icons">&#xE8AD;</i>{$store.fax}</li>
                                                {/if}
                                                {if $store.email}
                                                    <li><i class="material-icons">&#xE0BE;</i>{$store.email}</li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </footer>
                                </article>
                            </div>
                        {else}
                            <div class="carousel-item">
                                <article id="store-{$store.id}" class="store-item card storeItem">
                                    <div class=" clearfix h-100">
                                        <div class="col-md-3 store-picture hidden-sm-down d-none">
                                            <img src="{$store.image.bySize.stores_default.url}" alt="{$store.image.legend}"
                                                title="{$store.image.legend}">
                                        </div>
                                        <div class="col-md-5 col-sm-7 col-xs-12 store-description storeDescription">
                                            <h3 class="h3 card-title">{$store.name}</h3>
                                            <div>
                                                <table>
                                                    {if $store.email}
                                                        <tr>
                                                            <td class="storeLabel">Mail:</td>
                                                            <td class="storeInfo">{$store.email}</td>
                                                        </tr>
                                                    {/if}
                                                    {if $store.address}
                                                        <tr>
                                                            <th class="storeLabel">Adresse:</th>
                                                            <td class="storeInfo">
                                                                <!-- <address>{$store.address.formatted nofilter}</address> -->
                                                                {$store.address.address1}
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                    {if $store.phone}
                                                        <tr>
                                                            <th class="storeLabel">Telephone:</th>
                                                            <td class="storeInfo">{$store.phone}</td>
                                                        </tr>
                                                    {/if}
                                                </table>

                                            </div>
                                            <!-- <div>
                                            {if $store.note || $store.phone || $store.fax || $store.email}
                                            <a data-toggle="collapse" href="#about-{$store.id}" aria-expanded="false"
                                            aria-controls="about-{$store.id}"><strong>{l s='About and Contact' d='Shop.Theme.Cms'}</strong><i
                                                class="material-icons d-none">&#xE409;</i></a>
                                            {/if}
                                        </div> -->

                                        </div>
                                        <div class="col-md-4 col-sm-5 col-xs-12 divide-left d-none">
                                            <table>
                                                {foreach $store.business_hours as $day}
                                                    <tr>
                                                        <th>{$day.day|truncate:4:'.'}</th>
                                                        <td>
                                                            <ul>
                                                                {foreach $day.hours as $h}
                                                                    <li>{$h}</li>
                                                                {/foreach}
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            </table>
                                        </div>
                                    </div>

                                    <footer id="about-{$store.id}" class="collapse">
                                        <div class="store-item-footer divide-top">
                                            <div class="card-block">
                                                {if $store.note}
                                                    <p class="text-justify">{$store.note}
                                                    <p>
                                                    {/if}
                                            </div>
                                            <ul class="card-block">
                                                {if $store.phone}
                                                    <li><i class="material-icons">&#xE0B0;</i>{$store.phone}</li>
                                                {/if}
                                                {if $store.fax}
                                                    <li><i class="material-icons">&#xE8AD;</i>{$store.fax}</li>
                                                {/if}
                                                {if $store.email}
                                                    <li><i class="material-icons">&#xE0BE;</i>{$store.email}</li>
                                                {/if}
                                            </ul>
                                        </div>
                                    </footer>
                                </article>
                            </div>
                        {/if}
                    {* {/if} *}
                {/foreach}

            </div>

            <div class="controlsContainer d-flex">
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="swiper-pagination"></div>
            <style>
                .controlsContainer {
                    display: flex;
                    position: relative;

                    bottom: 0;
                    justify-content: flex-end;
                    margin-top: 10px;
                }

                .carousel-control-next {
                    padding-left: 50px;
                    color: black !important;
                }

                .carousel-control-prev {
                    position: relative !important;
                    color: black !important;
                }

                .carousel-control-prev-icon {
                    background-color: #EBEBEB !important;
                    margin-top: 10px;
                    display: flex;
                    border: 1px solid black;
                }

                .carousel-control-next-icon {
                    background-color: #EBEBEB !important;
                    margin-top: 10px;
                    border: 1px solid black
                }

                .section-with-carousel .swiper-pagination-bullets {
                    position: static;
                    display: flex;
                    justify-content: center;
                    margin-top: 10px;
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    width: auto;
                    height: auto;
                    background: transparent;
                    opacity: 0.5;
                    margin: 0 8px;
                    border-radius: 0;
                    transition: opacity 0.3s;
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet .line {
                    width: 3px;
                    height: 3px;
                    background: black;
                    transition: transform 0.3s;
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet .number {
                    opacity: 0;
                    transform: translateY(-7px);
                    transition: all 0.3s;
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active {
                    opacity: 1;
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .line {
                    transform: scaleX(8);
                }

                .section-with-carousel .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .number {
                    opacity: 1;
                    transform: none;
                }

                .section-with-carousel .swiper-slide figure {
                    position: relative;
                    overflow: hidden;
                }

                .section-with-carousel .swiper-slide img {
                    width: 100%;
                    height: 320px;
                    object-fit: cover;
                }

                .section-with-carousel .swiper-slide figcaption {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    transform: translateY(20%);
                    display: flex;
                    align-items: baseline;
                    justify-content: center;
                    padding: 20px;
                    text-align: center;
                    opacity: 0;
                    visibility: hidden;
                    color: white;
                    background: rgba(0, 0, 0, 0.5);
                    transition: all 0.4s;
                }

                .section-with-carousel .swiper-slide figcaption svg {
                    flex-shrink: 0;
                    fill: white;
                    margin-right: 10px;
                }

                .section-with-carousel .swiper-slide-active figcaption {
                    opacity: 1;
                    visibility: visible;
                    transform: none;
                }

                .section-with-carousel .carousel-controls {
                    position: absolute;
                    top: 50%;
                    left: 0;
                    right: 0;
                    transform: translateY(-50%);
                    display: flex;
                    justify-content: space-between;
                    padding: 0 12px;
                    z-index: 1;
                }

                .section-with-carousel .carousel-controls .carousel-control {
                    opacity: 0.25;
                    transition: opacity 0.3s;
                }

                .section-with-carousel .carousel-controls .carousel-control:hover {
                    opacity: 1;
                }

                @media (min-width: 768px) {
                    .section-with-carousel .swiper-slide img {
                        height: 370px;
                    }
                }

                @media (min-width: 1200px) {
                    .section-with-carousel .swiper-slide img {
                        height: 420px;
                    }

                    .section-with-carousel .carousel-controls {
                        padding: 0 50px;
                    }
                }
            </style>
            <link type="text/css" rel="stylesheet" href="css/lightslider.css" />
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script>
                let items = document.querySelectorAll(' .carousel .carousel-item')

                items.forEach((el) => {
                    // number of slides per carousel-item
                    const minPerSlide = 3
                    let next = el.nextElementSibling
                    for (var i = 1; i < minPerSlide; i++) {
                        if (!next) {
                            // wrap carousel by using first child
                            next = items[3]
                        }
                        let cloneChild = next.cloneNode(true)
                        el.appendChild(cloneChild.children[0])
                        next = next.nextElementSibling
                    }
                })
                $('.carousel').carousel({
                    interval: 2000,
                    wrap: true,
                    keyboard: true,
                    rows: 3,

                })
            </script>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
                integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
                integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
            </script>
        </div>
    </section>

{/block}