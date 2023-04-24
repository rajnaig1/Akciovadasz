@extends('../layouts/layout')
@section('content')
<h1 class="text-center">Bevásárlókosár</h1>
<div class="text-center">
<button class="btn btn-success modalToggler" data-bs-toggle="modal" id="" data-bs-target="#customModal">Egyedi termék felvétele</button></td>
</div>
<x-shopping-cart-table-component h2="Penny" id="Penny">
    @foreach($shoppingCarts as $shoppingCart)
            @if($shoppingCart->shop=="Penny"&&$shoppingCart->product_id!=null)
            <tr class="text-center">
                @include('../shoppingcart.shoppingcart_tablecontents')
                <td><button class="btn btn-primary modalToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#editModal">Szerkesztés</button></td>
                <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#deleteModal">Törlés</button></td>
            </tr>
            @elseif ($shoppingCart->shop=="Penny"&&$shoppingCart->product_id==null)
            <tr class="text-center">
                @include('../shoppingcart.shoppingcart_custom_tablecontents')
                <td><button class="btn btn-primary modalToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#editCustomModal">Szerkesztés</button></td>
                <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#deleteModal">Törlés</button></td>
            </tr>
            @endif
        @endforeach
</x-shopping-cart-table-component>
<x-shopping-cart-table-component h2="Tesco" id="Tesco">
    @foreach($shoppingCarts as $shoppingCart)
    @if($shoppingCart->shop=="Tesco"&&$shoppingCart->product_id!=null)
    <tr class="text-center">
        @include('../shoppingcart.shoppingcart_tablecontents')
    <td><button class="btn btn-primary modalToggler" id="{{ $shoppingCart->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Szerkesztés</button></td>
    <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#deleteModal">Törlés</button></td>
    @elseif ($shoppingCart->shop=="Tesco"&&$shoppingCart->product_id==null)
    <tr class="text-center">
        @include('../shoppingcart.shoppingcart_custom_tablecontents')
        <td><button class="btn btn-primary modalToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#editCustomModal">Szerkesztés</button></td>
        <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#deleteModal">Törlés</button></td>
    </tr>
    @endif
@endforeach
</x-shopping-cart-table-component>
<x-shopping-cart-table-component h2="Másik Bolt" id="Egyeb">
    @foreach($shoppingCarts as $shoppingCart)
    @if($shoppingCart->shop=="Egyéb"&&$shoppingCart->product_id==null)
    <tr class="text-center">
        @include('../shoppingcart.shoppingcart_custom_tablecontents')
        <td><button class="btn btn-primary modalToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#editCustomModal">Szerkesztés</button></td>
        <td><button class="btn btn-danger modalDeleteToggler" data-bs-toggle="modal" id="{{ $shoppingCart->id }}" data-bs-target="#deleteModal">Törlés</button></td>
    </tr>
    @endif
@endforeach
</x-shopping-cart-table-component>
<x-login-register-component class="nav-link-active" buttonText="Szerkesztés" id="editModal" title="Termék szerkesztése" body="" url="/updateshoppingcart" method="POST">
            @method('PUT')
            <div class="text-center d-grid gap-2">
            <p id="modalEditName"></p>
            <p id="modalEditPrice"></p>
            <p id="modalEditOfferBegin"></p>
            <p id="modalEditOfferEnd"></p>
            <input type="text" id="modalEditId" name="id" hidden>
            <input type="text" id="modalEditProductId" name="productId" value="" hidden>
            <input type="text" id="modalEditShop" name="shop" value="" hidden>
            <input type="number" id="modalEditAmount" class="form-control" name="amount" placeholder="" value="" required>
            <select name="quantity" id="modalEditQuantity"class="form-control" value="">
                <option value="db">Darab</option>
                <option value="kg">Kilogram</option>
                <option value="l">Liter</option>
            </select>
            <input type="textarea" class="form-control" id="modalEditComment"name="comment" placeholder="Megjegyzés" value="">
        </div>
