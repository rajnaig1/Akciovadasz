@foreach ($products as $product)
    <tr>
        <td><button id="{{ $product->id }}"class="btn btn-primary modalToggler" data-bs-toggle="modal"
                data-bs-target="#editModal">Szerkesztés</button></td>
        <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $product->id }}"
                data-bs-target="#deleteModal">Törlés</button></td>
        <td id="{{ $product->id }}_name"> {{ $product->name }}</td>
        <td id="{{ $product->id }}_price">{{ $product->price }}</td>
        <td id="{{ $product->id }}_unitlong">{{ $product->unitLong }}</td>
        <td id="{{ $product->id }}_unitprice">{{ $product->unitPrice }}</td>
        <td id="{{ $product->id }}_unitshort">{{ $product->unitShort }}</td>
        <td id="{{ $product->id }}_pricescore">{{ $product->priceScore }}</td>
        <td id="{{ $product->id }}_volumelabellong">{{ $product->volumeLabelLong }}</td>
        <td id="{{ $product->id }}_product_ident_id">{{ $product->product_ident_id }}</td>
        <td>{{ $product->productIdent->name }}</td>
        <td id="{{ $product->id }}_category">{{ $product->Category }}</td>
        <td id="{{ $product->id }}_validitystart">{{ $product->validityStart }}</td>
        <td id="{{ $product->id }}_validityend">{{ $product->validityEnd }}</td>
        <td id="{{ $product->id }}_ispublished">{{ $product->isPublished }}</td>
        <td id="{{ $product->id }}_weight">{{ $product->weight }}</td>
        <td id="{{ $product->id }}_productmarketing">{{ $product->productMarketing }}</td>
        <td id="{{ $product->id }}_images">{{ $product->images }}</td>
    </tr>
@endforeach
<tr>
    <td colspan="16" align="center">
        <x-paginator-component>
            {!! $products->links() !!}
        </x-paginator-component>
    </td>
</tr>
