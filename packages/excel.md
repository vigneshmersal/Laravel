# Excel Export

https://docs.laravel-excel.com/3.1/getting-started/installation.html
https://laraveldaily.teachable.com/p/export-import-with-excel-in-laravel
https://laraveldaily.com/laravel-excel-export-formatting-and-styling-cells/
https://laraveldaily.com/laravel-excel-3-0-export-custom-array-excel/

> composer require maatwebsite/excel

```php
Excel::download(new UsersExport(2019), 'users.xlsx');
return $excel->download(new UsersExport, 'users.xlsx');

return (new UsersExport)->download('users.xlsx');
return (new InvoicesExport)->forYear(2018)->download('invoices.xlsx');
```

```php
<?php

namespace App\Exports;

use App\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;

class CandidatesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	use Exportable;

	protected $created_at_from;

	public function __construct()
	{
	}

	public function createdAtFrom($created_at_from) {
		$this->created_at_from = $created_at_from;
		return $this;
	}

	public function collection()
	{
		\DB::enableQueryLog();

		$data = Candidate::query()
			->when(isset($this->created_at_from), function($query) {
				return $query->whereDate('created_at', '>=', $this->created_at_from);
			})
			->get(['id', 'name']);

		$arr = \DB::getQueryLog();
		\Log::info([ 'query' => $arr ]);
		return $data;
	}

	public function headings(): array
	{
		return [
			'#',
			'Name',
		];
	}
}

```
