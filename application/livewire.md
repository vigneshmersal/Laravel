# livewire
https://www.nicesnippets.com/blog/laravel-livewire-load-more-example
https://laravel-livewire.com/docs/2.x/reference

## Install
> composer require livewire/livewire

## create livewire
app/Http/Livewire/HelloWorld.php
resources/views/livewire/hello-world.blade.php
> php artisan make:livewire hello-world

app/Http/Livewire/Post/Search.php
resources/views/livewire/post/search.blade.php
> php artisan make:livewire post.search

app/Http/Livewire/SearchPosts.php
> php artisan make:livewire search-posts --inline

move livewire
> php artisan livewire:mv register auth.register

## Route
`resources/views/layouts/app.blade.php` that `@yield('content')`
> Route::livewire('/home', 'counter');

Customizing layout
> Route::livewire('/home', 'counter')->layout('layouts.app', [ 'title' => 'foo' ]);

Customizing section (`@yield('body')`)
> Route::livewire('/home', 'counter')->section('body');

Route group
> Route::group(['layout' => 'layouts.base', 'section' => 'body'], function () { });
>> Route::layout('layouts.base')->section('body')->group(function () { });

## Config
> @livewireStyles
>> <livewire:styles> - `laravel 7 and above`

> @livewire(hello-world, ['name'=>'vicky'])
>> <livewire:nav.search-posts :contact="$contact" /> - `laravel 7 and above`

> @livewireScripts
>> <livewire:scripts> - `laravel 7 and above`

## sub livewire
@foreach($names as $name)
	@livewire('say-hi', ['name'=>$name], key($name->id))
@endforeach

## HTML variables & functions & magic functions
> $event.target.innerText - get darget information
>> `wire:change="fun($event.target.value)"` - get value

> $Set('property', 'valur') - set data

> $toggle('property') - toogle boolean

> $refresh - refresh the parent component

> $emit('refreshChildrenFun', ...params) - It will not update the parent, the request will be send only to the childrens
>> window.livewire.emit('postAdded')

> wire.model="parent.message" - handle array data

## EVENTS
> wire:[event] = "fun({{ $todo->id }}, '{{ $todo->name }}')"

> wire:model="var"  - default 150ms
>> `wire:model.debounce.500ms="var"` - change request time
>> `wire:model.lazy="var"` - request will be send only when u click away

> wire:click

> wire:mouseenter

> wire:keydown
>> `wire:keydown.enter`
>> `wire.keydown.backspace`
>> `wire.keydown.escape`
>> `wire.keydown.shift`
>> `wire.keydown.tab`
>> `wire.keydown.arrow-right`
>> `wire.keydown.page-down`

> wire:submit
>> `wire:submit.prevent` - event.preventDefault()
>> `wire:submit.stop` - event.stopPropagation()

> wire:loading
>> wire:loading.remove
>> wire:loading.class="bg-gray"
>> wire:loading.attr="disabled"
>> wire:loading.class.remove="bg-blue"
>> wire:target="save, checkout"

> wire:poll -  refresh the component
>> wire.poll.750ms
>> wire:poll="action" - method will be called every 2 sec

> wire:click.prefetch="toggleContent"

> wire:offline
>> wire:offline.class="bg-red-300"
>> wire:offline.class.remove="bg-green-300"
>> wire:offline.attr="disabled"

> `wire:dirty.class="border-red-500"` - when a user modifies the input value, the element will receive the class.The class will be removed again if the input value returns to its original state.
>> wire.dirty.class.remove="bg-green-200"

```php
@error('name') <span class="error">{{ $message }}</span> @enderror
```

## Livewire class
```php
use Livewire\Component;
use \Illuminate\Session\SessionManager;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;

class {

	use WithFileUploads, AuthorizesRequests, WithPagination;

	public $search;

    # url query will be updated when state changed every time
	protected $updatesQueryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    # fill & reset data
    $this->fill(request()->only('search', 'page'));
    $this->fill(['message' => 'Hello World!']);
    $this->reset();

    # Casting Properties
    protected $casts = [
        'options' => 'collection', // public $options = ['foo', 'bar', 'bar'];
        'expiresAt' => 'date', // public $expiresAt = 'tomorrow';
        'formattedDate' => 'date:m-d-y' // public $formattedDate = 'today';
    ];

	// @livewire(hello-world, ['name'=>'vicky'])
	# runs during the initial page load
	public function mount(Request $request, SessionManager $session, $name) {
		$session->put("contact.{$contact->id}.last_viewed", now());
		$this->sectionHeading = request('section_heading', $sectionHeading);
		$this->search = request()->query('search', $this->search);
	}

	public function hydrate() { } // Runs on every request - when type at the input box

	public function updating($name, $value) { } // runs before update
	public function updated($name, $value) { } // runs after any update
	public function updatingName($value) { }
	public function updatedName($value) { }

	$this->emit('refreshChildren', 'data'); // this will update the both parent and children
	$this->emitUp('refreshParent'); // contact with parents
	$this->emitTo('counterLivewire', 'refreshLivewireEvent'); // named livewire component
	$this->emitSelf('postAdded'); // self

	Protected $listeners = ['refreshChildren' => 'fun', 'refreshChildren'=>'$refresh'];
	protected function getListeners() { return ['postAdded' => 'showPostAddedMessage']; }

	# computed property (useful for it won't make a seperate database query every time)
	public function getPostProperty() { // access by $this->post
        return Post::find($this->postId);
    }

    # Validation
    public function submit() {
    	$this->authorize('update', $this->post);

        # validation
        $this->validate([
            'name' => 'required|min:6',
            'photo' => 'image|max:1024', // 1MB Max
        ]);
        $validatedData = Validator::make( // {{ $errors->first('email') }}
            ['email' => $this->email],
            ['required' => 'The :attribute field is required'],
        )->validate(); // Contact::create($validatedData);

        # add custome key/value pair
        $this->addError('email', 'The email field is invalid.');

        # reset validation
        $this->resetErrorBag();
        $this->resetValidation();
		$this->resetValidation('email');
		$this->resetErrorBag('email');

		# get errors
		$errors = $this->getErrorBag();
		$errors->add('some-key', 'Some message');
    }
    # Real time validation - when type
    public function updated($name) {
        $this->validateOnly($name, [
            'name' => 'min:6',
            'email' => 'email',
        ]);
    }

	public function render()
    {
    	return view('livewire.show-posts', [
    		'posts' => Post::paginate(10) // {{ $posts->links() }}
    	]);

    	# inline blade
        return <<<'blade'
            <div>
                <button wire:click="delete">Delete Post</button>
            </div>
        blade;
    }
}
```

## Javascript
```js
// livewire.event - working in f2 console
livewire.emit('refreshChildren');

// Listening the event
window.livewire.on('postAdded', postId => {
    alert('A post was added with the id of: ' + postId);
})

document.addEventListener("livewire:load", function(event) {
    window.livewire.hook('beforeDomUpdate', () => {
        // Add your custom JavaScript here.
    });

    window.livewire.hook('afterDomUpdate', () => {
        // Add your custom JavaScript here.
    });
});
```
