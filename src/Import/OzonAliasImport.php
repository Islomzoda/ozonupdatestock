<?php
namespace Islomzoda\OzonUpdateStock\Import;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OzonAliasImport implements toArray, WithHeadingRow
{
    private array $items;
    public function array(array $array):void
    {
        array_filter($array, function($item){
            $this->items[] = array_filter($item);
        });
       DB::table('ozon_match')->upsert(array_filter($this->items), ['one_c_uid']);
    }
    public function headingRow(): int
    {
        return 1;
    }

}
