<?php namespace DoctrinePlayground\Domain\Selling\Entities;

use Ramsey\Uuid\Uuid;

class Item
{
    /** @var Uuid */
    public $item_id;

    /** @var string */
    public $reference;
}