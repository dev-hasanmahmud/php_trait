<div class="table-responsive text-center" id="report_table">
    <table class="table table-bordered bg-white report-table">
        <thead>
        <tr>

            {{-- <td width="3%">SL</td> --}}
            <td width="15%" class="text-left">Category</td>
            <td width="10%" class="text-left">Date</td>
            <td width="20%" class="text-left">Name</td>
            {{-- <td width="13%" class="text-left">Reference</td>
            --}}
            <td width="35%" class="text-left">File</td>
            <td width="20%" class="text-left">Status</td>
        </tr>
        </thead>
        <tbody>
        @php
            $previous = '';
            $l=0;
        @endphp

        @foreach ($files as $item)
            <tr>


                @if ($previous == $item->name)

                @else

                    <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->title }}</td>
                    <td rowspan="{{ $count[$loop->index + 1] }}">{{ $item->date }}</td>
                    <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->name }} </td>

                    @php
                        $l++;
                    @endphp

                @endif

                @php
                    $previous = $item->name;
                    $fileName = explode('-.-',$item->file_path);
                @endphp


                <td class="text-left">

                    <p>{{ isset($fileName[1]) ? $fileName[1] : null }}</p>
                </td>
                <td width="23%">
                <!--
                        <a class="btn btn-outline-primary btn-xs view-pdf mr-2" href="{{ url($item->file_path) }}"
                            target="_blank">
                            <i class="fa fa-eye" aria-hidden="true"></i> View </a>
                        -->
                    <a class="btn btn-outline-primary btn-xs view-pdf mr-2"
                       href="{{ url($item->file_path) }}"
                       target="_blank">
                        <i class="fa fa-eye" aria-hidden="true"></i> View </a>

                    <a class="btn btn-outline-success btn-xs"
                       href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$item->id]) }}"
                       target="_blank">
                        <i class="fa fa-download" aria-hidden="true"></i> Download</a>

                </td>
            </tr>
        @endforeach

        </tbody>

    </table>
    {{-- <div class="mt-4 text-center">{{ $files->links() }}</div>
    --}}
    <div class="mt-4 text-center">
        {{ $files->links() }}

    </div>
    <input type="text" hidden value="{{ $package_id }}" id="package_id">
    <input type="text" hidden value="{{ $fm_id }}" id="category_id">
</div>
