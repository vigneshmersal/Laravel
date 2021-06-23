# Laravel Chart

Document
- https://v6.charts.erik.cat/

https://www.chartjs.org/docs/latest/

Links
- https://nomadphp.com/blog/54/generating-charts-and-graphs-using-laravel
- https://www.itsolutionstuff.com/post/laravel-ajax-consoletvs-charts-tutorialexample.html

Google Chart Link:
https://github.com/cmen/CMENGoogleChartsBundle

Horizontal bar chart:
https://laravelarticle.com/laravel-horizontal-bar-chart

1.Install
> composer require consoletvs/charts:6.*

config/charts.php
> php artisan vendor:publish --tag=charts_config

2. config/app.php

```php
'providers' => [ ConsoleTVs\Charts\ChartsServiceProvider::class ],
```

3. command

> php artisan make:chart LatestUsers Chartjs

4. Controller

```php
$users = Candidate::selectRaw("
		DATE_FORMAT(created_at, '%b') as monthname,
		EXTRACT(MONTH FROM created_at) AS month,
		EXTRACT(DAY FROM created_at) AS day,
		COUNT(*) as count"
	)->whereYear('created_at', today())
	->orderBy('month')
	->groupBy('month')
	->pluck('count', 'monthname');

$chart = new LatestUsers;
$chart->labels($users->keys()) // ->labels(['Success', 'Fail'])
    ->dataset('New Users', 'line', $users->values())
    ->dataset('My dataset 2', 'doughnut', [4, 3, 2, 1]);
    ->height(400)
    ->width(100)
    ->loader(true)
    ->loaderColor("#22292F")
	->displaylegend(false)
	->barwidth(0.0)
	->minimalist(true)
    ->title($title, $font_size = 14, $color = '#666', $bold = true, $font_family = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif")
    ->color("rgb(255, 99, 132)")
    ->backgroundcolor("rgb(255, 99, 132)")
    ->fill(false)
    ->linetension(0.1)
    ->dashed([5])
    ->options([
    	'color' => '#ff0000',
    	'backgroundColor' => '',
    	'backgroundColor' => [ '#ff6384', '#36a2eb' ], // rgb(255, 99, 132)
        'fill' => 'true',
        'borderColor' => '#51C1C0',
        'borderColor' => [],
        'borderWidth' => '10',
		'type' => 'bar',
        'tooltip' => [
        	'show' => true // or false,
    	],
    ]);
return view('home', compact('chart'));
```

5. html

```php
<div class="card">
	<div class="card-header">
		<b>Today Sent Notifications</b>
	</div>

	<div class="card-body">
		<center>
			{!! $chart->container() !!}
		</center>
	</div>
</div>

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}
@endsection
```

---

## Type of charts
'type' => 'bar', // area, line, radar, pie, polarArea, bubble, scatter

