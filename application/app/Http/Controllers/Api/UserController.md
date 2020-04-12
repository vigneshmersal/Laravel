# Api Controller
Create
> php artisan make:controller BookController --api

```php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource(User::first());

        // (or)

        return new UserCollection(User::paginate(3));

        // (or)

        // When the preserveKeys property is set to true, collection keys will be preserved:
        return UserResource::collection(User::all()->keyBy->id);

        // response's headers
        return (new UserResource(User::find(1)))->response()->header('X-Value', 'True');

        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rating = Rating::firstOrCreate(
            [ 'user_id' => $request->user()->id ],
            [ 'rating' => $request->rating ]
        );

        return new UserResource($user);
        return response()->json([ "message" => "student record created" ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
        // (or)
        return response($student, 200); // success
        return response()->json([ "message" => "Student not found" ], 404); // fail
    }

    /**
     * Update the specified resource in storage.
     * PUT | Content-Type: application/json
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // check if currently authenticated user is the owner of the book
        if ($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        $user->update($request->only(['title', 'description']));

        return new UserResource($user);
        return response()->json([ "message" => "records updated successfully" ], 200); // success
        return response()->json([ "message" => "Student not found" ], 404); // fail
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return new UserResource($user);
        return response()->json(['message'=>'Deleted!'], 204); // success
        return response()->json([ "message" => "Records deleted!" ], 202); // success
        return response()->json([ "message" => "User not found" ], 404); // fail
    }
}
```