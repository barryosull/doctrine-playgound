<?php namespace DoctrinePlayground\App\Projections\Carts;

use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;
use Carbon\Carbon;
use DoctrinePlayground\Domain\Selling\Entities\Item;

class Projection
{
    private $db;

    const CARTS_TABLE = 'carts';
    const CART_ITEMS_TABLE = 'cart_items';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /** Example Commands **/

    public function createCart(UuidInterface $cart_id, UuidInterface $customer_id, Carbon $created_at)
    {
        $this->db->insert(self::CARTS_TABLE, [
            'cart_id'     => $cart_id,
            'customer_id' => $customer_id,
            'active'      => true,
            'created_at'  => $created_at->format("Y-m-d H:i:s"),
        ]);
    }

    public function addItemToCart(UuidInterface $cart_id, Item $item)
    {
        $this->db->insert(self::CART_ITEMS_TABLE, [
            'cart_id'     => $cart_id,
            'item_id'     => $item->item_id,
            'item_ref'    => $item->reference
        ]);
    }


    /** Example Queries **/

    public function getActiveCart(UuidInterface $customer_id)
    {
        $cart_arr = $this->db->fetchAssoc('SELECT * FROM '.self::CARTS_TABLE.' WHERE customer_id = ? AND active = 1', [$customer_id]);

        if (!$cart_arr) {
            return null;
        }

        $cart = (object)$cart_arr;

        $items = $this->db->fetchAll('SELECT * FROM '.self::CART_ITEMS_TABLE.' WHERE cart_id = ?', [$cart->cart_id]);

        $cart->items = array_map(function($item) {
            return (object)$item;
        }, $items);

        return $cart;
    }
}