<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Http\Request;

class PrintController extends Controller {
    
    public function getPrintView() {
        
        Log::info('PrintController - getPrintView()');
        
        $groupsList = \App\Group::all();
        $resourceList =  \App\Resource::all();

        return view('pages/print/print', ['groupsList' => $groupsList, 'resourceList' => $resourceList]);
    
    }
    
    public function downloadPDF(Request $request) {

        Log::info('PrintController - downloadPDF()');
        
        //TODO da concordare contenuti delle stampe
        
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
        
        //TODO completare query con filtro date
        $bookingList = \App\Booking::with('repeats')
                                    ->where('resource_id', $idResource)
//                                    ->where('repeat.event_date_start', '>=', $dateSearchFrom)
//                                    ->where('repeat.event_date_end', '<=', $dateSearchTo)
                                    ->get();

        $content = "";
        //TODO compleatare tabella con informazioni
        if(count($bookingList) > 0) {
            for($i = 0; $i < count($bookingList); $i++) {
                $content .= $bookingList[$i]->name;
            }
        }
        
        $html2pdf = new Html2Pdf('P','A4','it');
        $html2pdf->writeHTML($content);
        $html2pdf->Output("List of bookings.pdf", 'D'); 
        
    }
    
}
