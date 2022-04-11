<?php


namespace Modules\review\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\review\Repository\ReViewRepositoryInterface;

class ApiController extends Controller
{
    public function review($id,ReViewRepositoryInterface $repository)
    {
        $array=array();
        $review=$repository->getProductReview($id);
        foreach ($review as $key=>$value)
        {
            $array[$key]['title']=$value['title'];
            $n=explode('<p>',$value['tozihat']);
            $tozihat=$value['tozihat'];
            $j=0;
            for($i=0;$i<sizeof($n);$i++){
                $result=getBetweenTag('<p>','</p>',$tozihat);

                $img_src=getBetweenTag('src="','"',$result);
                if($img_src){
                    $array[$key]['content'][$j]='image:'.$img_src;
                    $j++;
                }
                else if($result){
                    $text=str_replace("&zwnj;"," ",$result);
                    if($text!="&nbsp;"){
                        $array[$key]['content'][$j]=strip_tags($text);
                        $j++;
                    }
                }
                $tozihat=str_replace("<p>$result</p>","",$tozihat);
            }
        }
        return $array;
    }
}
