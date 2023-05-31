

    <table class="table table-bordered bg-white report-table">
        <thead>
            <tr>
                {{-- <td width="4%"  >SL</td> --}}
                <td width="16%" >Category</td>
                <td width="10%" >Date</td>
                <td width="28%" >Report Name</td>
                <td width="20%" >Reference</td>
                <td width="22%" >Download</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($files as $item)
        <tr>
            {{-- <td>{{ $loop->index+$files->firstItem() }} </td> --}}
            <td class="text-left" >{{ $item->title}}</td>
            <td>{{ $item->date}}</td>
            <td class="text-left" >{{ $item->name}}</td>
            <td class="text-left" >{{ $item->description}}</td>
            <td width="22%">

                {{-- @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'doc' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'docx' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'xlsx') --}}
                    <a  class="btn btn-outline-primary btn-xs"  href="{{ url($item->file_path) }}" target="_blank">
                        <i class="fa fa-eye" aria-hidden="true"></i> View</a>

                {{-- @else --}}
                    <a class="btn btn-outline-success btn-xs" href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$item->id]) }}" target="_blank">
                        <i class="fa fa-download" aria-hidden="true"></i> Download</a>
                {{-- @endif --}}
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
     <div class="mt-4 text-center" >
        {{-- {{ $files->links() }} --}}
        @if ($files->lastPage() > 1)
            @php
                $filter_data = isset($is_filter[0]) ? "&catid=".$is_filter[1]."&date=".$is_filter[2] : null ;
                $category_id = isset($by_categoty_id[0]) ? "&category_id=".$by_categoty_id[1] : null ;
            @endphp
            <nav>
                <ul class="pagination" id="paginationtraining">
                    <li class="page-item {{ ($files->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" action="{{ $files->url($files->currentPage()-1).$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $files->currentPage()-1 }}" rel="next" aria-label="Next &raquo;">&lsaquo;</a>
                    </li>
                    @for ($i = 1; $i <= $files->lastPage(); $i++)
                        <li class="page-item {{ ($files->currentPage() == $i) ? ' active' : '' }}"  >
                            {{-- <input type="text"  hidden value="{{ $files->url($i).'&package_id='.$package_id.$filter_data.$category_id  }}" id="url_{{ $i }}"> --}}
                            <a class="page-link main-pagination" action="{{ $files->url($i).$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $i }}" >{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ( $files->currentPage() == $files->lastPage() ) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" action="{{ $files->url($files->currentPage()+1).$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $files->currentPage()+1 }}" rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>

