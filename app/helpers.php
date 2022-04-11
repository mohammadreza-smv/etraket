<?php

use App\GiftCart;
use App\Lib\Jdf;

function get_url($string)
{
    $url=str_replace('-','-',$string);
    $url=str_replace('-',' ',$url);
    $url=str_replace('/',' ',$url);
    $url=preg_replace('/\s+/','-',$url);
    return $url;
}
function upload_file($request,$name,$directory,$pix='')
{
    if($request->hasFile($name))
    {
        $file_name=$pix.time().'.'.$request->file($name)->getClientOriginalExtension();
        if($request->file($name)->move('files/'.$directory,$file_name))
        {
            return $file_name;
        }
        else{
            return null;
        }
    }
    else{
        return null;
    }
}
function replace_number($number)
{
    $number=str_replace("0",'۰',$number);
    $number=str_replace("1",'۱',$number);
    $number=str_replace("2",'۲',$number);
    $number=str_replace("3",'۳',$number);
    $number=str_replace("4",'۴',$number);
    $number=str_replace("5",'۵',$number);
    $number=str_replace("6",'۶',$number);
    $number=str_replace("7",'۷',$number);
    $number=str_replace("8",'۸',$number);
    $number=str_replace("9",'۹',$number);

    return $number;
}
function replace_number2($number)
{
    $number=str_replace("۰",'0',$number);
    $number=str_replace("۱",'1',$number);
    $number=str_replace("۲",'2',$number);
    $number=str_replace("۳",'3',$number);
    $number=str_replace("۴",'4',$number);
    $number=str_replace("۵",'5',$number);
    $number=str_replace("۶",'6',$number);
    $number=str_replace("۷",'7',$number);
    $number=str_replace("۸",'8',$number);
    $number=str_replace("۹",'9',$number);

    return $number;
}
function inTrashed($req)
{
    if(array_key_exists('trashed',$req) && $req['trashed']=='true')
    {
        return true;
    }
    else{
        return false;
    }
}
function create_paginate_url($string,$text)
{
    if($string=='?')
    {
        $string=$string.$text;
    }
    else{
        $string=$string.'&'.$text;
    }
    return $string;
}
function create_crud_route($route_param,$controller,$except=['show'],$config=[])
{
    Route::resource($route_param,$controller,$config)->except($except);
    Route::post($route_param.'/remove_items',$controller.'@remove_items')->name($route_param.'.destroy');
    Route::post($route_param.'/restore_items',$controller.'@restore_items')->name($route_param.'.restore');
    Route::post($route_param.'/{id}',$controller.'@restore')->name($route_param.'.restore');
}
function create_fit_pic($pic_url,$pic_name,$width=350,$height=350)
{
    if($pic_name!=null)
    {
        $thum=Image::make($pic_url);
        $thum->resize($width,$height);
        $thum->save('files/thumbnails/'.$pic_name);
    }
}
function remove_file($file_name,$directory)
{
    if(!empty($file_name) && file_exists('files/'.$directory.'/'.$file_name))
    {
        unlink('files/'.$directory.'/'.$file_name);
    }
}
function update_product_status($product)
{
    $warranty=ProductWarranty::where('product_id',$product->id)->where('product_number','>',0)->orderBy('price2','ASC')->first();
    if(!$warranty && $product)
    {
        $product->discount_price=0;
        $product->status=0;
        $product->update();
    }
}
function get_show_category_count($catList)
{
    $n=0;
    foreach ($catList as $key=>$value)
    {
        if($value->notShow==0)
        {
            $n++;
        }
    }
    return $n;
}
function getCatList()
{
    $data=cache('catList');
    if($data)
    {
        View::share('catList',$data);
    }
    else{
        $repository=App::make(\Modules\categories\Repository\CategoryRepositoryInterface::class);
        $category=$repository->all();
        $minutes=30*24*60*60;
        cache()->put('catList',$category,$minutes);
        View::share('catList',$category);
    }
}
function get_cat_url($cat)
{
    if(!empty($cat->search_url))
    {
        return url($cat->search_url);
    }
    else{
        return url('search/'.$cat->url);
    }
}
function getTimestamp($date,$type)
{
    $Jdf=new Jdf();
    $time=0;
    $e=explode('/',$date);
    if(sizeof($e)==3)
    {
        $y=$e[0];
        $m=$e[1];
        $d=$e[2];
        if($type=='first')
        {
            $time=$Jdf->jmktime(0,0,0,$m,$d,$y);
        }
        else{
            $time=$Jdf->jmktime(23,59,59,$m,$d,$y);
        }
    }
    return $time;
}
function getCartSellerData($sellers,$seller_id)
{
    foreach ($sellers as $key=>$value)
    {
        if($value->id==$seller_id)
        {
            return $value;
        }
    }
}
function CheckGiftCart($product,$user_id,$credit_cart,$order_id){

    if($product->use_for_gift_cart=='yes')
    {
        $code='digiGift-'.rand(99,999).$user_id.rand(9,99);
        $gift_cart=new GiftCart();
        $gift_cart->user_id=$user_id;
        $gift_cart->order_id=$order_id;
        $gift_cart->credit_cart=$credit_cart;
        $gift_cart->credit_used=0;
        $gift_cart->code=$code;
        $gift_cart->save();
    }
}
function getCommentOrderId($product_id,$user_id)
{
    define('product_id',$product_id);
    $order_id=0;
    $order=\App\Order::whereHas('getOrderProduct',function ( \Illuminate\Database\Eloquent\Builder $query){
        $query->where('product_id',product_id);
    })->where(['user_id'=>$user_id,'pay_status'=>'ok'])->select(['id'])->first();
    return $order_id;
}
function getScoreType($score,$scoreType){
    if(array_key_exists($score,$scoreType))
    {
        return $scoreType[$score];
    }
    else
    {
        return '';
    }
}
function getUserData($key,$additionalInfo)
{
    if(!empty(old($key))){
        return old($key);
    }
    else{
        if($key=='mobile_phone'){
            return Auth::user()->mobile;
        }
        elseif($additionalInfo && !empty($additionalInfo->$key)){
            return $additionalInfo->$key;
        }
        else{
            return '';
        }
    }
}
function checkEven($n)
{
    if($n%2==0){
        return true;
    }
    else{
        return false;
    }
}
function addLike($request,$score_type)
{
    $table_name=$request->get('table_name','');
    $row_id=$request->get('row_id','');
    if($table_name=='comments' || $table_name=='questions'){
        $row=DB::table($table_name)->where('id',$row_id)->first();
        if($row){
            $user_id=$request->user()->id;

            $user_scored_status=DB::table('user_scored_status')
                ->where(['user_id'=>$user_id,'row_id'=>$row_id,'score_type'=>$score_type,'type'=>$table_name])
                ->first();
            if($user_scored_status)
            {
                DB::table('user_scored_status')
                    ->where(['user_id'=>$user_id,'row_id'=>$row_id,'score_type'=>$score_type,'type'=>$table_name])->delete();
                DB::table($table_name)->where('id',$row_id)->decrement($score_type,1);
                return 'remove';
            }
            else
            {
                DB::table('user_scored_status')->insert([
                    'user_id'=>$user_id,
                    'row_id'=>$row_id,
                    'score_type'=>$score_type,
                    'type'=>$table_name
                ]);
                DB::table($table_name)->where('id',$row_id)->increment($score_type,1);
                return 'add';
            }
        }
        else{
            return 'error';
        }

    }
    else{
        return 'error';
    }
}
function checkParentMenuAccess($accessList,$access)
{
    $result=false;
    if(Auth::user()->role=='admin'){
        $result=true;
    }
    else{
        $e=explode('|',$access);
        if(sizeof($e)>0 && is_object($accessList)){
            foreach($e as $key=>$value)
            {
                if(!empty($value)){
                    if(property_exists($accessList,$value)){
                        $result=true;
                    }
                }
            }
        }
    }
    return $result;
}
function checkAddChildMuenAccess($accessList,$child){
    $result=false;
    if(Auth::user()->role=='admin'){
        $result=true;
    }
    else{
        $property=$child['access'];
        if(is_object($accessList))
        {
            if(property_exists($accessList,$property))
            {
                if(is_array($accessList->$property))
                {
                    if(!array_key_exists('accessValue',$child))
                    {
                        $result=true;
                    }
                    else{
                        foreach($accessList->$property as $key=>$value)
                        {
                            if($value==$child['accessValue'])
                            {
                                $result=true;
                            }
                        }
                    }
                }
            }
        }
    }
    return $result;
}
function get_stockroom_product_count($list)
{
    $n=0;
    foreach($list as $key=>$value)
    {
        if(!empty($value)){
            $e=explode('_',$value);
            if(sizeof($e)==2){
                $a=$e[1];
                setType($a,'integer');
                $n=$n+$a;
            }
        }
    }
    return $n;
}
function set_sale($order)
{
    if($order)
    {
        $jdf=new \App\Lib\Jdf();
        $y=$jdf->tr_num($jdf->jdate('Y'));
        $m=$jdf->tr_num($jdf->jdate('n'));
        $d=$jdf->tr_num($jdf->jdate('j'));
        $total_price=0;
        $commision_price=0;

        foreach($order->getProductRow as $key=>$value)
        {
            DB::table('product_warranties')->where('id',$value->product_warranty_id)
                ->decrement('product_number',$value->product_count);
            update_product_status($value->getProduct);
            $cat_id=$value->getProduct->cat_id;
            $brand_id=$value->getProduct->brand_id;
            $c=0;
            $product_price=$value->product_price2*$value->product_count;
            if($value->seller_id>0)
            {
                $commision=\App\Commission::where(['cat_id'=>$cat_id,'brand_id'=>$brand_id])->first();
                if($commision){
                    $c=($value->product_price2*$commision->percentage)/100;
                    $c=($c*$value->product_count);
                    $commision_price+=$c;
                }
                DB::table('sellers')->where('id',$value->seller_id)->increment('new_order_count');
                DB::table('sellers')->where('id',$value->seller_id)->increment('total_commission',$c);
                DB::table('sellers')->where('id',$value->seller_id)->increment('total_price',$product_price);
                $value->commission=$c;
                $value->update();

                set_seller_sale_statistics($product_price,$c,$y,$m,$d,$value->seller_id);
            }
            $total_price+=$product_price;
            product_sale_statistics($y,$m,$d,$c,$product_price,$value->product_id,$value->seller_id);
        }
        set_overall_statistics($y,$m,$d, $total_price,$commision_price);
    }
}
function product_sale_statistics($y,$m,$d,$commision,$product_price,$product_id,$seller_id,$type='plus')
{
    $product_sale=DB::table('product_sale_statistics')
        ->where(['year'=>$y,'month'=>$m,'day'=>$d,'product_id'=>$product_id])->first();
    if($product_sale)
    {
        if($type=='plus')
        {
            $product_price=$product_price+$product_sale->price;
            $commision=$commision+$product_sale->commision;
        }
        else{
            $product_price=$product_sale->price-$product_price;
            $commision=$product_sale->commision-$commision;
        }
        DB::table('product_sale_statistics')
            ->where(['year'=>$y,'month'=>$m,'day'=>$d,'product_id'=>$product_id])
            ->update([
                'price'=>$product_price,
                'commision'=>$commision
            ]);
    }
    else{
        if($type=='minus')
        {
            $commision=-$commision;
            $product_price=-$product_price;
        }
        DB::table('product_sale_statistics')
            ->insert([
                'year'=>$y,
                'month'=>$m,
                'day'=>$d,
                'product_id'=>$product_id,
                'commision'=>$commision,
                'price'=>$product_price
            ]);
    }
}
function set_seller_sale_statistics($product_price,$commision,$y,$m,$d,$seller_id,$type='plus')
{
    $seller_sale=DB::table('seller_sale_statistics')
        ->where(['year'=>$y,'month'=>$m,'day'=>$d,'seller_id'=>$seller_id])->first();
    if($seller_sale)
    {
        if($type=='plus')
        {
            $product_price=$product_price+$seller_sale->price;
            $commision=$commision+$seller_sale->commision;
        }
        else{
            $product_price=$seller_sale->price-$product_price;
            $commision=$seller_sale->commision-$commision;
        }
        DB::table('seller_sale_statistics')
            ->where(['year'=>$y,'month'=>$m,'day'=>$d,'seller_id'=>$seller_id])
            ->update([
                'price'=>$product_price,
                'commision'=>$commision
            ]);
    }
    else{
        if($type=='minus')
        {
            $commision=-$commision;
            $product_price=-$product_price;
        }
        DB::table('seller_sale_statistics')
            ->insert([
                'year'=>$y,
                'month'=>$m,
                'day'=>$d,
                'seller_id'=>$seller_id,
                'commision'=>$commision,
                'price'=>$product_price
            ]);
    }
}
function set_overall_statistics($y,$m,$d,$total_price,$commision,$type='plus')
{

    $sale_statistics=DB::table('sale_statistics')
        ->where(['year'=>$y,'month'=>$m,'day'=>$d])->first();
    if($sale_statistics)
    {
        if($type=='plus')
        {
            $total_price=$total_price+$sale_statistics->price;
            $commision=$commision+$sale_statistics->commision;
        }
        else{
            $total_price=$sale_statistics->price-$total_price;
            $commision=$sale_statistics->commision-$commision;
        }
        DB::table('sale_statistics')
            ->where(['year'=>$y,'month'=>$m,'day'=>$d])
            ->update([
                'price'=>$total_price,
                'commision'=>$commision
            ]);
    }
    else{
        if($type=='minus')
        {
            $commision=-$commision;
            $total_price=-$total_price;
        }
        DB::table('sale_statistics')
            ->insert([
                'year'=>$y,
                'month'=>$m,
                'day'=>$d,
                'commision'=>$commision,
                'price'=>$total_price
            ]);
    }
}
function get_sale_report($request,$year,$table_name,$where,$attr,$now)
{
    $sale=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
    $commision=[0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
    $data=DB::table($table_name)->where($where)->get();
    foreach($data as $key=>$value)
    {
        if(array_key_exists($value->month,$sale))
        {
            $sale[$value->month]=$sale[$value->month]+$value->$attr;
        }
        if(array_key_exists($value->month,$commision))
        {
            $commision[$value->month]=$commision[$value->month]+$value->commision;
        }
    }

    $first=DB::table($table_name)->first();
    $year_list=array();
    if($first && $first->year!=$now)
    {
        $j=0;
        $a=$first->year;
        settype($a,'integer');
        for($i=$a;$i<=$now;$i++)
        {
            $year_list[$j]=$i;
            $j++;
        }
    }
    else{
        $year_list[0]=$now;
    }
    $response=array();
    $response['sale']=$sale;
    $response['commision']=$commision;
    $response['default_year']=$year;
    $response['year_list']=$year_list;
    return $response;
}
function get_return_product_price($cat_id,$order_discount,$product_price)
{
    foreach($order_discount as $key=>$value)
    {
        if($value->cat_id==$cat_id)
        {
            $p=$value->total_price-$product_price;
            if($p>$value->min_price)
            {
                if(!empty($value->amount_percent))
                {
                    $product_price=$product_price-(($product_price*$value->amount_percent)/100);
                }
                return $product_price;
            }
            else{
                return ($product_price-$value->discount_price);
            }
        }
        else if($value->cat_id==0){
            $p=$value->total_price-$product_price;
            if($p>$value->min_price)
            {
                if(!empty($value->amount_percent))
                {
                    $product_price=$product_price-(($product_price*$value->amount_percent)/100);
                }
                return $product_price;
            }
            else{
                return ($product_price-$value->discount_price);
            }
        }
    }

    if(sizeof($order_discount)==0)
    {
        return $product_price;
    }
}

function set_admin_panel_variables(){
    $new_order_count=\App\Order::where('order_read','no')->count();
    $product_awaiting_review=Product::where('status',-2)->count();
    View::share('new_order_count',$new_order_count);
    View::share('product_awaiting_review',$product_awaiting_review);

}
function set_author_admin_variables($access){
    if(has_access_author_admin($access,'products','product_edit')){
        $product_awaiting_review=Product::where('status',-2)->count();
        View::share('product_awaiting_review',$product_awaiting_review);
    }
    if(has_access_author_admin($access,'products','product_edit')){
        $product_awaiting_review=Product::where('status',-2)->count();
        View::share('product_awaiting_review',$product_awaiting_review);
    }
    if(has_access_author_admin($access,'orders')){
        $new_order_count=\App\Order::where('order_read','no')->count();
        View::share('new_order_count',$new_order_count);
    }
}


function get_brand_from_string($filterString){
    $array=array();
    $filterString=explode('@',$filterString);
    foreach ($filterString as $filter){
        if(!empty($filter)){
            $filter=explode('brand_',$filter);
            if(sizeof($filter)==2){
                $array[sizeof($array)]=$filter[1];
            }
        }
    }
    return sizeof($array)>0 ? $array : null;
}
function get_color_from_string($filterString){
    $array=array();
    $filterString=explode('@',$filterString);
    foreach ($filterString as $filter){
        if(!empty($filter)){
            $filter=explode('color_',$filter);
            if(sizeof($filter)==2){
                $array[sizeof($array)]=$filter[1];
            }
        }
    }
    return sizeof($array)>0 ? $array : null;
}

function get_attribute_from_string($filterString){
    $array=array();
    $filterString=explode('@',$filterString);
    foreach ($filterString as $filter) {
        if (!empty($filter)) {
            $filter=explode('attribute_',$filter);
            if(sizeof($filter)==2){
                $keys=explode('_',$filter[1]);
                $size=array_key_exists($keys[0],$array) ? sizeof( $array[$keys[0]]) : 0;
                $array[$keys[0]][$size]=$keys[1];
            }
        }
    }
    return sizeof($array)>0 ? $array : null;
}
function getApplicationCartProducts($string){
    $list=explode('@',$string);
    $cart=array();
    foreach ($list as $key=>$value)
    {
        if(!empty($value)){
            $param=explode('_',$value);
            if(sizeof($param)==6){
                $k=$param[2].'_'.$param[3].'_'.$param[4];
                $cart[$param[1]]['product_data'][$k]=intval($param[5]);
            }
        }
    }
    return  $cart;
}

function changeProductCountOfCartTable($type,$product_warranty_id,$userId){
    $row=DB::table('cart')->where(['user_id'=>$userId,'product_warranty_id'=>$product_warranty_id])->first();
    if($row){
        $count=$type=='add' ? $row->count+1 : $row->count-1;
        DB::table('cart')
            ->where(['user_id'=>$userId,'product_warranty_id'=>$product_warranty_id])
            ->update(['count'=>$count]);
        return 'ok';
    }
    else{
        return  'error';
    }
}
function get_incredible_offers_start_time(){
    $jdf=new Jdf();
    $y=$jdf->jdate('Y');
    $m=$jdf->jdate('n');
    $d=$jdf->jdate('d');
    return $jdf->jmktime(23,59,59,$m,$d,$y);
}
function check_gift_cart_for_app($request,$code,$cart_final_price){
    $gift_cart=GiftCart::where('code',$code)->first();
    if($gift_cart){
        if($gift_cart->credit_cart-$gift_cart->credit_used>0)
        {
            $use=$gift_cart->credit_cart-$gift_cart->credit_used;
            if($cart_final_price<$use){
                $use=$cart_final_price;
            }
            $cart_final_price=$cart_final_price-$use;
            return [
                'status'=>'ok',
                'gift_value'=>$use,
                'cart_final_price'=>$cart_final_price,
                'gift_id'=>$gift_cart->id,
            ];
        }
        else
        {
            return 'اعتبار کارت هدیه برای استفاده به اتمام رسیده';
        }
    }
    else{
        return 'کارت هدیه وارد شده اشتباه می باشد';
    }
}
function check_discount_code($code){
    $time=time();
    $discounts=DiscountCode::where('code',$code)->where('expiry_time','>=',$time)->get();
    if($discounts){
        return DiscountCode::check($discounts,true);
    }
    else
    {
        return 'کد تخفیف وارد شده اشتباه می باشد';
    }
}
function update_gift_cart_value_for_web(){
    if(Session::has('gift_value') && Session::get('gift_value')>0){
        $gift_value=Session::get('gift_value');
        $gift_id=Session::get('gift_cart');
        $giftCart=GiftCart::where('id',$gift_id)->first();
        if($giftCart){
            $giftCart->credit_used=$giftCart->credit_used+$gift_value;
            $giftCart->update();
        }

        Session::forget('gift_value');
        Session::forget('gift_cart');
    }
}
function update_gift_cart_value_for_app($order){
    if(!empty($order->gift_id) && !empty($order->gift_value)){
        $giftCart=GiftCart::where('id',$order->gift_id)->first();
        if($giftCart){
            $giftCart->credit_used=$giftCart->credit_used+$order->gift_value;
            $giftCart->update();
        }
    }
}
function getUserCart($product_id,$user_id){
    $data=array();
    $cartData=DB::table('cart')->where(
        [
            'product_id'=>$product_id,
            'user_id'=>$user_id
        ]
    )->get();
    foreach ($cartData as $key=>$value){
        $data[$key]=$value->product_id."_".$value->product_warranty_id."_".$value->warranty_id."_".$value->color_id;
    }
    return $data;
}
function defaultCssFile(){
    $files=Config::get('app.css.backend');
    foreach ($files as $file){
        ?>
        <link href="<?= $file ?>" rel="stylesheet">
        <?php
    }
}
function add_panel_menu($array,$position="default"){
    if((Request::is('admin/*') || Request::is('admin')) && Request::isMethod('get')){
        $menu=Config::get('app.panel_menu',[]);
        if($position==="default"){
            $menu[]=$array;
        }
        else{
            if(!array_key_exists($position,$menu)){
                $menu[$position]=$array;
            }
            else{
                $new_menu=[];
                $new_menu[$position]=$array;
                foreach ($menu as $key=>$value){
                    if($key<$position){
                        $new_menu[$key]=$value;
                    }
                    else{
                        $new_menu[($key+1)]=$value;
                    }
                }

                $menu=$new_menu;
            }
        }
        Config::set('app.panel_menu',$menu);
    }
}
function run_action($actionName,$args,$return=false,$withOutKey=false){
    $modulesMainClass= Config::get('app.modulesMainClass',[]);
    $i=0;
    $res=[];
    foreach ($modulesMainClass as $object){
        if(method_exists($object,$actionName)){
            $result=call_user_func_array(array($object,$actionName), $args);
            if($withOutKey && $result){
                $res=$res+$result;
            }
            else if($result){
                $res[$i]=$result;
                $i++;
            }
        }
    }
    if($return){

        return $res;
    }
}
function add_css_file($theme='all'){
    $files=[];
    $actionName='registerCssFile';
    $modulesMainClass= Config::get('app.modulesMainClass',[]);
    foreach ($modulesMainClass as $key=>$object){
        if(method_exists($object,$actionName)){
            $result=call_user_func_array(array($object,$actionName), [$theme]);
            if(is_array($result)){
                $files=$files+$result;
            }
        }
    }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="<?= asset('css/vuetify.min.css') ?>" rel="stylesheet">
    <?php
    if(sizeof($files)){
        foreach ($files as $file){
            echo '<link href="'.$file.'" rel="stylesheet">';
        }
    }
}
function getRouteName(){
    $routeName=Request::route() ? Request::route()->getName() : null;
    $routeName=str_replace('.','_',$routeName);
    return $routeName;
}
function CView($path,$args=[]){

    $args=CompleteData('before_show_view',$args);

    if(function_exists('get_widget_data')){
        $widgetData=get_widget_data($path,$args);
        $args['design_config']=$widgetData['configs'];
        $args=array_merge($args,$widgetData['args']);
    }
    if(defined('layout')){
        run_action('set_layout_data',[layout]);
    }

    $view=view($path,$args);
    if(request()->has('request-type') && request()->get('request-type')=='axios'){
        $view=$view->renderSections();
        $view['js_tags']=registerVueFile('','vue',config('cms.develop'));
    }

    return $view;
}

function add_panel_child_menu($menu){
    if(is_array($menu)){
        $panel_menu=Config::get('app.panel_menu',[]);
        if(array_key_exists('parent_menu',$menu)){
            foreach ($panel_menu as $key=>$value){
                if(array_key_exists('name',$value)){
                    if($value['name']==$menu['parent_menu']){
                        if(array_key_exists('child',$panel_menu[$key])){
                            $panel_menu[$key]['child'][]=$menu;
                        }
                        else{
                            $panel_menu[$key]['child'][0]=$menu;
                        }
                    }
                }
            }
        }
        Config::set('app.panel_menu',$panel_menu);
    }

}

function CompleteData($actionName,$data,$array=false){
    $modulesMainClass= Config::get('app.modulesMainClass',[]);
    foreach ($modulesMainClass as $key=>$object) {
        if (method_exists($object, $actionName)) {
            $param_arr=$array===true ? $data : [$data];
            $result = call_user_func_array(array($object, $actionName), $param_arr);
            if($result){
                $data=$result;
            }
        }
    }
    return $data;
}
function get_price($price){
    return replace_number(number_format($price)).' تومان';
}
function position_view($position){
    $result=run_action($position,[],true);
    $views=[];

    foreach ($result as $array){
        foreach ($array as $key=>$value){
            if(array_key_exists($value['index'],$views)){
                $views[]=$value;
            }
            else{
                $views[$value['index']]=$value;
            }
        }
    }
    ksort($views);
    return $views;
}
function registerVueFile($theme,$render='ssr',$type='develop'){
    $files=[];
    $actionName='registerComponent';
    $type=config('cms.develop');
    $modulesMainClass= Config::get('app.modulesMainClass',[]);
    $index=0;
    foreach ($modulesMainClass as $key=>$object){
        if(method_exists($object,$actionName)){
            $result=call_user_func_array(array($object,$actionName), [$theme,$type]);
            if(is_array($result)){
                $files[$index]=$result;
                $index++;
            }
        }
    }
    if($render=='ssr'){
        foreach ($files as $file){
            ?>
            <script src="<?= asset($file['path'])  ?>" type="text/javascript"></script>
            <?php
        }
        $vue_path=$type==true ? 'js/vue-develop.js?id=v2' : 'js/vue.js';
        ?>
        <script src="<?= asset('js/widgets.js?id='.config('cms.widgetId'))  ?>" type="text/javascript"></script>
        <script src="<?= asset($vue_path) ?>" type="text/javascript"></script>
        <script src="<?= asset('js/vue-components.js') ?>" type="text/javascript"></script>
        <script>
            loadComponent(<?= json_encode($files) ?>);
            setTimeout(function () {
                const app= new Vue({
                    el: '#app',
                    store: store,
                    vuetify: new Vuetify({
                        rtl: true
                    })
                });
                window.vm=app;
            },10);
            setTimeout(function () {
                if(document.getElementById('app-body')!=null){
                    document.getElementById('default-loading').style.display = "none";
                    document.getElementById('app-body').style.display = "block"
                }
                window.dispatchEvent(new Event('resize'));
            },100);
        </script>
        <?php
    }
    else{
        return $files;
    }
}

function vue_component_detail($module,$file=null){
    $path=config()->get('cms.develop')===false ? 'modules/'.$module.'/min-components.js?id=v2' : 'modules/'.$module.'/components.js';
    $detail=[
        'code'=>$module,
        'path'=>$path
    ];
    if(config()->get('cms.develop')===true){
        $detail['file']=$file ? $file : './modules/'.$module.'/resource/js/components.js';
    }
    return $detail;
}

function add_vue_components($path){
    $content = file_get_contents('./js/vue-components.js');
    $content.= file_get_contents($path);
    $fp = fopen('./js/vue-components.js', 'w');
        if($fp){
        fwrite($fp,$content);
    }
}
