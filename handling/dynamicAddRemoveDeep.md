# route
```php
Route::get('blog-sidebar/get-tag', 'BlogSidebarController@getTag')->name('blog-sidebars.getTag');
Route::get('blog-sidebar/get-tag-sub', 'BlogSidebarController@getTagSub')->name('blog-sidebars.getTagSub');
```

# controller
```php
public function getTag(Request $request)
{
	$html = view("admin.blogSidebar.tag_dynamic", ['bid' => $request->bid])->render();
	return ['html' => $html];
}

public function getTagSub(Request $request)
{
	$html = view("admin.blogSidebar.tag_sub", ['bid' => $request->bid, 'sub_id' => $request->sub_id])->render();
	return ['html' => $html];
}
```

# tag.blade.php
```php
<div class="card">
	<div class="card-header">
		<b>Tags</b>
		<button onclick="addTag()" type="button" class="btn btn-success btn-xs float-right">Add More</button>
	</div>

	<div class="card-body">
		<div class="form-check">
			<div class="tag_div">
				@if(isset($record->tag))
					@foreach ($record->tag as $tag)
						@component('admin.blogSidebar.tag_dynamic', ['bid' => $loop->index+1, 'tag' => $tag])
						@endcomponent
					@endforeach
				@else
					@component('admin.blogSidebar.tag_dynamic', ['bid' => 1])
					@endcomponent
				@endif
			</div>
		</div>
	</div>
</div>
```

# tag_dynamic.blade.php
```php
<div class="tag" id="tag_{{$bid}}">
	<div class="row">
		<div class="col-md-5 form-group">
			<x-crud.label value="Title" />
			<input class="form-control" name="tag[{{$bid}}][title]" value="{{ $tag['title'] ?? null }}" type="text">
		</div>
		<div class="col-md-5 form-group">
			<x-crud.label value="Order" />
			<input class="form-control" name="tag[{{$bid}}][order]" value="{{ $tag['order'] ?? null }}" type="text">
		</div>
		<div class="col-md-2 flex align-items-center">
			@if($bid > 1)
				<button onclick='removeTag("{{$bid}}")' type="button" class="btn btn-danger btn-xs">
					{{-- <i class="c-sidebar-nav-icon fa-fw fa-remove fas text-red-400"></i> --}}
					Remove
				</button> &emsp;
			@endif
			<button onclick='addTagSub("{{$bid}}")' type="button" class="btn btn-info btn-xs">Add Tags</button>
		</div>
	</div>

	<div class="tag_{{ $bid }}">
		@if(isset($tag['sub']))
			@foreach ($tag['sub'] as $sub)
				@component('admin.blogSidebar.tag_sub', ['bid' => $bid, 'sub_id' => $loop->index+1, 'sub' => $sub])
				@endcomponent
			@endforeach
		@else
			@component('admin.blogSidebar.tag_sub', ['bid' => $bid, 'sub_id' => 1])
			@endcomponent
		@endif
	</div>
</div>

@once
@push('script')
<script>
	function addTag() {
		var bid = $('.tag').length + 1;
		$.ajax({
			type: 'GET',
			url: '{{ route('admin.blog-sidebars.getTag') }}',
			data: { bid: bid },
			success: function(res) {
				$(".tag_div").append(res.html);
			}
		});
	}

	function removeTag(bid) {
		$('#tag_'+bid).remove();
	}

	function addTagSub(bid) {
		var sub_id = $('.tag_sub_'+bid).length + 1;
		$.ajax({
			type: 'GET',
			url: '{{ route('admin.blog-sidebars.getTagSub') }}',
			data: { bid: bid, sub_id: sub_id },
			success: function(res) {
				$(".tag_"+bid).append(res.html);
			}
		});
	}

	function removeTagSub(bid, sub_id) {
		$('#tag_sub_'+bid+'_'+sub_id).remove();
	}
</script>
@endpush
@endonce
```

# tag_sub.blade.php
```php
<div class="row tag_sub_{{$bid}} tag_sub_{{$bid}}_{{$sub_id}}" id="tag_sub_{{$bid}}_{{$sub_id}}">
	<div class="col-md-1 form-group"></div>

	<div class="col-md-5 form-group">
		{{-- <label class="required"> Title </label> --}}
		<input class="form-control" name="tag[{{$bid}}][sub][{{$sub_id}}][title]" value="{{ $sub['title'] ?? null }}" required type="text" placeholder="Title">
	</div>

	<div class="col-md-5 form-group">
		{{-- <label class="required"> URL </label> --}}
		<input class="form-control" name="tag[{{$bid}}][sub][{{$sub_id}}][url]" value="{{ $sub['url'] ?? null }}" required type="text" placeholder="Link">
	</div>

	<div class="col-md-1 flex align-items-center">
		@if($sub_id > 1)
			<button onclick='removeTagSub("{{$bid}}", "{{$sub_id}}")' type="button" class="btn btn-danger btn-xs">Remove</button>
		@endif
	</div>
</div>
```
