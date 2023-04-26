@extends('frontend.layout.app')

@section('content')
    <!--home slider start-->
    <section class="furniture-slide" style="direction: ltr;">
        <div class="slide-1 no-arrow">


            @foreach ($sliders as $slider)
                <div>
                    <div class="slide-main">
                        <img src="{{ image_asset($slider->photo) }}" class="img-fluid bg-img" alt="ebtekar-slider">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p-0">

                                    <div class="slide-contain">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="animat-block">

                                        @foreach ($sliders as $slider)
                                            <img src="{{ image_asset($slider->photo) }}" class="img-fluid animat1"
                                                alt="ebtekar-slider">
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!--home slider end-->

    <!--title start-->
    <div class="title8 section-big-pt-space">
        <h4>جديد <span>المنتجات</span></h4>
    </div>
    <!--title end-->

    <!-- product tab start -->
    <section class="section-big-pb-space ratio_asos product" style="direction: ltr;">
        <div class="container">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-5 product-m no-arrow">
                        @foreach ($new_products as $product)
                            @php
                                $front_image = '';
                                $back_image = '';
                            @endphp
                            @if (json_decode($product->photos) != null && json_decode($product->photos)[0])
                                @php
                                    $front_image = json_decode($product->photos)[0] ?? '';
                                    $back_image = json_decode($product->photos)[1] ?? $front_image;
                                @endphp
                            @endif
                            <div>
                                <div class="product-box product-box2">
                                    <div class="product-imgbox">
                                        <div class="product-front">
                                            <a href="{{ route('frontend.product', $product->slug) }}">
                                                <img src="{{ image_asset($front_image) }}" class="img-fluid" alt="product">
                                            </a>
                                        </div>
                                        <div class="product-back">
                                            <a href="{{ route('frontend.product', $product->slug) }}">
                                                <img src="{{ image_asset($back_image) }}" class="img-fluid" alt="product">
                                            </a>
                                        </div>
                                        <div class="product-icon icon-inline">
                                            {{-- <button class="tooltip-top add-cartnoty" data-tippy-content="Add to cart">
                                                <i data-feather="shopping-cart"></i>
                                            </button> --}}
                                            <a href="{{ route('frontend.wishlist.add',$product->slug) }}" class="add-to-wish tooltip-top"
                                                data-tippy-content="Add to Wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="quick_view('{{$product->id}}')" data-bs-toggle="modal" data-bs-target="#quick-view"
                                                class="tooltip-top" data-tippy-content="Quick View">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </div>

                                        {{-- <div class="new-label1">
                                            <div>new</div>
                                        </div> --}}
                                        {{-- <div class="on-sale1">
                                            on sale
                                        </div> --}}
                                    </div>
                                    <div class="product-detail product-detail2 ">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <a href="{{ route('frontend.product', $product->slug) }}">
                                            <h3> {{ $product->name }} </h3>
                                        </a>
                                        <h5>
                                            @if ($product->discount > 0)
                                                {{ front_currency($product->calc_discount($product->unit_price)) }}
                                                <span>
                                                    {{ front_currency($product->unit_price) }}
                                                </span>
                                            @else
                                                {{ front_currency($product->unit_price) }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product tab end -->



    <!--rounded category start-->
    <section class="rounded-category" style="direction: ltr;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="slide-6 no-arrow">
                        @foreach ($home_categories as $home_category)
                            @if ($home_category->category)
                                <div>
                                    <div class="category-contain">
                                        <div class="img-wrapper">
                                            <a href="{{ route('frontend.products.category', $home_category->category->id) }}">
                                                <img src="{{ image_asset($home_category->category->banner) }}"
                                                    alt="category  " class="">
                                            </a>
                                        </div>
                                        <a href="{{ route('frontend.products.category', $home_category->category->id) }}" class="btn-rounded">
                                            {{ $home_category->category->name }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--rounded category end-->


    <!--tab product-->
    <section class="section-pb-space">
        <div class="tab-product-main tab-second">
            <div class="tab-prodcut-contain">
                <ul class="tabs tab-title">
                    @foreach ($home_categories as $key => $home_category)
                        @if ($home_category->category)
                            <li @if ($key == 1) class="current" @endif>
                                <a href="tab-{{ $key }}">
                                    <img src="{{ image_asset($home_category->category->banner) }}" alt="category"
                                        class="" heigh="30" width="30">
                                    {{ $home_category->category->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <!--tab product-->

    <!--media banner start-->
    <section class="section-pb-space" style="direction: ltr;">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="theme-tab">
                        <div class="tab-content-cls">
                            @foreach ($home_categories as $key => $home_category)
                                @if ($home_category->category)
                                    <div id="tab-{{ $key }}"
                                        class="tab-content @if ($key == 1) active default @endif">
                                        <div class="media-slide-5 no-arrow">
                                            @foreach ($home_category->category->products()->where('published', 1)->orderBy('created_at', 'desc')->get()->take(15)->chunk(3) as $chunk)
                                                <div>
                                                    <div class="media-banner b-g-white1 border-0">
                                                        @foreach ($chunk as $product)
                                                            @if (json_decode($product->photos) != null && json_decode($product->photos)[0])
                                                                @php
                                                                    $product_image = json_decode($product->photos)[0] ?? '';
                                                                @endphp
                                                            @else
                                                                {{ $product_image = '' }}
                                                            @endif
                                                            <div class="media-banner-box">
                                                                <div class="media">
                                                                    <a
                                                                        href="{{ route('frontend.product', $product->slug) }}">
                                                                        <img src="{{ image_asset($product_image) }}"
                                                                            class="img-fluid  "
                                                                            style="width: 86px;height:110px" alt="banner">
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <div class="media-contant">
                                                                            <div>
                                                                                <div class="product-detail">
                                                                                    <ul class="rating">
                                                                                        <li><i class="fa fa-star"></i></li>
                                                                                        <li><i class="fa fa-star"></i></li>
                                                                                        <li><i class="fa fa-star"></i></li>
                                                                                        <li><i class="fa fa-star"></i></li>
                                                                                        <li><i class="fa fa-star-o"></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <a
                                                                                        href="{{ route('frontend.product', $product->slug) }}">
                                                                                        <p>{{ $product->name }}</p>
                                                                                    </a>
                                                                                    <h6>
                                                                                        {{ front_currency($product->calc_discount($product->unit_price)) }}
                                                                                        @if ($product->discount > 0)
                                                                                            <span>
                                                                                                {{ front_currency($product->unit_price) }}
                                                                                            </span>
                                                                                        @else
                                                                                            {{ front_currency($product->unit_price) }}
                                                                                        @endif
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="cart-info">
                                                                                    <a href="{{ route('frontend.wishlist.add', $product->slug) }}"
                                                                                        class="add-to-wish tooltip-top"
                                                                                        data-tippy-content="Add to Wishlist"><i
                                                                                            data-feather="heart"
                                                                                            class="add-to-wish"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="quick_view('{{$product->id}}')" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top"  data-tippy-content="Quick View"><i  data-feather="eye"></i></a>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--media banner end-->

    <!--collection banner start-->
    <section class="collection-banner layout-3">
        <div class="container">
            <div class="row layout-3-collection">
                @foreach ($banners_1 as $banner)
                    <div class="col-md-6 ">
                        <div class="collection-banner-main banner-12 banner-style3 text-center p-right">
                            <div class="collection-img">
                                <img src="{{ image_asset($banner->photo) }}" class="img-fluid bg-img " alt="banner">
                            </div>
                            <div class="collection-banner-contain  ">
                                <div>
                                    {{-- <h3>وصل حديثا</h3>
                                <h4>اجندة 2023</h4> --}}
                                    <a href="{{ $banner->url }}" class="btn btn-rounded btn-xs">اطلب الان </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--collection banner end-->


    <!--title start-->
    <div class="title8 section-big-pt-space">
        <h4>الاكثر <span>مبيعا</span></h4>
    </div>
    <!--title end-->


    <!-- product section start -->
    <section class="section-big-pb-space ratio_square product" style="direction: ltr;">
        <div class="container">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-5 product-m no-arrow">
                        @foreach ($best_selling_products as $product)
                            @php
                                $front_image = '';
                                $back_image = '';
                            @endphp
                            @if (json_decode($product->photos) != null && json_decode($product->photos)[0])
                                @php
                                    $front_image = json_decode($product->photos)[0] ?? '';
                                    $back_image = json_decode($product->photos)[1] ?? $front_image;
                                @endphp
                            @endif
                            <div>
                                <div class="product-box product-box2">
                                    <div class="product-imgbox">
                                        <div class="product-front">
                                            <a href="{{ route('frontend.product', $product->slug) }}">
                                                <img src="{{ image_asset($front_image) }}" class="img-fluid"
                                                    alt="product">
                                            </a>
                                        </div>
                                        <div class="product-back">
                                            <a href="{{ route('frontend.product', $product->slug) }}">
                                                <img src="{{ image_asset($back_image) }}" class="img-fluid"
                                                    alt="product">
                                            </a>
                                        </div>
                                        <div class="product-icon icon-inline">
                                            {{-- <button class="tooltip-top add-cartnoty" data-tippy-content="Add to cart">
                                                <i data-feather="shopping-cart"></i>
                                            </button> --}}
                                            <a href="{{ route('frontend.wishlist.add',$product->slug) }}" class="add-to-wish tooltip-top"
                                                data-tippy-content="Add to Wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="quick_view('{{$product->id}}')" data-bs-toggle="modal" data-bs-target="#quick-view"
                                                class="tooltip-top" data-tippy-content="Quick View">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-detail product-detail2 ">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <a href="{{ route('frontend.product', $product->slug) }}">
                                            <h3> {{ $product->name }} </h3>
                                        </a>
                                        <h5>
                                            @if ($product->discount > 0)
                                                {{ front_currency($product->calc_discount($product->unit_price)) }}
                                                <span>
                                                    {{ front_currency($product->unit_price) }}
                                                </span>
                                            @else
                                                {{ front_currency($product->unit_price) }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product section end -->
@endsection
