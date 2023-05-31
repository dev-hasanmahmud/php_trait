@foreach ($data as $item)
<div class="col-6">
    <div class="form-group">
      <label for="exampleInputEmail1">{{ $item->label_name }}</label>
      <div class="input-group datepicker-box" id="show">
        <input name="value_{{ $loop->iteration }}"  class="form-control datepicker w-100" 
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
</div>
@endforeach

