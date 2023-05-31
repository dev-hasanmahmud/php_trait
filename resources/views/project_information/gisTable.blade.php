<div class="table-responsive text-center" id="report_table">
    <table class="table table-bordered bg-white report-table">
        <thead>
            <tr>

                {{-- <td width="3%">SL</td> --}}
                <td width="18%" class="text-left">Category</td>
                <td width="10%" class="text-left">Date</td>
                <td width="20%" class="text-left">Name</td>
                {{-- <td width="13%" class="text-left">Reference</td> --}}
                <td width="27%" class="text-left">File </td>
                <td width="23%" class="text-left">Status</td>
            </tr>
        </thead>
        <tbody>
            @php
            $previous = '';
            $l=0;
            @endphp

            @foreach ($files as $item)
                <tr>

                    {{-- <td class="text-center">{{ $loop->index + $files->firstItem() }}
                    </td>
                    <td class="text-left">{{ $item->title }}</td>
                    <td>{{ $item->date }}</td> --}}

                    @if ($previous == $item->name)
                        {{-- <td class="text-center"></td>
                        <td class="text-left"></td>
                        <td></td>
                        <td class="text-left"> </td>
                        <td></td> --}}
                    @else
                        {{-- <td class="text-center"
                            rowspan="{{ $count[$loop->index + 1] }}">{{ $l + $files->firstItem() }}</td>
                        --}}
                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->title }}</td>
                        <td rowspan="{{ $count[$loop->index + 1] }}">{{ $item->date }}</td>
                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->name }} </td>
                        {{-- <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->description }}</td> --}}

                        @php
                        $l++;
                        @endphp

                    @endif

                    @php
                    $previous = $item->name;
                    $fileName = explode('-.-',$item->file_path);
                    @endphp


                    <td class="text-left">
                        {{-- @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'PDF')
                            File
                            @else
                            Image
                        @endif --}}
                        <p>{{ isset($fileName[1]) ? $fileName[1] : null }}</p>
                    </td>
                    <td width="23%">
                        {{-- @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf')
                            --}}
                            <a class="btn btn-outline-primary btn-xs view-pdf mr-2" href="{{ url($item->file_path) }}"
                                target="_blank">
                                <i class="fa fa-eye" aria-hidden="true"></i> View </a>
                            {{-- @else
                            <a class="btn btn-outline-success btn-xs" href="{{ url($item->file_path) }}"
                                target="_blank">
                                <i class="fa fa-download" aria-hidden="true"></i> Download</a>
                            --}}
                            {{--
                        @endif --}}
{{--                        <a class="btn btn-outline-success btn-xs" href="{{ url($item->file_path) }}" target="_blank">--}}
                        <a class="btn btn-outline-success btn-xs" href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$item->id]) }}" target="_blank">
                            <i class="fa fa-download" aria-hidden="true"></i> Download</a>

                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>
    {{-- <div class="mt-4 text-center">{{ $files->links() }}</div>
    --}}
    <div class="mt-4 text-center">
        {{-- {{ $files->links() }} --}}
        @if ($files->lastPage() > 1)
            @php
            $filter_data = isset($is_filter[0]) ? "&catid=".$is_filter[1]."&date=".$is_filter[2] : null ;
            $category_id = isset($by_categoty_id[0]) ? "&category_id=".$by_categoty_id[1] : null ;
            @endphp
            <nav>
                <ul class="pagination" id="paginationtraining">
                    <li class="page-item {{ $files->currentPage() == 1 ? ' disabled' : '' }}">
                        <a class="page-link main-pagination"
                            action="{{ $files->url($files->currentPage() - 1) . $filter_data . $category_id }}"
                            href="javascript:void(0)" data-id="{{ $files->currentPage() - 1 }}" rel="next"
                            aria-label="Next &raquo;">&lsaquo;</a>
                    </li>
                    @for ($i = 1; $i <= $files->lastPage(); $i++)
                        <li class="page-item {{ $files->currentPage() == $i ? ' active' : '' }}">
                            {{-- <input type="text" hidden
                                value="{{ $files->url($i) . '&package_id=' . $package_id . $filter_data . $category_id }}"
                                id="url_{{ $i }}"> --}}
                            <a class="page-link main-pagination"
                                action="{{ $files->url($i) . $filter_data . $category_id }}" href="javascript:void(0)"
                                data-id="{{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $files->currentPage() == $files->lastPage() ? ' disabled' : '' }}">
                        <a class="page-link main-pagination"
                            action="{{ $files->url($files->currentPage() + 1) . $filter_data . $category_id }}"
                            href="javascript:void(0)" data-id="{{ $files->currentPage() + 1 }}" rel="next"
                            aria-label="Next &raquo;">&rsaquo;</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</div>
