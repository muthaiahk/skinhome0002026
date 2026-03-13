<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockReportExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->data as $stock) {
            $rows[] = [
                'Branch' => $stock->branch_name,
                'Brand' => $stock->brand_name,
                'Category' => $stock->prod_cat_name,
                'Product' => $stock->product_name,
                'Stock' => $stock->stock_in_hand,
            ];
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'Branch',
            'Brand',
            'Category',
            'Product',
            'Stock',
        ];
    }
}