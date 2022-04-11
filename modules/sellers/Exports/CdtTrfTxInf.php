<?php

namespace Modules\sellers\Exports;

use App\Seller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Modules\sellers\Repository\SellerRepositoryInterface;

class CdtTrfTxInf implements FromCollection,WithHeadings,WithTitle,ShouldAutoSize,WithMapping
{
    public function headings(): array
    {
        return [
            'InstrId',
            'EndToEndId',
            'Amt',
            'Cdtr',
            'CdtrAcct',
            'RmtInf'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $repository=app(SellerRepositoryInterface::class);
        return $repository->get_all_payment();
    }

    public function map($row): array{
        $price=$row->total_price - ($row->total_commission + $row->paid_commission);
        $name=$row->fname.' '.$row->lname;
        return [
            $row->id,
            'EMPTY',
            $price.'0',
            $name,
            $row->shaba,
            'بابت کارکرد فروشگاه'
        ];
    }

    public function title(): string
    {
        return 'CdtTrfTxInf';
    }
}
