<?php
class GoodsController extends Controller
{

    public $view = 'goods';

    public function index($data)
    {
        //var_dump($data);
        $goods = Good::getGood($data['id']);
        //var_dump($goods[0]["id_category"]);
        $categories = Category::getCategories($goods[0]['id_category']);


        //var_dump($categories);
        return ['subcategories' => $categories, 'goods' => $goods];
    }
}
?>
