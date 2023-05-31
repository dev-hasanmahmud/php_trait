@push('css')
     <style>
            .iframe-container {
    padding-bottom: 60%;
    padding-top: 30px; height: 0; overflow: hidden;
    }

    .iframe-container iframe,
    .iframe-container object,
    .iframe-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
     </style>
    <link rel="stylesheet" href="{{custom_asset('assets/css/colorbox.css')}}" />
    @endpush

<div class="table-responsive text-center" id="report_table">
        <table class="table table-bordered bg-white report-table">
    <thead>
    <tr>
      <td width="5%">SL</td>
      <td width="15%">Category</td>
      <td width="10%">Date</td>
      <td width="25%">Report Name</td>
      <td width="25%" >Reference</td>
      <td width="20%">Status</td>
    </tr>
    </thead>
    <tbody>
    @foreach ($files as $item)
     <tr>
        <td class="text-center" >{{ $loop->index+$files->firstItem() }}</td>
        <td class="text-left" >{{ $item->title}}</td>
        <td>{{ $item->date}}</td>
        <td class="text-left" >{{ $item->name}}</td>

        <td class="text-left" >{{ $item->description}}</td>
        <td>
             {{-- if doc or xl --}}
            @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'doc' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'docx' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'xlsx')
            <a  class="btn btn-outline-primary btn-xs"  href="{{ url($item->file_path) }}" target="_blank">
            <i class="fa fa-eye" aria-hidden="true"></i> View </a> &nbsp;
                {{-- if pdf --}}
            @elseif (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf' || pathinfo($item->file_path, PATHINFO_EXTENSION) == 'PDF')
            <a  class="btn btn-outline-primary btn-xs view-pdf"  href="{{ url($item->file_path) }}" target="_blank">
            <i class="fa fa-eye" aria-hidden="true"></i> View</a> &nbsp;
                {{-- if image --}}
            @else
            <a  class="btn btn-outline-primary btn-xs group1"  href="{{ url($item->file_path) }}" target="_blank">
            <i class="fa fa-eye" aria-hidden="true"></i> View</a> &nbsp;
            @endif
            <a class="btn btn-outline-success btn-xs" href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$item->id]) }}" target="_blank">
             <i class="fa fa-download" aria-hidden="true"></i> Download</a>
        </td>
     </tr>
    @endforeach

    </tbody>

    </table>
     <div class="mt-4 text-center">
          @if ($files->lastPage() > 1)
            @php
                $filter_data = isset($is_filter[0]) ? "&catid=".$is_filter[1]."&date=".$is_filter[2] : null ;
                $category_id = isset($by_categoty_id[0]) ? "&category_id=".$by_categoty_id[1] : null ;
            @endphp
            <nav>
                <ul class="pagination" id="paginationtraining">
                    <li class="page-item {{ ($files->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" action="{{ $files->url($files->currentPage()-1).'&package_id='.$package_id.$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $files->currentPage()-1 }}" rel="next" aria-label="Next &raquo;">&lsaquo;</a>
                    </li>
                    @for ($i = 1; $i <= $files->lastPage(); $i++)
                        <li class="page-item {{ ($files->currentPage() == $i) ? ' active' : '' }}"  >
                            {{-- <input type="text"  hidden value="{{ $files->url($i).'&package_id='.$package_id.$filter_data.$category_id  }}" id="url_{{ $i }}"> --}}
                            <a class="page-link main-pagination" action="{{ $files->url($i).'&package_id='.$package_id.$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $i }}" >{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ( $files->currentPage() == $files->lastPage() ) ? ' disabled' : '' }}">
                        <a class="page-link main-pagination" action="{{ $files->url($files->currentPage()+1).'&package_id='.$package_id.$filter_data.$category_id  }}" href="javascript:void(0)" data-id="{{ $files->currentPage()+1 }}" rel="next" aria-label="Next &raquo;">&rsaquo;</a>
                    </li>
                </ul>
            </nav>
        @endif
     </div>
    </div>
@push('script')
<script>
    /*
* This is the plugin
*/
(function(a){a.createModal=function(b){defaults={title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){
    $('.view-pdf').on('click',function(){
        var pdf_link = $(this).attr('href');
        //var filename= pdf_link.split('-');
        var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
        $.createModal({
        message: iframe,
        closeButton:true,
        scrollable:false
        });
        return false;
    });
})
</script>
<script src="{{custom_asset('assets/js/jquery.colorbox.js')}}"></script>
<script>
      var swiper = new Swiper(".swiper-container-slider", {
        slidesPerView: 3,
        spaceBetween: 10,
        freeMode: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false
        },
        // init: false,
        pagination: {
          el: ".swiper-pagination-slider",
          clickable: true
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 40
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 50
          }
        }
      });
    </script>
 <script>
      $(document).ready(function() {
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({ rel: "group1" , width:"90%", height:"90%" });
        $(".non-retina").colorbox({ rel: "group5", transition:"none" });
        $(".retina").colorbox({
          rel: "group5",
          transition: "none",
          retinaImage: true,
          retinaUrl: true
        });
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function() {
          $("#click")
            .css({
              "background-color": "#f00",
              color: "#fff",
              cursor: "inherit"
            })
            .text(
              "Open this window again and this message will still be here."
            );
          return false;
        });
      });
 </script>

@endpush
