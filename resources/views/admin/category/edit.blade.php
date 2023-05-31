@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-user" aria-hidden="true"></i> Edit File Manager Category
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    {{-- <a class="active btn sub-btn float-right"
                        href="{{ route('contactor.create') }}"><i class="fa fa-plus"> </i> Add Contractor </a>
                    --}}

                </div>
            </div>
        </div>
    </div>
    <div class="main-content form-component mt-4 ">
        <div class="container">
            <div class="card mb-4 card-design">
                <div class="card-body">
                    <div class="card-title bg-primary text-white">
                        <h5>Edit File Manager Category </h5>
                    </div>
                    @include('sweetalert::alert')


                    <form action="{{ route('file-manager-category.update', $category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="name_en">Category Name
                                    <span class="mendatory">*</span>
                                </label>
                                <input type="text" name="title" value="{{ $category->title }}" class="form-control"
                                    id="name_en" required />
                            </div>

                            @if ($category->parent)
                                <div class="col-md-12 mb-3" id="parent">
                                    <label for="type">Add Parent Category</label>
                                    <select name="parent_id" id="type"
                                        class="form-control form-control-sm select2 custom-select2" required="">
                                        <option value="0">Select Parent Category</option>
                                        @foreach ($parentcategories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $category->parent_id ? 'selected' : '' }}>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="checkbox" class="form-check-input"
                                            id="is_sub_category">
                                        <label class="form-check-label" for="exampleCheck1">Is Sub category ?</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-none" id="parent">
                                    <label for="type">Add Parent Category</label>
                                    <select name="parent_id" id="type"
                                        class="form-control form-control-sm select2 custom-select2" required="">
                                        <option value="0">Select Parent Category</option>
                                        @foreach ($parentcategories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $category->parent_id ? 'selected' : '' }}>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            @endif






                            <div class="text-right col-md-12 mb-3">
                                <a type="button" class="btn-lg btn btn-warning"
                                    href="{{ route('file-manager-category.index') }}">Cancel</a>
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
        $("#is_sub_category").on("click", function() {

            if ($(this).is(":checked")) {
                $('#parent').removeClass('d-none')
                $(".select2").select2();
            } else {
                $('#parent').addClass('d-none')
            }



        });

    </script>

@endpush
