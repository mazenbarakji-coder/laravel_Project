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
        
        // Default values if vacation config is null
        $vacationStartDate = null;
        $vacationEndDate = null;
        $vacationStatus = false;
        $vacationNote = null;
        $is_vacation_mode_now = 0;
        
        if ($inhouseVacation && is_array($inhouseVacation)) {
            $current_date = date('Y-m-d');
            $vacationStartDate = $inhouseVacation['vacation_start_date'] ?? null;
            $vacationEndDate = $inhouseVacation['vacation_end_date'] ?? null;
            $vacationStatus = $inhouseVacation['status'] ?? false;
            $vacationNote = $inhouseVacation['vacation_note'] ?? null;
            
            if ($vacationStartDate && $vacationEndDate) {
                $start_date = date('Y-m-d', strtotime($vacationStartDate));
                $end_date = date('Y-m-d', strtotime($vacationEndDate));
                $is_vacation_mode_now = $vacationStatus && ($current_date >= $start_date) && ($current_date <= $end_date) ? 1 : 0;
            }
        }
        
        $companyName = getWebConfig(name: 'company_name') ?? 'Company';
        $companyFavIcon = getWebConfig(name: 'company_fav_icon');
        $bottomBanner = getWebConfig(name: 'bottom_banner');
        $offerBanner = getWebConfig(name: 'offer_banner');
        $shopBanner = getWebConfig(name: 'shop_banner');
        $temporaryClose = getWebConfig(name: 'temporary_close');
        
        $admin = null;
        try {
            if (Schema::hasTable('admins')) {
                $admin = Admin::where(['id' => 1])->first();
            }
        } catch (\Exception $e) {
            // Table doesn't exist, continue with null
        }
        
        $inhouseShop = new Shop([
            'seller_id' => 0,
            'name' => $companyName,
            'slug' => Str::slug($companyName),
            'address' => getWebConfig(name: 'shop_address') ?? '',
            'contact' => getWebConfig(name: 'company_phone') ?? '',
            'image' => (is_array($companyFavIcon) && isset($companyFavIcon['key'])) ? $companyFavIcon['key'] : null,
            'bottom_banner' => (is_array($bottomBanner) && isset($bottomBanner['key'])) ? $bottomBanner['key'] : null,
            'offer_banner' => (is_array($offerBanner) && isset($offerBanner['key'])) ? $offerBanner['key'] : null,
            'vacation_start_date' => $vacationStartDate,
            'vacation_end_date' => $vacationEndDate,
            'is_vacation_mode_now' => $is_vacation_mode_now,
            'vacation_note' => $vacationNote,
            'vacation_status' => $vacationStatus,
            'temporary_close' => (is_array($temporaryClose) && isset($temporaryClose['status'])) ? $temporaryClose['status'] : 0,
            'banner' => (is_array($shopBanner) && isset($shopBanner['key'])) ? $shopBanner['key'] : null,
            'created_at' => $admin && $admin->created_at ? $admin->created_at : null,
        ]);
        $inhouseShop->id = 0;
        return $inhouseShop;
    }

    public function getInHouseSellerObject(): Seller
    {
        $companyName = getWebConfig(name: 'company_name') ?? 'Company';
        $companyPhone = getWebConfig(name: 'company_phone') ?? '';
        $companyEmail = getWebConfig(name: 'company_email') ?? '';
        $companyFavIcon = getWebConfig(name: 'company_fav_icon');
        $minimumOrderAmount = getWebConfig(name: 'minimum_order_amount');
        $freeDeliveryStatus = getWebConfig(name: 'free_delivery_status');
        $freeDeliveryOverAmount = getWebConfig(name: 'free_delivery_over_amount');
        
        $admin = null;
        try {
            if (Schema::hasTable('admins')) {
                $admin = Admin::where(['id' => 1])->first();
            }
        } catch (\Exception $e) {
            // Table doesn't exist, continue with null
        }
        
        $inhouseSeller = new Seller([
            "f_name" => $companyName,
            "l_name" => $companyName,
            "phone" => $companyPhone,
            "image" => (is_array($companyFavIcon) && isset($companyFavIcon['key'])) ? $companyFavIcon['key'] : null,
            "email" => $companyEmail,
            "status" => "approved",
            "pos_status" => 1,
            "minimum_order_amount" => $minimumOrderAmount ? (int)$minimumOrderAmount : 0,
            "free_delivery_status" => $freeDeliveryStatus ? (int)$freeDeliveryStatus : 0,
            "free_delivery_over_amount" => $freeDeliveryOverAmount ?? 0,
            "app_language" => getDefaultLanguage(),
            'created_at' => $admin && $admin->created_at ? $admin->created_at : now(),
            'updated_at' => $admin && $admin->created_at ? $admin->created_at : now(),
            "bank_name" => "",
            "branch" => "",
            "account_no" => "",
            "holder_name" => "",
        ]);
        $inhouseSeller->id = 0;
        return $inhouseSeller;
    }


}
