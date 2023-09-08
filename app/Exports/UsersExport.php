<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

/**
 * Class UsersExport
 * @package App\Exports
 *
 * @author Kozy-Korpesh Tolep
 */
class UsersExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return User::where('consent_to_data_collection', 1)->with('userConsentToDataCollection')->get();
    }


    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name . ' ' . $row->surname,
            $row->iin,
            $row->mobile,
            '',
            $row->created_at,
            $row->last_profile_check_at,
            $row->userConsentToDataCollection->first()->cmsSign,
        ];
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Арендатор',
            'ИИН',
            'Контактный номер',
            'Номер договора',
            'Дата регистрации',
            'Дата и время последней проверки',
            'Подпись соглашения (ЭЦП)',
        ];
    }

    /**
     * @return int[]
     */
    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 35,
            'F' => 35,
            'G' => 25,
        ];
    }
}
