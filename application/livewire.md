# livewire

## Install
> composer require livewire/livewire

create livewire
> php artisan make:livewire hello-world

move livewire
> php artisan livewire:mv register auth.register

## Config
> @livewireStyles

> @livewire(hello-world, ['name'=>'vicky'])

> @livewireScripts

## sub
@foreach($names as $name)
	@livewire('say-hi', ['name'=>$name], key($name->id))
@endforeach

## HTML variables & functions
> `fun($event.target.innerText)` - get darget information

> `wire:click="$Set('name', 'vignesh')"` - set data

> `wire:click="$refresh"` - refresh the parent component

> `wire:click="$emit('refreshChildren')"` - It will not update the parent, the request will be send only to the childrens

## EVENTS

> livewire.event - working in f2 console
>> `livewire.emit('refreshChildren')`

> wire:model="var"
>> `wire:model.debounce.1000ms="var"` - change request time
>> `wire:model.lazy="var"` - request will be send only when u click away

> wire:click="fun(arg)"

> wire:mouseenter=""

> wire:keydown=""

> wire:submi.prevent=""

## Livewire class

```php
class {
	public function mount(Request $request, $name) { } // @livewire(hello-world, ['name'=>'vicky'])

	public function hydrate() { } // when type at the input box

	public function updating() { }
	public function updated($name) { }
	public function updatedName() { }

	$this->emit('refreshChildren', 'data'); // this will update the both parent and children
	$this->emitUp('refreshParent'); // contact with parents
	Protected $listeners = ['refreshChildren' => 'fun', 'refreshChildren'=>'$refresh'];
}
```
