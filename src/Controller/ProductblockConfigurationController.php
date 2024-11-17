<?php
declare(strict_types=1);

namespace PrestaShop\Module\ProductBlock\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductblockConfigurationController extends FrameworkBundleAdminController
{
    public function index(Request $request): Response
    {
        $textFormDataHandler = $this->get('prestashop.module.productblock.form.productblock_configuration_text_form_data_handler');

        $textForm = $textFormDataHandler->getForm();
        $textForm->handleRequest($request);

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $errors = $textFormDataHandler->save($textForm->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successfull updated.', 'Admin.Notifications.Success'));
                return $this->redirectToRoute('productblock_configuration_form_simple');
            }
            $this->flashErrors($errors);
        }
        return $this->render('@Modules/productblock/views/templates/admin/form.html.twig', [
            'productblockConfigurationForm' => $textForm->createView()
        ]);
    }
}