## hasOneThrough {#hasOneThrough}

```php
# mechanic has one car, car has one owner
# get mechanic has owner
class Mechanic extends Model {
    public function carOwner() {
        return $this->hasOneThrough('App\Owner','App\Car',
            'mechanic_id', // Foreign key on cars table...
            'car_id', // Foreign key on owners table...
            'id', // Local key on mechanics table...
            'id' // Local key on cars table...
        );
    }
}
```
