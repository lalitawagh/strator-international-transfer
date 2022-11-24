<?php

namespace Kanexy\InternationalTransfer\Exports;

use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class MoneyTransferExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function styles(Worksheet $sheet)
    {
        return [
            '1' => ['font' => ['bold' => true]],
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($records)
    {
        $this->records = $records;
    }
    public function collection()
    {
        $list = collect();
        foreach ($this->records as $record) {
            $transactionslist = Transaction::find($record);
            $list->push($transactionslist);
        }

        return $list;
    }
    public function map($list): array
    {
        return [
            $list->urn,
            $list->created_at,
            @$list->meta['sender_name'],
            @$list->meta['base_currency'],
            @$list->meta['second_beneficiary_name'],
            @$list->meta['exchange_currency'],
            $list->payment_method,
            $list->status,
        ];
    }
    public function headings(): array
    {
        return [
            'TRANSACTION ID',
            'DATE & TIME',
            'SENDER NAME',
            'SENDING CURRENCY',
            'RECEIVER NAME',
            'RECEIVING CURRENCY',
            'SOURCE',
            'STATUS',
        ];
    }
}
