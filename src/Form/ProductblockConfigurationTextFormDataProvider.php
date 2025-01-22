<?php
declare(strict_types=1);

namespace PrestaShop\Module\ProductBlock\Form;


use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class ProductblockConfigurationTextFormDataProvider implements FormDataProviderInterface
{

    /**
     * @return DataConfigurationInterface
     */
    private $productBlockConfigurationTextDataConfiguration;

    public function __construct(DataConfigurationInterface $productBlockConfigurationTextDataConfiguration)
    {
        $this->productBlockConfigurationTextDataConfiguration = $productBlockConfigurationTextDataConfiguration;
    }
    public function getData(): array
    {
        return $this->productBlockConfigurationTextDataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->productBlockConfigurationTextDataConfiguration->updateConfiguration($data);
    }
}