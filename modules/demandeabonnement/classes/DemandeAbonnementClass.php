<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
use GuzzleHttp\Client;
require_once(_PS_MODULE_DIR_.'\jscomposer\classes\vccontentanywhere.php');
class demandeAbonnementClass extends ObjectModel
{

    public $id_demande;
    public $type_identifiant;
    public $identifiant;
    public $createddate;
    public $modifieddate;
    public $first_name;
    public $last_name;
    public $photocin1;
    public $photocin2;
    public $email;
    public $telmobile;
    public $locataire;
    public $hastelfixe;
    public $telfixe;
    public $periodpaiement_id;
    public $categorieproduitid;
    public $produitid;
    public $produitcrm;
    public $userid;
    public $gouvernoratid;
    public $villeid;
    public $adresse;
    public $codepostale;
    public $positionx;
    public $positiony;
    public $codeadresse;
    public $referencett;
    public $referencechifco;
    public $ancien_client;
    public $isactive;
    public $sendtocrm;
    public $log_message;
    public $statutid;
    public $etattt;


    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'demandeabonnement',
        'primary' => 'id_demande',
        'fields' => [
            'type_identifiant' => ['type' => self::TYPE_INT, 'required' => true],
            'identifiant' => ['type' => self::TYPE_STRING, 'required' => true],
            'createddate' => ['type' => self::TYPE_DATE, 'required' => false],
            'modifieddate' => ['type' => self::TYPE_DATE, 'required' => false],
            'first_name' => ['type' => self::TYPE_STRING, 'required' => true],
            'last_name' => ['type' => self::TYPE_STRING, 'required' => true],
            'photocin1' => ['type' => self::TYPE_STRING, 'required' => false],
            'photocin2' => ['type' => self::TYPE_STRING, 'required' => false],
            'email' => ['type' => self::TYPE_STRING, 'required' => false],
            'telmobile' => ['type' => self::TYPE_INT, 'required' => false],
            'locataire' => ['type' => self::TYPE_BOOL, 'required' => false],
            'hastelfixe' => ['type' => self::TYPE_BOOL, 'required' => false],
            'telfixe' => ['type' => self::TYPE_STRING, 'required' => false],
            'periodpaiement_id' => ['type' => self::TYPE_STRING, 'required' => false],
            'categorieproduitid' => ['type' => self::TYPE_INT, 'required' => false],
            'produitid' => ['type' => self::TYPE_STRING, 'required' => false],
            'produitcrm' => ['type' => self::TYPE_INT, 'required' => false],
            'userid' => ['type' => self::TYPE_DATE, 'required' => false],
            'gouvernoratid' => ['type' => self::TYPE_STRING, 'required' => false],
            'villeid' => ['type' => self::TYPE_STRING, 'required' => false],
            'adresse' => ['type' => self::TYPE_STRING, 'required' => false],
            'codepostale' => ['type' => self::TYPE_STRING, 'required' => false],
            'positionx' => ['type' => self::TYPE_STRING, 'required' => false],
            'positiony' => ['type' => self::TYPE_STRING, 'required' => false],
            'codeadresse' => ['type' => self::TYPE_STRING, 'required' => false],
            'referencett' => ['type' => self::TYPE_STRING, 'required' => false],
            'referencechifco' => ['type' => self::TYPE_STRING, 'required' => false],
            'ancien_client' => ['type' => self::TYPE_INT, 'required' => false],
            'isactive' => ['type' => self::TYPE_INT, 'required' => false],
            'sendtocrm' => ['type' => self::TYPE_INT, 'required' => false],
            'log_message' => ['type' => self::TYPE_STRING, 'required' => false],
            'statutid' => ['type' => self::TYPE_INT, 'required' => false],
            'etattt' => ['type' => self::TYPE_INT, 'required' => false],

        ],
    ];


}
