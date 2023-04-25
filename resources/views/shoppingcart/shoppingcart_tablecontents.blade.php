<span id="{{ $shoppingCart->id }}_product_id" hidden>{{ $shoppingCart->product_id }}</span>
<span id="{{ $shoppingCart->id }}_shop" hidden>{{ $shoppingCart->shop }}</span>
<td><a class="btn btn-success" href="#">Megvásárlás</a></td>
<td id="{{ $shoppingCart->id }}_name">{{ $shoppingCart->name }}</td>
<td><span id="{{ $shoppingCart->id }}_amount">{{ $shoppingCart->amount }}</span> <span
        id="{{ $shoppingCart->id }}_quantity">{{ $shoppingCart->quantity }}</span></td>
<td><span id="{{ $shoppingCart->id }}_price">{{ $shoppingCart->price }}</span> Ft</td>
<td id="{{ $shoppingCart->id }}_comment">{{ $shoppingCart->comment }}</td>
<td><span id="{{ $shoppingCart->id }}_offerBegin">{{ $shoppingCart->offerBegin }}</span>-tól <span
        id="{{ $shoppingCart->id }}_offerEnd">{{ $shoppingCart->offerEnd }}</span>-ig</td>
<td><a class="btn btn-secondary" id="{{ $shoppingCart->id }}_image" href="{{ $shoppingCart->imageURL }}">Kép</a></td>
