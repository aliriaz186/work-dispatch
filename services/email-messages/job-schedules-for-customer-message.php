<?php

namespace services\email_messages;

use App\ScheduledJob;
use App\Worker;

class JobScheduleForCustomerMessage
{
    public function message(string $jobId, string $scheduledId)
    {
        $scheduled = ScheduledJob::where('id', $scheduledId)->first();
        $worker = Worker::where('id', $scheduled->id_worker)->first();
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Your claim has been scheduled</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Technician ('.$worker->name .') will be at your location on '.$scheduled->date .' between ('.$scheduled->est_time_from .' - '.$scheduled->est_time_to .')</div><br>

 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. env('APP_URL'). '/job/'.$jobId.'/track" style=" background-color: #1AAA55;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">Track</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

    public function textMessage(string $jobId, string $scheduledId){
        $scheduled = ScheduledJob::where('id', $scheduledId)->first();
        $worker = Worker::where('id', $scheduled->id_worker)->first();
        $emailBody = "Your claim has been scheduled\n" . "Technician (".$worker->name .") will be at your location on ".$scheduled->date ." between (".$scheduled->est_time_from ." - ".$scheduled->est_time_to .")\nClick on link to track\n " . env('APP_URL')."/job/".$jobId."/track";
        return $emailBody;
    }

}
