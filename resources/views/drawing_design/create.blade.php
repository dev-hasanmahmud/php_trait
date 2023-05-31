@extends('layouts.master')
@section('content')
    <div class="sub-head header header2">
        <div class="container">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-1">
                    <div class="procurement-title">
                        <h5 class="d-inline">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Drawing & Design
                        </h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/drawing-design-report/create?package_id=') . $package_id }}'><i
                            class="fa fa-plus"> </i> Add Record </a>
                    <a class=" btn sub-btn float-right"
                        href='{{ url('dashboard/drawing-design-report?package_id=') . $package_id }}'><i
                            class="fa fa-dashboard"> </i> Drawing & Design Dashboard</a>
                    <a class=" btn sub-btn float-right" href="{{ route('dd.home') }}"><i class="fa fa-check"> </i>Choose
                        Package</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content form-component mt-4 ">
        <div class="container">
            <div class="card mb-4 card-design">
                <div class="card-body">
                    <div class="card-title bg-primary text-white">
                        <h5>Add New Record</h5>
                    </div>
                    <form method="POST" action="{{ route('dd.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Select Package <span class="mendatory">*</span></label>
                            <div class="col-sm-10">
                                <select name="package" id="package"
                                    class="form-control form-control-sm select2 custom-select2">
                                    <optgroup>
                                        <option value="0">Select Package</option>
                                        @foreach ($component as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == $package_id)
                                                {{ 'selected= "selected" ' }}
                                        @endif>{{ $item->package_no }}--{{ $item->name_en }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Select Category  <span class="mendatory">*</span></label>
                            <div class="col-sm-10">
                                <select name="fm_category_id" id="fm_category_id"
                                    class="form-control form-control-sm select2 custom-select2">
                                    <optgroup>
                                        <option value="0">Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Report Name  <span class="mendatory">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{ old('name') }}" required=""
                                    class="form-control " />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <div class="input-group datepicker-box">
                                    <input name="date" class="form-control datepicker w-100" value="{{ old('date') }}"
                                        type="text" placeholder="YY-MM-DD" />
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Reference</label>
                            <div class="col-sm-10">
                                <textarea name="description" id="" class="form-control" cols="30"
                                    rows="2">{{ old('description') }}</textarea>
                            </div>
                        </div> --}}


                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Upload Image </label>

                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="image_group">
                                <div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                                    <a href="javascript:void(0)" style="position:relative;z-index:2; border:none;"
                                        class="float-right btn btn-outline-danger delete" id="delete_image"> <i
                                            class="fa fa-trash"></i> </a>
                                    <img src="{{ asset('assets/images/image-preview.png') }}" alt="preview image"
                                        class="img-thumbnail rounded " id="image_preview_container_1"
                                        style="position:relative;z-index:1; margin-top:-30px; height:180px; width:100%;">

                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image_1"
                                                onclick="change_image(1)" id="image_1" accept="image/*" />
                                            <label class="my-3 custom-file-label" for="inputGroupFile02"
                                                aria-describedby="inputGroupFileAddon02">Choose
                                                file</label>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <input type="file" name="image_1" accept="image/*" id="image_1" class="my-2"
                                            onclick="change_image(1)">
                                    </div> --}}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                                <a href="javascript:void(0)" class="btn btn-outline-success fa fa-plus" id="add_image"></a>
                            </div>

                        </div>

                        <hr class="mb-3">

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Upload File </label>

                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="file_group">
                                <div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                                    <a href="javascript:void(0)" class="float-right btn btn-outline-danger delete"
                                        id="delete_image"> <i class="fa fa-trash"></i> </a>
                                    <div id="file_preview_container_1">
                                        <p>File Name </p>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file_1"
                                                onclick="change_file(1)" id="file_1" />
                                            <label class="my-3 custom-file-label" for="inputGroupFile02"
                                                aria-describedby="inputGroupFileAddon02">Choose
                                                file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
                                <a href="javascript:void(0)" class="btn btn-outline-success fa fa-plus" id="add_file"></a>
                            </div>



                        </div>

                        <div class="pull-right">
                            <button type="submit" id="submit" class="btn btn-lg btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')

    <script>
        $(document).ready(function() {


            var image_count = 1;

            $('body').on('click', '#add_image', function() {
                $('#test').val(4);
                image_count++;
                console.log(image_count + " ");
                var html = `<div class="pull-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                    <a href="javascript:void(0)" style="position:relative;z-index:2; border:none;" class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                    <img src="{{ asset('assets/images/image-preview.png') }}"
                        alt="preview image" id="image_preview_container_${image_count}" class="img-thumbnail rounded " style="position:relative;z-index:1; margin-top: -30px; height:180px; width:100%;" >
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_${image_count}" onclick="change_image(${image_count})"  id="image_${image_count}" accept="image/*" />
                            <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                            file</label>
                        </div>
                    </div>
                </div>`
                $('#image_group').append(html);
            });

            var file_count = 1;
            $('body').on('click', '#add_file', function() {
                file_count++;
                console.log(file_count + " ");
                var html = `<div class="float-sm-left col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3 pl-0">
                            <a href="javascript:void(0)"  class="float-right btn btn-outline-danger delete"  id="delete_image"> <i class="fa fa-trash"></i> </a>
                            <div id="file_preview_container_${file_count}"><p>File Name</p></div>

                            <div class="input-group mb-3">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" name="file_${file_count}" onclick="change_file(${file_count})"  id="file_${file_count}" />
                                  <label class="my-3 custom-file-label"  for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"  >Choose
                                    file</label>
                                </div>
                            </div>
                        </div>`
                $('#file_group').append(html);

            });

            //   $("#file_group .delete").click(function () {
            //     console.log("delete");
            //     $(this).parent().remove();
            //     //$(this).parent().remove();
            //   });
            $("#file_group").on('click', '.delete', function() {
                console.log("delete");
                $(this).parent().remove();
            });

            $("#image_group").on('click', '.delete', function() {
                console.log("image delete");
                $(this).parent().remove();
            });

        });

        function change_image(image_id) {
            console.log('preview funcrion start' + image_id)
            $('#image_' + image_id).change(function(e) {
                console.log("change " + e.target)
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#image_preview_container_' + image_id).attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        }

        function change_file(file_id) {
            console.log('preview file start' + file_id)
            $('#file_' + file_id).change(function(e) {
                console.log(this.files[0].name)
                html = `<p> ${this.files[0].name}</p>`
                $('#file_preview_container_' + file_id).html(html)
            });
        }

    </script>

@endpush
