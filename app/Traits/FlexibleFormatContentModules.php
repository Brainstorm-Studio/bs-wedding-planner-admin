<?php

namespace App\Traits;

use App\Models\Page\Landing;
use App\Models\Page\Page;
use App\Models\Store\ProductType;
use App\Models\Store\ProductSubType;
use App\Models\Store\ProductCategory;
use Illuminate\Support\Facades\Storage;

trait FlexibleFormatContentModules
{
    public function getContent($data)
    {

        $media_path = Storage::disk(config('media-library.flexible_layout_disk'));
        // dd($media_path);
        // $media_path = Storage::disk('spaces');

        foreach ($data as $key => $value) {

            $module_layout = $value['layout'];

            switch ($module_layout) {
                case 'single-text-layout':
                    $content = $value['attributes']['text'];
                    break;
                case 'video':
                    $content = $value['attributes'];
                    break;
                case 'card_slider':
                    $card_slides = $value['attributes']['card_slider'];
                    $slides = [];
                    foreach ($card_slides as $key_slide => $card_slide) {
                        $image = $card_slide['attributes']['image'] ?? '';
                        $items_card_slider = collect([
                            'order' => $key_slide,
                            'title' => $card_slide['attributes']['title'],
                            'text' => $card_slide['attributes']['text'],
                            'image' => $image ? $media_path->url($image) : '',
                        ]);
                        $slides[] = $items_card_slider;
                    }
                    $content_card_slider = array(
                        'title' => $value['attributes']['title'],
                        'slides' => $slides
                    );
                    $content = $content_card_slider;
                    break;
                case 'card':
                    $card_module = $value['attributes'];
                    $image = $card_module['attributes']['image'] ?? '';
                    $content = collect([
                        'text' => $card_module['text'],
                        'image' => $image ? $media_path->url($image) : '',
                        'title' => $card_module['title'],
                        'format' => $card_module['format'],
                        'button_url' => $card_module['button_url'],
                        'button_text' => $card_module['button_text'],
                        'attachment_name' => $card_module['attachment_name'],
                        'show_contact_card' => $card_module['show_contact_card'],
                    ]);
                    break;
                case 'accordion':
                    $accordion = $value['attributes']['accordion'];
                    $accordion_items = [];
                    foreach ($accordion as $key_accordion => $accordion_item) {
                        $image = $accordion_item['attributes']['image'] ?? '';
                        $items_accordion = collect([
                            'order' => $key_accordion,
                            'title' => $accordion_item['attributes']['accordion_title'],
                            'text' => $accordion_item['attributes']['text'],
                            'image' => $image ? $media_path->url($image) : '',
                        ]);
                        $accordion_items[] = $items_accordion;
                    }
                    $content_slide = array(
                        'title' => $value['attributes']['title'],
                        'accordion' => $accordion_items
                    );
                    $content = $content_slide;
                    break;
                case 'tabs':
                    $tab_module = $value['attributes']['tab'];
                    $tab_items = [];
                    foreach ($tab_module as $key_tab => $tab_item) {
                        $image = $tab_item['attributes']['image'] ?? '';
                        $item_tabs = collect([
                            'order' => $key_tab,
                            'title' => $tab_item['attributes']['tab_title'],
                            'text' => $tab_item['attributes']['text'],
                            'image' => $image ? $media_path->url($image) : '',
                        ]);
                        $tab_items[] = $item_tabs;
                    }
                    $content_slide = array(
                        'title' => $value['attributes']['title'],
                        'slides' => $tab_items
                    );
                    $content = $content_slide;
                    break;
                case 'progress-bar':
                    $progress_bar = $value['attributes']['progress'];
                    $progress_items = [];
                    foreach ($progress_bar as $key_progress => $progress_item) {
                        $item_progress = collect([
                            'order' => $key_progress,
                            'title' => $progress_item['attributes']['title'],
                            'percentage' => $progress_item['attributes']['percentage']
                        ]);
                        $progress_items[] = $item_progress;
                    }
                    $content_progress = array(
                        'title' => $value['attributes']['title'],
                        'progress_items' => $progress_items
                    );
                    $content = $content_progress;
                    break;
                case 'feature-box':
                    $feature_box = $value['attributes']['feature_box'];
                    $feature_items = [];
                    foreach ($feature_box as $key_feature => $feature_item) {
                        $item_feature = collect([
                            'order' => $key_feature,
                            'title' => $feature_item['attributes']['text'],
                            'copy' => $feature_item['attributes']['copy'],
                            'icon' => $feature_item['attributes']['icon'] ?? '',
                        ]);
                        $feature_items[] = $item_feature;
                    }
                    $content_feature_box = array(
                        'title' => $value['attributes']['title'],
                        'feature_items' => $feature_items
                    );
                    $content = $content_feature_box;
                    break;
                default:
                    $content = $value['attributes'];
                    break;
            }

            $layouts[] = collect([
                'order' => $key,
                'layout' => $value['layout'],
                'content' => $content,
            ])->sortBy('order');
        }
        return $layouts;
    }

