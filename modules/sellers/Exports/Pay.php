<?php

namespace Modules\sellers\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Pay implements WithMultipleSheets
{
    private $count=0;

    private $sum=0;

    public function __construct($count,$sum)
    {
        $this->sum=$sum;
        $this->count = $count;
    }

    public function sheets(): array
    {
        $sheets = [];
        for($i=0;$i<3;$i++)
        {
            if($i==0){
                $sheets[$i]=new GrpHdr($this->count, $this->sum);
            }
            if ($i == 1) {
                $sheets[$i] = new PmtInf($this->count, $this->sum);
            }
            if ($i == 2) {
                $sheets[$i] = new CdtTrfTxInf();
            }
        }
        return $sheets;
    }
}
