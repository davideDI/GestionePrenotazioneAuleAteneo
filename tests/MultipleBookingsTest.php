<?php

class MultipleBookingsTest extends TestCase {
    
    public function testMultipleBookings() {
        
        $response = $this   ->withSession(['useri_id'   => '3'])
                            ->call('POST', 
                                '/new-booking', 
                                [   'name'              => 'test multiple bookings',
                                    'description'       => 'test multiple bookings with PHPUnit',
                                    'num_students'      => '15',
                                    'event_date_start'  => '01-05-2017',
                                    'event_date_end'    => '31-05-2017',
                                    'repeat_event'      => '2',
                                    'type_repeat'       => '[1, 3, 5]',
                                    'detail_day_from_1' => '09:00',
                                    'detail_day_to_1'   => '11:00',
                                    'detail_day_from_3' => '11:00',
                                    'detail_day_to_3'   => '13:00',
                                    'detail_day_from_5' => '16:00',
                                    'detail_day_to_5'   => '18:00',
                                    'group_id'          => '1',
                                    'resource_id'       => '1',
                                    'tip_event_id'      => '1',
                                ]);
        
    }
    
    
}

