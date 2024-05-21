<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

/**
 * @property Store $object
 */
class AdminController extends AdminStoresControllerCore
{
    public function __construct()
    {

        parent::__construct();

    }



    public function renderForm()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $image = _PS_STORE_IMG_DIR_ . $obj->id . '.jpg';
        $image_url = ImageManager::thumbnail(
            $image,
            $this->table . '_' . (int) $obj->id . '.' . $this->imageType,
            350,
            $this->imageType,
            true,
            true
        );
        $image_size = file_exists($image) ? filesize($image) / 1000 : false;

        $tmp_addr = new Address();
        $res = $tmp_addr->getFieldsRequiredDatabase();
        $required_fields = [];
        foreach ($res as $row) {
            $required_fields[(int) $row['id_required_field']] = $row['field_name'];
        }

        $this->fields_form = [
            'legend' => [
                'title' => $this->trans('Stores', [], 'Admin.Shopparameters.Feature'),
                'icon' => 'icon-home',
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->trans('Name', [], 'Admin.Global'),
                    'name' => 'name',
                    'lang' => true,
                    'required' => false,
                    'hint' => [
                        $this->trans('Store name (e.g. City Center Mall Store).', [], 'Admin.Shopparameters.Feature'),
                        $this->trans('Allowed characters: letters, spaces and %s', [], 'Admin.Shopparameters.Feature'),
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Address', [], 'Admin.Global'),
                    'name' => 'address1',
                    'lang' => true,
                    'required' => true,
                ],
                [
                    'type' => 'select',
                    'label' => $this->trans('Gouvernerat', [], 'Admin.Global'),
                    'name' => 'address2',
                    'required' => true,
                    'lang' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Zip/Postal code', [], 'Admin.Global'),
                    'name' => 'postcode',
                    'required' => in_array('postcode', $required_fields),
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('City', [], 'Admin.Global'),
                    'name' => 'city',
                    'required' => true,
                ],
                [
                    'type' => 'select',
                    'label' => $this->trans('Country', [], 'Admin.Global'),
                    'name' => 'id_country',
                    'required' => true,
                    'default_value' => (int) $this->context->country->id,
                    'options' => [
                        'query' => Country::getCountries($this->context->language->id),
                        'id' => 'id_country',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'select',
                    'label' => $this->trans('State', [], 'Admin.Global'),
                    'name' => 'id_state',
                    'required' => true,
                    'options' => [
                        'id' => 'id_state',
                        'name' => 'name',
                        'query' => null,
                    ],
                ],
                [
                    'type' => 'latitude',
                    'label' => $this->trans('Latitude / Longitude', [], 'Admin.Shopparameters.Feature'),
                    'name' => 'latitude',
                    'required' => true,
                    'maxlength' => 12,
                    'hint' => $this->trans('Store coordinates (e.g. 45.265469/-47.226478).', [], 'Admin.Shopparameters.Feature'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Phone', [], 'Admin.Global'),
                    'name' => 'phone',
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Fax', [], 'Admin.Global'),
                    'name' => 'fax',
                ],
                [
                    'type' => 'text',
                    'label' => $this->trans('Email address', [], 'Admin.Global'),
                    'name' => 'email',
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->trans('Note', [], 'Admin.Global'),
                    'name' => 'note',
                    'lang' => true,
                    'cols' => 42,
                    'rows' => 4,
                ],
                [
                    'type' => 'switch',
                    'label' => $this->trans('Active', [], 'Admin.Global'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('Yes', [], 'Admin.Global'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('No', [], 'Admin.Global'),
                        ],
                    ],
                    'hint' => $this->trans('Whether or not to display this store.', [], 'Admin.Shopparameters.Help'),
                ],
                [
                    'type' => 'file',
                    'label' => $this->trans('Picture', [], 'Admin.Shopparameters.Feature'),
                    'name' => 'image',
                    'display_image' => true,
                    'image' => $image_url ? $image_url : false,
                    'size' => $image_size,
                    'hint' => $this->trans('Storefront picture.', [], 'Admin.Shopparameters.Help'),
                ],
            ],
            'hours' => [
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
        ];

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso',
            ];
        }

        $days = [];
        $days[1] = $this->trans('Monday', [], 'Admin.Shopparameters.Feature');
        $days[2] = $this->trans('Tuesday', [], 'Admin.Shopparameters.Feature');
        $days[3] = $this->trans('Wednesday', [], 'Admin.Shopparameters.Feature');
        $days[4] = $this->trans('Thursday', [], 'Admin.Shopparameters.Feature');
        $days[5] = $this->trans('Friday', [], 'Admin.Shopparameters.Feature');
        $days[6] = $this->trans('Saturday', [], 'Admin.Shopparameters.Feature');
        $days[7] = $this->trans('Sunday', [], 'Admin.Shopparameters.Feature');

        $hours = [];

        $hours_temp = ($this->getFieldValue($obj, 'hours'));
        if (is_array($hours_temp) && !empty($hours_temp)) {
            $langs = Language::getLanguages(false);
            $hours_temp = array_map('json_decode', $hours_temp);
            $hours = array_map(
                [$this, 'adaptHoursFormat'],
                $hours_temp
            );
            $hours = (count($langs) > 1) ? $hours : $hours[reset($langs)['id_lang']];
        }

        $this->fields_value = [
            'latitude' => $this->getFieldValue($obj, 'latitude') ? $this->getFieldValue($obj, 'latitude') : '',
            'longitude' => $this->getFieldValue($obj, 'longitude') ? $this->getFieldValue($obj, 'longitude') : '',
            'days' => $days,
            'hours' => $hours,
        ];

        return parent::renderForm();
    }


