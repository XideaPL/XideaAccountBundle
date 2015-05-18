<?php

namespace Xidea\Bundle\AccountBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaAccountExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config, $loader) = $this->setUp($configs, new Configuration($this->getAlias()), $container);

        $loader->load('account.yml');
        $loader->load('account_orm.yml');
        $loader->load('account_controller.yml');
        $loader->load('account_form.yml');

        $this->loadAccountSection($config['account'], $container, $loader);
    }
    
    protected function loadAccountSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_account.account.class', $config['class']);
        $container->setAlias('xidea_account.account.configuration', $config['configuration']);
        $container->setAlias('xidea_account.account.factory', $config['factory']);
        $container->setAlias('xidea_account.account.manager', $config['manager']);
        $container->setAlias('xidea_account.account.loader', $config['loader']);
        
        if (!empty($config['form'])) {
            $this->loadAccountFormSection($config['form'], $container, $loader);
        }
        
        if(isset($config['template'])) {
            $this->loadTemplateSection(sprintf('%s.%s', $this->getAlias(), 'account'), $config['template'], $container, $loader);
        }
    }
    
    protected function loadAccountFormSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setAlias('xidea_account.account.form.create.factory', $config['create']['factory']);
        $container->setAlias('xidea_account.account.form.create.handler', $config['create']['handler']);
        
        $container->setParameter('xidea_account.account.form.create.type', $config['create']['type']);
        $container->setParameter('xidea_account.account.form.create.name', $config['create']['name']);
        $container->setParameter('xidea_account.account.form.create.validation_groups', $config['create']['validation_groups']);
    }
    
    protected function getConfigurationDirectory()
    {
        return __DIR__.'/../Resources/config';
    }
}