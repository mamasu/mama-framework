<?php
use Mmf\Auth\Auth;
use Mmf\Model\PDO AS MmfPDO;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-25 at 15:36:06.
 */
class MmfAuthTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var MmfAuth
     */
    protected $objectguest;

    /**
     * @var MmfAuth
     */
    protected $objectUser;

    /**
     * @var MmfAuth
     */
    protected $objectAdmin;

    /**
     * @var MmfAuth
     */
    protected $objectUserDBNoExist;

    /**
     * @var MmfAuth
     */
    protected $objectUserN;

    public static function setUpBeforeClass() {
        //include_once __DIR__ . '/../include.php';
        include_once __DIR__ . '/../include.common.functions.php';
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers \Mmf\Auth\Auth::__construct
     */
    protected function setUp() {
        /* Create user guess */
        $sessionguest = $this->getMockBuilder('Mmf\Parameter\SessionInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $sessionguest->method('get')
                ->will($this->returnCallback('callbackSessionguestAuth'));
        /* End Create user guess */

        /* Create user user */
        $sessionUser = $this->getMockBuilder('Mmf\Parameter\SessionInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $sessionUser->method('get')
                ->will($this->returnCallback('callbackSessionUserAuth'));
        /* End Create user user */

        /* Create user admin */
        $sessionAdmin = $this->getMockBuilder('Mmf\Parameter\SessionInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $sessionAdmin->method('get')
                ->will($this->returnCallback('callbackSessionAdminAuth'));
        /* End Create user admin */

        /* Create user admin */
        $sessionUserDBNoExist = $this->getMockBuilder('Mmf\Parameter\SessionInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $sessionUserDBNoExist->method('get')
                ->will($this->returnCallback('callbackSessionUserNoDatabaseAuth'));
        /* End Create user admin */

        $config = $this->getMockBuilder('Mmf\Parameter\ParametersInterface')
                ->disableOriginalConstructor()
                ->getMock();
        $config->method('get')
                ->will($this->returnCallback('callbackConfigAuth'));


        $connection = new MmfPDO($config);

        $this->objectguest         = new Auth($sessionguest, null, $connection);
        $this->objectUser          = new Auth($sessionUser, null, $connection);
        $this->objectAdmin         = new Auth($sessionAdmin, null, $connection);
        $this->objectUserDBNoExist = new Auth($sessionUserDBNoExist, null, $connection);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Mmf\Auth\Auth::isAuthenticated
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::getUsername
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testIsAuthenticated() {
        $this->assertEquals(false, $this->objectguest->isAuthenticated());
        $this->assertEquals(true,  $this->objectUser->isAuthenticated());
        $this->assertEquals(true,  $this->objectAdmin->isAuthenticated());
        $this->assertEquals(false, $this->objectUserDBNoExist->isAuthenticated());
    }

    /**
     * @covers \Mmf\Auth\Auth::getUsername
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testGetUsername() {
        $this->assertEquals('guest', $this->objectguest->getUsername());
        $this->assertEquals('useruser', $this->objectUser->getUsername());
        $this->assertEquals('useradmin', $this->objectAdmin->getUsername());
    }

    /**
     * @covers \Mmf\Auth\Auth::getRoleName
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::authenticate
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testGetRoleName() {
        $this->assertEquals('guest', $this->objectguest->getRoleName());
        $this->assertEquals('user', $this->objectUser->getRoleName());
        $this->assertEquals('admin', $this->objectAdmin->getRoleName());
    }

    /**
     * @covers \Mmf\Auth\Auth::getUserId
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::authenticate
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testGetUserId() {
        $this->assertEquals(0, $this->objectguest->getUserId());
        $this->assertEquals(2, $this->objectUser->getUserId());
        $this->assertEquals(3, $this->objectAdmin->getUserId());
    }

    /**
     * @covers \Mmf\Auth\Auth::setUsername
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::authenticate
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testSetUsername() {
        $this->objectguest->setUsername('pepita');
        $this->objectUser->setUsername('pepita1');
        $this->objectAdmin->setUsername('pepita2');

        $this->assertEquals('pepita', $this->objectguest->getUsername());
        $this->assertEquals('pepita1', $this->objectUser->getUsername());
        $this->assertEquals('pepita2', $this->objectAdmin->getUsername());
    }

    /**
     * @covers \Mmf\Auth\Auth::setRoleName
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::authenticate
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testSetNameRole() {
        $this->objectguest->setRoleName('pepita');
        $this->objectUser->setRoleName('pepita1');
        $this->objectAdmin->setRoleName('pepita2');

        $this->assertEquals('pepita', $this->objectguest->getRoleName());
        $this->assertEquals('pepita1', $this->objectUser->getRoleName());
        $this->assertEquals('pepita2', $this->objectAdmin->getRoleName());
    }

    /**
     * @covers \Mmf\Auth\Auth::setRoleName
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::authenticate
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testSetUserId() {
        $this->objectguest->setUserId(20);
        $this->objectUser->setUserId(21);
        $this->objectAdmin->setUserId(22);

        $this->assertEquals(20, $this->objectguest->getUserId());
        $this->assertEquals(21, $this->objectUser->getUserId());
        $this->assertEquals(22, $this->objectAdmin->getUserId());
    }

    /**
     * @covers \Mmf\Auth\Auth::__construct
     * @covers \Mmf\Auth\Auth::logout
     * @group auth
     * @group db
     * @group modules
     * @group development
     * @group production
     */
    public function testSetUserGuess() {
        $this->objectUser->logout();
        $this->objectAdmin->logout();
        $this->assertEquals(false,  $this->objectUser->isAuthenticated());
        $this->assertEquals(false,  $this->objectAdmin->isAuthenticated());
    }

}

function callbackSessionguestAuth() {
    $functionArguments = func_get_args();
    $return = array('userId' => null, 'username' => null, 'roleName' => null, 'roleId' => 1);
    return $return[$functionArguments[0]];
}

function callbackSessionUserAuth() {
    $functionArguments = func_get_args();
    $return = array('userId' => 2, 'username' => 'useruser', 'roleName' => 'user',
        'roleId' => 2);
    return $return[$functionArguments[0]];
}

function callbackSessionAdminAuth() {
    $functionArguments = func_get_args();
    $return = array('userId' => 3, 'username' => 'useradmin', 'roleName' => 'admin',
        'roleId' => 3);
    return $return[$functionArguments[0]];
}

function callbackSessionUserNoDatabaseAuth() {
    $functionArguments = func_get_args();
    $return = array('userId' => 99999, 'username' => 'useruser', 'roleName' => 'user',
        'roleId' => 2);
    return $return[$functionArguments[0]];
}

function callbackConfigAuth() {
    $functionArguments = func_get_args();
    $conection1 = array('host' => 'localhost', 'port' => '8889', 'name' => 'marketplace',
        'user' => 'root', 'pass' => 'root');
    $conection2 = array('host' => 'localhost', 'port' => '8889', 'name' => 'marketplace1',
        'user' => 'root', 'pass' => 'root');

    $return = array('db_default' => $conection1, 'db_secondary' => $conection2);
    return $return[$functionArguments[0]];
}
