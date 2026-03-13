<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $values;
    protected $dates;

    public function __construct($values, $dates)
    {
        $this->values = $values;
        $this->dates  = $dates;
    }

    public function collection()
    {
        $rows = [];
        $sl = 1;

        foreach ($this->values as $staff) {
            $row = [];
            $row[] = $sl++;
            $row[] = $staff['staff_name'];
            $row[] = $staff['designation'];

            foreach ($staff['dates'] as $d) {
                $row[] = $d['status'] ?? '-';
            }

            $rows[] = $row;
        }

        return collect($rows);
    }

    public function headings(): array
    {
        $headings = ['Sl No', 'Staff Name', 'Designation'];
        foreach ($this->dates as $date) {
            $headings[] = $date;
        }
        return $headings;
    }
}