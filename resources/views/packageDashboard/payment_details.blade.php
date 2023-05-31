
@foreach ($payment as $item)
    

<td class="text-left" >{{isset($item->contactor->name_en)?$item->contactor->name_en:null}}</td>
<td class="text-left" >{{isset($item->source_of_fund->name_en)?$item->source_of_fund->name_en:null}}</td>
<td>{{$item->amount}}</td>
<td>{{$item->date}}</td>

@endforeach