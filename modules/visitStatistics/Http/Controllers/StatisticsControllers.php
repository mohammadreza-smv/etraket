<?php

namespace Modules\visitStatistics\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Jdf;
use DB;
use Illuminate\Http\Response;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\visitStatistics\Models\ProductStatistics;
use Modules\visitStatistics\Models\Statistics;

class StatisticsControllers extends Controller
{
    public function week_visit($year=null){
        $jdf=new Jdf();
        $year=$year ? $year : $jdf->tr_num($jdf->jdate('Y'));
        $visit=DB::table('statistics__week_visit')
            ->where(['year'=>$year])->get();
        $now_year=$jdf->tr_num($jdf->jdate('Y'));
        $first=DB::table('statistics__week_visit')->first();
        $years=[];
        if($first && $first->year!=$now_year)
        {
            $j=0;
            $a=$first->year;
            settype($a,'integer');
            for($i=$a;$i<=$now_year;$i++)
            {
                $years[$j]=$i;
                $j++;
            }
        }
        if(sizeof($years)==0){
            $years=[intval($year)];
        }
        return [
            'visit'=>$visit,
            'year'=>$year,
            'years'=>$years
        ];
    }

    public function month_visit(): array
    {
        $statistics=new Statistics();
        return $statistics->getMonthVisit();
    }

    public function product_visit($product_id): array
    {
        $productStatistics=new ProductStatistics($product_id);
        return $productStatistics->getVisit();
    }

    public function product_visit_view($product_id){
        $product=null;
        if(file_exists(base_path('modules/products/Repository/ProductRepositoryInterface.php'))){
            $repository=app(ProductRepositoryInterface::class);
            $product=$repository->find($product_id);
        }
        return CView('visitStatistics::chart.product',compact('product'));
    }
}
