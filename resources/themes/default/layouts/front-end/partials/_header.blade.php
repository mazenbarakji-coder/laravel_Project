@php
    $announcement = getWebConfig('announcement');
@endphp

@if (isset($announcement) && $announcement['status'] == 1)
    <div class="text-center position-relative px-4 py-1" id="announcement"
         style="background-color: {{ $announcement['color'] ?? '#000' }}; color: {{ $announcement['text_color'] ?? '#fff' }}">
        <span>{{ $announcement['announcement'] ?? '' }}</span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif

<header class="rtl __inline-10">
    <div class="topbar">
        <div class="container">
            <div>
                <div class="topbar-text dropdown d-md-none ms-auto">
                    <a class="topbar-link direction-ltr" href="tel:{{ $web_config['phone']->value ?? '' }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone']->value ?? '' }}
                    </a>
                </div>
                <div class="d-none d-md-block mr-2 text-nowrap">
                    <a class="topbar-link d-none d-md-inline-block direction-ltr" href="tel:{{ $web_config['phone']->value ?? '' }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone']->value ?? '' }}
                    </a>
                </div>
            </div>

            <div>
                @php
                    $currency_model = getWebConfig('currency_model');
                @endphp
                @if($currency_model == 'multi_currency')
                    <div class="topbar-text dropdown disable-autohide mr-4">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <span>{{ session('currency_code') ?? 'USD' }} {{ session('currency_symbol') ?? '$' }}</span>
                        </a>
                        <ul class="text-align-direction dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }} min-width-160px">
                            @php
                                $currencies = collect([]);
                                try {
                                    if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                                        $currencies = \App\Models\Currency::where('status', 1)->get();
                                    }
                                } catch (\Exception $e) {
                                    $currencies = collect([]);
                                }
                            @endphp
                            @foreach ($currencies as $currency)
                                <li class="dropdown-item cursor-pointer get-currency-change-function"
                                    data-code="{{ $currency['code'] ?? '' }}">
                                    {{ $currency->name ?? '' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="topbar-text dropdown disable-autohide __language-bar text-capitalize">
                    <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                        @php
                            $languageData = [];
                            try {
                                if (isset($language['value'])) {
                                    $languageData = json_decode($language['value'], true);
                                    if (!is_array($languageData)) {
                                        $languageData = [];
                                    }
                                }
                            } catch (\Exception $e) {
                                $languageData = [];
                            }
                        @endphp
                        @foreach($languageData as $data)
                            @if(isset($data['code']) && $data['code'] == getDefaultLanguage())
                                <img class="mr-2" width="20"
                                     src="{{ theme_asset('public/assets/front-end/img/flags/'.$data['code'].'.png') }}"
                                     alt="{{ $data['name'] ?? '' }}">
                                {{ $data['name'] ?? '' }}
                            @endif
                        @endforeach
                    </a>
                    <ul class="text-align-direction dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">
                        @foreach($languageData as $data)
                            @if(isset($data['status']) && $data['status'] == 1)
                                <li class="change-language" data-action="{{ route('change-language') }}" data-language-code="{{ $data['code'] ?? '' }}">
                                    <a class="dropdown-item pb-1" href="javascript:">
                                        <img class="mr-2"
                                             width="20"
                                             src="{{ theme_asset('public/assets/front-end/img/flags/'.$data['code'].'.png') }}"
                                             alt="{{ $data['name'] ?? '' }}"/>
                                        <span class="text-capitalize">{{ $data['name'] ?? '' }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <div class="navbar-sticky bg-light mobile-head">
        <div class="navbar navbar-expand-md navbar-light">
            <div class="container">
                {{-- Navbar brand, search form, toolbar, cart, etc. --}}
                {{-- ... (keep your existing navbar content here, it's fine) --}}
            </div>
        </div>

        {{-- MEGAMENU --}}
        <div class="megamenu-wrap">
            <div class="container">
                <div class="category-menu-wrap">
                    <ul class="category-menu">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('products', ['id' => $category['id'] ?? 0, 'data_from' => 'category', 'page' => 1]) }}">
                                    {{ $category->name ?? '' }}
                                </a>

                                @if(isset($category->childes) && $category->childes->count() > 0)
                                    <div class="mega_menu z-2">
                                        @foreach($category->childes as $sub_category)
                                            <div class="mega_menu_inner">
                                                <h6>
                                                    <a href="{{ route('products', ['id' => $sub_category['id'] ?? 0, 'data_from' => 'category', 'page' => 1]) }}">
                                                        {{ $sub_category->name ?? '' }}
                                                    </a>
                                                </h6>

                                                @if(isset($sub_category->childes) && $sub_category->childes->count() > 0)
                                                    @foreach($sub_category->childes as $sub_sub_category)
                                                        <div>
                                                            <a href="{{ route('products', ['id' => $sub_sub_category['id'] ?? 0, 'data_from' => 'category', 'page' => 1]) }}">
                                                                {{ $sub_sub_category->name ?? '' }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        <li class="text-center">
                            <a href="{{ route('categories') }}" class="text-primary font-weight-bold justify-content-center">
                                {{ translate('View_All') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

@push('script')
    <script>
        "use strict";
        let arrowDirection = "{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}";
        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item")
            .find("> a")
            .append("<i class='czi-arrow-" + arrowDirection + "'></i>");
    </script>
@endpush
