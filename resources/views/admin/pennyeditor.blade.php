@extends('../layouts/layout')
@section('content')
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
@if (null!=Session::get('status')))

        <div class="alert alert-success">
            <p>"Database Updated Succesfully!"</p>
        </div>
        @elseif ((null!=Session::get('pennyUpdatefailure')))
        <div class="alert alert-danger">
            <p>Hiba</p>
            <p>{{ $errors }}</p>
        </div>
        @else
    @endif
<div class="table-responsive">
<table class="table table-bordered table-striped text-center">
    <thead>
        <th colspan="2">Műveletek</th>
        <th class="sorting" data-sorting_type="asc" data-column_name="name">name<span id="name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="price" scope="col">price<span id="price_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="unitLong" scope="col">unitlong<span id="unitLong_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="unitPrice" scope="col">unitPrice<span id="unitPrice_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="unitShort" scope="col">unitshort<span id="unitShort_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="priceScore" scope="col">priceScore<span id="priceScore_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="volumeLabelLong" scope="col">volumeLabelong<span id="volumeLabelLong_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="product_ident_id" scope="col">product_ident_id<span id="product_ident_id_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="product_ident_name" scope="col">product_ident name<span id="product_ident_name_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="Category" scope="col">category<span id="Category_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="validityStart" scope="col">validityStart<span id="validityStart_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="validityEnd" scope="col">validityEnd<span id="validityEnd_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="isPublished" scope="col">isPublished<span id="isPublished_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="weight" scope="col">weight<span id="weight_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="productMarketing" scope="col">productMarketing<span id="productMarketing_icon"></span></th>
        <th class="sorting" data-sorting_type="asc" data-column_name="images" scope="col">productImage<span id="images_icon"></span></th>
    </thead>
    <tbody>
      @include("../admin.pennyeditortabledatas")
    </tbody>
</table>
</div>
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc">
<x-login-register-component class="nav-link-active" buttonText="Szerkesztés" id="editModal" title="Termék szerkesztése" body="" url="/admin/updatepennyproduct" method="POST">
    @method('PUT')
    <div class="text-center d-grid gap-2">
    <input type="text" id="modalEditId" name="id" hidden>
    <strong>Terméknév:</strong>
    <input type="text" class="form-control" placeholder="Terméknév" id="modalEditName" name="name" required>
    <strong>Termékár:</strong>
    <input type="number" class="form-control" placeholder="Termékár"id="modalEditPrice" name="price" required>
    <strong>Egység hosszú:</strong>
    <input type="text" class="form-control" placeholder="Egység hosszú"id="modalEditUnitLong" name="unitLong" required>
    <strong>Egységár:</strong>
    <input type="number" class="form-control" placeholder="Egységár" id="modalEditUnitPrice" name="unitPrice" required>
    <strong>Egység rövid:</strong>
    <input type="text" class="form-control" placeholder="Egység rövid" id="modalEditUnitShort" name="unitShort" required>
    <strong>Saját sújtényező:</strong>
    <input type="number" class="form-control" step="any" placeholder="Saját súlytényező"id="modalEditPriceScore" name="priceScore" required>
    <strong>Volume label:</strong>
    <input type="text" class="form-control" placeholder="Volume Label"id="modalEditVolumeLabelLong" name="volumeLabelLong" required>
    <strong>Kategória:</strong>
    <input type="text" class="form-control" placeholder="Kategória" id="modalEditCategory" name="Category" required>
    <strong>Akció kezdete:</strong>
    <input type="date" class="form-control" placeholder="Akció kezdete" id="modalEditValidityStart" name="validityStart" required>
    <strong>Akció vége:</strong>
    <input type="date" class="form-control" placeholder="Akció vége" id="modalEditValidityEnd" name="validityEnd" required>
    <strong>Publicálva?:</strong>
    <input type="text" class="form-control" placeholder="Publikálva?" id="modalEditIsPublished" name="isPublished" required>
    <strong>Súlytényező:</strong>
    <input type="number" class="form-control" step="any" placeholder="Súlytényező"id="modalEditWeight" name="weight" required>
    <strong>ProductMarketing:</strong>
    <input type="text" class="form-control" placeholder="ProductMarketing"id="modalEditProductMarketing" name="productMarketing">
    <strong>Kép link:</strong>
    <input type="text" class="form-control" placeholder="Kép link" id="modalEditImages" name="images">

</div>
</x-login-register-component>
<x-login-register-component class="nav-link-active" buttonText="Törlés" id="deleteModal" title="Termék törlése" body="Biztosan törölni akarja a terméket?" url="/admin/deletepennyproduct" method="POST">
    @method('DELETE')
    <p id="modalDeleteName"></p>
    <input type="text" id="modalDeleteId" name="id" hidden>
