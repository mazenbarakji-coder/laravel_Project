<?php

use App\Models\Currency;

if (!function_exists('loadCurrency')) {
    /**
     * @return void
     */
    function loadCurrency(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                // Table doesn't exist, set default currency values
                if (!session()->has('currency_code')) {
                    session()->put('currency_code', 'USD');
                }
                if (!session()->has('currency_symbol')) {
                    session()->put('currency_symbol', '$');
                }
                if (!session()->has('currency_exchange_rate')) {
                    session()->put('currency_exchange_rate', 1);
                }
                return;
            }

            $defaultCurrency = getWebConfig(name: 'system_default_currency');
            $currentCurrencyInfo = session('system_default_currency_info');
            
            if (!session()->has('system_default_currency_info') || 
                ($defaultCurrency && is_array($currentCurrencyInfo) && $defaultCurrency != ($currentCurrencyInfo['id'] ?? null)) ||
                ($defaultCurrency && is_object($currentCurrencyInfo) && $defaultCurrency != ($currentCurrencyInfo->id ?? null))) {
                
                $id = getWebConfig(name: 'system_default_currency');
                if ($id) {
                    $currency = Currency::find($id);
                    if ($currency) {
                        session()->put('system_default_currency_info', $currency);
                        session()->put('currency_code', $currency->code);
                        session()->put('currency_symbol', $currency->symbol);
                        session()->put('currency_exchange_rate', $currency->exchange_rate);
                    } else {
                        // Currency not found, set defaults
                        if (!session()->has('currency_code')) {
                            session()->put('currency_code', 'USD');
                        }
                        if (!session()->has('currency_symbol')) {
                            session()->put('currency_symbol', '$');
                        }
                        if (!session()->has('currency_exchange_rate')) {
                            session()->put('currency_exchange_rate', 1);
                        }
                    }
                } else {
                    // No default currency configured, set defaults
                    if (!session()->has('currency_code')) {
                        session()->put('currency_code', 'USD');
                    }
                    if (!session()->has('currency_symbol')) {
                        session()->put('currency_symbol', '$');
                    }
                    if (!session()->has('currency_exchange_rate')) {
                        session()->put('currency_exchange_rate', 1);
                    }
                }
            }
        } catch (\Exception $e) {
            // Error loading currency, set defaults
            if (!session()->has('currency_code')) {
                session()->put('currency_code', 'USD');
            }
            if (!session()->has('currency_symbol')) {
                session()->put('currency_symbol', '$');
            }
            if (!session()->has('currency_exchange_rate')) {
                session()->put('currency_exchange_rate', 1);
            }
        }
    }
}

if (!function_exists('currencyConverter')) {
    /** system default currency to usd convert
     * @param float $amount
     * @param string $to
     * @return float|int
     */
    function currencyConverter(float $amount, string $to = USD): float|int
    {
        try {
            $currencyModel = getWebConfig('currency_model');
            if ($currencyModel == MULTI_CURRENCY) {
                $currencyId = getWebConfig('system_default_currency');
                if ($currencyId && \Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                    $currency = Currency::find($currencyId);
                    $default = $currency ? ($currency->exchange_rate ?? 1) : 1;
                } else {
                    $default = 1;
                }
                $exchangeRate = exchangeRate($to);
                $rate = $default / $exchangeRate;
                $value = $amount / floatval($rate);
            } else {
                $value = $amount;
            }
            return $value;
        } catch (\Exception $e) {
            return $amount;
        }
    }
}

if (!function_exists('usdToDefaultCurrency')) {
    /**
     * system usd currency to default convert
     * @param float|int|null $amount
     * @return float|int
     */
    function usdToDefaultCurrency(float|int|null $amount = 0): float|int
    {
        try {
            $currencyModel = getWebConfig('currency_model');
            if ($currencyModel == MULTI_CURRENCY) {
                if (session()->has('default')) {
                    $default = session('default');
                } else {
                    $currencyId = getWebConfig('system_default_currency');
                    if ($currencyId && \Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                        $currency = Currency::find($currencyId);
                        $default = $currency ? ($currency->exchange_rate ?? 1) : 1;
                    } else {
                        $default = 1;
                    }
                    session()->put('default', $default);
                }

                if (session()->has('usd')) {
                    $usd = session('usd');
                } else {
                    $usd = exchangeRate(USD);
                    session()->put('usd', $usd);
                }

                $rate = $default / $usd;
                $value = $amount * floatval($rate);
            } else {
                $value = $amount;
            }

            return round($value, 2);
        } catch (\Exception $e) {
            return round($amount ?? 0, 2);
        }
    }
}

