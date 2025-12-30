<?php

namespace App\Traits;

use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait InHouseTrait
{
    public function __construct(
        private readonly AdminRepositoryInterface             $adminRepo,
    )
    {
    }

    public function getInHouseShopObject(): Shop
    {
        $inhouseVacation = getWebConfig(name: 'vacation_add');
        
        // Handle null or non-array values
        if (!is_array($inhouseVacation) || is_null($inhouseVacation)) {
            $inhouseVacation = [
                'vacation_start_date' => null,
                'vacation_end_date' => null,
                'status' => false,
                'vacation_note' => null,
            ];
        }

        $current_date = date('Y-m-d');
        $start_date = isset($inhouseVacation['vacation_start_date']) ? date('Y-m-d', strtotime($inhouseVacation['vacation_start_date'])) : null;
        $end_date = isset($inhouseVacation['vacation_end_date']) ? date('Y-m-d', strtotime($inhouseVacation['vacation_end_date'])) : null;
        $is_vacation_mode_now = isset($inhouseVacation['status']) && $inhouseVacation['status'] && isset($inhouseVacation['vacation_start_date']) && isset($inhouseVacation['vacation_end_date']) && ($current_date >= $inhouseVacation['vacation_start_date']) && ($current_date <= $inhouseVacation['vacation_end_date']) ? 1 : 0;
        
        $companyName = getWebConfig(name: 'company_name');
        $companyNameValue = is_object($companyName) && isset($companyName->value) ? $companyName->value : (is_string($companyName) ? $companyName : 'Company');
        
        $companyFavIcon = getWebConfig(name: 'company_fav_icon');
        $companyFavIconKey = (is_array($companyFavIcon) && isset($companyFavIcon['key'])) ? $companyFavIcon['key'] : null;
        
        $bottomBanner = getWebConfig(name: 'bottom_banner');
        $bottomBannerKey = (is_array($bottomBanner) && isset($bottomBanner['key'])) ? $bottomBanner['key'] : null;
        
        $offerBanner = getWebConfig(name: 'offer_banner');
        $offerBannerKey = (is_array($offerBanner) && isset($offerBanner['key'])) ? $offerBanner['key'] : null;
        
        $temporaryClose = getWebConfig(name: 'temporary_close');
        $temporaryCloseStatus = (is_array($temporaryClose) && isset($temporaryClose['status'])) ? $temporaryClose['status'] : 0;
        
        $shopBanner = getWebConfig(name: 'shop_banner');
        $shopBannerKey = (is_array($shopBanner) && isset($shopBanner['key'])) ? $shopBanner['key'] : null;
        
        $adminCreatedAt = null;
        try {
            if (Schema::hasTable('admins')) {
                $admin = Admin::where(['id' => 1])->first();
                $adminCreatedAt = $admin ? $admin->created_at : null;
            }
        } catch (\Exception $e) {
            $adminCreatedAt = null;
        }
        
        $inhouseShop = new Shop([
            'seller_id' => 0,
            'name' => $companyNameValue,
            'slug' => Str::slug($companyNameValue),
            'address' => getWebConfig(name: 'shop_address') ?? '',
            'contact' => getWebConfig(name: 'company_phone') ?? '',
            'image' => $companyFavIconKey,
            'bottom_banner' => $bottomBannerKey,
            'offer_banner' => $offerBannerKey,
            'vacation_start_date' => $inhouseVacation['vacation_start_date'] ?? null,
            'vacation_end_date' => $inhouseVacation['vacation_end_date'] ?? null,
            'is_vacation_mode_now' => $is_vacation_mode_now,
            'vacation_note' => $inhouseVacation['vacation_note'] ?? null,
            'vacation_status' => $inhouseVacation['status'] ?? false,
            'temporary_close' => $temporaryCloseStatus,
            'banner' => $shopBannerKey,
            'created_at' => $adminCreatedAt,
        ]);
        $inhouseShop->id = 0;
        return $inhouseShop;
    }

    public function getInHouseSellerObject(): Seller
    {
        $companyName = getWebConfig(name: 'company_name');
        $companyNameValue = is_object($companyName) && isset($companyName->value) ? $companyName->value : (is_string($companyName) ? $companyName : 'Company');
        
        $companyFavIcon = getWebConfig(name: 'company_fav_icon');
        $companyFavIconKey = (is_array($companyFavIcon) && isset($companyFavIcon['key'])) ? $companyFavIcon['key'] : null;
        
        $adminCreatedAt = null;
        try {
            if (Schema::hasTable('admins')) {
                $admin = Admin::where(['id' => 1])->first();
                $adminCreatedAt = $admin ? $admin->created_at : now();
            } else {
                $adminCreatedAt = now();
            }
        } catch (\Exception $e) {
            $adminCreatedAt = now();
        }
        
        $inhouseSeller = new Seller([
            "f_name" => $companyNameValue,
            "l_name" => $companyNameValue,
            "phone" => getWebConfig(name: 'company_phone') ?? '',
            "image" => $companyFavIconKey,
            "email" => getWebConfig(name: 'company_email') ?? '',
            "status" => "approved",
            "pos_status" => 1,
            "minimum_order_amount" => (int)(getWebConfig(name: 'minimum_order_amount') ?? 0),
            "free_delivery_status" => (int)(getWebConfig(name: 'free_delivery_status') ?? 0),
            "free_delivery_over_amount" => getWebConfig(name: 'free_delivery_over_amount') ?? 0,
            "app_language" => getDefaultLanguage(),
            'created_at' => $adminCreatedAt,
            'updated_at' => $adminCreatedAt,
            "bank_name" => "",
            "branch" => "",
            "account_no" => "",
            "holder_name" => "",
        ]);
        $inhouseSeller->id = 0;
        return $inhouseSeller;
    }


}