    protected function _getDefaultFieldsContent()
    {
        $this->context = Context::getContext();
        $countryList = [];
        $countryList[] = ['id' => '0', 'name' => $this->trans('Choose your country', [], 'Admin.Shopparameters.Feature')];
        foreach (Country::getCountries($this->context->language->id) as $country) {
            $countryList[] = ['id' => $country['id_country'], 'name' => $country['name']];
        }
        $stateList = [];
        $stateList[] = ['id' => '0', 'name' => $this->trans('Choose your state (if applicable)', [], 'Admin.Shopparameters.Feature')];
        foreach (State::getStates($this->context->language->id) as $state) {
            $stateList[] = ['id' => $state['id_state'], 'name' => $state['name']];
        }

        $formFields = [
            'PS_SHOP_NAME' => [
                'title' => $this->trans('Shop name', [], 'Admin.Shopparameters.Feature'),
                'hint' => $this->trans('Displayed in emails and page titles.', [], 'Admin.Shopparameters.Feature'),
                'validation' => 'isGenericName',
                'required' => true,
                'type' => 'text',
                'no_escape' => true,
            ],
            'PS_SHOP_EMAIL' => ['title' => $this->trans('Shop email', [], 'Admin.Shopparameters.Feature'),
                'hint' => $this->trans('Displayed in emails sent to customers.', [], 'Admin.Shopparameters.Help'),
                'validation' => 'isEmail',
                'required' => true,
                'type' => 'text',
            ],
            'PS_SHOP_DETAILS' => [
                'title' => $this->trans('Registration number', [], 'Admin.Shopparameters.Feature'),
                'hint' => $this->trans('Shop registration information (e.g. SIRET or RCS).', [], 'Admin.Shopparameters.Help'),
                'validation' => 'isGenericName',
                'type' => 'textarea',
                'cols' => 30,
                'rows' => 5,
            ],
            'PS_SHOP_ADDR1' => [
                'title' => $this->trans('Shop address line 1', [], 'Admin.Shopparameters.Feature'),
                'validation' => 'isAddress',
                'type' => 'text',
            ],
            'PS_SHOP_ADDR2' => [
                'title' => $this->trans('Shop address line 2', [], 'Admin.Shopparameters.Feature'),
                'validation' => 'isAddress',
                'type' => 'text',
            ],
            'PS_SHOP_CODE' => [
                'title' => $this->trans('Zip/Postal code', [], 'Admin.Global'),
                'validation' => 'isGenericName',
                'type' => 'text',
            ],
            'PS_SHOP_CITY' => [
                'title' => $this->trans('City', [], 'Admin.Global'),
                'validation' => 'isGenericName',
                'type' => 'text',
            ],
            'PS_SHOP_COUNTRY_ID' => [
                'title' => $this->trans('Country', [], 'Admin.Global'),
                'validation' => 'isInt',
                'type' => 'select',
                'list' => $countryList,
                'identifier' => 'id',
                'cast' => 'intval',
                'defaultValue' => (int) $this->context->country->id,
            ],
            'PS_SHOP_STATE_ID' => [
                'title' => $this->trans('State', [], 'Admin.Global'),
                'validation' => 'isInt',
                'type' => 'select',
                'list' => $stateList,
                'identifier' => 'id',
                'cast' => 'intval',
            ],
            'PS_SHOP_PHONE' => [
                'title' => $this->trans('Phone', [], 'Admin.Global'),
                'validation' => 'isGenericName',
                'type' => 'text',
            ],
            'PS_SHOP_FAX' => [
                'title' => $this->trans('Fax', [], 'Admin.Global'),
                'validation' => 'isGenericName',
                'type' => 'text',
            ],
        ];

        return $formFields;
    }

