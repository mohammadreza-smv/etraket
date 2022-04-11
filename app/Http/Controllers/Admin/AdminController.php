<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Offers;
use App\Product;
use App\ProductWarranty;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Order;
use App\Payment;
use App\Seller;
use DB;
class AdminController extends Controller
{
    public function index()
    {
        $indexChartData=Order::ChartData();
        $submissions=DB::table('order_infos')->count();
        $submissions_approved=DB::table('order_infos')->where('send_status',1)->count();
        $items_today=DB::table('order_infos')->where('send_status',2)->count();
        $submissions_ready=DB::table('order_infos')->where('send_status',3)->count();
        $posting_send=DB::table('order_infos')->where('send_status',4)->count();
        $posting_receive=DB::table('order_infos')->where('send_status',5)->count();
        $delivered=DB::table('order_infos')->where('send_status',6)->count();
        $user_count=User::count();
        $order_count=Order::count();
        //Comment::count()
        $comment_count=0;
        //Question::where('question_id',0)->count();
        $total_question_count=0;
        $product_count=Product::count();
        $seller_count=Seller::count();
        $last_orders=Order::orderBy('id','DESC')->limit(5)->get();
        return view('admin.index',[
            'indexChartData'=>$indexChartData,
            'submissions'=>$submissions,
            'submissions_approved'=>$submissions_approved,
            'items_today'=>$items_today,
            'submissions_ready'=>$submissions_ready,
            'posting_send'=>$posting_send,
            'posting_receive'=>$posting_receive,
            'delivered'=>$delivered,
            'user_count'=>$user_count,
            'order_count'=>$order_count,
            'comment_count'=>$comment_count,
            'total_question_count'=>$total_question_count,
            'product_count'=>$product_count,
            'seller_count'=>$seller_count,
            'last_orders'=>$last_orders
        ]);
    }

    public function admin_login_form()
    {
        return view('admin.admin_login_form');
    }
    public function error403()
    {
        return view('403');
    }
    public function author_panel()
    {
        return view('author_panel');
    }
    public function sale_report()
    {
        $totalSale=DB::table('sale_statistics')->sum('price');
        $commission=DB::table('sale_statistics')->sum('commision');
        return view('admin.sale_report',['commission'=>$commission,'totalSale'=>$totalSale]);
    }
    public function get_sale_report(Request $request)
    {
        $jdf=new \App\Lib\Jdf();
        $y=$jdf->tr_num($jdf->jdate('Y'));
        $y=!empty($request->get('default_year')) ?  $request->get('default_year') : $y;
        $now=$jdf->tr_num($jdf->jdate('Y'));

        return get_sale_report($request,$y,'sale_statistics',['year'=>$y],'price',$now);
    }
}
