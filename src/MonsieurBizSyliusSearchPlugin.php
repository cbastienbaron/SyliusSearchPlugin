<?php

/*
 * This file is part of Monsieur Biz' Search plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusSearchPlugin;

use MonsieurBiz\SyliusSearchPlugin\DependencyInjection\AutomapperConfigurationRegistryPass;
use MonsieurBiz\SyliusSearchPlugin\DependencyInjection\AutowireMappingProviderParameterPass;
use MonsieurBiz\SyliusSearchPlugin\DependencyInjection\DocumentableRegistryPass;
use MonsieurBiz\SyliusSearchPlugin\DependencyInjection\RegisterSearchRequestPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MonsieurBizSyliusSearchPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->containerExtension) {
            $this->containerExtension = false;
            $extension = $this->createContainerExtension();
            if (null !== $extension) {
                $this->containerExtension = $extension;
            }
        }

        return $this->containerExtension instanceof ExtensionInterface
            ? $this->containerExtension
            : null;
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new DocumentableRegistryPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 50); // Run the compiler pass before \MonsieurBiz\SyliusSettingsPlugin\DependencyInjection\InstantiateSettingsPass
        $container->addCompilerPass(new AutowireMappingProviderParameterPass());
    }
}