</x-login-register-component>
<x-login-register-component class="nav-link-active" buttonText="Szerkesztés" id="editCustomModal" title="Termék szerkesztése" body="" url="/updatecustomshoppingcart" method="POST">
    @method('PUT')
    <div class="text-center d-grid gap-2">
    <p id="modalEditCustomName"></p>
    <select name="shop" id="modalEditCustomShop"class="form-control" value="">
        <option value="Penny">Penny</option>
        <option value="Tesco">Tesco</option>
        <option value="Egyéb">Egyéb</option>
    </select>
    <input type="text" id="modalEditCustomId" name="id" hidden>
    <input type="number" id="modalEditCustomAmount" class="form-control" name="amount" placeholder="" value="" required>
    <select name="quantity" id="modalEditCustomQuantity"class="form-control" value="">
        <option value="db">Darab</option>
        <option value="kg">Kilogram</option>
        <option value="l">Liter</option>
    </select>
    <input type="textarea" class="form-control" id="modalEditCustomComment"name="comment" placeholder="Megjegyzés" value="">
</div>
</x-login-register-component>
<x-login-register-component class="nav-link-active" buttonText="Törlés" id="deleteModal" title="Termék törlése" body="Biztosan törölni akarja a terméket?" url="/deleteshoppingcart" method="POST">
    @method('DELETE')
    <p id="modalDeleteName"></p>
    <input type="text" id="modalDeleteId" name="id" hidden>
</x-login-register-component>
<x-login-register-component class="nav-link-active" buttonText="Felvétel" id="customModal" title="Egyéb Termék felvétele" body="" url="/addcustomshoppingcart" method="POST">
    <div class="text-center d-grid gap-2">
    <select name="shop" id="modalEditQuantity"class="form-control">
        <option value="Penny">Penny</option>
        <option value="Tesco">Tesco</option>
        <option value="Egyéb">Egyéb</option>
    </select>
    <input type="number" placeholder="Mennyiség" id="modalEditAmount" class="form-control" name="amount" placeholder="" value="" required>
    <select name="quantity" id="modalEditQuantity"class="form-control" value="">
        <option value="db">Darab</option>
        <option value="kg">Kilogram</option>
        <option value="l">Liter</option>
    </select>
    <input type="textarea" class="form-control" id="modalEditComment"name="comment" placeholder="Megjegyzés" value="">
</div>
</x-login-register-component>
<script>
    $(document).ready(function(){
    $('.modalToggler').click(function(){
        let id=$(this).attr('id');
        let name=$('#'+id+'_name').text();
        let price=$('#'+id+'_price').text();
        let offerBegin=$('#'+id+'_offerBegin').text();
        let offerEnd=$('#'+id+'_offerEnd').text();
        $("#modalEditName").text(name);
        $("#modalEditPrice").text(price+' Ft');
        $("#modalEditOfferBegin").text(offerBegin+'-tól');
        $("#modalEditOfferEnd").text(offerEnd+'-ig');
        $("#modalEditId").val(id);
        let product_id=$('#'+id+'_product_id').text();
        $("#modalEditProductId").val(product_id);
        let shop=$('#'+id+'_shop').text();
        $("#modalEditShop").val(shop);
        let amount=$('#'+id+'_amount').text();
        $("#modalEditAmount").val(amount);
        let quantity=$('#'+id+'_quantity').text();
        $("#modalEditQuantity").val(quantity);
        let comment=$('#'+id+'_comment').text();
        $("#modalEditComment").val(comment);
    })
   
    }) 
    $(document).ready(function(){
    $('.modalToggler').click(function(){
        let id=$(this).attr('id');
        $("#modalEditCustomName").text(name);
        $("#modalEditCustomId").val(id);
        let shop=$('#'+id+'_shop').text();
        $("#modalEditCustomShop").val(shop);
        let amount=$('#'+id+'_amount').text();
        $("#modalEditCustomAmount").val(amount);
        let quantity=$('#'+id+'_quantity').text();
        $("#modalEditCustomQuantity").val(quantity);
        let comment=$('#'+id+'_comment').text();
        $("#modalEditCustomComment").val(comment);
    })
})
    $(document).ready(function(){
        $('.modalDeleteToggler').click(function(){
            let id=$(this).attr('id');
            let name=$('#'+id+'_name').text();
            $("#modalDeleteName").text(name);
            $("#modalDeleteId").val(id);
            let link=$("#deleteModal_form").attr('action');
            console.log(link);
            $("#deleteModal_form").attr("action",link+'/'+id);
        })
    })
    $(document).ready(function(){
        if ($('#TescoTable tr').length > 0) {
            $('#TescoTable').show();
            $('#Tesco_h2').show();
        }
        if ($('#PennyTable tr').length > 0) {
            $('#PennyTable').show();
            $('#Penny_h2').show();
        }
        if ($('#EgyebTable tr').length > 0) {
            $('#EgyebTable').show();
            $('#Egyeb_h2').show();
        }
    })
</script>
@endsection