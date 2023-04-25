    <span id="{{ $shoppingCart->id }}_product_id" hidden>{{ $shoppingCart->product_id }}</span>
    <span id="{{ $shoppingCart->id }}_shop" hidden>{{ $shoppingCart->shop }}</span>
    <td><a class="btn btn-success" href="#">Megvásárlás</a></td>
    <td id="{{ $shoppingCart->id }}_name">{{ $shoppingCart->name }}</td>
    <td><span id="{{ $shoppingCart->id }}_amount">{{ $shoppingCart->amount }}</span> <span
            id="{{ $shoppingCart->id }}_quantity">{{ $shoppingCart->quantity }}</span></td>

    <td id="{{ $shoppingCart->id }}_comment" colspan=3>{{ $shoppingCart->comment }}</td>

    <td><a class="btn btn-secondary" id="{{ $shoppingCart->id }}_image" href="{{ $shoppingCart->imageURL }}">Kép</a>
    </td>
