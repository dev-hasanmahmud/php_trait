<small class="st-text text-right pr-4 "> <b>* All BDT amount represent in lakh</b></small>
<table class="w-100 table table-bordered table-striped">
    <thead class="t-blue">
        <td width="12%">Package Number</td>
        <td>Package Name</td>
        <td>Estimate Amount (BDT)</td>
        <td width="15%">
            Contract Amount (BDT)
        </td>
        <td width="15%">
            Payment Receive (BDT)
        </td>
        <td>Remarks</td>
    </thead>

    <tbody>
        @foreach ($package as $item)
            <tr>
                <td class="text-left"><a href="" data-toggle="modal" data-id="{{ $item->id }}" class="pop_up">
                        {{ $item->package_no }} </a> </td>
                <td class="text-left"> <a href="" data-toggle="modal" data-id="{{ $item->id }}" class="pop_up">
                        {{ $item->name_en }} </a> </td>

                <td class="text-left pop_up" data-id="{{ $item->id }}">
                    {{ number_format(convert_to_lakh($item->cost_tk_est), 2, '.', ',') }}
                </td>

                <td class="text-left pop_up" data-id="{{ $item->id }}">
                    {{ number_format(convert_to_lakh($item->contract_price_act_bdt), 2, '.', ',') }}
                </td>
                <td class="text-left pop_up" data-id="{{ $item->id }}">
                    {{ number_format(convert_to_lakh($item->payment), 2, '.', ',') }}
                </td>

                <td class="text-left pop_up" data-id="{{ $item->id }}">{{ substr($item->remark, 0, 35) }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
<div class="text-center">
    {!! $package->links() !!}
</div>
