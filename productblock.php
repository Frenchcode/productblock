<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please email
 *  license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
declare(strict_types=1);


if (!defined('_PS_VERSION_')) {
    exit();
}

class ProductBlock extends Module
{
    public function __construct()
    {
        $this->name = 'productblock';
        $this->tab = 'front_office_features';
        $this->version = '2.0.0';
        $this->author = "Ephraim Bokuma";
        $this->author_uri = "https://www.ephraimbokuma.com";
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '8.1.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Product Block', [], 'Modules.Productblock.Admin');
        $this->description = $this->trans('Display Two product', [], 'Modules.Productblock.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Productblock.Admin');

        if (!Configuration::get('PRODUCT_BLOCK')) {
            $this->warning = $this->trans('Product Block is disabled.', [], 'Modules.Productblock.Admin');
        }
    }

    public function install(): bool
    {
        return (
            parent::install() &&
            Configuration::updateValue('PRODUCT_BLOCK', 'productblock')
        );
    }

    public function uninstall(): bool
    {
        return (
            parent::uninstall() &&
            Configuration::deleteByName('PRODUCT_BLOCK')
        );
    }
}

