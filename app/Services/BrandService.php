<?php

namespace App\Services;

use App\Traits\FileManagerTrait;

class BrandService
{
    use FileManagerTrait;

    public function getAddData(object $request): array
    {
        $storage = config('filesystems.disks.default') ?? 'public';
        $imageFormat = $this->getSupportedImageFormat();
        $defaultLanguageIndex = array_search('en', $request['lang']) !== false ? array_search('en', $request['lang']) : 0;
        
        return [
            'name' => $request['name'][$defaultLanguageIndex],
            'image' => $this->upload('brand/', $imageFormat, $request->file('image')),
            'image_storage_type' => $request->has('image') ? $storage : null,
            'image_alt_text' => $request['image_alt_text'] ?? null,
            'status' => 1,
        ];
    }

    public function getUpdateData(object $request, object $data): array
    {
        $storage = config('filesystems.disks.default') ?? 'public';
        $imageFormat = $this->getSupportedImageFormat();
        $defaultLanguageIndex = array_search('en', $request['lang']) !== false ? array_search('en', $request['lang']) : 0;
        $image = $request->file('image') ? $this->update('brand/', $data['image'], $imageFormat, $request->file('image')) : $data['image'];
        
        return [
            'name' => $request->name[$defaultLanguageIndex],
            'image' => $image,
            'image_storage_type' => $request->file('image') ? $storage : $data['image_storage_type'],
            'image_alt_text' => $request['image_alt_text']??null,
        ];
    }

    public function deleteImage(object $data): bool
    {
        if ($data['image']) {$this->delete('brand/'.$data['image']);};
        return true;
    }

    /**
     * Get supported image format (webp if supported, otherwise png)
     * @return string
     */
    private function getSupportedImageFormat(): string
    {
        // Check if WebP is supported by PHP GD
        if (function_exists('imagewebp') && function_exists('imagecreatefromwebp')) {
            return 'webp';
        }
        // Fallback to PNG which is universally supported
        return 'png';
    }

}