</x-login-register-component>
<script>
    $(document).ready(function(){
        function fetch_data(page, sort_type, sort_by,query)
 {
  $.ajax({
   url:"/admin/getpennydatas/fetchdata?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+'&query='+query,
   success:function(products)
   {
    $('tbody').html('');
    $('tbody').html(products);
   }
  })
 }
 $(document).on('keyup','#searchField',function(){
    var query=$('#searchField').val();
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page=$('#hidden_page').val();
    fetch_data(page, sort_type, column_name,query);
 })
        $(document).on('click', '.sorting', function(){
            var column_name = $(this).data('column_name');
            var order_type = $(this).data('sorting_type');
            var reverse_order = '';
            if(order_type == 'asc')
            {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                clear_icon();
                $('#'+column_name+'_icon').html('<span class="fa fa-fw fa-sort-down"></span>');
            }
            if(order_type == 'desc')
            {
                $(this).data('sorting_type', 'asc');
                reverse_order = 'asc';
                clear_icon();
                $('#'+column_name+'_icon').html('<span class="fa fa-fw fa-sort-up"></span>');
            }
            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var query = $('#searchField').val();
            fetch_data(page, reverse_order, column_name,query);
        });
        function clear_icon()
        {
            $('#name_icon').html('');
            $('#price_icon').html('');
            $('#unitLong_icon').html('');
            $('#unitPrice_icon').html('');
            $('#unitShort_icon').html('');
            $('#priceScore_icon').html('');
            $('#volumeLabelLong_icon').html('');
            $('#product_ident_id_icon').html('');
            $('#product_ident_name_icon').html('');
            $('#Category_icon').html('');
            $('#validityStart_icon').html('');
            $('#validityEnd_icon').html('');
            $('#isPublished_icon').html('');
            $('#weight_icon').html('');
            $('#productMarketing_icon').html('');
            $('#images_icon').html('');
        }
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();

            var query = $('#searchField').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, sort_type, column_name,query);
        });
        $(document).on('click','.modalToggler',function(){
        let id=$(this).attr('id');
        let name=$('#'+id+'_name').text();
        let price=$('#'+id+'_price').text();
        let unitLong=$('#'+id+'_unitlong').text();
        let unitPrice=$('#'+id+'_unitprice').text();
        let unitShort=$('#'+id+'_unitshort').text();
        let priceScore=$('#'+id+'_pricescore').text();
        let volumelabel=$('#'+id+'_volumelabellong').text();
        let product_ident_id=$('#'+id+'_product_ident_id').text();
        let category=$('#'+id+'_category').text();
        let validityStart=$('#'+id+'_validitystart').text();
        let validityEnd=$('#'+id+'_validityend').text();
        let isPublished=$('#'+id+'_ispublished').text();
        let weight=$('#'+id+'_weight').text();
        let productMarketing=$('#'+id+'_productMarketing').text();
        let images=$('#'+id+'_images').text();

        $("#modalEditId").val(id);    
        $("#modalEditName").val(name);
        $("#modalEditPrice").val(price);
        $("#modalEditUnitLong").val(unitLong);
        $("#modalEditUnitPrice").val(unitPrice);
        $("#modalEditUnitShort").val(unitShort);
        $("#modalEditPriceScore").val(priceScore);
        $("#modalEditVolumeLabelLong").val(volumelabel);
        $("#modalEditCategory").val(category);
        $("#modalEditValidityStart").val(validityStart);
        $("#modalEditValidityEnd").val(validityEnd);
        $("#modalEditIsPublished").val(isPublished);
        $("#modalEditWeight").val(weight);
        $("#modalProductMarketing").val(productMarketing);
        $("#modalEditImages").val(images);
   
        
    });
    $(document).on('click','.modalDeleteToggler',function(){
            let id=$(this).attr('id');
            let name=$('#'+id+'_name').text();
            $("#modalDeleteName").text(name);
            $("#modalDeleteId").val(id);
            let link=$("#deleteModal_form").attr('action');
            console.log(link);
            $("#deleteModal_form").attr("action",link+'/'+id);
        })
    })




   /*  $(document).ready(function(){
    $('.modalToggler').click(function(){
        console.log('clicked')
        let id=$(this).attr('id');
        let name=$('#'+id+'_name').text();
        let price=$('#'+id+'_price').text();
        let offerBegin=$('#'+id+'_offerBegin').text();
        let offerEnd=$('#'+id+'_offerEnd').text();
        $("#modalEditName").val(name);
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
    }) */
</script>
@endsection