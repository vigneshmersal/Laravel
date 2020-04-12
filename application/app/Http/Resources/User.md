# Modal Resource
Create both `Resource` and `collection`
> php artisan make:resource Users --collection

Create Resource
> php artisan make:resource User

```php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
	/**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = true;

	/**
	* Transform the resource into an array.
	*
	* @param \Illuminate\Http\Request $request
	* @return array
	*/
	public function toArray($request) {

		return parent::toArray($request);

		// (or)

		return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,

            // Relationships
            'posts' => PostResource::collection($this->posts),

            // Conditional Relationships
            'posts' => PostResource::collection($this->whenLoaded('posts')),

            // Conditional Pivot Information
            'expires_at' => $this->whenPivotLoaded('role_user', function () {
	            return $this->pivot->expires_at;
	        }),

	        // If your intermediate table is using an accessor other than pivot
	        'expires_at' => $this->whenPivotLoadedAs('subscription', 'role_user', function () {
	            return $this->subscription->expires_at;
	        }),

            // Conditional Attributes
            'secret' => $this->when(Auth::user()->isAdmin(), 'secret-value'),
            'secret' => $this->when(Auth::user()->isAdmin(), function () {
			    return 'secret-value';
			}),

            // Merging Conditional Attributes
			$this->mergeWhen(Auth::user()->isAdmin(), [
	            'first-secret' => 'value',
	            'second-secret' => 'value',
	        ]),
        ];
	}

	/**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }

    /**
     * Adding Additional Data
     *
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'api_url' => url('http://lpgvue/api')
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
    "version": "1.0.0",
  	"api_url": "http://lpgvue/api"
}
```
