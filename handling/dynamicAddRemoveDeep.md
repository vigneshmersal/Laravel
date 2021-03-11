route

```php
public function getBox(Request $request)
{
	$html = view("components.menu.box", ['bid' => $request->bid])->render();
	return ['html' => $html];
}

public function getLevel1(Request $request)
{
	$html = view("components.menu.level1", ['bid' => $request->bid, 'l1_id' => $request->l1_id])->render();
	return ['html' => $html];
}
```

create.blade.php

```php
<div class="form-group">
    <div class="col-xs-12 form-group">
        <button onclick="addBox()" style="margin-bottom:5px;" type="button" class="btn btn-success btn-xs">Add More</button>
    </div>

    <div class="box_div">
        @component('components.menu.box', ['bid' => 1])
        @endcomponent
    </div>
</div>
```

box.blade.php

```php
<div class="box" id="box_{{$bid}}">
	<div class="row">
		<div class="col-md-6 form-group">
			<label class="required"> Title </label>
			<input class="form-control" name="box[{{$bid}}][title]" value="" required="required" type="text">
		</div>
		<div class="col-md-6 form-group">
			<label class="required"> URL </label>
			<input class="form-control" name="box[{{$bid}}][url]" value="" required="required" type="text">
		</div>
	</div>

	<div class="text-right categRemove">
		@if($bid > 1)
			<button onclick='removeBox("{{$bid}}")' style="margin-bottom:10px;" type="button" class="btn btn-danger btn-xs">Remove</button>
		@endif
		<button onclick='addL1("{{$bid}}")' style="margin-bottom:10px;" type="button" class="btn btn-info btn-xs">Add Menu</button>
	</div>

	<div class="box_{{ $bid }}">

	</div>
</div>

@once
@push('script')
<script>
	function addBox() {
		var bid = $('.box').length + 1;
		$.ajax({
			type: 'GET',
			url: '{{ route('admin.menu.getBox') }}',
			data: { bid: bid },
			success: function(res) {
				$(".box_div").append(res.html);
			}
		});
	}

	function addL1(bid) {
		var l1_id = $('.l1_'+bid).length + 1;
		$.ajax({
			type: 'GET',
			url: '{{ route('admin.menu.getLevel1') }}',
			data: { bid: bid, l1_id: l1_id },
			success: function(res) {
				$(".box_"+bid).append(res.html);
			}
		});
	}

	function removeBox(bid) {
		$('#box_'+bid).remove();
	}

	function removeL1(bid, l1_id) {
		$('#l1_'+bid+'_'+l1_id).remove();
	}
</script>
@endpush
@endonce
```

level1.blade.php

```php
<div class="row l1_{{$bid}} l1_{{$bid}}_{{$l1_id}}" id="l1_{{$bid}}_{{$l1_id}}">
	<div class="col-md-1 form-group"></div>

	<div class="col-md-5 form-group">
		<label class="required"> Title </label>
		<input class="form-control" name="box[{{$bid}}][{{$l1_id}}][title]" value="" required="required" type="text">
	</div>

	<div class="col-md-5 form-group">
		<label class="required"> URL </label>
		<input class="form-control" name="box[{{$bid}}][{{$l1_id}}][url]" value="" required="required" type="text">
	</div>

	<div class="col-md-1 form-group">
		@if($l1_id > 1)
			<label for=""></label>
			<button onclick='removeL1("{{$bid}}", "{{$l1_id}}")' type="button" class="btn btn-danger btn-xs">Remove</button>
		@endif
	</div>
</div>

<div class="box_l1_{{ $bid }}">

</div>
```
