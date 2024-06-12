<?php

class APIRoutes
{
    public static final function getRoutes(): array
    {
        return [
            'module-binshopsrest-bootstrap' => [
                'rule' => 'rest/bootstrap',
                'keywords' => [],
                'controller' => 'bootstrap',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-lightbootstrap' => [
                'rule' => 'rest/lightbootstrap',
                'keywords' => [],
                'controller' => 'lightbootstrap',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //recuperer parametres pour creer un compte nety
            'module-binshopsrest-credentials' => [
                'rule' => 'rest/credentials',
                'keywords' => [],
                'controller' => 'credentials',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //code otp
            'module-binshopsrest-otp' => [
                'rule' => 'rest/otp',
                'keywords' => [],
                'controller' => 'otp',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste de govs
            'module-binshopsrest-gouvernerats' => [
                'rule' => 'rest/gouvernerats',
                'keywords' => [],
                'controller' => 'gouvernerats',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
             //liste de villes selon gov id
            'module-binshopsrest-villes' => [
                'rule' => 'rest/villes',
                'keywords' => [],
                'controller' => 'villes',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste des offres internets
            'module-binshopsrest-offresinternet' => [
                'rule' => 'rest/offresinternet',
                'keywords' => [],
                'controller' => 'offresinternet',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
           //liste des factures
            'module-binshopsrest-factures' => [
                'rule' => 'rest/factures',
                'keywords' => [],
                'controller' => 'factures',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste de codes postales selon ville id
            'module-binshopsrest-postcode' => [
                'rule' => 'rest/postcode',
                'keywords' => [],
                'controller' => 'postcode',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //test identifiant demande abonnement
            'module-binshopsrest-identifier' => [
                'rule' => 'rest/identifier',
                'keywords' => [],
                'controller' => 'identifier',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //login
            'module-binshopsrest-login' => [
                'rule' => 'rest/login',
                'keywords' => [],
                'controller' => 'login',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //new customer
            'module-binshopsrest-register' => [
                'rule' => 'rest/register',
                'keywords' => [],
                'controller' => 'register',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //logout
            'module-binshopsrest-logout' => [
                'rule' => 'rest/logout',
                'keywords' => [],
                'controller' => 'logout',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //profile info
            'module-binshopsrest-accountinfo' => [
                'rule' => 'rest/accountInfo',
                'keywords' => [],
                'controller' => 'accountinfo',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //demande abonnemeent periodicite 
            'module-binshopsrest-periodicite' => [
                'rule' => 'rest/periodicite',
                'keywords' => [],
                'controller' => 'periodicite',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //edit profile
            'module-binshopsrest-accountedit' => [
                'rule' => 'rest/accountedit',
                'keywords' => [],
                'controller' => 'accountedit',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //demande abonnement
            'module-binshopsrest-demandeabonnement' => [
                'rule' => 'rest/demandeabonnement',
                'keywords' => [],
                'controller' => 'demandeabonnement',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //recuperer cle antivirus            
            'module-binshopsrest-antiviruskey' => [
                'rule' => 'rest/antiviruskey',
                'keywords' => [],
                'controller' => 'antiviruskey',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //detail de produit
            'module-binshopsrest-productdetail' => [
                'rule' => 'rest/productdetail',
                'keywords' => [],
                'controller' => 'productdetail',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //historique de commande
            'module-binshopsrest-orderhistory' => [
                'rule' => 'rest/orderhistory',
                'keywords' => [],
                'controller' => 'orderhistory',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //Panier
            'module-binshopsrest-cart' => [
                'rule' => 'rest/cart',
                'keywords' => [],
                'controller' => 'cart',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste des categories
            'module-binshopsrest-categoryproducts' => [
                'rule' => 'rest/categoryProducts',
                'keywords' => [],
                'controller' => 'categoryproducts',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-productsearch' => [
                'rule' => 'rest/productSearch',
                'keywords' => [],
                'controller' => 'productsearch',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],

            'module-binshopsrest-featuredproducts' => [
                'rule' => 'rest/featuredproducts',
                'keywords' => [],
                'controller' => 'featuredproducts',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-address' => [
                'rule' => 'rest/address',
                'keywords' => [],
                'controller' => 'address',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste of nety user contracts 
            'module-binshopsrest-contrat' => [
                'rule' => 'rest/contrat',
                'keywords' => [],
                'controller' => 'contrat',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
             //telecharger facture de commande 
             'module-binshopsrest-orderfacturepdf' => [
                'rule' => 'rest/orderfacturepdf',
                'keywords' => [],
                'controller' => 'orderfacturepdf',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
              //pdf contrat
              'module-binshopsrest-pdfcontrat' => [
                'rule' => 'rest/pdfcontrat',
                'keywords' => [],
                'controller' => 'pdfcontrat',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
                ],
            
            //paiement facture
            'module-binshopsrest-paiementfacture' => [
                'rule' => 'rest/paiementfacture',
                'keywords' => [],
                'controller' => 'paiementfacture',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //Download facture
           'module-binshopsrest-facturepdf' => [
                'rule' => 'rest/facturepdf',
                'keywords' => [],
                'controller' => 'facturepdf',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
                ],
            //liste des adresses
            'module-binshopsrest-alladdresses' => [
                'rule' => 'rest/alladdresses',
                'keywords' => [],
                'controller' => 'alladdresses',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-addressform' => [
                'rule' => 'rest/addressform',
                'keywords' => [],
                'controller' => 'addressform',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-carriers' => [
                'rule' => 'rest/carriers',
                'keywords' => [],
                'controller' => 'carriers',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-setaddresscheckout' => [
                'rule' => 'rest/setaddresscheckout',
                'keywords' => [],
                'controller' => 'setaddresscheckout',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-setcarriercheckout' => [
                'rule' => 'rest/setcarriercheckout',
                'keywords' => [],
                'controller' => 'setcarriercheckout',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-paymentoptions' => [
                'rule' => 'rest/paymentoptions',
                'keywords' => [],
                'controller' => 'paymentoptions',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-resetpasswordemail' => [
                'rule' => 'rest/resetpasswordemail',
                'keywords' => [],
                'controller' => 'resetpasswordemail',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-resetpasswordcheck' => [
                'rule' => 'rest/resetpasswordcheck',
                'keywords' => [],
                'controller' => 'resetpasswordcheck',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-resetpasswordenter' => [
                'rule' => 'rest/resetpasswordenter',
                'keywords' => [],
                'controller' => 'resetpasswordenter',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-resetpasswordbyemail' => [
                'rule' => 'rest/resetpasswordbyemail',
                'keywords' => [],
                'controller' => 'resetpasswordbyemail',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-resetpasswordsetnewpass' => [
                'rule' => 'rest/resetpasswordsetnewpass',
                'keywords' => [],
                'controller' => 'resetpasswordsetnewpass',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-listcomments' => [
                'rule' => 'rest/listcomments',
                'keywords' => [],
                'controller' => 'listcomments',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-postcomment' => [
                'rule' => 'rest/postcomment',
                'keywords' => [],
                'controller' => 'postcomment',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-hello' => [
                'rule' => 'rest',
                'keywords' => [],
                'controller' => 'hello',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-hello-s' => [
                'rule' => 'rest/',
                'keywords' => [],
                'controller' => 'hello',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-ps_checkpayment' => [
                'rule' => 'rest/ps_checkpayment',
                'keywords' => [],
                'controller' => 'ps_checkpayment',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-ps_wirepayment' => [
                'rule' => 'rest/ps_wirepayment',
                'keywords' => [],
                'controller' => 'ps_wirepayment',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-ps_cashondelivery' => [
                'rule' => 'rest/ps_cashondelivery',
                'keywords' => [],
                'controller' => 'ps_cashondelivery',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-wishlist' => [
                'rule' => 'rest/wishlist',
                'keywords' => [],
                'controller' => 'wishlist',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            'module-binshopsrest-emailsubscription' => [
                'rule' => 'rest/emailsubscription',
                'keywords' => [],
                'controller' => 'emailsubscription',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste des categories
            'module-binshopsrest-allcategories' => [
                'rule' => 'rest/allcategories',
                'keywords' => [],
                'controller' => 'allcategories',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste des Top Packs
            'module-binshopsrest-alltoppack' => [
                'rule' => 'rest/alltoppack',
                'keywords' => [],
                'controller' => 'alltoppack',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //api rest to confirm my order
            'module-binshopsrest-confirmorder' => [
                'rule' => 'rest/confirmorder',
                'keywords' => [],
                'controller' => 'confirmorder',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            //liste des produits on stock
            'module-binshopsrest-productstock' => [
                'rule' => 'rest/productstock',
                'keywords' => [],
                'controller' => 'productstock',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
            // Modifier mot de passe
            'module-binshopsrest-resetpassword' => [
                'rule' => 'rest/resetpassword',
                'keywords' => [],
                'controller' => 'resetpassword',
                'params' => [
                    'fc' => 'module',
                    'module' => 'binshopsrest'
                ]
            ],
        ];
    }
}
