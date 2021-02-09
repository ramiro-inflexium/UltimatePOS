<?php

namespace Modules\Manufacturing\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;

class DataController extends Controller
{
    /**
     * Defines module as a superadmin package.
     * @return Array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'manufacturing_module',
                'label' => __('manufacturing::lang.manufacturing_module'),
                'default' => false
            ]
        ];
    }

    /**
     * Defines user permissions for the module.
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'manufacturing.access_recipe',
                'label' => __('manufacturing::lang.access_recipe'),
                'default' => false
            ],
            [
                'value' => 'manufacturing.add_recipe',
                'label' => __('manufacturing::lang.add_recipe'),
                'default' => false
            ],
            [
                'value' => 'manufacturing.edit_recipe',
                'label' => __('manufacturing::lang.edit_recipe'),
                'default' => false
            ],
            [
                'value' => 'manufacturing.access_production',
                'label' => __('manufacturing::lang.access_production'),
                'default' => false
            ]
        ];
    }

    public function modifyAdminMenu(){
        Menu::modify('admin-sidebar-menu', function ($menu) {

            //Manufacturing dropdown
            if (auth()->user()->can('manufacturing.access_recipe') || auth()->user()->can('manufacturing.access_production') ) {
                $menu->dropdown(
                    __('manufacturing::lang.manufacturing'),
                    function ($sub) {
                        if (auth()->user()->can('manufacturing.access_recipe')) {
                            $sub->url(
                                action('\Modules\Manufacturing\Http\Controllers\RecipeController@index'),
                                __('manufacturing::lang.recipe'),
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'recipe']
                            );
                        }
                        if (auth()->user()->can('manufacturing.access_production')) {
                            $sub->url(
                                action('\Modules\Manufacturing\Http\Controllers\ProductionController@index'),
                                __('manufacturing::lang.production'),
                                ['icon' => 'fa fas fa-arrow-right', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'production' && request()->segment(3) == null]
                            );
                            $sub->url(
                                action('\Modules\Manufacturing\Http\Controllers\ProductionController@create'),
                                __('manufacturing::lang.add_production'),
                                ['icon' => 'fa fas fa-arrow-right', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'production' && request()->segment(3) == 'create']
                            );
                            $sub->url(
                                action('\Modules\Manufacturing\Http\Controllers\SettingsController@index'),
                                __('messages.settings'),
                                ['icon' => 'fa fas fa-arrow-right', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'settings']
                            );
                            $sub->url(
                                action('\Modules\Manufacturing\Http\Controllers\ProductionController@getManufacturingReport'),
                                __('manufacturing::lang.manufacturing_report'),
                                ['icon' => 'fa fas fa-arrow-right', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'report']
                            );
                        }

                    },
                    ['icon' => 'fa fas fa-industry', 'id' => 'tour_step6']
                )->order(22);
            }
        });
    }
}
