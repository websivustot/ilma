<?php
class CartController extends Controller
{

    public $view = 'cart';

    public function index($data)
    {

        if (isset($_SESSION['cart'])) {
          $cart = Cart::getCart($_SESSION['cart']);
          return ['cart' => $cart, 'h1' => 'Корзина'];
        }

        return ['message' => 'Корзина пуста.', 'h1' => 'Корзина'];

    }

    public function add($data)
    {
        if(isset($_SESSION['user_id'])) {
          $user_id = $_SESSION['user_id'];
        }
        else {
          $user_id = 'noName';
        }
        $cart = ['user_id' => $user_id, 'good_id' => $_GET['good_id'], 'quantity' => $_GET['quantity']];
        $_SESSION['cart'][] = $cart;
        return [ 'message' => 'Товар добавлен в корзину', 'cart' => $cart ];

    }

    public function clear($data)
    {
        unset($_SESSION['cart']);
        return [ 'message' => 'Корзина очищена'];
    }
}
?>
