@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Package Working Progress</h5>
            </div>

            

            <form  method="POST" action="{{ url('package_working_progrss',$component->id) }}"  >
                
                @csrf
                {{method_field("PATCH")}}
                <div class="border p-3 bg-white rounded">

                    <div class="form-group">
                        <label for="source_of_fund_name_en">Package Number</label>
                        <input name="package_id" value="{{ $component->id }}" hidden/>

                        <input
                          type="text"
                          value="{{ $component->package_no }}-{{ $component->name_en }}"
                          class="form-control"
                          readonly
                          id="source_of_fund_name_en"
                          aria-describedby="textHelp"
                        />
                        
                    </div>


                    <div class="form-group">
                        <label for="source_of_fund_name_bn">Area of Activity</label>
                        {!! Form::select('area_of_activities[]', \App\Camp::pluck('name_en', 'id'), old('area_of_activities',
                        isset($package_progress[0]->area_of_activities) ? json_decode($package_progress[0]->area_of_activities):null), [ 'multiple' =>
                        'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '']) !!}
                    </div>
                    <div class="from-group">
                        <label for="source_of_fund_name_bn">Area of Activity Details</label>
                        <textarea name="area_of_activity_details" id="" class="form-control" cols="30" rows="5">

                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="source_of_fund_name_bn">Contractors</label>
                        {!! Form::select('contactors[]', \App\Contactor::pluck('name_en', 'id'), old('contactors',
                        isset($package_progress[0]->contactors) ? json_decode($package_progress[0]->contactors):null), [ 'multiple' =>
                        'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '']) !!}
                    </div>

                    <div class="form-group">
                        <label for="source_of_fund_name_bn">Key Indicator To Measure Progress</label>
                        
                        {!! Form::select('key_indicators[]', \App\Indicator::where('component_id',$component->id)->pluck('name_en', 'id'), old('key_indicators',
                        isset($package_progress[0]->key_indicators)? json_decode($package_progress[0]->key_indicators):null), [ 'multiple' =>
                        'multiple', 'class' => 'form-control custom-select select2 full-width', 'data-init-plugin'=>'select2', 'id' => '']) !!}
                        
                    </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
              </form>
            
            </div>
        </div>
      </div>
    </div>


@endsection