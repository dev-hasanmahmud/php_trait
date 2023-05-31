@extends('layouts.master')
@section('content')

@include('sweetalert::alert')

<div class="container  mb-4">

	<div class="card card-design">
		<div class="card-body">
			<div class="card-title bg-primary">
				<h5 class="d-inline"><i class="fa fa-check" aria-hidden="true"></i> Choose Package </h5>
			</div>

			@php
			$length= count($goods)
			@endphp

			{{-- <fieldset class="pb-3 custom-fieldset border rounded">
        <legend class="custom-legend"> Goods </legend>
        <div class="row">
			<div class="pl-1 pr-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <table class="table table-striped table-bordered">
                <tbody>
					@php
					$i=1;
					@endphp
					@forelse($goods as $k=>$r)
						@if($i%2 != 0)
						<tr>
						@endif
							<td class="text-left w-50"><a href='{{ url("dashboard/drawing-design-report?package_id=").$r->id }}'>{{ $r->package_no }}
			-- {{ $r->name_en }}</a></td>
			@if($i%2 == 0)
			</tr>
			@endif
			@php $i++; @endphp
			@empty
			@endforelse

			</tbody>
			</table>
		</div>
	</div>
	</fieldset> --}}




	<fieldset class="pb-3 custom-fieldset border rounded">
		<legend class="custom-legend"> Works </legend>
		<div class="row">
			<div class="pl-1 pr-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<table class="table table-bordered  table-striped">
					<tbody>
						@php
						$i=1;
						@endphp
						@forelse($works as $k=>$r)
						@if($i%2 != 0)
						<tr>
							@endif
							<td class="text-left w-50"><a
									href='{{ url("dashboard/drawing-design-report?package_id=").$r->id }}'>{{ $r->package_no }}
									-- {{ $r->name_en }}</a></td>
							@if($i%2 == 0)
						</tr>
						@endif
						@php $i++; @endphp
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
		</div>
	</fieldset>
	{{--
	<fieldset class="mb-0 pb-3 custom-fieldset border rounded">
		<legend class="custom-legend"> Service </legend>
		<div class="row">
			<div class="pl-1 pr-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<table class="table table-striped table-bordered">
					<tbody>
						@php
						$i=1;
						@endphp
						@forelse($service as $k=>$r)
						@if($i%2 != 0)
						<tr>
							@endif
							<td class="text-left w-50"><a
									href='{{ url("dashboard/drawing-design-report?package_id=").$r->id }}'>{{ $r->package_no }}
	-- {{ $r->name_en }}</a></td>
	@if($i%2 == 0)
	</tr>
	@endif
	@php $i++; @endphp
	@empty
	@endforelse

	</tbody>
	</table>
</div>
</div>
</fieldset> --}}

</div>
</div>
</div>
</div>

@endsection
