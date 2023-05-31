@extends('layouts.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ custom_asset('assets/css/colorbox.css') }}" />
    @endpush
    <div class="main-content form-component mt-4">
        <div class="container">
            @include('sweetalert::alert')
            <div class="card mb-4 card-design">
                <div class="card-body">
                    <div class="card-title bg-primary text-white text-center">
                        <h5>Training Activity Information</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="po-show table table-bordered table-striped">
                            <tbody>

                                <tr>
                                    <th>Data Uploded By :</th>
                                    <td>{{ isset($data->upload_by->name) ? $data->upload_by->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Package Name:</th>
                                    <td>{{ isset($data->component->package_no) ? $data->component->package_no . ' ' . $data->component->name_en : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location : </th>
                                    <td> <a target="_blank"
                                            href="{{ 'https://www.google.com/maps?q=' . $data->location }}">{{ $data->location }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Activity :</th>
                                    <td> {{ isset($data->data_input_title->title) ? $data->data_input_title->title : '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Upazila :</th>
                                    <td> {{ isset($data->upazila->name) ? $data->upazila->name : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Area / Union :</th>
                                    <td> {{ isset($data->union->name) ? $data->union->name : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Date: </th>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('D, d M Y') }}</td>
                                </tr>


                                <tr>
                                    <th>Details : </th>
                                    <td>{{ $data->description }}</td>
                                </tr>

                                {{-- <tr>
                                    <th>Data Approved By :</th>
                                    <td>{{ $data->files[0]->approval->name }}</td>
                                </tr> --}}

                                <tr>

                            </tbody>
                        </table>
                        <div class="mt-4 text-center"></div>
                    </div>

                    <div class="mb-4 col-xs-12 col-sm-12 col-md-12">
                        <fieldset class="tra-img-gal scheduler-border">
                            <legend align="center" class="tra-img-gal scheduler-border"><i class="fa fa-picture-o"
                                    aria-hidden="true"></i>
                                Image Gallery</legend>

                            <div class="row pt-2">
                                @foreach ($data->files as $item)

                                    <div class="col-xs-12 col-sm-12 col-md-3 ">
                                        <a class="gl-box group1" href="{{ custom_asset($item->file_path) }}"
                                            title="Title : EMCRP">
                                            <img src="{{ custom_asset($item->file_path) }}" width="100%" height="200"
                                                alt="EMCRP" />
                                            <div class="overlay">
                                                <div class="zoom"><i class="fa fa-expand fa-2x" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <span class="gallery-cap">

                                                <p>Date : {{ $data->date }}</p>
                                            </span>
                                            <a class="btn btn-primary app-img-downlaod" download role="button" target="_blank"
                                                href="{{ url($item->file_path) }}"> 
                                                <i class="fa fa-download"></i> download
                                            </a>
                                        </a>
                                    </div>

                                @endforeach
                            </div>

                        </fieldset>
                    </div>

                    <div class="form-group row">
                        {{-- <label for="inputPassword"
                            class="col-sm-1 col-form-label"></label> --}}
                        <div class="col-sm-12 ml-3">
                            <div class="row_c">
                                <h2>Recommendations |{{ $recommend->count() }}|
                                @if (isset($permission['AppImageController@recommendation']))
                                    <div class="pull-right"><a href="javascript:void(0)" id="addacomment"
                                            class="btn btn-primary">Add a recommendation</a> </div>
                                @endif            
                                </h2>
                            </div>

                            <div class="row_c mt-2" id="addcomment" style="display: none;">
                                <form action="{{ url('app-image/recommendation', $data->id) }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <textarea name="recommendation" class="form-control"
                                        placeholder="Recommendations content..."></textarea><br />

                                    <button class="btn btn-primary">Send</button>
                                </form>
                            </div>

                            <hr class="hr_class">
                            @foreach ($recommend as $item)
                                <div class="row_c comment">
                                    <div class="head">
                                        @php
                                        $date = explode(' ',$item->created_at);
                                        @endphp
                                        <small><strong class='user'> {{ $item->users->name }} </strong> {{ $date[0] }}
                                        </small>
                                    </div>
                                    <p>{{ $item->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- container -->
    </div>

@endsection


@push('script')

    <script src="{{ custom_asset('assets/js/jquery.colorbox.js') }}"></script>

    <script>
        $(document).on('click', '#addacomment', function() {
            $('#addcomment').toggle();
        });
        $(document).ready(function() {
            //Examples of how to assign the Colorbox event to elements
            $(".group1").colorbox({
                rel: "group1",
                width: "90%",
                height: "90%"
            });
            $(".non-retina").colorbox({
                rel: "group5",
                transition: "none"
            });
            $(".retina").colorbox({
                rel: "group5",
                transition: "none",
                retinaImage: true,
                retinaUrl: true
            });
            //Example of preserving a JavaScript event for inline calls.
            $("#click").click(function() {
                $("#click")
                    .css({
                        "background-color": "#f00",
                        color: "#fff",
                        cursor: "inherit"
                    })
                    .text(
                        "Open this window again and this message will still be here."
                    );
                return false;
            });
        });

    </script>

@endpush