if (!function_exists('webCurrencyConverter')) {
    /**
     * currency convert for web panel
     * @param string|int|float $amount
     * @return float|string
     */
    function webCurrencyConverter(string|int|float $amount): float|string
    {
        try {
            $currencyModel = getWebConfig('currency_model');
            if ($currencyModel == MULTI_CURRENCY) {
                if (session()->has('usd')) {
                    $usd = session('usd');
                } else {
                    if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                        $usdCurrency = Currency::where(['code' => 'USD'])->first();
                        $usd = $usdCurrency ? $usdCurrency->exchange_rate : 1;
                    } else {
                        $usd = 1;
                    }
                    session()->put('usd', $usd);
                }
                $myCurrency = \session('currency_exchange_rate') ?? 1;
                $rate = $myCurrency / $usd;
            } else {
                $rate = 1;
            }

            return setCurrencySymbol(amount: round($amount * $rate, 2), currencyCode: getCurrencyCode(type: 'web'));
        } catch (\Exception $e) {
            // Fallback to default conversion
            return setCurrencySymbol(amount: round($amount, 2), currencyCode: getCurrencyCode(type: 'web'));
        }
    }
}

if (!function_exists('exchangeRate')) {
    /**
     * @param string $currencyCode
     * @return float|int
     */
    function exchangeRate(string $currencyCode = USD): float|int
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                $currency = Currency::where('code', $currencyCode)->first();
                return $currency ? ($currency->exchange_rate ?? 1) : 1;
            }
        } catch (\Exception $e) {
            // Table doesn't exist or query failed
        }
        return 1;
    }
}

if (!function_exists('getCurrencySymbol')) {
    /**
     * @param string $currencyCode
     * @return float|int|string
     */
    function getCurrencySymbol(string $currencyCode = USD): float|int|string
    {
        loadCurrency();
        if (session()->has('currency_symbol')) {
            $currentSymbol = session('currency_symbol');
        } else {
            $systemDefaultCurrencyInfo = session('system_default_currency_info');
            if (is_object($systemDefaultCurrencyInfo) && isset($systemDefaultCurrencyInfo->symbol)) {
                $currentSymbol = $systemDefaultCurrencyInfo->symbol;
            } elseif (is_array($systemDefaultCurrencyInfo) && isset($systemDefaultCurrencyInfo['symbol'])) {
                $currentSymbol = $systemDefaultCurrencyInfo['symbol'];
            } else {
                $currentSymbol = '$'; // Default to USD symbol
            }
        }
        return $currentSymbol ?? '$';
    }
}

if (!function_exists('setCurrencySymbol')) {
    /**
     * @param string|int|float $amount
     * @param string $currencyCode
     * @return string
     */
    function setCurrencySymbol(string|int|float $amount, string $currencyCode = USD): string
    {
        $decimalPointSettings = getWebConfig('decimal_point_settings');
        $position = getWebConfig('currency_symbol_position');
        if ($position === 'left') {
            $string = getCurrencySymbol(currencyCode: $currencyCode) . '' . number_format($amount, (!empty($decimalPointSettings) ? $decimalPointSettings : 0));
        } else {
            $string = number_format($amount, !empty($decimalPointSettings) ? $decimalPointSettings : 0) . '' . getCurrencySymbol(currencyCode: $currencyCode);
        }
        return $string;
    }
}

if (!function_exists('getCurrencyCode')) {
    /**
     * @param string $type default,web
     * @return string
     */
    function getCurrencyCode(string $type = 'default'): string
    {
        $currencyCode = null;
        
        if ($type == 'web') {
            $currencyCode = session('currency_code');
        } else {
            if (session()->has('system_default_currency_info')) {
                $systemDefaultCurrencyInfo = session('system_default_currency_info');
                $currencyCode = is_object($systemDefaultCurrencyInfo) && isset($systemDefaultCurrencyInfo->code) 
                    ? $systemDefaultCurrencyInfo->code 
                    : null;
            } else {
                $currencyId = getWebConfig('system_default_currency');
                if ($currencyId) {
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                            $currency = Currency::where('id', $currencyId)->first();
                            $currencyCode = $currency ? $currency->code : null;
                        }
                    } catch (\Exception $e) {
                        $currencyCode = null;
                    }
                }
            }
        }
        
        // Return default currency code if all lookups fail
        return $currencyCode ?? 'USD';
    }
}

if (!function_exists('getFormatCurrency')) {
    /**
     * @param string|int|float $amount
     * @return string
     */
    function getFormatCurrency(string|int|float $amount): string
    {
        $suffixes = ["1t+" => 1000000000000, "B+" => 1000000000, "M+" => 1000000, "K+" => 1000];
        foreach ($suffixes as $suffix => $factor) {
            if ($amount >= $factor) {
                $div = $amount / $factor;
                $formattedValue = number_format($div, 1) . $suffix;
                break;
            }
        }

        if (!isset($formattedValue)) {
            $formattedValue = number_format($amount, 2);
        }

        return $formattedValue;
    }
}

