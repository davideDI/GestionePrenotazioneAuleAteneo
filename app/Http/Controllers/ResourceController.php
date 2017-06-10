<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ResourceController extends Controller {
    
    public function getResourceView() {
        
        Log::info('ResourcesController - getResourceView()');
        
        $groupList = \App\Group::all();
        $groupDefault = $groupList->first();
        $resourceList = \App\Resource::where('group_id', $groupDefault->id)->get();
        
        return view('pages/resources/resources', ['selectedGroup' => $groupDefault, 'groupList' => $groupList, 'resourceList' => $resourceList]);
        
    }
    
    public function getResourceFromId($idGroup) {
        
        Log::info('ResourcesController - getResourceFromId(idGroup: '.$idGroup.')');
        
        $group = \App\Group::find($idGroup);
        $groupList = \App\Group::all();
        $resourceList = \App\Resource::where('group_id', $group->id)->get();
        
        return view('pages/resources/resources', ['selectedGroup' => $group, 'groupList' => $groupList, 'resourceList' => $resourceList]);
        
    }
    
    public function getInsertResourceView() {
        
        Log::info('ResourcesController - getInsertResourceView()');
        
        $resource = new \App\Resource;
        $tipResourceList = \App\TipResource::pluck('name', 'id');
        $groupList = \App\Group::pluck('name', 'id');
        return view('pages/resources/insert-resource', ['resource' => $resource, 'groupList' => $groupList, 'tipResourceList' => $tipResourceList]);
        
    }
    
    public function insertResource(Request $request) {
        
        Log::info('ResourcesController - insertResource()');
        
        try {
            
            $resource = new \App\Resource;
            $resource->fill($request->all());
            $resource->save();
            
            return redirect()->route('manage_resources_from_id', [$resource->group_id])->with('success', 100);
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - insertResource() : '.$ex->getMessage());
            return Redirect::back()->withErrors([500]);
        }
        
    }
    
    public function updateResourceView($idResource) {
        
        Log::info('ResourcesController - updateResourceView(idResource: '.$idResource.')');
        
        $resource = \App\Resource::find($idResource);
        $tipResourceList = \App\TipResource::pluck('name', 'id');
        $groupList = \App\Group::pluck('name', 'id');
        return view('pages/resources/update-resource', ['resource' => $resource, 'tipResourceList' => $tipResourceList, 'groupList' => $groupList]);
        
    }
    
    public function updateResource(Request $request) {
        
        Log::info('ResourcesController - updateResource()');
        
        $resource = \App\Resource::find($request->id);
        $resource->fill($request->all());
        $resource->save();
        return redirect()->route('manage_resources_from_id', [$resource->group_id])->with('success', 100);
        
    }
    
    public function getInsertGroupView() {
        
        Log::info('ResourcesController - getInsertGroupView()');
        
        $group = new \App\Group;
        $tipGroupList = \App\TipGroup::pluck('name', 'id');
        return view('pages/group/insert-group', ['group' => $group, 'tipGroupList' => $tipGroupList]);
        
    }
    
    public function insertGroup(Request $request) {
        
        Log::info('ResourcesController - insertGroup()');
        
        try {
            
            $group = new \App\Group; 
            $group->fill($request->all());
            //TODO gestione utenza
            //capire se mostrare lista di matricole o permettere l'inserimento
            //N.B. user_id è chiave della tabella Users
            $group->admin_id=1;
            $group->save();
            
            return redirect()->route('manage_resources')->with('success', 100);
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - insertGroup() : '.$ex->getMessage());
            return Redirect::back()->withErrors([500]);
        }
        
    }
    
}
