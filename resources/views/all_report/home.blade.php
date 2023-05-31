@extends('layouts.master')
@section('content')

    <div class="container  mt-4">


		<section class="procurement-page procurement" id="">

			<ul class="procur_tab_auto p-tab mt-2">
			  <li class="type active" data-id="1"><a href="javascript:void(0)"  data-id="1">goods</a>
			  </li>
			  <li class="type" data-id="2"><a href="javascript:void(0)"  data-id="2">works</a>
			  </li>
			  <li class="type" data-id="3"><a href="javascript:void(0)"  data-id="3">Consulting services</a>
			  </li>
			  <li class="type" data-id="4"><a href="javascript:void(0)">Non Consulting services</a>
			  </li>
			</ul>
		</section>

		<div id="content" style="min-height: 400px"></div>


		{{-- <fieldset class="pb-3 custom-fieldset border rounded">
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
							<td class="text-left w-50"><a href='{{ url("dashboard/package-report?package_id=").$r->id }}'>{{ $r->package_no }} -- {{ $r->name_en }}</a></td>
						@if($i%2 == 0)
						</tr>
						@endif
						@php	$i++; @endphp
					@empty
					@endforelse

			</tbody>
            </table>
			</div>
            </div>
        </fieldset> --}}

		{{-- <fieldset class="pb-3 mb-0 custom-fieldset border rounded">
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
							<td class="text-left w-50"><a href='{{ url("dashboard/package-report?package_id=").$r->id }}'>{{ $r->package_no }} -- {{ $r->name_en }}</a></td>
						@if($i%2 == 0)
						</tr>
						@endif
						@php	$i++; @endphp
					@empty
					@endforelse

            </tbody>
            </table>
			</div>
            </div>
        </fieldset> --}}

</div>

@endsection

@push('script')
<script>
$(document).ready(function(){

    init();

    function init(){
        $.ajax({
			type: "GET",
			url:  " {{ url('ajax/package-list-by-type-id') }}"+'/'+'1',
			//data:{"id":id},
			//dataType:'JSON',
			//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function (data) {
				console.log('fff' +data)
				$('#content').html(data)
			},
			error: function (data) {
				console.log('e')
			// console.log(data.responseText)

			}
      });
    }

	$('body').on('click', '.type', function () {

		var id = $(this).data('id')
		$('li').removeClass('active')
		//$('#content').removeClass('d-none')
		$(this).addClass('active')
		console.log('pop up  '+id)
		var url = ""
		$.ajax({
			type: "GET",
			url:  " {{ url('ajax/package-list-by-type-id') }}"+'/'+id,
			//data:{"id":id},
			//dataType:'JSON',
			//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function (data) {
				console.log('fff' +data)
				$('#content').html(data)
			},
			error: function (data) {
				console.log('e')
			// console.log(data.responseText)

			}
      });
	});
});
</script>
@endpush
