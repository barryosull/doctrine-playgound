<?php namespace DoctrinePlaygroundTests;

use Carbon\Carbon;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use DoctrinePlayground\App\Projections\Carts;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class CartProjectionTest extends TestCase
{
    private $db;

    public function setUp()
    {
        $config = new Configuration();

        $connectionParams = array(
            'dbname' => 'homestead',
            'user' => 'homestead',
            'password' => 'secret',
            'host' => '192.168.10.10',
            'driver' => 'pdo_mysql',
        );

        $this->db = DriverManager::getConnection($connectionParams, $config);
    }

    public function test_can_fetch_cart()
    {
        $projection = new Carts\Projection($this->db);

        $user_id = Uuid::uuid4();
        $cart_id = Uuid::uuid4();

        $projection->createCart($cart_id, $user_id, Carbon::now());

        $cart = $projection->getActiveCart($user_id);

        $this->assertNotNUll($cart);
    }

    public function test_get_null_when_there_is_no_cart()
    {
        $projection = new Carts\Projection($this->db);

        $user_id = Uuid::uuid4();

        $cart = $projection->getActiveCart($user_id);

        $this->assertNull($cart);
    }
}