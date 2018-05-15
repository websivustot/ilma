<?php

class Cart extends Model {
    protected static $table = 'cart';

    protected static function setProperties()
    {
        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['password'] = [
            'type' => 'text',
        ];

        self::$properties['status'] = [
            'type' => 'int',
        ];
    }

    public static function getCart($cart)
    {
        $good_list = [];
        foreach ($cart as $key => $value) {
          $good_name = db::getInstance()->Select(
                'SELECT name FROM goods WHERE id=:id',
                ['id' => $value['good_id']]);                
          $good_list[] = [$good_name[0]['name'], $value['quantity']];
        }
        return $good_list;

    }
}
