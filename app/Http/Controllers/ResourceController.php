<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ResourceController extends Controller {
    
    public function getResourceView() {
        
        Log::info('ResourcesController - getResourceView()');
        
        $groupList = \App\Group::all();
        $groupDefault = $groupList->first();
        $resourceList = \App\Resource::where('group_id', $groupDefault->id)->get();
        
        return view('pages/resources', ['groupList' => $groupList, 'resourceList' => $resourceList]);
        
    }
    
}
