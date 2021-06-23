# [Carbon](https://packagist.org/packages/nesbot/carbon)

## Document:
https://carbon.nesbot.com/docs/

`use Carbon\Carbon;`

## strtotime
```php
strtotime("2021-01-08 14:32:31"); // 1610116351
Carbon::parse(1610116351) // 2021-01-08 14:32:31
```

## select
```php
selectRaw("
    DATE_FORMAT(created_at, '%b') as shortmonthname,
    DATE_FORMAT(created_at, '%M') as monthname,
    EXTRACT(MONTH FROM created_at) AS month,
")
```

## Date
```php
now()
Carbon::now()
Carbon::today()
Carbon::getCurrentWeekDays() // array of dates
Carbon::getCurrentMonthDays() // array of dates

Carbon::yesterday()
Carbon::tomorrow() | Carbon::tomorrow('Europe/London')

# Constants (0 TO 6)
Carbon::SUNDAY,
Carbon::MONDAY,
Carbon::TUESDAY,
Carbon::WEDNESDAY,
Carbon::THURSDAY,
Carbon::FRIDAY,
Carbon::SATURDAY

Carbon::SECONDS_PER_MINUTE // 60
Carbon::MINUTES_PER_HOUR // 60
Carbon::HOURS_PER_DAY // 24
Carbon::DAYS_PER_WEEK // 7
Carbon::WEEKS_PER_YEAR // 52
Carbon::MONTHS_PER_YEAR // 12
Carbon::YEARS_PER_DECADE // 10
Carbon::YEARS_PER_CENTURY // 100

# +, -, ago, first, next, last, this, today, tomorrow, yesterday
new Carbon('tomorrow')
new Carbon('last friday')
new Carbon('this thursday')
new Carbon('next wednesday')

Carbon::create($year, $month, $day, $hour, $minute, $second, $tz)
Carbon::createFromDate($year, $month, $day, $tz)
Carbon::createMidnightDate($year, $month, $day, $tz)
Carbon::createFromTime($hour, $minute, $second, $tz)
Carbon::createFromTimeString("$hour:$minute:$second", $tz)
Carbon::createFromTimestamp(-1, $tz);
Carbon::createFromFormat($format='Y-m-d H', $time='1975-05-21 22', $tz);

# Add & Sub
$dt->add('3 days 6 hours 40 minutes')
$dt->add(61, 'seconds')
$dt->addMicroSecond() | $dt->addMicroSeconds(61)
$dt->addMilliSecond() | $dt->addMilliSeconds(61)
$dt->addSecond() | $dt->addSeconds(61)
$dt->addMinute() | $dt->addMinutes(61)
$dt->addHour() | $dt->addHours(24)
$dt->addDay() | $dt->addDays(29)
$dt->addWeekday() | $dt->addWeekdays(2)
$dt->addWeek() | $dt->addWeeks(2)
$dt->addMonth(1) | $dt->subMonth(1) | $dt->addMonths(1)
$dt->addYear() | $dt->addYears(5)
$dt->addQuarter() | $dt->addQuarters(2)
$dt->addCentury() | $dt->addCenturies(5) // 2512-01-31

$dt->closest($dt1, $dt2)
$dt->farthest($dt1, $dt2)

# age
Carbon::createFromDate(1995, 2, 7)->age;

# Zone
locale('zh_CN') // fr_FR, fr, ar
Carbon::now($tz)
Carbon::now('+13.30')
Carbon::create(2012, 1, 1, 0, 0, 0, $tz)
->tzName // Europe/London
->timezoneName
```

## Time
```php
date('gA', strtotime($time)) = 1PM
```

## format
```php
Carbon::parse($dt)
Carbon::parse('first day of December 2008')
new \DateTime('first day of January 2008')
Carbon::parse()->format('M d Y');
$dt->toDateTimeString()

$dt->startOfSecond() | $dt->endOfSecond()
$dt->startOfMinute() | $dt->endOfMinute()
$dt->startOfHour() | $dt->endOfHour()
$dt->startOfDay() | $dt->endOfDay()
$dt->startOfWeek() | $dt->endOfWeek()
$dt->startOfMonth() | $dt->endOfMonth()
$dt->startOfYear() | $dt->endOfYear()
$dt->startOfDecade() | $dt->endOfDecade()
$dt->startOfCentury() | $dt->endOfCentury()

$dt->firstOfMonth() | $dt->lastOfMonth()
$dt->firstOfQuarter() | $dt->lastOfQuarter()
$dt->firstOfYear() | $dt->lastOfYear()

# Diff
$dt->diffForHumans($now) // 1 month ago
$dt->diffInMilliseconds($now) | $dt->diffInMicroseconds($now) | $dt->diffInSeconds($now)
$dt->diffInMinutes($now)
$dt->diffInHours($now)
now()->diffInDays($user->updated_at) // 31
$dt->diffInWeeks($now)
$dt->diffInWeekdays($now) | $dt->diffInWeekenddays($now)
$dt->diffInMonths($now)
$dt->diffInQuarters($now)
$dt->diffInYears($nwow)

$dt->diffFromYears(2019) // 1 year after
$dt->diffFromYears(2019, true) // 1 year
$dt->diffFromYears(2019, true, true) // 1yr

$dt->previousWeekday()
$dt->previousWeekendDay()

$dt->nextWeekday()
$dt->nextWeekendDay()

# Get & Set
$dt->hour
$dt->minute
$dt->second

$dt->day
$dt->dayName // Friday
$dt->minDayName
$dt->shortDayName
$dt->daysInMonth // return total days in this month 30
$dt->dayOfWeek // 1 (monday) to 7 (sunday)
$dt->dayOfYear // current day number in a year 279

$dt->week() // 6
$dt->weekday() // 0
$dt->firstWeekDay // 0
$dt->lastWeekDay // 6
$dt->weekNumberInMonth // 12
$dt->weekOfMonth // 4
$dt->weekOfYear // 40
$dt->weekYear() // 2017
$en->weeksInYear() // 52

$dt->month
$dt->monthName // October
$dt->shortMonthName // Oct

$dt->year
```

