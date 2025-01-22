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
        $this->version = '3.0.0';
        $this->author = "Ephraim Bokuma";
        $this->author_uri = "https://www.ephraimbokuma.com";
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '8.1.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Product Block', [], 'Modules.Productblock.Admin');
        $this->description = $this->trans('Display two product from your store', [], 'Modules.Productblock.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Productblock.Admin');

        if (!Configuration::get('PRODUCT_BLOCK')) {
            $this->warning = $this->trans('No name provided', [], 'Modules.Productblock.Admin');
        }
    }

    public function install(): bool
    {
        return (
            parent::install() &&
            $this->registerHook('displayHome') &&
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

    /**
     * @throws Exception
     */
    public  function getContent(): void
    {
        $route = $this->get('router')->generate('productblock_configuration_form_simple');
        Tools::redirectAdmin($route);
    }

    private function getShopProducts(): array
    {
        return Product::getProducts(
            $this->context::getContext()->language->id,
            0,
            0,
            'name',
            'asc'
        );
    }

    private function getShopCoverImage(string $productId):array
    {
        $images = Image::getCover($productId);
        return $images;
    }

    private function getShopProduct(array $products, string $productId): mixed
    {
        $productFound = null;

        foreach ($products as $product) {
            if ($product['id_product'] == $productId) {
                $productFound = $product;
                break;
            } else {
                $productFound = "Didn't find anything";
            }
        }
        return $productFound;
    }

    /**
     * @throws PrestaShopException
     */
    public function hookDisplayHome(): bool | string
    {
        $products = $this->getShopProducts();
        $firstProductId = Configuration::get('PRODUCT_FORM_PRODUCT_ONE');
        $secondProductId = Configuration::get('PRODUCT_FORM_PRODUCT_TWO');

        $firstProductCoverImageId = $this->getShopCoverImage($firstProductId);
        $secondProductCoverImageId = $this->getShopCoverImage($secondProductId);

        $firstProduct = $this->getShopProduct($products, $firstProductId);
        $secondProduct = $this->getShopProduct($products, $secondProductId);

        $this->context->smarty->assign([
            'product' => $firstProduct,
            'product_name' => $firstProduct['name'],
            'product_link' => $this->context->link->getProductLink($firstProduct['id_product']),
            'product_cover_image' => $this->context->link->getImageLink(
                $firstProduct['link_rewrite'],
                $firstProductCoverImageId['id_image'],
                'large_default'
            ),
            'product_two' => $secondProduct,
            'product_name_two' => $secondProduct['name'],
            'product_link_two' => $this->context->link->getProductLink($secondProduct['id_product']),
            'product_cover_image_two' => $this->context->link->getImageLink(
                $secondProduct['link_rewrite'],
                $secondProductCoverImageId['id_image'],
                'large_default'
            ),
        ]);

        return $this->display(__FILE__, 'productpage.tpl');
    }
}

