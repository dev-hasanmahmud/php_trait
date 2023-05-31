 <table class="table table-bordered table-striped">
    <thead class="t-blue">
        <td width="12%" >Package Number</td>
        <td>Package Name</td>
        <td width="15%"   >
            Contract Amount (BDT in lakh)
            {{-- <p style="color:white;" > Contract Amount</p>
            <p style="color:white;" >(BDT in Lakh)</p> --}}
            {{-- Contract amount
            <p>(BDT in Lakh)</p>  --}}
        </td>
        <td width="15%" >
            Payment Receive (BDT in lakh)
            {{-- <p>Payment receive</p>
            <p>(BDT in Lakh)</p> --}}
        <!-- Amount <span>(Taka in Lac)</span></td> -->
        </td>
    </thead>

    <tbody>
        @foreach ($package as $item)
        <tr>
        {{-- <td>  <a href="{{ url("package_dashboard").'/'.$item->id }}">  {{ $item->package_no }}  </a>  </td>
        <td>  <a href="{{ url("package_dashboard").'/'.$item->id }}">  {{ $item->name_en}}      </a>  </td>  --}}
        
        <td class="text-left" >  {{ $item->package_no }}  </td>
        <td class="text-left" >   {{ $item->name_en}}      </td> 
        
        <td class="text-left" >  {{ number_format(convert_to_lakh($item->cost_tk_est),2,'.', ',')  }} </td>
        <td class="text-left" >  {{ number_format(convert_to_lakh($item->payment),2,'.', ',')  }} </td>
        </tr>
        @endforeach
        
        
    </tbody>
</table>

<div class="text-xs-center">
    <ul id="paginationt1" class="res-pagination">
        {!! $package->links() !!}
     </ul>
</div>
