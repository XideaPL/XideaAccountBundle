<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Doctrine\ORM\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Xidea\Component\Base\Doctrine\ORM\Manager\ModelManagerInterface;
use Xidea\Component\Account\Manager\AccountManagerInterface,
    Xidea\Component\Account\Model\AccountInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class AccountManager implements ModelManagerInterface, AccountManagerInterface
{
    /*
     * @var bool
     */
    protected $flushMode;
    
    /*
     * @var EntityManager
     */
    protected $entityManager;
    
    /*
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructs a account manager.
     *
     * @param EntityManager The entity manager
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        
        $this->setFlushMode(true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFlushMode($flushMode = true)
    {
        $this->flushMode = $flushMode;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isFlushMode()
    {
        return $this->flushMode;
    }

    /**
     * {@inheritdoc}
     */
    public function save(AccountInterface $account)
    {
        $this->entityManager->persist($account);

        if($this->isFlushMode())
            $this->entityManager->flush();

        return $account->getId();
    }
    
    public function update(AccountInterface $account)
    {  
        $this->entityManager->persist($account);

        if($this->isFlushMode())
            $this->entityManager->flush();

        return $account->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(AccountInterface $account)
    {
        $this->entityManager->remove($account);
    }
    
    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->entityManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->entityManager->clear();
    }
}
