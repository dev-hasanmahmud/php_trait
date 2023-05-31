<table class="table table-bordered table-striped" >
    <thead>
      <tr>
        <td width="21%" class="text-left">Progress Stage</td>
        <td width="8%">Ave Weightage</td>
        <td width="8%">Target</td>
        <td width="12%">In Progress</td>
        <td width="50%">Achievement in %</td>
      </tr>
    </thead>
    <tbody>
      @forelse($indicator_list as $r)
        <tr>
        <td><a  href="" data-toggle="modal" data-id="{{ $r->id }}" class="indicatormodal" >{{ $r->name_en }}</a></td>
        <td>{{ $r->ave_weightage }}</td>
        <td>{{ $r->target }}</td>
        <td>@if(isset($indicator_data[$r->id]['qty'])) {{ $indicator_data[$r->id]['qty'] }} @endif</td>
        <td>
          <div class="progress">
            @if(isset($indicator_data[$r->id]['achivement']))  
            <div class="progress-bar" role="progressbar" style="width: {{ $indicator_data[$r->id]['achivement'] }}%;" aria-valuenow="{{ $indicator_data[$r->id]['achivement'] }}"
              aria-valuemin="{{ $indicator_data[$r->id]['achivement'] }}" aria-valuemax="100">
              {{ $indicator_data[$r->id]['achivement'] }}%
            </div>
            @else
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
              aria-valuemin="0" aria-valuemax="100">
              0%
            </div>	
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 90%;" aria-valuenow="90"
              aria-valuemin="0" aria-valuemax="100">
              0%
            </div>
          </div>
        </td>
      </tr>
      @endforelse
      
      
     
    </tbody>
  </table>