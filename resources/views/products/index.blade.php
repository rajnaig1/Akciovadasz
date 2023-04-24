@extends('../layouts/layout')
@section('content')
<div class="row">
@foreach ($products as $product)
  <div class="col-lg-4 col-md-6 d-flex justify-content-center">
    <div class="card">
    <div class="flip-card">
      <div class="flip-card-inner">
        <div class="flip-card-front">

    <img src="{{ $product->images }}" class="card-img-top" alt="..." style="width: 18rem;text-align: center;">
  </div>
  <div class="flip-card-back">
    <h2>{{ $product->name }}</h2> 
    <p>{{ $product->price }} Ft</p>
    <p>{{ $product->unitPrice }} Ft/{{ $product->unit }}</p>
    <p>{{ $product->offerBegins }}-tól {{ $product->offerEnds }}-ig</p>
    <p>{{ $product->comment }}</p> 
  </div>
</div>
</div>
<div class="card-body d-flex justify-content-center align-items-center text-center" style="padding-top: 0.5rem;">    
@if($product->shop=='Tesco')
        <div class="tesco"></div>
        @else
        <div class="penny"></div>
        @endif
      <p class="card-text">
       <span>{{mb_strtoupper($product->name)}}</span></p>
    </div>
    @guest
    @else
    @include('../products/order')   
    @endguest 
  </div>
  
</div>

@endforeach
</div>
<x-paginator-component>
  {!! $products->links() !!}
</x-paginator-component>
<script>
  $(document).ready(function(){
       $('.shoppingCart').click(function(){
         let id=$(this).attr('id');
         $('#'+id+'amount').show();
         $('#'+id+'unit').show();
         $('#'+id+'comment').show();
         $('#'+id+'submit').show();
         $('#'+id+'back').show();
         $(this).hide();
         $('#'+id+'back').click(function(){
             $('#'+id+'amount').hide();
             $('#'+id+'unit').hide();
             $('#'+id+'submit').hide();
             $('#'+id+'comment').hide();
             $(this).hide();
             $('#'+id).show();
         })
       });
 });
 </script> 
@endsection