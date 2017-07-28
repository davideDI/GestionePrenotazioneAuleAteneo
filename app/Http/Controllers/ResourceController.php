<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Group;
use App\Resource;
use App\Booking;
use App\TipGroup;
use App\TipResource;
use App\Repeat;
use Exception;

class ResourceController extends Controller {
    
    public function getResourceView() {
        
        Log::info('ResourcesController - getResourceView()');
        
        $groupList = Group::all();
        $groupDefault = $groupList->first();
        $resourceList = Resource::where('group_id', $groupDefault->id)->get();
        
        return view('pages/resources/resources', ['selectedGroup' => $groupDefault, 'groupList' => $groupList, 'resourceList' => $resourceList]);
        
    }
    
    public function getResourceFromId($idGroup) {
        
        Log::info('ResourcesController - getResourceFromId(idGroup: '.$idGroup.')');
        
        $group = Group::find($idGroup);
        $groupList = Group::all();
        $resourceList = Resource::where('group_id', $group->id)->get();
        
        return view('pages/resources/resources', ['selectedGroup' => $group, 'groupList' => $groupList, 'resourceList' => $resourceList]);
        
    }
    
    public function getInsertResourceView() {
        
        Log::info('ResourcesController - getInsertResourceView()');
        
        $resource = new Resource;
        $tipResourceList = TipResource::pluck('name', 'id');
        $groupList = Group::pluck('name', 'id');
        
        return view('pages/resources/insert-resource', ['resource' => $resource, 'groupList' => $groupList, 'tipResourceList' => $tipResourceList]);
        
    }
    
