@extends('layouts.master')
@section('content')
 
   
    <div class="main-content mt-4 ">
      @include('sweetalert::alert')
     <div class="container">
    <div class="row justify-content-center">
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-primary text-white text-center"><strong>Change Password</strong></div>

        <div class="card-body">
            <form method="POST" action="{{ route('change.password') }}">
                @csrf 

                    @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                    @endforeach 

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                    <div class="col-md-6">
                        <input id="old_password" type="password" class="form-control" name="old_password" autocomplete="old-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="confirm_password" type="password" class="form-control" name="confirm_password" autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
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




