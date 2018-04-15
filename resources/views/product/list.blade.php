<?php /** @var \App\Models\Product[] $products */ ?>
<?php /** @var string $sort */ ?>
@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="clearfix">Termékek</h1>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Rendezés: {!! __('global.' . $sort) !!}
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownSort">
                    <a class="dropdown-item" href="{{ route('productList', ['sort' => 'nameAsc']) }}">{!! __('global.nameAsc') !!}</a>
                    <a class="dropdown-item" href="{{ route('productList', ['sort' => 'nameDesc']) }}">{!! __('global.nameDesc') !!}</a>
                    <a class="dropdown-item" href="{{ route('productList', ['sort' => 'priceAsc']) }}">{!! __('global.priceAsc') !!}</a>
                    <a class="dropdown-item" href="{{ route('productList', ['sort' => 'priceDesc']) }}">{!! __('global.priceDesc') !!}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($products as $prod)
            <div class="col-12 col-sm-6 productListItem">
                <div class=" border border-secondary rounded clearfix">
                    <img src="{{ asset($prod->img_url) }}" class="rounded float-left"/>
                    <p><strong>{{ $prod->title }}</strong><br>
                        Szerző: {{ $prod->author }}<br>
                        Kiadó: {{ $prod->publisher }}</p>
                    @if ($prod->hasPriceDiscount())
                        <p class="oldPrice">
                            Régi ár:
                            <span>{{ $prod->getOldPrice(true) }}</span> Ft
                        </p>
                        <p class="itemPrice">
                            Új ár:
                            <span>{{ $prod->getDiscountPrice(true) }}</span> Ft
                        </p>
                    @else
                        <p class="itemPrice">
                            Ár:
                            <span>{{ $prod->getPrice(true) }}</span> Ft
                        </p>
                    @endif
                    @if ($prod->hasOtherDiscount())
                        <span class="badge badge-danger">{{ $prod->getOtherDiscount() }}</span>
                    @endif
                    <form class="cartAction" action="{{ route('addToCart') }}">
                        <input type="hidden" name="pid" value="{{ $prod->id }}">
                        <div class="input-group float-right mb-1 mr-1">
                            <input type="number" class="form-control" name="amount" min="1" value="1" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit"><i class="fa fa-cart-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection