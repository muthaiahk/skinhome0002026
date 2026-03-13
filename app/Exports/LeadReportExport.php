<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadReportExport implements FromCollection, WithHeadings
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->data as $lead) {

            $rows[] = [
                'Name' => $lead->lead_first_name.' '.$lead->lead_last_name,
                'Phone' => $lead->lead_phone,
                'Email' => $lead->lead_email,
                'Lead Source' => $lead->lead_source_name,
                'Problem' => $lead->lead_problem,
                'Status' => $lead->lead_status_name,
                'Next Followup' => $lead->next_followup_date
            ];
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Email',
            'Lead Source',
            'Problem',
            'Status',
            'Next Followup'
        ];
    }
}