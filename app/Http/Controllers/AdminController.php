<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Group;
use App\Repeat;
use App\Booking;
use App\TipBookingStatus;
use App\TipUser;

class AdminController extends Controller {

    //Search Bookings By Id Status
    public function getBookingsByIdStatus(Request $request) {

        $idStatus = $request['id_status'];
        Log::info('AdminController - getBookingsByIdStatus(idStatus: '.$idStatus.')');

        //Se utente admin ateneo prendere tutte le prenotazioni
        $sessionRole = session('ruolo');
        $groups;
        if($sessionRole == TipUser::ROLE_ADMIN_ATENEO) {
            $groups =  Group::all();
        } else if($sessionRole == TipUser::ROLE_ADMIN_DIP) {
            $groups = Group::where('id', session('group_id_to_manage'))->get();
        }

        $bookingsList = array();

        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    foreach($booking->repeats as $repeat) {
                        if($repeat->tip_booking_status_id == $idStatus) {
                            if (!in_array($booking, $bookingsList)) {
                                  array_push($bookingsList, $booking);
                            }
                        }
                    }
                }
            }
        }

        return $bookingsList;

    }

    //Ricerca prenotazione in base a "Groups" amministrati
    public function getBookings() {

        Log::info('AdminController - getBookings()');

        $quequedBookings   = array();
        $workingBookings   = array();
        $confirmedBookings = array();
        $rejectedBookings  = array();

        //Groups amministrati dall'utente
        //se utente admin ateneo prendere tutte le prenotazioni
        $sessionRole = session('ruolo');
        $groups;
        if($sessionRole == TipUser::ROLE_ADMIN_ATENEO) {
            $groups =  Group::all();
        } else if($sessionRole == TipUser::ROLE_ADMIN_DIP) {
            $groups = Group::where('id', session('group_id_to_manage'))->get();
        }

        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    foreach($booking->repeats as $repeat) {
                        //Se lo stato della prenotazione è RICHIESTA
                        if($repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_REQUESTED) {
                            if (!in_array($booking, $quequedBookings)) {
                              array_push($quequedBookings, $booking);
                            }
                        }
                        //Se lo stato della prenotazione è IN LAVORAZIONE
                        if($repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_WORKING) {
                            if (!in_array($booking, $workingBookings)) {
                              array_push($workingBookings, $booking);
                            }
                        }
                        //Se lo stato della prenotazione è GESTITA
                        if($repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_OK) {
                            if (!in_array($booking, $confirmedBookings)) {
                              array_push($confirmedBookings, $booking);
                            }
                        }
                        //Se lo stato della prenotazione è SCARTATA
                        if($repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_KO) {
                            if (!in_array($booking, $rejectedBookings)) {
                              array_push($rejectedBookings, $booking);
                            }
                        }
                    }
                }
            }
        }

        return view('pages/console/console', [  'quequedBookings'   => $quequedBookings,
                                                'workingBookings'   => $workingBookings,
                                                'confirmedBookings' => $confirmedBookings,
                                                'rejectedBookings'  => $rejectedBookings,
                                                'groups'            => $groups]);

    }

    public function getBookingsByIdGroup(Request $request) {

        $idGroup = $request['id_group'];
        Log::info('AdminController - getBookingsByIdGroup($idGroup: '.$idGroup.')');

        $group = Group::find($idGroup);

        $bookings = array();
        //Per ogni risorsa associata ad un gruppo
        foreach($group->resources as $resource) {
            //Per ogni prenotazione associata ad una risorsa
            foreach($resource->bookings as $booking) {
                $booking->resource;
                foreach($booking->repeats as $repeat) {
                    //Stato RICHIESTA o IN LAVORAZIONE
                    if($repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_REQUESTED
                            ||
                       $repeat->tip_booking_status_id == TipBookingStatus::TIP_BOOKING_STATUS_WORKING) {
                        if (!in_array($booking, $bookings)) {
                            array_push($bookings, $booking);
                        }
                    }
                }
            }
        }

        return $bookings;

    }

    public function confirmBooking(Request $request) {

        $idRepeat = $request['id_repeat'];
        Log::info('AdminController - confirmBooking($idRepeat: '.$idRepeat.')');

        $repeat = Repeat::find($idRepeat);
        $repeat->tip_booking_status_id = TipBookingStatus::TIP_BOOKING_STATUS_OK;
        $repeat->save();

        return $repeat;

    }

    public function rejectBooking(Request $request) {

        $idRepeat = $request['id_repeat'];
        Log::info('AdminController - rejectBooking($idRepeat: '.$idRepeat.')');

        $repeat = Repeat::find($idRepeat);
        $repeat->tip_booking_status_id = TipBookingStatus::TIP_BOOKING_STATUS_KO;
        $repeat->save();

        return $repeat;

    }

}
