@if ($product->inShoppingCart == true)
    <a href="{{ url('/getshoppingcart') }}"class="btn btn-primary"
        id="{{ $product->id . 'shoppingCart' }}"style="display:visible">Bevásárlólistához</a>
@else
    <a class="btn btn-success shoppingCart"
        id="{{ $product->id . 'shoppingCart' }}"style="display:visible">Bevásárlókosárba</a>
@endif
<form action="/addtoshoppingcart" method="POST">
    @csrf
    <div class="d-grid gap-2"style="display:none">
        <input type="text" name="product_id" value="{{ $product->id }}"hidden>
        <input type="text" name="shop" value="{{ $product->shop }}"hidden>
        <input type="number" name="amount" placeholder="Mennyiség" id="{{ $product->id . 'shoppingCartamount' }}"
            required style="display:none">
        <select name="quantity" id="{{ $product->id . 'shoppingCartunit' }}"style="display:none">
            <option value="db">Darab</option>
            <option value="kg">Kilogram</option>
            <option value="l">Liter</option>
        </select>
        <input type="textarea" name="comment" placeholder="Megjegyzés..."
            id="{{ $product->id . 'shoppingCartcomment' }}"style="display:none">
        <button class='btn btn-success' id="{{ $product->id . 'shoppingCartsubmit' }}" type="submit"
            style="display:none">Felír</button>
        <button class='btn btn-danger' id="{{ $product->id . 'shoppingCartback' }}" style="display:none">Vissza</button>
    </div>
</form>
