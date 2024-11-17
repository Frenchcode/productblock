<?php
declare(strict_types=1);

namespace PrestaShop\Module\ProductBlock\Form;

use \PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

final class ProductblokcConfigurationTextDataConfiguration implements DataConfigurationInterface
{
    public const PRODUCT_FORM_PRODUCT_ONE = 'PRODUCT_FORM_PRODUCT_ONE';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }
    public function getConfiguration(): array
    {
        $return = [];
        $return['product_one'] = $this->configuration->get(static::PRODUCT_FORM_PRODUCT_ONE);

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            $this->configuration->set(static::PRODUCT_FORM_PRODUCT_ONE, $configuration['product_one']);
        } else {
            $errors[] = 'Missing configuration parameter';
        }
        return $errors;
    }

    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['product_one']);
    }
}