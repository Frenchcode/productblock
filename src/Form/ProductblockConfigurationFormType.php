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

namespace PrestaShop\Module\ProductBlock\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductblockConfigurationFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Fetch products
        $products = \Product::getProducts(
            \Context::getContext()->shop->id,
            0,
            0,
            'name',
            'asc',
        );

        $choices = [];
        foreach ($products as $product) {
            $choices[$product['name']] = $product['id_product'];
        }
        $builder
            ->add('product_one', ChoiceType::class, [
                'choices' => $choices,
                'label' => $this->trans('First Product', 'Modules.Productblock.Admin'),
                'help' => $this->trans('Choose a product', 'Modules.Productblock.Admin'),
            ]);
    }
}