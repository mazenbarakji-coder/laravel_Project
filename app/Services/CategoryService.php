<?php

namespace App\Services;

use App\Traits\FileManagerTrait;
use Illuminate\Support\Str;

class CategoryService
{
    use FileManagerTrait;

    public function getAddData(object $request): array
    {
        $storage = config('filesystems.disks.default') ?? 'public';
        $defaultLanguageIndex = array_search('en', $request['lang']) !== false ? array_search('en', $request['lang']) : 0;
        $imageFormat = $this->getSupportedImageFormat();

        return [
            'name' => $request['name'][$defaultLanguageIndex],
            'slug' => Str::slug($request['name'][$defaultLanguageIndex]),
            'icon' => $this->upload('category/', $imageFormat, $request->file('image')),
            'icon_storage_type' => $request->has('image') ? $storage : null,
            'parent_id' => $request->get('parent_id', 0),
            'position' => $request['position'],
            'priority' => $request['priority'],
        ];
    }

    public function getUpdateData(object $request, object $data): array
    {
        $storage = config('filesystems.disks.default') ?? 'public';
        $imageFormat = $this->getSupportedImageFormat();
        $image = $request->file('image') ? $this->update('category/', $data['image'], $imageFormat, $request->file('image')) : $data['icon'];
        $defaultLanguageIndex = array_search('en', $request['lang']) !== false ? array_search('en', $request['lang']) : 0;
        
        return [
            'name' => $request['name'][$defaultLanguageIndex],
            'slug' => Str::slug($request['name'][$defaultLanguageIndex]),
            'icon' => $image,
            'icon_storage_type' => $request->has('image') ? $storage : $data['icon_storage_type'],
            'priority' => $request['priority'],
        ];
    }

    public function getSelectOptionHtml(object $data): string
    {
        $output = '<option value="" disabled selected>' . (translate('select_sub_category')) . '</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->defaultName . '</option>';
        }
        return $output;
    }

    public function deleteImages(object $data): bool
    {
        if ($data->childes) {
            foreach ($data->childes as $child) {
                if ($child->childes) {
                    foreach ($child->childes as $item) {
                        if ($item['icon']) {
                            $this->delete('category/' . $item['icon']);
                        }
                    }
                }
                if ($child['icon']) {
                    $this->delete('category/' . $child['icon']);
                }
            }
        }
        if ($data['icon']) {
            $this->delete('category/' . $data['icon']);
        }
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
