# Excel Export

https://docs.laravel-excel.com/3.1/getting-started/installation.html
https://laraveldaily.teachable.com/p/export-import-with-excel-in-laravel
https://laraveldaily.com/laravel-excel-export-formatting-and-styling-cells/
https://laraveldaily.com/laravel-excel-3-0-export-custom-array-excel/

# Fast excel
https://dev.to/rap2hpoutre/export-10m-rows-in-xlsx-with-laravel-without-memory-issues-6bk
https://github.com/rap2hpoutre/fast-excel

# github
https://github.com/qirolab/laravel-excel-export-import-example/blob/master/app/Exports/UsersExport.php

> composer require maatwebsite/excel

# Download
```php
Excel::download(new UsersExport(2019), 'users.xlsx');
return $excel->download(new UsersExport, 'users.xlsx');

return (new UsersExport)->download('users.xlsx');
return (new InvoicesExport)->forYear(2018)->download('invoices.xlsx');
```

# Store disk
```php
User::all()->storeExcel(
    $filePath,
    $disk = null,
    $writerType = null,
    $headings = false
)

public function storeExcel() { 
	// Store on default disk
    Excel::store(new InvoicesExport(2018), 'invoices.xlsx');
    // Store on a different disk (e.g. s3)
    Excel::store(new InvoicesExport(2018), 'invoices.xlsx', 's3');
    // Store on a different disk with a defined writer type. 
    Excel::store(new InvoicesExport(2018), 'invoices.xlsx', 's3', Excel::XLSX);
	Excel::store(new InvoicesExport(2018), 'invoices.xlsx', 's3', null, [
        'visibility' => 'private',
    ]);
	Excel::store(new InvoicesExport(2018), 'invoices.xlsx', 's3', null, 'private');
}
```

<!-- https://stackoverflow.com/questions/64686685/export-large-data-from-db-using-laravel-excel -->

```php
<?php

namespace App\Exports;

use App\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;
use Illuminate\Contracts\Queue\ShouldQueue;

class CandidatesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithCustomQuerySize, ShouldQueue
{
	use Exportable;

	protected $created_at_from;

	public function __construct($request)
	{
		$this->request = $request;
	}

	public function createdAtFrom($created_at_from) {
		$this->created_at_from = $created_at_from;
		return $this;
	}

	public function collection()
	{
		$request = $this->request;
		$collect = collect();

		\DB::enableQueryLog();

		$data = Candidate::query()
			->when(isset($this->created_at_from), function($query) {
				return $query->whereDate('created_at', '>=', $this->created_at_from);
			})
			->select(['id', 'name', 'email', 'mobile', 'status'])
			->chunk(10000, function ($users) use ($collect) {
				foreach ($users as $user) {
					$collect->push($user);
				}
			});

		$arr = \DB::getQueryLog();
		\Log::info([ 'query' => $arr ]);
		return $collect;
	}

	public function headings(): array
	{
		return [
			'#',
			'Name',
		];
	}

	public function styles(Worksheet $sheet)
	{
		return [
			// Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
		];
	}
}

```
