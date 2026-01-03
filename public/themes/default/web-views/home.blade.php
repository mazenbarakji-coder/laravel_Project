@extends('layouts.front-end.app')

@section('title', $web_config['name']->value.' '.translate('online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{$web_config['web_logo']['path']}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{url('/')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    {{-- FIXED: Removed named arguments to prevent PHP 8.2 ParseError --}}
    <link rel="stylesheet" href="{{theme_asset('public/assets/front-end/css/home.css')}}"/>
    <link rel="stylesheet" href="{{ theme_asset('public/assets/front-end/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('public/assets/front-end/css/owl.theme.default.min.css') }}">
@endpush

@section('content')
    <div class="__inline-61">
        {{-- FIXED: Converted @php(...) to proper @php block to prevent PHP 8.2 ParseError --}}
        @php
            $decimalPointSettings = !empty(getWebConfig('decimal_point_settings')) ? getWebConfig('decimal_point_settings') : 0;
        @endphp
        
        @include('web-views.partials._home-top-slider',['main_banner'=>$main_banner ?? collect([])])

        @if (isset($flashDeal) && isset($flashDeal['flashDeal']) && isset($flashDeal['flashDealProducts']) && $flashDeal['flashDeal'] && $flashDeal['flashDealProducts'])
            @include('web-views.partials._flash-deal', ['decimal_point_settings'=>$decimalPointSettings])
        @endif

        {{-- FIXED: Added safety check for $featuredProductsList --}}
        @if (isset($featuredProductsList) && $featuredProductsList->count() > 0)
            <div class="container py-4 rtl px-0 px-md-3">
                <div class="__inline-62 pt-3">
                    <div class="feature-product-title mt-0 web-text-primary">
                        {{ translate('featured_products') }}
                    </div>
                    <div class="text-end px-3 d-none d-md-block">
                        <a class="text-capitalize view-all-text web-text-primary" href="{{route('products',['data_from'=>'featured','page'=>1])}}">
                            {{ translate('view_all')}}
                            <i class="czi-arrow-{{Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1' : 'right ml-1'}}"></i>
                        </a>
                    </div>
                    <div class="feature-product">
                        <div class="carousel-wrap p-1">
                            <div class="owl-carousel owl-theme" id="featured_products_list">
                                @foreach($featuredProductsList as $product)
                                    <div>
                                        @include('web-views.partials._feature-product',['product'=>$product, 'decimal_point_settings'=>$decimalPointSettings])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center pt-2 d-md-none">
                            <a class="text-capitalize view-all-text web-text-primary" href="{{route('products',['data_from'=>'featured','page'=>1])}}">
                                {{ translate('view_all')}}
                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1' : 'right ml-1'}}"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('web-views.partials._category-section-home')

        {{-- FIXED: Converted HTML comment to Blade comment to prevent Blade directives from being parsed --}}
        {{-- Featured deals section is commented out
        @if($web_config['featured_deals'] && (count($web_config['featured_deals'])>0))
            <section class="featured_deal">
                <div class="container">
                    <div class="__featured-deal-wrap bg--light">
                        <div class="d-flex flex-wrap justify-content-between gap-8 mb-3">
                            <div class="w-0 flex-grow-1">
                                <span class="featured_deal_title font-bold text-dark">{{ translate('featured_deal')}}</span>
                                <br>
                                <span class="text-left text-nowrap">{{ translate('see_the_latest_deals_and_exciting_new_offers')}}!</span>
                            </div>
                            <div>
                                <a class="text-capitalize view-all-text web-text-primary" href="{{route('products',['data_from'=>'featured_deal'])}}">
                                    {{ translate('view_all')}}
                                    <i class="czi-arrow-{{Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1' : 'right ml-1'}}"></i>
                                </a>
                            </div>
                        </div>
                        <div class="owl-carousel owl-theme new-arrivals-product">
                            @foreach($web_config['featured_deals'] as $key=>$product)
                                @include('web-views.partials._product-card-1',['product'=>$product, 'decimal_point_settings'=>$decimalPointSettings])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        --}}

        @if (isset($main_section_banner) && $main_section_banner)
            <div class="container rtl pt-4 px-0 px-md-3">
                <a href="{{$main_section_banner->url ?? '#'}}" target="_blank"
                    class="cursor-pointer d-block">
                    {{-- FIXED: Removed named arguments to prevent PHP 8.2 ParseError --}}
                    <img class="d-block footer_banner_img __inline-63" alt=""
                         src="{{ getStorageImages($main_section_banner->photo_full_url ?? '', 'wide-banner') }}">
                </a>
            </div>
        @endif

        {{-- FIXED: Converted @php(...) to proper @php block to prevent PHP 8.2 ParseError --}}
        @php
            $businessMode = getWebConfig('business_mode');
        @endphp
        {{-- FIXED: Added safety check for $topVendorsList --}}
        @if ($businessMode == 'multi' && isset($topVendorsList) && count($topVendorsList) > 0)
            @include('web-views.partials._top-sellers')
        @endif

        {{-- FIXED: Converted HTML comment to Blade comment to prevent Blade directives from being parsed --}}
        {{-- Deal of the day and new arrivals section is commented out
        @include('web-views.partials._deal-of-the-day', ['decimal_point_settings'=>$decimalPointSettings])

        <section class="new-arrival-section">

            @if ($newArrivalProducts->count() >0 )
                <div class="container rtl mt-4">
                    <div class="section-header">
                        <div class="arrival-title d-block">
                            <div class="text-capitalize">
                                {{ translate('new_arrivals')}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container rtl mb-3 overflow-hidden">
                    <div class="py-2">
                        <div class="new_arrival_product">
                            <div class="carousel-wrap">
                                <div class="owl-carousel owl-theme new-arrivals-product">
                                    @foreach($newArrivalProducts as $key=> $product)
                                        @include('web-views.partials._product-card-2',['product'=>$product,'decimal_point_settings'=>$decimalPointSettings])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="container rtl px-0 px-md-3">
                <div class="row g-3 mx-max-md-0">

                    @if ($bestSellProduct->count() >0)
                        @include('web-views.partials._best-selling')
                    @endif

                    @if ($topRated->count() >0)
                        @include('web-views.partials._top-rated')
                    @endif
                </div>
            </div>
        </section>
        --}}


        {{-- FIXED: Added safety checks and fixed data access for footer banners --}}
        @if (isset($footer_banner) && $footer_banner->count() > 0)
            @if ($footer_banner->count() > 1)
                <div class="container rtl pt-4">
                    {{-- FIXED: Changed class to match JS initialization in custom.js --}}
                    <div class="promotional-banner-slider owl-carousel owl-theme">
                        @foreach($footer_banner as $banner)
                            <a href="{{ is_object($banner) ? ($banner->url ?? '#') : ($banner['url'] ?? '#') }}" class="d-block" target="_blank">
                                {{-- FIXED: Removed named arguments and fixed mixed array/object access --}}
                                <img class="footer_banner_img __inline-63" alt=""
                                     src="{{ getStorageImages(is_object($banner) ? ($banner->photo_full_url ?? '') : ($banner['photo_full_url'] ?? ''), 'banner') }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="container rtl pt-4">
                    <div class="row">
                        @foreach($footer_banner as $banner)
                            <div class="col-md-6">
                                <a href="{{ is_object($banner) ? ($banner->url ?? '#') : ($banner['url'] ?? '#') }}" class="d-block" target="_blank">
                                    {{-- FIXED: Removed named arguments and fixed mixed array/object access --}}
                                    <img class="footer_banner_img __inline-63" alt=""
                                         src="{{ getStorageImages(is_object($banner) ? ($banner->photo_full_url ?? '') : ($banner['photo_full_url'] ?? ''), 'banner') }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- FIXED: Added safety checks for brands section --}}
        @php
            $brands = $brands ?? collect([]);
            $brand_setting = isset($web_config['brand_setting']) ? $web_config['brand_setting'] : ($brand_setting ?? '0');
        @endphp
        @if($brand_setting && isset($brands) && $brands->count() > 0)
            <section class="container rtl pt-4">

                <div class="section-header">
                    <div class="text-black font-bold __text-22px">
                        <span> {{translate('brands')}}</span>
                    </div>
                    <div class="__mr-2px">
                        <a class="text-capitalize view-all-text web-text-primary" href="{{route('brands')}}">
                            {{ translate('view_all')}}
                            <i class="czi-arrow-{{Session::get('direction') === 'rtl' ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                        </a>
                    </div>
                </div>

                <div class="mt-sm-3 mb-3 brand-slider">
                    <div class="owl-carousel owl-theme p-2 brands-slider">
                        @foreach($brands as $brand)
                            <div class="text-center">
                                {{-- FIXED: Fixed mixed array/object access for brand ID --}}
                                <a href="{{route('products',['id'=> (is_object($brand) ? ($brand->id ?? 0) : ($brand['id'] ?? 0)),'data_from'=>'brand','page'=>1])}}"
                                   class="__brand-item">
                                    {{-- FIXED: Removed named arguments and fixed mixed array/object access --}}
                                    <img alt="{{ is_object($brand) ? ($brand->image_alt_text ?? '') : ($brand['image_alt_text'] ?? '') }}"
                                        src="{{ getStorageImages(is_object($brand) ? ($brand->image_full_url ?? '') : ($brand['image_full_url'] ?? ''), 'brand') }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- FIXED: Added safety check for homeCategories --}}
        @if (isset($homeCategories) && $homeCategories->count() > 0)
            @foreach($homeCategories as $category)
                @include('web-views.partials._category-wise-product', ['decimal_point_settings'=>$decimalPointSettings])
            @endforeach
        @endif

        {{-- FIXED: Converted @php(...) to proper @php block to prevent PHP 8.2 ParseError --}}
        @php
            $companyReliability = getWebConfig('company_reliability');
        @endphp
        @if($companyReliability != null)
            @include('web-views.partials._company-reliability')
        @endif
    </div>

    <span id="direction-from-session" data-value="{{ session()->get('direction') }}"></span>
@endsection

@push('script')
    {{-- FIXED: Removed named arguments to prevent PHP 8.2 ParseError --}}
    <script src="{{theme_asset('public/assets/front-end/js/owl.carousel.min.js')}}"></script>
    <script src="{{ theme_asset('public/assets/front-end/js/home.js') }}"></script>
@endpush
