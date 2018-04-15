<?php /** @var \App\Cart $cart */ ?>
@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="clearfix">Kosaram</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped cartTable">
                    <thead>
                    <tr>
                        <th class="imageHolder">&nbsp;</th>
                        <th>Termék</th>
                        <th>Egységár</th>
                        <th>Mennyiség</th>
                        <th>Részösszeg</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->getItems() as $k => $item)
                        <tr data-row-id="{{ $k }}">
                            <td class="imageHolder">
                                <img src="{{ asset($item->product->img_url) }}">
                            </td>
                            <td>
                                <p><strong>{{ $item->product->title }}</strong><br>
                                    Szerző: {{ $item->product->author }}<br>
                                    Kiadó: {{ $item->product->publisher }}</p>
                            </td>
                            <td class="text-center">
                                @if ($item->product->hasPriceDiscount())
                                    <p class="oldPrice">
                                        Régi ár:
                                        <span>{{ $item->product->getOldPrice(true) }}</span> Ft
                                    </p>
                                    <p class="itemPrice">
                                        Új ár:
                                        <span>{{ $item->product->getDiscountPrice(true) }}</span> Ft
                                    </p>
                                @else
                                    <p class="itemPrice">
                                        Ár:
                                        <span>{{ $item->product->getPrice(true) }}</span> Ft
                                    </p>
                                @endif
                            </td>
                            <td>
                                <form class="cartAction" action="{{ route('updateCart') }}">
                                    <input type="hidden" name="pid" value="{{ $item->product->id }}">
                                    <input type="hidden" name="row_id" value="{{ $k }}">
                                    <div class="input-group mx-auto">
                                        <input type="number" class="form-control" name="amount" min="1" value="{{ $item->count }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-sync"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center finalPrice">
                                <strong>{{ $item->product->formatPrice($item->product->getDiscountPrice() * $item->count, true) }}</strong> Ft
                            </td>
                            <td>
                                <form class="cartAction" action="{{ route('deleteCartItem') }}">
                                    <input type="hidden" name="pid" value="{{ $item->product->id }}">
                                    <input type="hidden" name="row_id" value="{{ $k }}">
                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Részösszesen:</td>
                        <td class="text-center finalPrice"><strong class="partPrice">{{ number_format($cart->getPartPrice(), 0, '', ' ') }}</strong> Ft</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">2+1 Akció kedvezmény összesen:</td>
                        <td class="text-center finalPrice"><strong class="discount2plus1">{{ number_format(-1 * $cart->get2plus1Discount(), 0, '', ' ') }}</strong> Ft</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Végösszeg:</td>
                        <td class="text-center finalPrice"><strong class="finalPrice">{{ number_format($cart->getFullPrice(), 0, '', ' ') }}</strong> Ft</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection