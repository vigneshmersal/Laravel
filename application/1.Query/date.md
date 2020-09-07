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
