<table class="report_1 table table-bordered report-table text-center"  >
    <thead>
      <tr>
        <td rowspan="2" >SL Number</td>
        <td rowspan="2"  >Package Number</td>
        <td rowspan="2" >Description Of Procurement Package as per RDPP</td>
        <td rowspan="2"  >Unit</td>
        <td rowspan="2" >Quantity</td>
        <td rowspan="2" > Method and Type</td>
        <td rowspan="2" >Contract Approving Authority</td>
        <td rowspan="2" >Source Of Fund</td>
        <td rowspan="2"  >Estd. Cost (BDT in Lakh) </td>
        <td colspan="4" >Indicative Dates </td>   
      </tr>
      <tr>
          {{-- <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td> --}}
          <td >Invitation For pre-qualification (If applicable)</td>
          <td >Invitation For Tender</td>
          <td>Signing of Contract</td>
          <td>Completion of Contract</td>
      </tr>

    </thead>
    <tbody>
      <tr>
        <td></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
      </tr>
      @foreach ($component as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->package_no }}</td>
        <td>{{ $item->name_en }}</td>
        <td>{{ $item->unit->name_en }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ isset($item->proc_method->name_en)?$item->proc_method->name_en:'-' }}</td>
        <td>{{ isset($item->approving_authority->name_en)?$item->approving_authority->name_en:'-' }}</td>
        <td>{{ $source_name[$item->id] }}</td>
        <td>{{ number_format(convert_to_lakh($item->cost_tk_act),2,'.', ',')  }}</td>
        <td>Not Applicable</td>
        <td>11-Sep-19</td>
        <td>20-Nov-19</td>
        <td>20-Feb-20</td>
      </tr>
      @endforeach
    </tbody>
  </table>