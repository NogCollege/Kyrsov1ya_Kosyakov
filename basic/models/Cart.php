<?php

// models/Cart.php

namespace app\models;

use Yii;
use yii\base\Model;

class Cart extends Model
{
    public $items = [];

    public function addItem($tovar)
    {
        $id = $tovar['id'];
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity']++;
        } else {
            $this->items[$id] = [
                'id' => $tovar['id'],
                'name' => $tovar['name'],
                'price' => $tovar['price'],
                'image_url' => $tovar['image_url'],
                'quantity' => 1,
            ];
        }
    }

    public function removeItem($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }
    }

    public function updateItem($id, $quantity)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
