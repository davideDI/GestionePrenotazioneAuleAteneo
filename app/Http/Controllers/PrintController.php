<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Http\Request;
use App\Group;
use App\Resource;

include 'Variables.php';

class PrintController extends Controller {
    
    public function getPrintView() {
        
        Log::info('PrintController - getPrintView()');
        
        $groupsList = Group::all();
        $resourceList =  Resource::all();

        return view('pages/print/print', [  'groupsList' => $groupsList, 
                                            'resourceList' => $resourceList]);
    
    }
    
    //TODO da concordare contenuti delle stampe
    public function downloadPDF(Request $request) {

        Log::info('PrintController - downloadPDF()');

        $idResource = $request['resource_id'];
        
        $dateSearchFromString = $request['date_search_from'];
        $dateSearchFrom = "";
        if($dateSearchFromString != '') {
            $dateSearchFrom = date("Y-m-d",strtotime($dateSearchFromString));
        } else {
            $dateSearchFrom = "1900-01-01";
        }
        
        $dateSearchToString = $request['date_search_to'];
        $dateSearchTo = "";
        if($dateSearchToString != '') {
            $dateSearchTo = date("Y-m-d",strtotime($dateSearchToString));
        } else {
            $dateSearchTo = "9999-01-01";
        }
        
        //TODO modifica query per utilizzare eloquent (le query annidate si riscrivono)
//        $bookingList = \App\Booking::with(['repeats' => function($query) use($dateSearchFrom, $idResource, $dateSearchTo) {
//                                                Log::info($dateSearchFrom.'-'.$dateSearchTo);
//                                                $query->where('event_date_start', '>=', $dateSearchFrom)
//                                                      ->where('event_date_end', '<=', $dateSearchTo)
//                                                        ->where('resource_id', $idResource);
//                                            }])
//                                    
//                                    ->get();
        
        $listOfParameters = array($idResource, TIP_BOOKING_STATUS_OK, $dateSearchFrom, $dateSearchTo);
        $bookingList = DB::select
                        ( DB::raw
                            ("  select bookings.name, bookings.description,  
                                resources.name as resource_name,
                                repeats.event_date_start, repeats.event_date_end
                                from bookings 
                                left join repeats 
                                on bookings.id = repeats.booking_id 
                                left join resources
                                on bookings.resource_id = resources.id 
                                where resource_id = ? 
                                and tip_booking_status_id = ?
                                and repeats.event_date_start >= ? 
                                and repeats.event_date_end <= ?
                            ")
                            , 
                            $listOfParameters
                        );
 
        $content  = "<table>";
        $content .= "<thead>";
        $content .= "<tr>";
        $content .= "<th>Title</th>";
        $content .= "<th>Description</th>";
        $content .= "<th>Date from</th>";
        $content .= "<th>Date end</th>";
        $content .= "<th>Resource</th>";
        $content .= "</tr>";
        $content .= "</thead>";
        $content .= "<tbody>";
        //TODO compleatare tabella con informazioni
        if(count($bookingList) > 0) {
            for($i = 0; $i < count($bookingList); $i++) {
                $content .=  "<tr>";
                $content .=  "<td>".$bookingList[$i]->name."</td>";
                $content .=  "<td>".$bookingList[$i]->description."</td>";
                $content .=  "<td>".$bookingList[$i]->event_date_start."</td>";
                $content .=  "<td>".$bookingList[$i]->event_date_end."</td>";
                $content .=  "<td>".$bookingList[$i]->resource_name."</td>";
                $content .=  "</tr>";
            }
        }
        $content .=  "</tbody>";
        $content .=  "</table>";
        
        $html2pdf = new Html2Pdf('P','A4','it');
        $html2pdf->writeHTML($content);
        $html2pdf->Output("List of bookings.pdf", 'D'); 
        
    }
    
}
