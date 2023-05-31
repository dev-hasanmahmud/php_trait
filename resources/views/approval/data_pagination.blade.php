     <div class="mt-4 text-center" id="paginationtraining">
        {{-- {{ $indicator_data->links() }} --}}
        @if ($indicator_data->lastPage() > 1)
            @php
                $filter_data = $is_filter ? "&component_id=".$search[0]."&status=".$search[1] : null ;
            @endphp
            <nav>
                <ul class="pagination">
                    <li class="page-item {{ ($indicator_data->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" href="{{ $indicator_data->url($indicator_data->currentPage()-1).$filter_data}}"  data-id="{{ $indicator_data->currentPage()-1 }}" rel="next" aria-label="Next &raquo;">&lsaquo;</a>
                    </li>
                    @for ($i = 1; $i <= $indicator_data->lastPage(); $i++)
                        <li class="page-item {{ ($indicator_data->currentPage() == $i) ? ' active' : '' }}"  >
                            {{-- <input type="text"  hidden value="{{ $indicator_data->url($i).'&component_id='.$component_id.$filter_data.$category_id  }}" id="url_{{ $i }}"> --}}
                            <a class="page-link main-pagination" href="{{ $indicator_data->url($i).$filter_data  }}"  data-id="{{ $i }}" >{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ( $indicator_data->currentPage() == $indicator_data->lastPage() ) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" href="{{ $indicator_data->url($indicator_data->currentPage()+1).$filter_data  }}"  data-id="{{ $indicator_data->currentPage()+1 }}" rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>