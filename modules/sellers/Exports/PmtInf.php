<?php

namespace Modules\sellers\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Database\Eloquent\Collection;
use App\Lib\Jdf;

class PmtInf implements FromCollection,WithHeadings,WithMapping,WithTitle,ShouldAutoSize
{
    private $count = 0;
    private $sum = 0;
    public function __construct($count, $sum)
    {
        $this->sum = $sum;
        $this->count = $count;
    }
    public function headings(): array
    {
        return [
            'PmtInfId',
            'PmtMtd',
            'NbOfTxs',
            'CtrlSum',
            'ReqdExctnDt',
            'Dbtr',
            'DbtrAcct',
            'DbtrAgt'
        ];
    }
    public function map($row): array
    {
        $jdf = new Jdf();
        $date = $jdf->tr_num($jdf->jdate('Y-n-j'));
        $payId = substr(time(), 0, 9);
        return [
            '1',
            'TRF',
            $this->count,
            $this->sum.'0',
            $date,
            'ایده پردازان جوان',
            'IR062960000000100324200001',
            'BMJIIRTHXXX'
        ];
    }
    public function collection()
    {
        return new Collection([
            '1'
        ]);
    }
    public function title(): string
    {
        return 'PmtInf';
    }
}
