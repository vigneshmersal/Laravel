# Add/Remove Row

database

```php
$table->json('section');
```

model

```php
protected $casts = [
	// App\MockTest::first()->section = Collection{ all:[ 1=>["name"=>"vig"], 2=>[] ] }
	// App\MockTest::first()->section->count() = 2
	// App\MockTest::first()->section->toArray() = [ 1=>["name"=>"vig"], 2=>[] ]
	// App\MockTest::first()->section->keys() = Collection { all:[1, 2] }
	// App\MockTest::first()->section->keys()->toArray() = [1, 2]
	// App\MockTest::first()->section->values() = Collection{ all:[ ["name"=>"vig"], [] ] }
	// App\MockTest::first()->section->values()->toArray() = [ ["name"=>"vig"], [] ]
	// App\MockTest::first()->section->first() = ["name":"vig"]
	// App\MockTest::first()->section[2] = ["name":"vig"]
	// App\MockTest::first()->section[2]['name'] = "vig"
	'section' => 'collection'

	// App\MockTest::first()->section = [ 1=>["name"=>"vig"], 2=>[] ]
	// App\MockTest::first()->section[2] = ["name":"vig"]
	// App\MockTest::first()->section[2]['name'] = "vig"
	'section' => 'array'
];

public function setSectionAttribute($value)
{
	if($value) {
		$data = [];
		foreach(array_values($value) as $val) {
			if($val['name']) $data[] = $val;
		}
		$this->attributes['section'] = json_encode($data);
	}
}
```

validation

```php
'section' => 'required|array',
'section.*.name' => 'required|string',
```

route

```php
Route::get('tests/getBox', 'testsController@getBox')->name('test.getBox');
```

controller

```php
# store
$test = Test::create($request->all());
// foreach ($request->rowSections as $value) {
// 	$name = $request->{$key}['name'];
// }

# update
$test->update($request->all());

public function getBox(Request $request)
{
	$html = view("components.testSection", ['rid' => $request->rid])->render();
	return ['html' => $html];
}
```

testSection.blade.php

```php
<div id="seccount{{$rid}}" class="section_box">
	<div class="row">
		<div class="col-md-2 col-xs-12 form-group">
			<label class="col-xs-12 required"> Section </label>
			<input class="form-control col-xs-12 addsectn text_div" name="section[{{$rid}}][name]" value="{{ old('section[$rid][name]', $section['name'] ?? null) }}" placeholder="" required type="text">
		</div>
	</div>
	<div class="col-xs-12 text-right">
		@if($rid > 1)
			<button onclick='removeRow("{{$rid}}")' style="margin-bottom:10px;" type="button" class="btn btn-danger btn-xs">Remove</button>
		@endif
	</div>
	{!! Form::hidden('rowSections[]', $rid, []) !!}
</div>

@once
@push('script')
<script>
function addRow() {
	var rid = $('.section_box').length + 1;
	$.ajax({
		type: 'GET',
		url: '{{ route('admin.test.getBox') }}',
		data: { rid: rid },
		success: function(res) {
			$(".section_div").append(res.html);
		}
	});
}

function removeRow(id) {
	$('#seccount'+id).remove();
}
</script>
@endpush
@endonce
```

create.blade.php

```php
<div class="card">
	<div class="card-header">
		<b>Question/Answer</b>
		<button onclick="addRow()" type="button" class="btn btn-success btn-xs float-right">Add More</button>
	</div>

	<div class="card-body section_div">
		@component('components.meta.question', ['rid' => 1])
		@endcomponent
	</div>
</div>
```

edit.blade.php

```php
<div class="card">
	<div class="card-header">
		<b>Question/Answer</b>
		<button onclick="addRow()" type="button" class="btn btn-success btn-xs float-right">Add More</button>
	</div>

	<div class="card-body section_div">
		@if(isset($metaDetail) && isset($metaDetail->question) && count($metaDetail->question))
			@foreach($metaDetail->question as $key => $question)
				@component('components.meta.question', ['rid' => $key, 'question' => $question])
				@endcomponent
			@endforeach
		@else
			@component('components.meta.question', ['rid' => 1])
			@endcomponent
		@endif
	</div>
</div>
```

show.blade.php

```php
<tr>
	<td colspan="2">
		<table class="w-100">
			<tr>
				<th><b>Question</b></th>
				<th><b>Answer</b></th>
			</tr>
			@foreach($metaDetail->question as $key => $section)
				<tr>
					<td>{{ $section['ques'] ?? null }}</td>
					<td>{{ $section['ans'] ?? null }}</td>
				</tr>
			@endforeach
		</table>
	</td>
</tr>
```
