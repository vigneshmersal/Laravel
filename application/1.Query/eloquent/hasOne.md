## hasOne
(one to one)

```php
Class User{
    public function phone() {
        return $this->hasOne('App\Phone', 'foreign_key'='user_id', 'local_key'='id');
    }
}

$phone = User::find(1)->phone;
```
