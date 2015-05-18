<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Tests\Model;

use Xidea\Bundle\AccountBundle\Tests\Fixtures\Model\Account;

/**
 * @author Artur Pszczółka <artur.pszczolka@xidea.pl>
 */
class AccounttTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $account = $this->createAccount();
        $this->assertNull($account->getName());
        
        $name = 'Account 1';
        
        $account->setName($name);
        $this->assertEquals($name, $account->getName());
    }
    
    protected function createAccount()
    {
        return new Account();
    }
}