    public function getMenuContent($data)
    {
        foreach ($data as $key_data => $value_menu_content) {

            $layout = $value_menu_content['layout'];

            switch ($layout) {
                case 'custom_menu':
                    $menu[] = collect([
                        'order_key' => $key_data,
                        'menu_first_level' => [
                            'menu_level_one_title' => $value_menu_content['attributes']['title'],
                            'menu_level_one_url' => $value_menu_content['attributes']['url'],
                            'menu_second_level' => $this->getSubMenuFromCustomMenu($value_menu_content['attributes']['sub_menu']),
                        ],
                    ]);
                    break;
                case 'menu_from_categories':
                    $menu_list = $value_menu_content['attributes']['menu_items'];
                    foreach ($menu_list as $key_menu_list => $value_menu_list) {
                        $subcategory_list = $value_menu_list['attributes']['sub_category'];
                        foreach ($subcategory_list as $key_subcategory_list => $value_subcategory_list) {
                            $menu_subcategory[] = collect([
                                'order_key' => $key_subcategory_list,
                                'menu_sub_title_title' => $this->getProductTypeName($value_subcategory_list['attributes']['product_sub_type_id']),
                                'menu_sub_title_url' => $value_menu_list['attributes']['product_category'] . '/' . $value_subcategory_list['attributes']['product_sub_type_id'],
                            ]);
                        }

                        $menu_category[] = collect([
                            'order_key' => $key_menu_list,
                            'menu_first_level' => [
                                'menu_level_one_title' => $this->getProductCategoryName($value_menu_list['attributes']['product_category']),
                                'menu_level_one_url' => '/'.$value_menu_list['attributes']['product_category'],
                                'sub_categories' => $menu_subcategory,
                            ],
                        ]);

                    }
                    $menu = $menu_category;
                    break;
                default:
                    $menu = $data;
                    break;
            };

            $content[] = collect([
                'order' => $key_data,
                'layout' => $layout,
                'content' => $menu,
            ])->sortBy('order');

        }
        return $content;
    }

    public function getSubMenuFromCustomMenu($data)
    {
        foreach ($data as $key_sub_menu => $value_sub_menu) {
            $layouts[] = collect([
                'order_key' => $key_sub_menu,
                'url' => $value_sub_menu['attributes']['url'],
                'title' => $value_sub_menu['attributes']['title'],
                'external-link' => $value_sub_menu['attributes']['external-link'] ?? '',
            ])->sortBy('order');
        }
        return $layouts;
    }

    public function getLandingName($data)
    {
        $category = Landing::where('slug', $data)->first();
        return $category ? $category->name : null;
    }

    public function getPageName($data)
    {
        $subtype = Page::where('slug', $data)->first();
        return $subtype ? $subtype->name : null;
    }
}
