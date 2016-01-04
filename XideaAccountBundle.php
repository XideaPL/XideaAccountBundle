<?php

namespace Xidea\Bundle\AccountBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerBuilder;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class XideaAccountBundle extends Bundle
{   
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $this->addMappingsPass($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function addMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            //sprintf('%s/Resources/config/doctrine/user-model', $this->getPath()) => 'Xidea\Account',
            sprintf('%s/Resources/config/doctrine/model', $this->getPath()) => 'Xidea\Bundle\AccountBundle\Model'
        );
        
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createYamlMappingDriver(
                    $mappings,
                    array(),
                    false,
                    array(
                        //'XideaAccount' => 'Xidea\Account',
                        'XideaAccountBundle' => 'Xidea\Bundle\AccountBundle\Model'
                    )
            ));
        }
    }
}
