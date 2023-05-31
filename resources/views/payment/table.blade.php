<div class="table-responsive text-center" id="report_table">
    <table class="table table-bordered bg-white report-table">
        <thead>
            <tr>
                <td width="25%" class="text-center">Package Name</td>
                <td width="10%" class="text-center">Contract Price Amount (BDT)*</td>
                <td width="9%" class="text-center">Cumulative Payment Amount (BDT)*</td>
                <td width="18%" class="text-center">Contractor Name</td>
                <td width="9%" class="text-center">Payment Amount (BDT)*</td>
                <td width="9%" class="text-center">Payment Date</td>
                <td width="20%" class="text-center">Status</td>
            </tr>
        </thead>
        <tbody>
            @php
            $previous = '';
            $l=0;
            @endphp

            @forelse ($payment as $item)
                <tr>
                    @if ($previous == $item->package_no)
                    @else
                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">
                            {{ $item->package_no . '-' . $item->name_en }}
                        </td>

                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">
                            {{ number_format(convert_to_lakh($item->contract_price_act_bdt), 2, '.', ',') }}
                        </td>

                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">
                            {{ number_format(convert_to_lakh($item->total_pay_amout), 2, '.', ',') }}
                        </td>
                        <td class="text-left" rowspan="{{ $count[$loop->index + 1] }}">{{ $item->contract_name }} </td>
                        @php
                        $l++;
                        @endphp
                    @endif
                    @php
                    $previous = $item->package_no;
                    @endphp

                    <td class="text-left">{{ number_format(convert_to_lakh($item->amount), 2, '.', ',') }}

                    <td class="text-left">
                        {{ \Carbon\Carbon::parse($item->date)->format(' d M Y') }}
                    </td>
                    <td>
                        <a class="edit-service-type-modal btn btn-info btn-xs"
                            href="{{ route('payment.show', $item->payment_id) }}" title="Show"><i class="fa fa-eye"></i>
                        </a>
                        <a class="edit-service-type-modal btn btn-warning btn-xs"
                            href="{{ route('payment.edit', $item->payment_id) }}" title="Edit"><i class="fa fa-edit"></i>
                        </a>

                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $item->payment_id }}"
                            class="edit-service-type-modal btn btn-danger btn-xs" title="Delete"><i
                                class="fa fa-trash"></i></a>

                    </td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
    <div class="mt-4 text-center">
        {{ $payment->links() }}
    </div>
</div>
