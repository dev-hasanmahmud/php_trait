@extends('layouts.master')
@section('content')
 
    <div class="main-content mt-4 mb-4">
    <div class="container">
   @include('sweetalert::alert')
       <div class="main-content">
      <div class="container">
        <div class="card card-design">
          <div class="card-body">
            <div class="card-title bg-primary">
              <h5 class="">Update Permission</h5>
            </div>

            <form  action="{{ url('user-permision',$role_details->id) }}" method="POST"  class="borde rounded bg-white">
                @csrf
                {{method_field("PATCH")}}
              <div class="seperate2">
              <div class="row">
                <div style="border-right: double 3px #bfbfbf;" class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><i class="fa fa-users text-primary mr-2"></i> User Role :</div>
                <div style="padding: 0.5rem 1.5rem !important;" class="col-xs-12 col-sm-6 col-md-9 col-lg-9">{{ $role_details->name }}</div>
              </div>
              </div>
              

                @php
                  $previous_permission="";
              @endphp
             
			 @foreach ($permissions as $permission)
			 
        @if($previous_permission != $permission->description)
        <fieldset class="custom-fieldset border rounded">
        <legend class="custom-legend"> {{$permission->description}} </legend>
        <div class="row">
				@endif
					<div class="po-bor rounded col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div class="m-b-5 popo padding-5 card card-block w-100">
						 <div class="custom-control custom-radio">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  name="permissions[]"
                  value="{{$permission->id}}"
                  id="{{$permission->id}}"
						      @php if(isset($role_permission[$permission->id]) && $role_permission[$permission->id]) { @endphp checked @php } @endphp
                  />
                <label class="custom-control-label" for="{{$permission->id}}">{{$permission->display_name}} </label>

              </div>

                      @php
                        $previous_permission = $permission->description;
                        $check = isset( $permissions[$loop->index +1]->description)?$permissions[$loop->index +1]->description:"-";
                      @endphp
						</div>
          </div>	
          
          @if($previous_permission !=$check || $check=='-')
          </div>
        </fieldset>
          @endif
				
        @endforeach
        
            <div class="text-right">
              <button class="btn btn-primary">Update</button>
            </div>
             </div>
            
            </form>

          </div>
        </div>
      </div>
    </div>

    </div>
  </div>
@endsection

@push('script')


@endpush