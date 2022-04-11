<?php

namespace Modules\sellers\Imports;

use App\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
use Modules\sellers\Repository\SellerRepositoryInterface;

class PaymentImport implements ToCollection,WithHeadingRow,WithChunkReading
{
    public function collection(Collection $rows)
    {
        if(sizeof($rows)>0){
            $repository=app(SellerRepositoryInterface::class);
            foreach($rows as $row){
                if ($row->has('instrid') && $row->has('amt')) {

                    if(!empty($row['instrid']))
                    {
                        $repository->add_payment($row);
                    }

                }
            }
        }
    }
    public function chunkSize(): int
    {
        return 1;
    }
}
