<div class="modal fade modal-md" id="{{ $id }}">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h3 class="modal-title">{{ $header }}</h3>
				<button type="button" class="close" data-dismiss="modal" id="closeModal">×</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				{{ $slot }}
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				@isset($footer)
					{{ $footer }}
				@else
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				@endisset
			</div>

		</div>
	</div>
</div>
