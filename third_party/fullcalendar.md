# Laravel 5 Full Calendar Helper
[![http://fullcalendar.io](http://fullcalendar.io)](http://fullcalendar.io)

https://www.webslesson.info/2021/03/how-to-implement-fullcalendar-in-laravel-8-using-ajax.html

https://github.com/rcvioleta/fullcalendar-with-laravel-and-vue/blob/master/resources/js/components/CalendarComponent.vue

https://www.youtube.com/playlist?list=PLm0kCoXE9i0eJm8RwEIpx98-u8vdnLR84
## Installing
Package

    composer require maddhatter/laravel-fullcalendar

In config/app.php add service provider & alias
> MaddHatter\LaravelFullcalendar\ServiceProvider::class

> 'Calendar' => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,

### Creating Events

#### Using `event()`:
The simpliest way to create an event is to pass the event information to `Calendar::event()`:

```php
$endDate = $endDate. "24:00:00";
$event[] = \Calendar::event(
    "Valentine's Day", //event title
    false, //full day event?
    '2015-02-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
    new /DateTime($endDate), //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
	$id, //optional event ID
	[ // [additional parameters](http://fullcalendar.io/docs/event_data/Event_Object)
		'url' => 'http://full-calendar.io',
		'color' => $color,
		'textColor' => '',
	]
);
$calendar = \Calendar::addEvents($event); (or) // $calendar = \Calendar::addEvent($event);
```
#### Implementing `Event` Interface

Alternatively, you can use an existing class and have it implement `MaddHatter\LaravelFullcalendar\Event`. An example of an Eloquent model that implements the `Event` interface:

```php
class EventModel extends Eloquent implements \MaddHatter\LaravelFullcalendar\Event
{
    protected $dates = ['start', 'end'];

    /**
     * Get the event's id number
     * @return int
     */
    public function getId() {
		return $this->id;
	}

    /**
     * Get the event's title
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Is it an all day event?
     * @return bool
     */
    public function isAllDay() {
        return (bool)$this->all_day;
    }

    /**
     * Get the start time
     * @return DateTime
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * Get the end time
     * @return DateTime
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * Optional FullCalendar.io settings for this event
     * @return array
     */
    public function getEventOptions()
    { // [additional parameters](http://fullcalendar.io/docs/event_data/Event_Object)
        return [
            'color' => $this->background_color,
			//etc
        ];
    }
}
```

#### Sample Controller

```php
$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

$calendar = \Calendar::addEvents($events) //add an array with addEvents
    ->addEvent($eloquentEvent, [ //set custom color fo this event
        'color' => '#800',
    ])->setOptions([ //set fullcalendar options
		'firstDay' => 1,
        'defaultDate' => $book->day,
        'defaultView' => 'agendaDay',
        'eventLimit'     => 4,
	])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        'viewRender' => 'function() {alert("Callbacks!");}',
        'eventClick' => 'function(event) { // id, title, allDay, start, end
            title= event.title;
            return $calendar;
        }
    ]);

return view('hello', compact('calendar'));
```

#### Sample View

```php
<!doctype html>
<html lang="en">
<head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
</head>
<body>
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}
</body>
</html>
```

![](http://i.imgur.com/qjgVhCY.png)
