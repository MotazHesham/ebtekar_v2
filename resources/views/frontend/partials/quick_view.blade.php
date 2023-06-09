
@php
    $image = '';
@endphp
@if(json_decode($product->photos) != null && json_decode($product->photos)[0])
    @php
        $image = json_decode($product->photos)[0] ?? '';
    @endphp
@endif
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="quick-view-img">
            <img src="{{ image_asset($image) }}" alt=""
                class="img-fluid bg-img">
        </div>
    </div>
    <div class="col-lg-6 rtl-text">
        <div class="product-right">
            <div class="pro-group">
                <h2>
                    {{ $product->name }}
                </h2>
                <ul class="pro-price">
                    @if($product->discount > 0)
                        <li>{{front_currency($product->calc_discount($product->unit_price))}}</li>
                        <li><span> {{ front_currency($product->unit_price) }}</span></li>
                        @if($product->discount_type == 'percent')
                            <li>{{$product->discount}}% خصم</li>
                        @else
                            <li>خصم {{front_currency($product->discount)}} </li>
                        @endif
                    @else
                        <li>{{ front_currency($product->unit_price) }}</li>
                    @endif
                </ul>
                <div class="revieu-box">
                    <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star-o"></i></li>
                    </ul>
                    <a href="review.html"><span>(0 تقييمات)</span></a>
                </div>

            </div>
            <div class="pro-group">
                <h6 class="product-title">تفاصيل المنتج</h6>
                <p>
                    <?php echo $product->description; ?>
                </p>
            </div>
            <div class="pro-group pb-0">
                @php
                    $has_unit_attribute = false;
                @endphp

                @if ($product->choice_options != null && count(json_decode($product->choice_options)) > 0)
                    @foreach (json_decode($product->choice_options) as $key => $choice)

                        @php
                            if($choice->attribute == 'unit'){
                                $has_unit_attribute = true;
                            }
                        @endphp
                        <h6 class="product-title size-text"> {{ $choice->attribute }} <span>
                            </span></h6>
                        <div class="size-box" id="{{$key}}-{{$choice->attribute}}">
                            <ul>
                                @foreach ($choice->values as $key2 => $value)
                                    <li data-attribute="{{$key}}-{{$choice->attribute}}"  style="width: fit-content">
                                        <input style="display: none;" type="radio" id="{{ $choice->attribute }}-{{ $value }}" name="attribute_{{ $choice->attribute }}" value="{{ $value }}" >
                                        <label style="width:100%;height:100%;user-select: none;padding: 6px 12px;" for="{{ $choice->attribute }}-{{ $value }}">{{ $value }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif

                @if ($product->colors != null && !empty(json_decode($product->colors)))

                    <h6 class="product-title">اللون</h6>
                    <div class="color-selector inline">
                        <ul>
                            @if (count(json_decode($product->colors)) > 0)
                                @foreach (json_decode($product->colors) as $key => $color)
                                    <li>
                                        <input style="display:none" type="radio" id="{{ $product->id }}-color-{{ $key }}" name="color" >
                                        <label style="background: {{ $color }};" for="{{ $product->id }}-color-{{ $key }}" data-toggle="tooltip" >

                                        </label>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif

                <div class="product-buttons">
                    <a href="{{ route('frontend.product',$product->slug) }}" class="btn btn-normal tooltip-top"
                        data-tippy-content="view detail">
                        عرض التفاصيل
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
