<?php

namespace Modules\sellers\Exports;

use App\Lib\Jdf;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GrpHdr implements FromCollection,WithHeadings,WithMapping,WithTitle,ShouldAutoSize
{
    private $count = 0;
    private $sum = 0;
    public function __construct($count, $sum)
    {
        $this->sum = $sum;
        $this->count = $count;
    }
    public function headings() : array
    {
       return [
            'MsgId',
            'CreDtTm',
            'NbOfTxs',
            'CtrlSum',
            'InitgPty'
       ];
    }
    public function map($row): array{
        $jdf=new Jdf();
        $date=$jdf->tr_num($jdf->jdate('Y-n-j'));
        $time = $date.'T'.date('H:i:m');
        $payId=substr(time(),0,9);
        return [
            'IR062960000000100324200001'.$payId,
            $time,
            $this->count,
            $this->sum.'0',
            'ایده پردازان جوان'
        ];
    }
    public function collection()
    {
        return new Collection([
            'IR062960000000100324200001'
        ]);
    }
    public function title() :string
    {
        return 'GrpHdr';
    }

}
