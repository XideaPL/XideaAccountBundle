<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class AccountRepository extends EntityRepository implements AccountRepositoryInterface
{
    public function findQb()
    {
        $qb = $this->createQueryBuilder('a');
        
        return $qb;
    }
}
