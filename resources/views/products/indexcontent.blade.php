<div id="ajax">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex justify-content-center" style="padding: 0;">
                <div class="card text-center">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">

                                <img src="{{ $product->images }}" class="card-img-top" alt="..."
                                    style="width: 18rem;text-align: center;">
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
                    <div
                        class="card-body text-center"style=" padding-left:0rem;padding-right: 0rem; margin-right:0rem;">
                        <div class=" d-flex justify-content-center align-items-center text-center"
                            style="padding-top: 0.5rem; margin-rigth:1rem;">
                            @if ($product->shop == 'Tesco')
                                <div class="tesco"></div>
                            @else
                                <div class="penny"></div>
                            @endif
                            <p class="card-text" style="max-width: 300px;">
                                <span>{{ mb_strtoupper($product->name) }}</span>
                            </p>
                        </div>
                    </div>
                    @guest
                    @else
                        @include('../products/order')
                    @endguest
                </div>

            </div>
        @endforeach
    </div>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1">
    <x-paginator-component>
        {!! $products->links() !!}
    </x-paginator-component>
