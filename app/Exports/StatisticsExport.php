<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StatisticsExport implements FromArray, WithHeadings, WithMapping
{
    protected $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function array(): array
    {
        $data = [];
        
        // General Stats
        $data[] = [
            'نوع الإحصائية' => 'عدد الكتاب',
            'القيمة' => $this->stats['writers']
        ];
        $data[] = [
            'نوع الإحصائية' => 'عدد الفيديوهات',
            'القيمة' => $this->stats['videos']
        ];
        $data[] = [
            'نوع الإحصائية' => 'عدد المهام',
            'القيمة' => $this->stats['tasks']
        ];
        $data[] = [
            'نوع الإحصائية' => 'المهام المعلقة',
            'القيمة' => $this->stats['pending_tasks']
        ];

        // Daily Visits
        foreach ($this->stats['visits_labels'] as $index => $date) {
            $data[] = [
                'نوع الإحصائية' => 'زيارات ' . $date,
                'القيمة' => $this->stats['visits_data'][$index]
            ];
        }

        // Popular Articles
        foreach ($this->stats['popular_articles_labels'] as $index => $title) {
            $data[] = [
                'نوع الإحصائية' => 'مقال: ' . $title,
                'القيمة' => $this->stats['popular_articles_data'][$index]
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'نوع الإحصائية',
            'القيمة'
        ];
    }

    public function map($row): array
    {
        return [
            $row['نوع الإحصائية'],
            $row['القيمة']
        ];
    }
}