    public function insertResource(Request $request) {
        
        Log::info('ResourcesController - insertResource()');
        
        try {
            
            $this->validate($request, [
                'name'             => 'required|max:50',
                'description'      => 'required|max:100',
                'capacity'         => 'required|numeric|min:1',
                'room_admin_email' => 'required|email',
                'network'          => 'required|numeric|min:0' 
            ]);
            
            $resource = new Resource;
            $resource->fill($request->all());
            $resource->save();
            
            return redirect()->route('manage_resources_from_id', [$resource->group_id])->with('success', 'insert_resource_ok');
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - insertResource(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_insert_ko');
        }
        
    }
    
    public function updateResourceView($idResource) {
        
        Log::info('ResourcesController - updateResourceView(idResource: '.$idResource.')');
        
        $resource = Resource::find($idResource);
        $tipResourceList = TipResource::pluck('name', 'id');
        $groupList = Group::pluck('name', 'id');
        
        return view('pages/resources/update-resource', ['resource' => $resource, 'tipResourceList' => $tipResourceList, 'groupList' => $groupList]);
        
    }
    
    public function updateResource(Request $request) {
        
        Log::info('ResourcesController - updateResource(idResource: '.$request->id.')');
        
        try {
            
            $this->validate($request, [
                'name'             => 'required|max:50',
                'description'      => 'required|max:100',
                'capacity'         => 'required|numeric|min:1',
                'room_admin_email' => 'required|email',
                'network'          => 'required|numeric|min:0' 
            ]);
            
            $resource = Resource::find($request->id);
            $resource->fill($request->all());
            $resource->save();
            
            return redirect()->route('manage_resources_from_id', [$resource->group_id])->with('success', 'update_resource_ok');
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - updateResource(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_update_ko');
        }
               
    }
    
    public function deleteResource(Request $request) {
        
        Log::info('ResourcesController - deleteResource(idResource: '.$request->idResource.')');
        
        try {
            
            $idResource = $request->idResource;
            $resource = Resource::find($idResource);

            $listOfBookings = Booking::where('resource_id', '=', $idResource)->get();

            foreach($listOfBookings as $booking) {
                $listOfRepeats = Repeat::where('booking_id', '=', $booking->id)->get();
                //elimina repeats
                foreach($listOfRepeats as $repeat) {
                    $repeatTemp = Repeat::find($repeat->id);
                    $repeatTemp->delete();
                }
            
            }
            
            //elimina bookings
            foreach($listOfBookings as $booking) {
                $bookingTemp = Booking::find($booking->id);
                $bookingTemp->delete();
            }

            //elimina resources
            $resource->delete();

            return redirect()->route('manage_resources')->with('success', 'common_delete_ok');
        
        } catch (Exception $ex) {
            Log::error('ResourcesController - deleteResource(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_delete_ko');
        }
        
    }
    
    public function getInsertGroupView() {
        
        Log::info('ResourcesController - getInsertGroupView()');
        
        $group = new Group;
        $tipGroupList = TipGroup::pluck('name', 'id');
        
        return view('pages/group/insert-group', ['group' => $group, 'tipGroupList' => $tipGroupList]);
            
    }
    
    public function updateGroupView($idGroup) {
        
        Log::info('ResourcesController - updateGroupView(idGroup: '.$idGroup.')');
        
        $group = Group::find($idGroup);
        $tipGroupList = TipGroup::pluck('name', 'id');
        
        return view('pages/group/update-group', ['group' => $group, 'tipGroupList' => $tipGroupList]);
        
    }
    
    public function updateGroup(Request $request) {
        
        Log::info('ResourcesController - updateGroup(idGroup: '.$request->id.')');
        
        try {
            
            $this->validate($request, [
                'name'         => 'required|max:50',
                'description'  => 'required|max:100',
                'tip_group_id' => 'required'
            ]);
            
            $group = Group::find($request->id);
            $group->fill($request->all());
            $group->save();
        
            return redirect()->route('manage_resources_from_id', [$group->id])->with('success', 'update_group_ok');
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - updateGroup(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_update_ko');
        }
        
    }
    
    public function insertGroup(Request $request) {
        
        Log::info('ResourcesController - insertGroup()');
        
        try {
            
            $this->validate($request, [
                'name'         => 'required|max:50',
                'description'  => 'required|max:100',
                'tip_group_id' => 'required'
            ]);
            
            $group = new Group; 
            $group->fill($request->all());
            //TODO gestione utenza
            //capire se mostrare lista di matricole o permettere l'inserimento
            //N.B. user_id è chiave della tabella Users
            $group->admin_id=1;
            $group->save();
            
            return redirect()->route('manage_resources_from_id', [$group->id])->with('success', 'insert_group_ok');
            
        } catch (Exception $ex) {
            Log::error('ResourcesController - insertGroup(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_insert_ko');
        }
        
    }
    
    public function deleteGroup(Request $request) {
        
        Log::info('ResourcesController - deleteGroup(idGroup: '.$request->idGroup.')');
        
        try {
            
            $idGroup = $request->idGroup;
            $group = Group::find($idGroup);

            $listOfResource = Resource::where('group_id', '=', $idGroup)->get();
            
            foreach($listOfResource as $resource) {
            
                $listOfBookings = Booking::where('resource_id', '=', $resource->id)->get();

                foreach($listOfBookings as $booking) {
                    $listOfRepeats = Repeat::where('booking_id', '=', $booking->id)->get();
                    //elimina repeats
                    foreach($listOfRepeats as $repeat) {
                        $repeatTemp = Repeat::find($repeat->id);
                        $repeatTemp->delete();
                    }

                }

                //elimina bookings
                foreach($listOfBookings as $booking) {
                    $bookingTemp = Booking::find($booking->id);
                    $bookingTemp->delete();
                }
                
                //elimina resource
                $resourceTemp = Resource::find($resource->id);
                $resourceTemp->delete();
            
            }
            
            //elimina group
            $group->delete();

            return redirect()->route('manage_resources')->with('success', 'common_delete_ok');
        
        } catch (Exception $ex) {
            Log::error('ResourcesController - deleteGroup(): '.$ex->getMessage());
            return redirect()->back()->with('customError', 'common_delete_ko');
        }
        
    }
    
}
