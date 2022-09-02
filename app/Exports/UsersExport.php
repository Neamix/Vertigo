<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    protected $search;
    public function __construct($filter)
    {
        $this->search = $filter['search'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View {
        return view('export.users', [
            'users' => User::filter($this->search)->get()
        ]);
    }
}
