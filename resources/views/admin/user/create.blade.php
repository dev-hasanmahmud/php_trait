@extends('layouts.master')
@section('content')
@push('css')
    <style>
      .hidden{
        display:none;
        }
      </style>
@endpush
<div class="sub-head header header2">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
        <div class="procurement-title">
          <h5 class="d-inline">
            <i class="fa fa-user" aria-hidden="true"></i> Add User
          </h5>                
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <a class="btn sub-btn float-right" href="{{ route('user.index') }}" ><i class="fa fa-users"> </i> All Users </a>
      </div>
    </div>
  </div>
</div>
  
    <div class="main-content form-component mt-4 ">
      <div class="container">
	  		<div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>Add User</h5>
            </div>
      @include('sweetalert::alert')
      @if ($errors->any())
      <div class=”alert alert-danger”>
      <ul>
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $error }}</strong>
      </div>
      @endforeach
      </ul>
      </div>
    @endif
    <form action="{{ route('user.store') }}"  method="post">
        @csrf
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="name_en">Name
              <span class="mendatory">*</span>
            </label>
           <input type="text" class="form-control" id="name" name="name"  required="" autofocus/>
          </div>
          
          <div class="col-md-6 mb-3">
           <label for="email">Email
              <span class="mendatory">*</span>
            </label>
            <input type="email" class="form-control" id="email" name="email" required="" />
          </div>
          <div class="col-md-6 mb-3">
           <label for="designation">Designation
              <span class="mendatory">*</span>
            </label>
             <select name="designation" class="form-control form-control-sm select2 custom-select2"   required="">
               <optgroup>
                @foreach ($designations as $dessignation)
                    <option value="{{ $dessignation->id }}">{{ $dessignation->name_en }}</option>
                @endforeach
              </optgroup>
            </select>
          </div>
          <div class="col-md-6 mb-3">
             <label for="email">Password
              <span class="mendatory">*</span>
            </label>
            <input type="password" class="form-control" id="password" name="password" required=""/>
          </div>
            <div class="col-md-6 mb-3">
            <label for="password_confirmation">Confirm Password
              <span class="mendatory">*</span>
            </label>
            <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation"
            data-match="#password" data-match-error="Whoops, these don't match" required/>
          </div>
           <div class="col-md-6 mb-3">
            <label for="text">Address</label>
            <input type="text" class="form-control" id="address" name="address"/>
          </div>

          <div class="col-md-6 mb-3">
            <label for="text">Role<span class="mendatory">*</span></label>
            <select name="role" class="form-control form-control-sm select2 custom-select2" id="role_id">
              <optgroup>
                @foreach ($role as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </optgroup>
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="email">Status
              <span class="mendatory">*</span>
            </label>
            <select name="status" class="form-control form-control-sm select2 custom-select2"  required="">
              <optgroup>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
             </optgroup>
           </select>
             {{-- {!! Form::select('status' , ['1' => 'Active','0' => 'Inactive' ], old('status'), ['class' => 'form-control custom-select', 'id' => 'status', 'required' => 'required']) !!} --}}
          </div>
          
          <div class=" col-md-6 mb-3" id="team_lead">
            <label for="">Team Name</label>
            
            <select name="teamlead_id" class="form-control form-control-sm select2 custom-select2" >
            <option value="0">Select Team</option>
            @foreach ($teams as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach

             {{-- {!! Form::select('teamlead_id',App\Team::get()->pluck('name', 'id'), old('teamlead_id'),
                 ['class' => 'form-control form-control-sm ']) !!} --}}
          </div>

          <div class="col-md-6 mb-3">
            <label class="checkbox-inline mt-4" for="check">
            <input type="checkbox" name="Checkboxes" id="check"> Is this User is a Consultant or From any Consultant Firm?</label> 
          </div>
          
          <div class="hidden col-md-6 mb-3" id="select_consultant">
            <label for="">Select Consultant </label>
             {!! Form::select('is_consultant',App\Contactor::where(function($query){
                    $query->where('type','Consultant')->orWhere('type','Consulting Firm')->get();
                })->pluck('name_en', 'id'), old('is_consultant'),
                 ['class' => 'form-control form-control-sm custom-select2', 'id' => 'status', 'required' => 'required']) !!}
          </div>




          {{-- <div class="col-md-6 mb-3">
            {{-- <label for="check"></label> --}}
            {{-- <label class="checkbox-inline" for="check"><input type="checkbox" name="Checkboxes" id="check">Is this User is a Consultant?</label> 
          </div>
         
          <div class="hidden">
            <div class="col-md-6 mb-3">
            <select name="is_consultant" id="is_consultant" class="form-control select2 custom-select2">
              <option value="0"> Select Consultant </option>
              @foreach ($contactors as $item)
                <option value="{{ $item->id }}">{{ $item->name_en }}</option>
              @endforeach
            </select>
          </div>
          </div> --}}
        
          
       
          <div class="text-right col-md-12">
            <a type="button" class="btn-lg btn btn-warning" href="{{ route('user.index') }}">Cancel</a>
            <button class="btn-lg btn btn-primary" type="submit">Save</button>
          </div>
		  
        </div>
    </form>
    </div>
  </div>
      </div>
  </div>
@endsection
@push('script')
  <script>
    $('input[name="Checkboxes"]').click(function(){
      if($(this).is(":checked")){ 
        $('#select_consultant').show();
        }
      else{
        $('#select_consultant').hide();
      }    
    });

    // $('#role_id').change(function(){
    //   var id = $('#role_id').val()
    //   //console.log(id)
    //   if(id==14){
    //     $('#team_lead').show();
    //   }
    //   else{
    //     $('#team_lead').hide();
    //   } 
    // });
  </script>
@endpush