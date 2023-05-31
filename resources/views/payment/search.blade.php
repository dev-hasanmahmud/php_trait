@extends('layouts.master')
@section('content')


    <div class="main-content mt-4 ">
        <div class="container">
            @include('sweetalert::alert')
            <div class="programme-title">
                {{-- <h3 class="d-inline">
                    <img src="{{ custom_asset('assets/images/programme.png') }}" alt="" /> Payment List
                </h3>
                --}}
                {{-- <a href="{{ route('payment.create') }}" type="submit"
                    class="btn btn-success btn-sm d-inline fa fa-plus" title="Add Indicator Data"></a>
                --}}

            </div>

            <section class="package-table card card-body">
                <small class="payment-sm-text ">*All BDT Amount Represent in Lakh</small>
                <form method="get" action="{{ url('payment') }}" role="search">
                    <div class="form-row my-2 mr-2">
                        <div class="col">
                            <input type="text" name="package_no" class="form-control" placeholder="Package Number">
                        </div>
                        <div class="col">
                            <input type="text" name="name_en" class="form-control" placeholder="Package Name">
                        </div>
                        <div class="col input-group datepicker-box">
                            <input name="date" class="form-control datepicker w-100" value="{{ old('date') }}" type="text"
                                placeholder="YY-MM-DD" />
                        </div>
                        {{-- <div class="col">
                            <input type="text" name="economic_head" class="form-control" placeholder="Economoic Head">
                        </div> --}}
                        <button type="submit" class="btn  btn-info fa fa-search" title="Search"> </button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td width="3%" class="text-center">Id</td>
                                <td class="text-left" width="25%">Package Name / Financial-Item</td>
                                <td width="17%" td class="text-left">Contractor Name</td>
                                {{-- <td>Source Of Fund </td> --}}
                                <td width="10%"> Payment Amount in (BDT)*</td>
                                <td width="9%">Date</td>
                                <td width="10%">Cumulative Payment Amount in (BDT)*</td>
                                {{-- <td width="10%">Till to Date</td>
                                --}}
                                <td width="16%">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + $payment->firstItem() }}</td>
                                    @if ($item->is_package)
                                        <td class="text-left">
                                            {{ isset($item->package_name) ? $item->code . ' ' . $item->package_name : null }}
                                        </td>
                                    @else
                                        <td class="text-left">
                                            {{ isset($item->item_name) ? $item->code2 . ' ' . $item->item_name : null }}
                                        </td>
                                    @endif

                                    <td class="text-left">{{ isset($item->contactor_name) ? $item->contactor_name : null }}
                                    </td>
                                    {{-- <td class="text-left">
                                        {{ isset($item->name_en) ? $item->name_en : null }}
                                    </td>
                                    --}}
                                    <td>{{ number_format(convert_to_lakh($item->amount), 2, '.', ',') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format(' d M Y') }}</td>
                                    {{-- <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->details }}</td> --}}
                                    <td>{{ number_format(convert_to_lakh($amountData[$item->package_id]), 2, '.', ',') }}
                                    </td>
                                    {{-- <td class="text-left">
                                        {{ \Carbon\Carbon::parse(now())->format(' d M Y') }}</td>
                                    --}}
                                    <td>
                                        <a class="edit-service-type-modal btn btn-info btn-xs"
                                            href="{{ route('payment.show', $item->id) }}" title="Show"><i
                                                class="fa fa-eye"></i>
                                        </a>
                                        <a class="edit-service-type-modal btn btn-warning btn-xs"
                                            href="{{ route('payment.edit', $item->id) }}" title="Edit"><i
                                                class="fa fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->id }}"
                                            class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-4 text-center">{{ $payment->links() }}</div>
                </div>
            </section>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {

            $('body').on('click', '#delete-user', function() {
                console.log('fuunfsa')
                var payment_id = $(this).data("id");

                swal({
                    title: 'Are you sure?',
                    text: 'This record and it`s details will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        console.log('succes method')
                        $.ajax({
                            type: "DELETE",
                            url: " {{ url('payment') }}" + '/' + payment_id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                console.log(data)
                                swal("Deleted!",
                                    "Your imaginary file has been deleted.",
                                    "success");
                                window.location.assign("/payment")
                            },
                            error: function(data) {
                                console.log('Error:', data);
                                swal("Cancelled", "Something went wrong :)", "error");
                            }
                        });
                    }
                });
            });
        });

    </script>
@endpush


{{-- <form action="{{ route('indicator_data.destroy', $item->id) }}" method="post"
    class="delete">
    @csrf
    @method('DELETE')
    <a class="edit-service-type-modal btn btn-warning btn-xs" href="{{ route('indicator_data.edit', $item->id) }}"
        title="Edit"><i class="fa fa-edit"></i>
    </a>

    <button class="delete-service-type-modal btn btn-danger btn-xs" id="delete" title="Delete"><i
            class="fa fa-trash"></i>
    </button>
</form> --}}
