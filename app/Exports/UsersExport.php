<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('users')->select(DB::raw("name, email, CASE WHEN active= 1 THEN 'Yes' ELSE 'No' END AS Male"))->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Active'
        ];
    }
}
