## Looping Variable
```php
$loop->count // total iterations

$loop->index // (starts at 0)
$loop->iteration // (starts at 1)
$loop->first // when first iteration start

$loop->remaining // get remaing iteration count
$loop->even // when even iteration occures
$loop->odd  // when odd iteration occures

$loop->last // when the last iteration occur

$loop->depth // The nesting level of the current loop iteration
$loop->parent
```

## Loop
```php
# while
@while (true)
@endwhile

# switch
@switch($i)
	@case(1)
		@break
	@default
@endswitch

# for
@for ($i = 0; $i < 10; $i++)
@endfor

# forelse
@forelse ($users as $user)
	@empty
@endforelse

# foreach
@foreach ($users as $each)
	{{ $loop->index + $users->firstItem() }} // row id -> index(0) + modal

	@if($loop->first)
	@endif

	@continue
	@continue($whenCondition) // @continue($user->type == 1)

	@break
	@break($whenCondition)

	@if ($loop->last)
	@endif

	@foreach ($user->posts as $post)
        @if ($loop->parent->first) // nested loop
        @endif
    @endforeach
@endforeach

# css - split each row has 3 columns
@foreach ($collection->chunk(3) as $chunk)
    <div class="row">
        @foreach ($chunk as $product)
            <div class="col-xs-4">{{ $product->name }}</div>
        @endforeach
    </div>
@endforeach
```
