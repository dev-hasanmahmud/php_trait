@foreach ($indicator_details as $item)
    
<div class="col-md-6 mb-3">
    <label for="progress_value">Previous Progress Percentage (%) </label>
    <input type="text"  class="form-control" value="{{ $item->progress }}" readonly="" />
</div>
<div class="col-md-6 mb-3 ">
    <label for="achievement_quantity">Previous Achievement In Quantity </label>
    <input type="text"  class="form-control" value="{{ $item->qty }}"  readonly=""/>
</div>

@endforeach

<input type="number" id="indicator_target"  value="{{ $indicator_target->target }}">