## check
```php
Carbon::hasRelativeKeywords('first day of next month') // true

# current
$dt->isToday()
$dt->isCurrentHour()
$dt->isCurrentMinute()
$dt->isCurrentSecond()
$dt->isCurrentDay()
$dt->isCurrentMonth()
$dt->isCurrentYear()

# past
$dt->isYesterday()
$dt->isPast()
$dt->isLastWeek()
$dt->isLastMonth()
$dt->isLastOfMonth() // is last day of the month
$dt->isLastYear()

# future
$dt->isTomorrow()
$dt->isFuture()
$dt->isNextWeek()
$dt->isNextMonth()
$dt->isNextYear()

# loop
use Carbon\CarbonPeriod;
$period = CarbonPeriod::create('2018-06-14', '2018-06-20');
foreach ($period as $date) { echo $date->format('Y-m-d'); }
$dates = $period->toArray();

# day
$dt->isMonday() | isTuesday() | isWednesday() | isThursday() |
isFriday() | isSaturday() | isSunday()

# check date
$dt->isStartOfDay() | $dt->isMidnight() // 00:00:00
$dt->isMidday() // 12:00:00
$dt->isEndOfDay() // 23:59:59
$dt->isWeekday()
$dt->isWeekend()
$dt->isDayOfWeek(1)

$dt->isLeapYear()
$dt->isLongYear()

# check two dates Comparison
$dt->isSameHour($dt2)
$dt->isSameMinute($dt2)
$dt->isSameDay($dt2); // Same day of same month of same year
$dt->isSameMonth($dt2)
$dt->isSameYear($dt2)


//IN Model
$this->created_at->gt(now())

$dt1->eq($dt2) | $dt1->equalTo($dt2) | $dt1 == $dt2
$dt1->ne($dt2) | $dt1->notEqualTo($dt2) | $dt1 != $dt2
$dt1->lt($dt2) | $dt1->lessThan($dt2) | $dt1->isBefore($dt2)
$dt1->lte($dt2) | $dt1->lessThanOrEqualTo($dt2) | $dt1 <= $dt2
$dt->between($dt1, $dt2)
$dt1->gt($dt2) | $dt1->greaterThan($dt2) | $dt1->isAfter($dt2) | $dt1 > $dt2
$dt1->gte($dt2) | $dt1->greaterThanOrEqualTo($dt2) | $dt1 >= $dt2

https://www.w3schools.com/sql/func_mysql_date_format.asp

DATE_FORMAT("2017-06-15", "%D %b-%Y")
15th Jun-2017

>>> Carbon\Carbon::parse('2020-07-02')->isoFormat('Do MMM-Y')
=> "2nd Jul-2020"

# Day number
d =>  0 (Sunday) to 6 (Saturday) (week)
e =>  0 (Sunday) to 6 (Saturday) (week)
E =>  1 (Monday) to 7 (Sunday) (week)
D => 5 (month)
DD => 05 (month)
Do => 5th (month)
DDD => 1 to 366 (year)
DDDo => 1st to 366th (year)
DDDD => 001 to 366 (year)

# Day Name
dd => Th
ddd => Thu
dddd => Thursday

# week
W - 1
ww - 01
wo - 1st

# Month number
M => 1 to 12
MM => 01 to 12
Mo => 1st to 12th

# Month Name
MMM => Jan
MMMM => January

# Year
Y => 2019
YY => 19
YYYY => 2019
YYYYY => 02019

# Hour
h - 0 to 12
h - 00 to 12
H - 0 to 23
HH - 00 to 23
k - 1 to 24
kk - 01 to 24

# Minute
i - minute
m - 0 to 59
mm - 00 to 59

# second
s - 0 to 59
ss - 00 to 59

# Meridiem
a - am/pm
A - AM/PM
```

## Time Travel

```php
Carbon::setTestNow(Carbon::now()->addDay());

# Forward
$this->travel(8)->years();
$this->travel(8)->weeks();
$this->travel(8)->days();
$this->travel(8)->minutes();
$this->travel(8)->hours();
$this->travel(8)->seconds();
$this->travel(8)->milliseconds();

# Backward
$this->travel(-1)->days();

# Reset to actual current time
$this->travelBack();
```
