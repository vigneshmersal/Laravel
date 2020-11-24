## Date
```php
# created_at, updated_at timestamps - by default carbon
$user->created_at->addDays(1); 

# Date - today
whereDate('date', now()) 
whereDate('date', '=', now())
whereDate('date', date('Y-m-d'))
whereDate('date', Carbon::now())
whereDate('date', Carbon::now()->format('Y-m-d'))
whereDate('date', Carbon::today())
whereDate('date', Carbon::today()->toDateString())
whereDate('date', DB::raw('CURDATE()'))

# Month
whereMonth('date', '12')
whereMonth('date', date('m'))

# Day
whereDay('date', '31')
whereDay('date', date('d'))

# Year
whereYear('date', '2020')
whereYear('date', date('Y'))

# Time
whereTime('date', '=', '14:13:58')
```

## Between
```php
$from = date('2018-01-01');
$to = date('2018-05-02');

whereBetween('reservation_from', [$from, $to])
whereBetween('created_at', [$from." 00:00:00",$to." 23:59:59"])

->whereDate('from','<=', $today)->whereDate('to','>=', $today)

Reservation::all()->filter(function($item) {
  if (Carbon::now->between($item->from, $item->to) {
    return $item;
  }
});
```

## groupBy
```php
->select(DB::raw('
    id, upload_date, pdf,
    year(upload_date) year,
    month(upload_date) month,
    monthname(upload_date) monthname,
    day(upload_date) day
'))
->orderByDesc('year')
->orderByDesc('month')
->orderBy('day')
->get()
->map(function($item, $key){
    return new DailyPracticePdfResource($item);
})
->groupBy(['year', 'monthname']);

selectRaw('year(created_at) year, monthname(created_at) monthname, count(*) data, month(created_at) month')

->select(DB::raw('count(id) as `data`'), 
    DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  
    DB::raw('YEAR(created_at) year'))
    DB::raw('MONTH(created_at) month'))
->groupby('year','month')

->groupBy(function($item, $key) {
    return Carbon::parse($item['date'])->format('Y');
    return Carbon::parse($val->date)->format('d');
});
```
