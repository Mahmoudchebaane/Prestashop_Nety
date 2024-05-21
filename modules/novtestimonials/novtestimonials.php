<?php
/******************
 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package    novtestimonials
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) May 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

/**
 * @since   1.5.0
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'novtestimonials/Testimonials.php');

class novtestimonials extends Module
{
	private $_html = '';
	private $default_limit = 5;
	private $default_type = 'type-one';

	public function __construct()
	{
		$this->name = 'novtestimonials';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'VinovaThemes';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();
		$this->themeName = Context::getContext()->shop->theme_name;
		$this->displayName = $this->l('Vinova Testimonials for your homepage');
		$this->description = $this->l('Adds an image Testimonials to your homepage.');
		$this->ps_versions_compliancy = array('min' => '1.6.0.4', 'max' => _PS_VERSION_);
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
		if (parent::install() &&
			//$this->registerHook('displayHome') &&
			$this->registerHook('displayNovTestimonal') &&
			$this->registerHook('actionShopDataDuplication')
		)
		{
			$shops = Shop::getContextListShopID();
			$shop_groups_list = array();

			/* Setup each shop */
			foreach ($shops as $shop_id)
			{
				$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

				if (!in_array($shop_group_id, $shop_groups_list))
					$shop_groups_list[] = $shop_group_id;

				/* Sets up configuration */
				$res = Configuration::updateValue('novtestimonials_limit', $this->default_limit, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_type', $this->default_type, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_desktop', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_tablet', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_mobile', 1, false, $shop_group_id, $shop_id);
			}
			
			/* Sets up Shop Group configuration */
			if (count($shop_groups_list))
			{
				foreach ($shop_groups_list as $shop_group_id)
				{
				$res = Configuration::updateValue('novtestimonials_limit', $this->default_limit, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_type', $this->default_type, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_desktop', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_tablet', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_mobile', 1, false, $shop_group_id, $shop_id);
				}
			}

			/* Sets up Global configuration */
				$res = Configuration::updateValue('novtestimonials_limit', $this->default_limit, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_type', $this->default_type, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_desktop', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_tablet', 1, false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_mobile', 1, false, $shop_group_id, $shop_id);


			/* Creates tables */
			$res &= $this->createTables();

			/* Adds samples */
			if ($res)
				$this->installSamples();

			// Disable on mobiles and tablets
			$this->disableDevice(Context::DEVICE_MOBILE);

			return (bool)$res;
		}

		return false;
	}

	/**
	 * Adds samples
	 */
	private function installSamples()
	{
		$languages = Language::getLanguages(false);
		for ($i = 1; $i <= 3; ++$i)
		{
		
			$testimonial = new Testimonials();
			$testimonial->position   = $i;
			$testimonial->active     = 1;
			$testimonial->image     = 'image-'.$i.'.png';
			$testimonial->name       = 'Vinova '.$i;
			$testimonial->email      = 'vinovathemes@gmail.com';
			$testimonial->company    = 'Vinova Theme';
			$testimonial->address    = 'Street - City';
			$testimonial->url = 'https://www.youtube.com/watch?v=BtkgzFoeZfQ';

			foreach ($languages as $lang)
			{
				$testimonial->content[$lang['id_lang']]   = "Liquam quis risus viverra, ornare ipsum vitae, congue tellus. Vestibulum nunc lorem, scelerisque a tristique non, accumsan ornare eros. Nullam sapien metus, volutpat dictum..".$i;
				$testimonial->html[$lang['id_lang']]      = 'Praesent tellus felis, aliquet id augue at, tincidunt vestibulum '.$i;
			}
			$testimonial->add();
		}
	}

	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();
			/* Unsets configuration */
			$res &= Configuration::deleteByName('novtestimonials_limit');
			$res &= Configuration::deleteByName('novtestimonials_type');
			$res &= Configuration::deleteByName('novtestimonials_item_desktop');
			$res &= Configuration::deleteByName('novtestimonials_item_tablet');
			$res &= Configuration::deleteByName('novtestimonials_item_mobile');


			return (bool)$res;
		}

		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
	
		/* testimonials */
		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'novtestimonials` (
			  	`id_novtestimonials` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  	`name` varchar(100) NOT NULL,
			    `email` varchar(100) NOT NULL,
			    `company` varchar(255) DEFAULT NULL,
			    `address` varchar(255) NOT NULL,
			    `date_add` datetime DEFAULT NULL,
			    `position` int(11) DEFAULT NULL,
			  	`active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
			  	PRIMARY KEY (`id_novtestimonials`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');
		/* novtestimonials_lang */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'novtestimonials_lang` (
			  	`id_novtestimonials` int(10) unsigned NOT NULL,
				`id_lang` int(10) NOT NULL,
			    `content` varchar(500) NOT NULL,
			    `html` varchar(500) DEFAULT NULL,
				`url` varchar(255) NOT NULL,
				`image` varchar(255) NOT NULL,
			  	PRIMARY KEY (`id_novtestimonials`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');
		/* novtestimonials_shop */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'novtestimonials_shop` (
			  	`id_novtestimonials` int(10) unsigned NOT NULL,
				`id_shop` int(10) NOT NULL,
			  	PRIMARY KEY (`id_novtestimonials`,`id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');
	

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$testimonials = $this->getTestimonialss();
		foreach ($testimonials as $testimonial)
		{
			$to_del = new Testimonials ($testimonial['id_novtestimonials']);
			$to_del->delete();
		}

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'novtestimonials`, `'._DB_PREFIX_.'novtestimonials_lang`, `'._DB_PREFIX_.'novtestimonials_shop`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();

		/* Validate & process */
		if (Tools::isSubmit('submitTestimonials') || Tools::isSubmit('delete_id_novtestimonials') ||
			Tools::isSubmit('submitTestimonialsr') ||
			Tools::isSubmit('changeStatus')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
				$this->_html .= $this->renderForm();
				$this->_html .= $this->renderList();
			}
			else
				$this->_html .= $this->renderAddForm();

			$this->clearCache();
		}
		elseif (Tools::isSubmit('addTestimonials') || (Tools::isSubmit('id_novtestimonials') && $this->testimonialExists((int)Tools::getValue('id_novtestimonials'))))
		{
			if (Tools::isSubmit('addTestimonials'))
				$mode = 'add';
			else
				$mode = 'edit';

			if ($mode == 'add')
			{
				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
					$this->_html .= $this->renderAddForm();
				else
					$this->_html .= $this->getShopContextError(null, $mode);
			}
			else
			{
				$associated_shop_ids = Testimonials ::getAssociatedIdsShop((int)Tools::getValue('id_novtestimonials'));
				$context_shop_id = (int)Shop::getContextShopID();

				if ($associated_shop_ids === false)
					$this->_html .= $this->getShopAssociationError((int)Tools::getValue('id_novtestimonials'));
				else if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL && in_array($context_shop_id, $associated_shop_ids))
				{
					if (count($associated_shop_ids) > 1)
						$this->_html = $this->getSharedTestimonialsWarning();
					$this->_html .= $this->renderAddForm();
				}
				else
				{
					$shops_name_list = array();
					foreach ($associated_shop_ids as $shop_id)
					{
						$associated_shop = new Shop((int)$shop_id);
						$shops_name_list[] = $associated_shop->name;
					}
					$this->_html .= $this->getShopContextError($shops_name_list, $mode);
				}
			}
		}
		else // Default viewport
		{
			$this->_html .= $this->getWarningMultishopHtml().$this->getCurrentShopInfoMsg().$this->renderForm();

			if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
				$this->_html .= $this->renderList();
		}

		return $this->_html;
	}

	private function _postValidation()
	{
		$errors = array();

		/* Validation for Testimonialsr configuration */
		if (Tools::isSubmit('submitTestimonialsr'))
		{

			if (!Validate::isInt(Tools::getValue('HOMESLIDER_SPEED')) || !Validate::isInt(Tools::getValue('HOMESLIDER_PAUSE')) ||
				!Validate::isInt(Tools::getValue('HOMESLIDER_WIDTH'))
			)
				$errors[] = $this->l('Invalid values');
		} /* Validation for status */
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_novtestimonials')))
				$errors[] = $this->l('Invalid testimonial');
		}
		/* Validation for Testimonials */
		elseif (Tools::isSubmit('submitTestimonials'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_testimonial')) || (Tools::getValue('active_testimonial') != 0 && Tools::getValue('active_testimonial') != 1))
				$errors[] = $this->l('Invalid testimonial state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid testimonial position.');
			/* If edit : checks id_novtestimonials */
			if (Tools::isSubmit('id_novtestimonials'))
			{

				//d(var_dump(Tools::getValue('id_novtestimonials')));
				if (!Validate::isInt(Tools::getValue('id_novtestimonials')) && !$this->testimonialExists(Tools::getValue('id_novtestimonials')))
					$errors[] = $this->l('Invalid testimonial ID');
			}
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('content_'.$language['id_lang'])) > 500)
					$errors[] = $this->l('The content is too long.');
				if (Tools::strlen(Tools::getValue('html_'.$language['id_lang'])) > 500)
					$errors[] = $this->l('The html is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
				if (Tools::getValue('image_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
				if (Tools::getValue('image_old_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_old_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (Tools::strlen(Tools::getValue('url_'.$id_lang_default)) == 0)
				$errors[] = $this->l('The URL is not set.');
			if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('The image is not set.');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('The image is not set.');
			if ( !Validate::isEmail(Tools::getValue('email')) )
				$errors[] = $this->l('The email is empty or incorrect data input.');	
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_novtestimonials') && (!Validate::isInt(Tools::getValue('delete_id_novtestimonials')) || !$this->testimonialExists((int)Tools::getValue('delete_id_novtestimonials'))))
			$errors[] = $this->l('Invalid testimonial ID');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	private function _postProcess()
	{
		$errors = array();
		$shop_context = Shop::getContext();

		/* Processes Testimonialsr */
		if (Tools::isSubmit('submitTestimonialsr'))
		{
			$shop_groups_list = array();
			$shops = Shop::getContextListShopID();

			foreach ($shops as $shop_id)
			{
				$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

				if (!in_array($shop_group_id, $shop_groups_list))
					$shop_groups_list[] = $shop_group_id;
				
				$res = Configuration::updateValue('novtestimonials_limit', (int)Tools::getValue('novtestimonials_limit'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_type', Tools::getValue('novtestimonials_type'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_desktop', Tools::getValue('novtestimonials_item_desktop'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_tablet', Tools::getValue('novtestimonials_item_tablet'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_mobile', Tools::getValue('novtestimonials_item_mobile'), false, $shop_group_id, $shop_id);
			}

			/* Update global shop context if needed*/
			switch ($shop_context)
			{
				case Shop::CONTEXT_ALL:
				$res = Configuration::updateValue('novtestimonials_limit', (int)Tools::getValue('novtestimonials_limit'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_type', Tools::getValue('novtestimonials_type'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_desktop', Tools::getValue('novtestimonials_item_desktop'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_tablet', Tools::getValue('novtestimonials_item_tablet'), false, $shop_group_id, $shop_id);
				$res &= Configuration::updateValue('novtestimonials_item_mobile', Tools::getValue('novtestimonials_item_mobile'), false, $shop_group_id, $shop_id);
					if (count($shop_groups_list))
					{
						foreach ($shop_groups_list as $shop_group_id)
						{
							$res = Configuration::updateValue('novtestimonials_limit', (int)Tools::getValue('novtestimonials_limit'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_type', Tools::getValue('novtestimonials_type'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_desktop', Tools::getValue('novtestimonials_item_desktop'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_tablet', Tools::getValue('novtestimonials_item_tablet'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_mobile', Tools::getValue('novtestimonials_item_mobile'), false, $shop_group_id, $shop_id);
						}
					}
					break;
				case Shop::CONTEXT_GROUP:
					if (count($shop_groups_list))
					{
						foreach ($shop_groups_list as $shop_group_id)
						{
							$res = Configuration::updateValue('novtestimonials_limit', (int)Tools::getValue('novtestimonials_limit'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_type', Tools::getValue('novtestimonials_type'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_desktop', Tools::getValue('novtestimonials_item_desktop'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_tablet', Tools::getValue('novtestimonials_item_tablet'), false, $shop_group_id, $shop_id);
							$res &= Configuration::updateValue('novtestimonials_item_mobile', Tools::getValue('novtestimonials_item_mobile'), false, $shop_group_id, $shop_id);
						}
					}
					break;
			}

			$this->clearCache();

			if (!$res)
				$errors[] = $this->displayError($this->l('The configuration could not be updated.'));
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		} /* Process Testimonials status */
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_novtestimonials'))
		{
			$testimonial = new Testimonials ((int)Tools::getValue('id_novtestimonials'));
			if ($testimonial->active == 0)
				$testimonial->active = 1;
			else
				$testimonial->active = 0;
			$res = $testimonial->update();
			$this->clearCache();
			$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('The configuration could not be updated.')));
		}
		/* Processes Testimonials */
		elseif (Tools::isSubmit('submitTestimonials'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_novtestimonials'))
			{
				$testimonial = new Testimonials ((int)Tools::getValue('id_novtestimonials'));
				if (!Validate::isLoadedObject($testimonial))
				{
					$this->_html .= $this->displayError($this->l('Invalid testimonial ID'));
					return false;
				}
			}
			else
				$testimonial = new Testimonials ();
			/* Sets position */
			$testimonial->position = (int)$this->getNextPosition();
			/* Sets active */
			$testimonial->active = (int)Tools::getValue('active_testimonial');
			$testimonial->name = Tools::getValue('name');
			$testimonial->email = Tools::getValue('email');
			$testimonial->company = Tools::getValue('company');
			$testimonial->address = Tools::getValue('address');

			/* Sets each langue fields */
			$languages = Language::getLanguages(false);

			foreach ($languages as $language)
			{
				$testimonial->content[$language['id_lang']] = Tools::getValue('content_'.$language['id_lang']);
				$testimonial->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
				$testimonial->html[$language['id_lang']] = Tools::getValue('html_'.$language['id_lang']);

				/* Uploads image and sets testimonial */
				$type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
				$imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name']);
				if (isset($_FILES['image_'.$language['id_lang']]) &&
					isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($imagesize) &&
					in_array(
						Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
							'jpg',
							'gif',
							'jpeg',
							'png'
						)
					) &&
					in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
				)
				{
					$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
					$salt = sha1(microtime());
					if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']]))
						$errors[] = $error;
					elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name))
						return false;
					elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.Tools::encrypt($_FILES['image']['name'].$salt).'.'.$type, null, null, $type))
						$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
					if (isset($temp_name))
						@unlink($temp_name);
					$testimonial->image[$language['id_lang']] = Tools::encrypt($_FILES['image']['name'].$salt).'.'.$type;
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$testimonial->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_novtestimonials'))
				{
					if (!$testimonial->add())
						$errors[] = $this->displayError($this->l('The testimonial could not be added.'));
				}
				/* Update */
				elseif (!$testimonial->update())
					$errors[] = $this->displayError($this->l('The testimonial could not be updated.'));
				$this->clearCache();
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_novtestimonials'))
		{
			$testimonial = new Testimonials ((int)Tools::getValue('delete_id_novtestimonials'));
			$res = $testimonial->delete();
			$this->clearCache();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitTestimonials') && Tools::getValue('id_novtestimonials'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		elseif (Tools::isSubmit('submitTestimonials'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
	}

	private function _prepareHook()
	{
		if (!$this->isCached('module:novtestimonials/views/templates/hook/novtestimonials.tpl', $this->getCacheId()))
		{
			$config = array(
            	'novtestimonials_item_desktop' =>  Configuration::get("novtestimonials_item_desktop") ? Configuration::get("novtestimonials_item_desktop") : 1,
            	'novtestimonials_item_tablet' =>  Configuration::get("novtestimonials_item_tablet") ? Configuration::get("novtestimonials_item_tablet") : 1,
            	'novtestimonials_item_mobile' =>  Configuration::get("novtestimonials_item_mobile") ? Configuration::get("novtestimonials_item_mobile") : 1,
	            'link_image' => _MODULE_DIR_.$this->name.'/images/',
            );

            if(Tools::getValue('home')){
				Tools::clearSmartyCache();
				
				$home = Tools::getValue('home');
				$config_home = (isset($home_page[$home]) && ($home_page[$home])) ? ($home_page[$home]) : array();
				$config['novtestimonials_item_desktop'] = $config_home['novtestimonials_item_desktop'];
				$config['novtestimonials_type'] = $config_home['novtestimonials_type'];
				$config['novtestimonials_limit'] = $config_home['novtestimonials_limit'];
				
			} else {
			}
			$config['novtestimonials_item_desktop'] = Configuration::get("novtestimonials_item_desktop") ? Configuration::get("novtestimonials_item_desktop") : 1;
			$config['novtestimonials_type'] = Configuration::get("novtestimonials_type") ? Configuration::get("novtestimonials_type") : 'type-one';
			$config['novtestimonials_limit'] =  Configuration::get("novtestimonials_limit") ? Configuration::get("novtestimonials_limit") : 5;

			$testimonials = $this->getTestimonialss(true);
			
			if (is_array($testimonials))
				foreach ($testimonials as &$testimonial)
				{
					$testimonial['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$testimonial['image']));
					if (isset($testimonial['sizes'][3]) && $testimonial['sizes'][3])
						$testimonial['size'] = $testimonial['sizes'][3];
				}

			if (!$testimonials)
				return false;

			$this->smarty->assign(array('novtestimonials' => $testimonials));
			$this->smarty->assign('config_testimonials' , $config);
			
		}

		return true;
	}


	public function hookDisplayHome()
	{
		if (!$this->isCached('module:novtestimonials/views/templates/hook/novtestimonials.tpl', $this->getCacheId()))
		{
			$config = array(
            	'novtestimonials_item_desktop' =>  Configuration::get("novtestimonials_item_desktop") ? Configuration::get("novtestimonials_item_desktop") : 1,
            	'novtestimonials_item_tablet' =>  Configuration::get("novtestimonials_item_tablet") ? Configuration::get("novtestimonials_item_tablet") : 1,
            	'novtestimonials_item_mobile' =>  Configuration::get("novtestimonials_item_mobile") ? Configuration::get("novtestimonials_item_mobile") : 1,
	            'link_image' => _MODULE_DIR_.$this->name.'/images/',
            );

            if(Tools::getValue('home')){
				Tools::clearSmartyCache();
				include(_PS_ALL_THEMES_DIR_ . $this->themeName.'/sample/ConfigHomePage.php');
				$home = Tools::getValue('home');
				$config_home = (isset($home_page[$home]) && ($home_page[$home])) ? ($home_page[$home]) : array();
				if(isset($config_home['novtestimonials_item_desktop']) && $config_home['novtestimonials_item_desktop']){
					$config['novtestimonials_item_desktop'] = $config_home['novtestimonials_item_desktop'];
				} else {
					$config['novtestimonials_item_desktop'] = Configuration::get("novtestimonials_item_desktop") ? Configuration::get("novtestimonials_item_desktop") : 1;
				}
				if(isset($config_home['novtestimonials_type']) && $config_home['novtestimonials_type']){
					$config['novtestimonials_type'] = $config_home['novtestimonials_type'];
				} else {
					$config['novtestimonials_type'] = Configuration::get("novtestimonials_type") ? Configuration::get("novtestimonials_type") : 'type-one';
				}
				if(isset($config_home['novtestimonials_limit']) && $config_home['novtestimonials_limit']){
					$config['novtestimonials_limit'] = $config_home['novtestimonials_limit'];
				} else {
					$config['novtestimonials_limit'] = Configuration::get("novtestimonials_limit") ? Configuration::get("novtestimonials_limit") : 5;
				}
				
			} else {
				$config['novtestimonials_item_desktop'] = Configuration::get("novtestimonials_item_desktop") ? Configuration::get("novtestimonials_item_desktop") : 1;
				$config['novtestimonials_type'] = Configuration::get("novtestimonials_type") ? Configuration::get("novtestimonials_type") : 'type-one';
				$config['novtestimonials_limit'] =  Configuration::get("novtestimonials_limit") ? Configuration::get("novtestimonials_limit") : 5;
			}

			$testimonials = $this->getTestimonialss(true);
			
			if (is_array($testimonials))
				foreach ($testimonials as &$testimonial)
				{
					$testimonial['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$testimonial['image']));
					if (isset($testimonial['sizes'][3]) && $testimonial['sizes'][3])
						$testimonial['size'] = $testimonial['sizes'][3];
				}

			if (!$testimonials)
				return false;

			$this->smarty->assign(array('novtestimonials' => $testimonials));
			$this->smarty->assign('config_testimonials' , $config);
			
		}
		return $this->display(__FILE__, 'novtestimonials.tpl', $this->getCacheId());
	}

	public function hookDisplayNovTestimonal()
	{
		if (!$this->_prepareHook())
			return false;

		return $this->display(__FILE__, 'novtestimonials.tpl', $this->getCacheId());
	}

	public function clearCache()
	{
		$this->_clearCache('novtestimonials.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
			INSERT IGNORE INTO '._DB_PREFIX_.'novtestimonials  (id_novtestimonials _testimonials, id_shop)
			SELECT id_novtestimonials, '.(int)$params['new_id_shop'].'
			FROM '._DB_PREFIX_.'novtestimonials 
			WHERE id_shop = '.(int)$params['old_id_shop']
		);
		$this->clearCache();
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');
		/* Style & js for fieldset 'testimonials configuration' */
		$html = '<script type="text/javascript">
			$(function() {
				var $myTestimonialss = $("#testimonials");
				$myTestimonialss.sortable({
					opacity: 0.6,
					cursor: "move",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateTestimonialssPosition";
						$.post("'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'", order);
						}
					});
				$myTestimonialss.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
				});
			});
		</script>';

		return $html;
	}

	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(hs.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'novtestimonials_shop` hss, `'._DB_PREFIX_.'novtestimonials` hs
			WHERE hss.`id_novtestimonials` = hs.`id_novtestimonials` AND hss.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	public function getTestimonialss($active = null)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_novtestimonials` as id_novtestimonials, hssl.`image`,hs.`name`, hs.`company`, hs.`address`, hs.`position`, hs.`active`, hssl.`content`,
			hssl.`url`, hssl.`html`, hssl.`image`
			FROM '._DB_PREFIX_.'novtestimonials  hs
			LEFT JOIN '._DB_PREFIX_.'novtestimonials_shop hss ON (hs.id_novtestimonials = hss.id_novtestimonials)
			LEFT JOIN '._DB_PREFIX_.'novtestimonials_lang hssl ON (hss.id_novtestimonials = hssl.id_novtestimonials)
			WHERE id_shop = '.(int)$id_shop.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hs.`active` = 1' : ' ').'
			ORDER BY hs.position'
		);
	}

	public function getAllImagesByTestimonialssId($id_novtestimonialss, $active = null, $id_shop = null)
	{
		$this->context = Context::getContext();
		$images = array();

		if (!isset($id_shop))
			$id_shop = $this->context->shop->id;

		$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hssl.`image`, hssl.`id_lang`
			FROM '._DB_PREFIX_.'novtestimonials  hs
			LEFT JOIN '._DB_PREFIX_.'novtestimonials_shop hss ON (hs.id_novtestimonials  = hss.id_novtestimonials )
			LEFT JOIN '._DB_PREFIX_.'novtestimonials_lang hssl ON (hss.id_novtestimonials  = hssl.id_novtestimonials )
			WHERE hs.`id_novtestimonials` = '.(int)$id_novtestimonialss.' AND hss.`id_shop` = '.(int)$id_shop.
			($active ? ' AND hs.`active` = 1' : ' ')
		);

		foreach ($results as $result)
			$images[$result['id_lang']] = $result['image'];

		return $images;
	}

	public function displayStatus($id_novtestimonials, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_novtestimonials='.(int)$id_novtestimonials.'" title="'.$title.'"><i class="'.$icon.'"></i> '.$title.'</a>';

		return $html;
	}

	public function testimonialExists($id_novtestimonials)
	{
		$req = 'SELECT hs.`id_novtestimonials` as id_novtestimonials
				FROM `'._DB_PREFIX_.'novtestimonials` hs
				WHERE hs.`id_novtestimonials` = '.(int)$id_novtestimonials;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function renderList()
	{
		$testimonials = $this->getTestimonialss();
		foreach ($testimonials as $key => $testimonial)
		{
			$testimonials[$key]['status'] = $this->displayStatus($testimonial['id_novtestimonials'], $testimonial['active']);
			$associated_shop_ids = Testimonials ::getAssociatedIdsShop((int)$testimonial['id_novtestimonials']);
			if ($associated_shop_ids && count($associated_shop_ids) > 1)
				$testimonials[$key]['is_shared'] = true;
			else
				$testimonials[$key]['is_shared'] = false;
		}

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'testimonials' => $testimonials,
				'image_baseurl' => $this->_path.'images/'
			)
		);

		return $this->display(__FILE__, 'list.tpl');
	}

	public function renderAddForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Testimonials information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(

					array(
						'type' => 'text',
						'label' => $this->l('Name'),
						'name' => 'name',
						'desc' => 'Not empty!',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Email'),
						'name' => 'email',
						'desc' => 'Email should to input correctly format.',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Company or Job position'),
						'name' => 'company',
						'desc' => "Your company's name",
					),
					array(
						'type' => 'text',
						'label' => $this->l('Address'),
						'name' => 'address',
						'desc' => 'Not empty!',
					),
					array(
						'type' => 'file_lang',
						'label' => $this->l('Image'),
						'name' => 'image',
						'lang' => true
					),
					array(
						'type' => 'text',
						'label' => $this->l('URL'),
						'name' => 'url',
						'lang' => true,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Content'),
						'name' => 'content',
						'autoload_rte' => true,
						'lang' => true,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Html'),
						'name' => 'html',
						'autoload_rte' => true,
						'required' => false,
						'lang' => true,
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'active_testimonial',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_novtestimonials') && $this->testimonialExists((int)Tools::getValue('id_novtestimonials')))
		{
			$testimonial = new Testimonials ((int)Tools::getValue('id_novtestimonials'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_novtestimonials');
			$fields_form['form']['images'] = $testimonial->image;

			$has_picture = true;

			foreach (Language::getLanguages(false) as $lang)
				if (!isset($testimonial->image[$lang['id_lang']]))
					$has_picture &= false;

			if ($has_picture)
				$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
		}
		
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitTestimonials';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->_path.'images/'
		);

		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);

		if (count($languages) > 1)
			return $this->getMultiLanguageInfoMsg().$helper->generateForm(array($fields_form));
		else
			return $helper->generateForm(array($fields_form));
	}

	public function renderForm()
	{
		$helper = new HelperForm();

		$list_style = array(
		  array(
			'value' => 'type_one',
			'name' 	=> 	$this->l('Type One')
		  ),
		  array(
			'value' => 'type_two',
			'name' 	=> 	$this->l('Type Two')
		  ),
		  array(
			'value' => 'type_three',
			'name' 	=> 	$this->l('Type Three')
		  ),
		);

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),

                'input' => array(
                	array(
                		'type' => 'text',
                		'label' => $this->l('Testimonials limit:'),
                		'name' => 'novtestimonials_limit',
                		'suffix' => 'integer',
                		'desc' => $this->l('The maximum number testimonial show in list  (default: 5)'),
                        'default' => '5',
                	),
                	array(
					  'type' => 'select',                              
					  'label' => $this->l('Testimonials Item Style'),
					  'name' => 'novtestimonials_type',   
					  'default' => 'type_one',		                          
					  'options' => array(
						'query' => $list_style,
						'id' => 'value',                           
						'name' => 'name',                               
					  )
					),
					array(
                		'type' => 'text',
                		'label' => $this->l('Column on Desktop'),
                		'name' => 'novtestimonials_item_desktop',
                		'suffix' => 'integer',
                		'desc' => $this->l('The column products in Page (default: 1). '),
                        'default' => '1',
                	),
                	array(
                		'type' => 'text',
                		'label' => $this->l('Column on Tablets'),
                		'name' => 'novtestimonials_item_tablet',
                		'suffix' => 'integer',
                		'desc' => $this->l('The column products on Tablets (default: 1).'),
                        'default' => '1',
                	),
               		array(
                		'type' => 'text',
                		'label' => $this->l('Column on Mobile'),
                		'name' => 'novtestimonials_item_mobile',
                		'suffix' => 'integer',
                		'desc' => $this->l('The column products on Mobile (default: 1). '),
                        'default' => '1',
                	)
                	
                ),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitTestimonialsr';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		$id_shop_group = Shop::getContextShopGroupID();
		$id_shop = Shop::getContextShopID();
		
		return array(
			'novtestimonials_limit' => Tools::getValue('novtestimonials_limit', Configuration::get('novtestimonials_limit', null, $id_shop_group, $id_shop)),
			'novtestimonials_type' => Tools::getValue('novtestimonials_type', Configuration::get('novtestimonials_type', null, $id_shop_group, $id_shop)),
			'novtestimonials_item_desktop' => Tools::getValue('novtestimonials_item_desktop', Configuration::get('novtestimonials_item_desktop', null, $id_shop_group, $id_shop)),
			'novtestimonials_item_tablet' => Tools::getValue('novtestimonials_item_tablet', Configuration::get('novtestimonials_item_tablet', null, $id_shop_group, $id_shop)),
			'novtestimonials_item_mobile' => Tools::getValue('novtestimonials_item_mobile', Configuration::get('novtestimonials_item_mobile', null, $id_shop_group, $id_shop)),
		);
	}

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_novtestimonials') && $this->testimonialExists((int)Tools::getValue('id_novtestimonials')))
		{
			$testimonial = new Testimonials ((int)Tools::getValue('id_novtestimonials'));
			$fields['id_novtestimonials'] = (int)Tools::getValue('id_novtestimonials', $testimonial->id);
		}
		else
			$testimonial = new Testimonials ();
		
		$fields['active_testimonial'] = Tools::getValue('active_testimonial', $testimonial->active);
		$fields['name'] = Tools::getValue('name', $testimonial->name);
		$fields['email'] = Tools::getValue('email', $testimonial->email);
		$fields['company'] = Tools::getValue('company', $testimonial->company);
		$fields['address'] = Tools::getValue('address', $testimonial->address);
		$fields['has_picture'] = true;

		$languages = Language::getLanguages(false);

		foreach ($languages as $lang)
		{
			$fields['image'][$lang['id_lang']] = Tools::getValue('image_'.(int)$lang['id_lang']);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $testimonial->url[$lang['id_lang']]);
			$fields['content'][$lang['id_lang']] = Tools::getValue('content_'.(int)$lang['id_lang'], $testimonial->content[$lang['id_lang']]);
			$fields['html'][$lang['id_lang']] = Tools::getValue('html_'.(int)$lang['id_lang'], $testimonial->html[$lang['id_lang']]);
		}
		
		return $fields;
	}

	private function getMultiLanguageInfoMsg()
	{
		return '<p class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'</p>';
	}

	private function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<p class="alert alert-warning">'.
						$this->l('You cannot manage testimonials items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'</p>';
		else
			return '';
	}

	private function getShopContextError($shop_contextualized_name, $mode)
	{
		if (is_array($shop_contextualized_name))
			$shop_contextualized_name = implode('<br/>', $shop_contextualized_name);

		if ($mode == 'edit')
			return '<p class="alert alert-danger">'.
							$this->l(sprintf('You can only edit this testimonial from the shop(s) context: %s', $shop_contextualized_name)).
					'</p>';
		else
			return '<p class="alert alert-danger">'.
							$this->l(sprintf('You cannot add testimonials from a "All Shops" or a "Group Shop" context')).
					'</p>';
	}

	private function getShopAssociationError($id_novtestimonials)
	{
		return '<p class="alert alert-danger">'.
						$this->l(sprintf('Unable to get testimonial shop association information (id_novtestimonials: %d)', (int)$id_novtestimonials)).
				'</p>';
	}


	private function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
				$shop_info = $this->l(sprintf('The modifications will be applied to shop: %s', $this->context->shop->name));
			else if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$shop_info = $this->l(sprintf('The modifications will be applied to this group: %s', Shop::getContextShopGroup()->name));
			else
				$shop_info = $this->l('The modifications will be applied to all shops and shop groups');

			return '<div class="alert alert-info">'.
						$shop_info.
					'</div>';
		}
		else
			return '';
	}

	private function getSharedTestimonialsWarning()
	{
		return '<p class="alert alert-warning">'.
					$this->l('This testimonial is shared with other shops! All shops associated to this testimonial will apply modifications made here').
				'</p>';
	}
}
