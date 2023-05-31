
<div class="table-responsive text-center" id="report_table">
        <table class="table table-bordered bg-white report-table">
    <thead>
    <tr>

        <td width="5%">SL</td>
        <td width="15%">Category</td>
        <td width="10%">Date</td>
        <td width="25%">Report Name</td>
        {{-- <td width="25%" >Reference</td> --}}
        <td width="20%">Status</td>
    </tr>
    </thead>
    <tbody>
    @foreach ($files as $item)
     <tr>
        <td class="text-center" >{{ $loop->index+$files->firstItem()	}}</td>
        <td class="text-left" >{{ $item->title}}</td>
        <td>{{ $item->date}}</td>
        <td class="text-left" >{{ $item->name}}</td>
        {{-- <td class="text-left" >{{ $item->description}}</td> --}}
        <td width="23%">
            {{-- @if (pathinfo($item->file_path, PATHINFO_EXTENSION) == 'pdf') --}}
                <a  class="btn btn-outline-primary btn-xs view-pdf mr-2"  href="{{ url($item->file_path) }}" target="_blank">
                    <i class="fa fa-eye" aria-hidden="true"></i> View </a>
            {{-- @else
                <a class="btn btn-outline-success btn-xs" href="{{ url($item->file_path) }}" target="_blank">
                <i class="fa fa-download" aria-hidden="true"></i> Download</a> --}}
            {{-- @endif --}}
            <a class="btn btn-outline-success btn-xs" href="{{ route('package_Report.file_manager.download',['fileManagerId'=>$item->id]) }}" target="_blank">
                <i class="fa fa-download" aria-hidden="true"></i> Download</a>
        </td>
     </tr>
    @endforeach

    </tbody>

    </table>
     <div class="mt-4 text-center">{{ $files->links() }}</div>
    </div>
