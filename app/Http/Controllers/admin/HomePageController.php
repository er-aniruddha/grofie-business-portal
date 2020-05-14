<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Product;
use Grofie\Category;

class HomePageController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

 	public function Index_Product()
 	{
 		$products = Product::orderBy('product_id', 'desc')->get();
 		return view('admin_v2.home.topsaver-product',['products' => $products ]);
 	}
 	public function add_Product(Request $request)
 	{
 		Product::where('product_id', $request->product_id)->update(['home_show_stat' => 1]);
 		return redirect('/admin/home/new/product');
 	}
 	public function del_Product($product_id)
 	{
 		Product::where('product_id', $product_id)->update(['home_show_stat' => 0]);
 		return redirect('/admin/home/new/product');
 		// echo "<pre>"; print_r($dat); echo "</pre>";
 	}
 	public function Index_Category()
 	{
 		$categories = Category::orderBy('category_id', 'desc')->get();
 		return view('admin_v2.home.category',['categories' => $categories ]);
 	}
 	public function add_Category(Request $request)
 	{
 		Category::where('category_id', $request->category_id)->update(['home_show_stat' => 1]);
 		return redirect('/admin/home/new/category');
 	}
 	public function del_Category(Request $request)
 	{
 		Category::where('category_id', $request->category_id)->update(['home_show_stat' => 0]);
 		return redirect('/admin/home/new/category');
 		// echo "<pre>"; print_r($dat); echo "</pre>";
 	}
}
