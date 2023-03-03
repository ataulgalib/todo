<?php

namespace App\Services\Core;

use Illuminate\Support\Facades\Route;
use App\Services\Interfaces\BreadCrumInfoInterface;

class BreadCrumInfoService implements BreadCrumInfoInterface
{

    private $current_route_name;

    public function __construct()
    {
        $this->current_route_name = Route::currentRouteName();
    }

    public function breadCrumInfoGenerate()
    {

        $core_genarated_menu = core_genarated_menu();

        return $core_genarated_menu->filter(function ($parent_menu_collections) {

            if($parent_menu_collections->get('sidebar_header')) {

                $parent_menu_collections->forget('sidebar_header');
            
            }

            // Parent Menu filter by route name

            if ($parent_menu_collections->get('route_name') == $this->current_route_name) {

                return $parent_menu_collections;
            }

            // Child Menu filter by route name

            if ($parent_menu_collections->has('child_menu') && $parent_menu_collections->get('child_menu')->isNotEmpty()) {

                $child_menu_collections = $parent_menu_collections->get('child_menu');
                $child_menu_collections = $child_menu_collections->filter(function($permission_route_collection_list) {

                    $permission_route_collection = $permission_route_collection_list->get('permission_route')
                    ->filter(function($permission_route_collection) {
                        if ($permission_route_collection->get('route_name') == $this->current_route_name) {
 
                            return $permission_route_collection;
                        }
                    });

                    if($permission_route_collection->isNotEmpty()) {
                        return $permission_route_collection_list;
                    }
                    
                }); 
    

                if($child_menu_collections->isNotEmpty()) {

                    return $parent_menu_collections->put('permission_route', $child_menu_collections
                                        ->first()->get('permission_route'))
                                        ->put('child_menu', $child_menu_collections->first())
                                        ->get('child_menu');
                                        // ->forgetByRelationsLast(['child_menu','permission_route']);
                    
                }
            }
            
        })->map(function($master_filtered_data){
  
            return arrayToCollection(
                    [
                        'parent_menu_display_name' => __($master_filtered_data->get('parent_menu')),
                        'parent_menu_icon_class_name' => $master_filtered_data->get('icon_class'),
                        'parent_menu_route_name' => $master_filtered_data->get('route_name'),

                        'child_menu_display_name' => __($master_filtered_data->get('child_menu')->get('parent_menu')),
                        'child_menu_icon_class_name' => $master_filtered_data->get('child_menu')->get('icon_class'),
                        'child_menu_route_name' => $master_filtered_data->get('child_menu')->get('route_name'),

                        'page_display_name' => $master_filtered_data->get('child_menu')->isNotEmpty() ? __($master_filtered_data->get('permission_route')->where('route_name',$this->current_route_name)->first()->get('display_name')) : '',

                        'page_route_name' => $master_filtered_data->get('child_menu')->isNotEmpty() ? $master_filtered_data->get('permission_route')->where('route_name',$this->current_route_name)->first()->get('route_name') : '',

                        'app_version' => config('configuration.app_version'),
                    ]
                );
                        
        })->first();


    }

}
