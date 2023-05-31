<table class="table table-bordered table-striped">
    <thead>
      <tr>
        <td width="10%" class="text-left">SL</td>
        <td width="50%">Title</td>
        <td width="25%">File</td>
        <td width="15%">Action</td>
      </tr>
    </thead>
    <tbody>
     @foreach ($file_list as $item)
     @php

        $filename = explode('-.-',$item->file_path)
         
     @endphp
     <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ isset($filename[1])?$filename[1]:''  }}</td>
        <td>
        <a class="btn btn-success btn-sm" href="{{ url($item->file_path) }}">
            <i class="fa fa-download" aria-hidden="true"></i> Download</a>
        </td>
      </tr>
     @endforeach
    </tbody>
</table>

<div class="text-center"> 
  <a class="btn btn-success btn-sm mt-4" href="{{ url('dashboard/package-report?package_id='.$package_id) }}" > More </a>
</div>