  <style type="text/css">
  table td, table th{
  border: 1px solid;
  }
  </style>
  <table class="report_1 table table-bordered report-table text-center">
        <thead>
          <tr>
            <td><strong>SL.#</strong></td>
            <td><strong>Sub-no.</strong></td>
            <td><strong>Name of the Item</strong></td>
            <td><strong>No. of total Training Events</strong></td>
            <td><strong>No. of Total Training Batches</strong></td>
            <td><strong>No. of total Training Events Actual</strong></td>
            <td><strong>No. of Total Training Batches Actual</strong></td>
          </tr>
          
        </thead>
        <tbody>

          @foreach ($training_categories as $category)
            <tr>
            <td><strong>{{ $category->serial_no }}</strong></td>
            <td colspan="3" class="text-left">
              <strong> {{ $category->name }}</strong>
            </td>
            <td></td>
            <td></td>
            <td></td>
            </tr>

            @foreach ($trainings as $item)
            @if ($item->training_category_id==$category->id)
              <tr>
              <td></td>
              <td>{{ $item->serial_number }}</td>
              <td>{{ $item->title}}</td>
              <td>{{ $item->total_event }}</td>
              <td>{{ $item->toatal_batch }}</td>

              @foreach ($training_activities as $actual)
              @if ($actual->training_id==$item->id)
              <td>{{ $actual->number_of_event }}</td>
              <td>{{ $actual->number_of_batch }}</td>
              @endif

              @endforeach  
            </tr>
            @endif
            @endforeach
          @endforeach

        </tbody>
  </table>
            
            