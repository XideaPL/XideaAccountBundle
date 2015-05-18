<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class LoadAccountData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $this->loadData();

        $accountManager = $this->container->get('xidea_account.account.manager');
        
        foreach($data as $account) {
            $accountManager->save($account);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
    
    /**
     * Returns a account factory.
     * 
     * @return \Xidea\Bundle\AccountBundle\Model\AccountFactory The account factory
     */
    protected function getAccountFactory()
    {
        return $this->container->get('xidea_account.account.factory');
    }
    
    /**
     * Returns a data.
     * 
     * @return array The data
     */
    protected function loadData()
    {
        $accountFactory = $this->getAccountFactory();
        
        $account1 = $accountFactory->create();
        $account1->setName('Acme');
        $this->setReference('account-acme', $account1);
        
        $account2 = $accountFactory->create();
        $account2->setName('John Doe');
        $this->setReference('account-johndoe', $account2);
        
        return array(
            $account1,
            $account2
        );
    }
 
}
