<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Survey;
use App\Repeat;
use App\TipSurveyStatus;
use App\TipBookingStatus;
use Exception;
use ErrorException;
use PDOException;

class ManageRepeatsAndSurveis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manageRepeatsSurveis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Management of repeats and surveis in pending states';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    function getToday() {
    
        return date('Y-m-d 22:00:00');

    }

    public function handle() {
        
        Log::info('ManageRepeatsAndSurveis - start job - '.  getToday());
        $this->info('ManageRepeatsAndSurveis - start job - '.  getToday());
        
        Log::info('ManageRepeatsAndSurveis - get surveis - '.date('Y-m-d G:h:i'));
        $this->info('ManageRepeatsAndSurveis - get surveis - '.date('Y-m-d G:h:i'));
        
        try {
            
            $listOfSurveis = Survey::where('tip_survey_status_id', TipSurveyStatus::TIP_SURVEY_STATUS_REQUESTED)
                                        ->where('created_at', '<=', getToday())
                                        ->get();

            Log::info('ManageRepeatsAndSurveis - get repeats - '.date('Y-m-d G:h:i'));
            $this->info('ManageRepeatsAndSurveis - get repeats - '.date('Y-m-d G:h:i'));

            $listOfRepeats = Repeat::where('tip_booking_status_id', TipBookingStatus::TIP_BOOKING_STATUS_REQUESTED)
                                        ->where('updated_at', '<=', getToday())
                                        ->get();

            Log::info('ManageRepeatsAndSurveis - update elements - '.date('Y-m-d G:h:i'));
            $this->info('ManageRepeatsAndSurveis - update elements - '.date('Y-m-d G:h:i'));

            if(count($listOfSurveis) > 0) {
                foreach ($listOfSurveis as $survey) {
                    $surveyTemp = Survey::find($survey->id);
                    $surveyTemp->tip_survey_status_id = TipSurveyStatus::TIP_SURVEY_STATUS_REJECTED;
                    $surveyTemp->save();
                }
            }

            if(count($listOfRepeats) > 0) {
                foreach ($listOfRepeats as $repeat) {
                    $repeatTemp = Repeat::find($repeat->id);
                    $repeatTemp->tip_booking_status_id = TipBookingStatus::TIP_BOOKING_STATUS_KO;
                    $repeatTemp->save();
                }
            }
        
        } catch (PDOException $ex) {
            Log::error('ManageRepeatsAndSurveis - PDOException: '.$ex->getMessage());
        } catch (ErrorException $ex) {
            Log::error('ManageRepeatsAndSurveis - ErrorException: '.$ex->getMessage());
        } catch (Exception $ex) {
            Log::error('ManageRepeatsAndSurveis - Exception: '.$ex->getMessage());
        }
        
        Log::info('ManageRepeatsAndSurveis - end job - '.date('Y-m-d G:h:i'));
        $this->info('ManageRepeatsAndSurveis - end job - '.date('Y-m-d G:h:i'));
        
    }
}