    protected function _buildOrderedFieldsShop($formFields)
    {
        // You cannot do that, because the fields must be sorted for the country you've selected.
        // Simple example: the current country is France, where we don't display the state. You choose "US" as a country in the form. The state is not dsplayed at the right place...

        // $associatedOrderKey = array(
        // 'PS_SHOP_NAME' => 'company',
        // 'PS_SHOP_ADDR1' => 'address1',
        // 'PS_SHOP_ADDR2' => 'address2',
        // 'PS_SHOP_CITY' => 'city',
        // 'PS_SHOP_STATE_ID' => 'State:name',
        // 'PS_SHOP_CODE' => 'postcode',
        // 'PS_SHOP_COUNTRY_ID' => 'Country:name',
        // 'PS_SHOP_PHONE' => 'phone');
        // $fields = array();
        // $orderedFields = AddressFormat::getOrderedAddressFields(Configuration::get('PS_SHOP_COUNTRY_ID'), false, true);
        // foreach ($orderedFields as $lineFields)
        // if (($patterns = explode(' ', $lineFields)))
        // foreach ($patterns as $pattern)
        // if (($key = array_search($pattern, $associatedOrderKey)))
        // $fields[$key] = $formFields[$key];
        // foreach ($formFields as $key => $value)
        // if (!isset($fields[$key]))
        // $fields[$key] = $formFields[$key];

        $fields = $formFields;
        $this->fields_options['contact'] = [
            'title' => $this->trans('Contact details', [], 'Admin.Shopparameters.Feature'),
            'icon' => 'icon-user',
            'fields' => $fields,
            'submit' => ['title' => $this->trans('Save', [], 'Admin.Actions')],
        ];
    }

    public function beforeUpdateOptions()
    {
        if (isset($_POST['PS_SHOP_STATE_ID']) && $_POST['PS_SHOP_STATE_ID'] != '0') {
            $sql = 'SELECT `active` FROM `' . _DB_PREFIX_ . 'state`
					WHERE `id_country` = ' . (int) Tools::getValue('PS_SHOP_COUNTRY_ID') . '
						AND `id_state` = ' . (int) Tools::getValue('PS_SHOP_STATE_ID');
            $isStateOk = Db::getInstance()->getValue($sql);
            if ($isStateOk != 1) {
                $this->errors[] = $this->trans('The specified state is not located in this country.', [], 'Admin.Shopparameters.Notification');
            }
        }
    }

    public function updateOptionPsShopCountryId($value)
    {
        if (!$this->errors && $value) {
            $country = new Country($value, $this->context->language->id);
            if ($country->id) {
                Configuration::updateValue('PS_SHOP_COUNTRY_ID', $value);
                Configuration::updateValue('PS_SHOP_COUNTRY', pSQL($country->name));
            }
        }
    }

    public function updateOptionPsShopStateId($value)
    {
        if (!$this->errors && $value) {
            $state = new State($value);
            if ($state->id) {
                Configuration::updateValue('PS_SHOP_STATE_ID', $value);
                Configuration::updateValue('PS_SHOP_STATE', pSQL($state->name));
            }
        }
    }

    /**
     * Adapt the format of hours.
     *
     * @param array $value
     *
     * @return array
     */
    protected function adaptHoursFormat($value)
    {
        $separator = array_fill(0, count($value), ' | ');

        return array_map('implode', $separator, $value);
    }
}
