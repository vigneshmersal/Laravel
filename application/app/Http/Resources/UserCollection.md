# Resource Collection

> new UserCollection(User::all()->load('roles')

```php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

// php artisan make:resource Users --collection
// php artisan make:resource UserCollection
class PostCollection extends ResourceCollection
{
    // pass additional value
    // (new UserResourceCollection($user))->foo('bar');
    protected $foo;

    public function foo($value){
        $this->foo = $value;
        return $this;
    }

    public function toArray($request){
        return $this->collection->map(function(UserResource $resource) use($request){
            return $resource->foo($this->foo)->toArray($request);
    })->all();

	/**
     * The resource that this resource collects.
     * Customizing Resource Class Path
     * @var string
     */
    public $collects = 'App\Http\Resources\User';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // (or)

        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
```

## Sample Result

```json
{
    "data": [
        {
            "id": 1,
            "name": "Eladio Schroeder Sr.",
            "email": "therese28@example.com",
        },
        {
            "id": 2,
            "name": "Liliana Mayert",
            "email": "evandervort@example.com",
        }
    ],
    "links":{
        "first": "http://example.com/pagination?page=1",
        "last": "http://example.com/pagination?page=1",
        "prev": null,
        "next": null
    },
    "meta":{
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://example.com/pagination",
        "per_page": 15,
        "to": 10,
        "total": 10
    }
}
```
