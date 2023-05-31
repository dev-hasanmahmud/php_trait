<div class="card card-design" id="content">
    <div class="card-body">
        <div class="card-title bg-primary">
            <h5 class="d-inline"><i class="fa fa-check" aria-hidden="true"></i> Choose Package </h5>
        </div>

        <fieldset class="pb-3 custom-fieldset border rounded">
            <div class="pl-1 pr-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @php
                $length= count($packages)
                @endphp
                <table class="table table-striped table-bordered">
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @forelse($packages as $k=>$r)
                            @if ($i % 2 != 0)
                                <tr>
                            @endif
                            <td class="text-left w-50"><a
                                href="{{ url('dashboard/package-report?package_id='. $r->id)  }}">
                                {{ $r->package_no }} -- {{ $r->name_en }}</a></td>
                            @if ($i % 2 == 0)
                                </tr>
                            @endif
                            @php $i++; @endphp
                        @empty
                            <h2>No Package Found</h2>
                        @endforelse

                    </tbody>
                </table>
            <div>

        </fieldset>
    </div>
</div>
