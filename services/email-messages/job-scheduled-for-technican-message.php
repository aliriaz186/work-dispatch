<?php

namespace services\email_messages;

use App\DispatchJob;
use App\ScheduledJob;
use App\Worker;

class JobScheduleForTechnicanMessage
{
    public function message(string $jobId, string $scheduledId)
    {
        $scheduled = ScheduledJob::where('id', $scheduledId)->first();
        $worker = Worker::where('id', $scheduled->id_worker)->first();
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">A claim has been assigned to you.</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">A claim  has been assigned on '.$scheduled->date .' between ('.$scheduled->est_time_from .' - '.$scheduled->est_time_to .')</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Please click on button below to update status of your claim</div><br>

 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. env('APP_URL'). '/job/'.$jobId.'/worker/view" style=" background-color: #1AAA55;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">View Claim</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

    public function textMessage(string $jobId, string $scheduledId){
        $scheduled = ScheduledJob::where('id', $scheduledId)->first();
        $worker = Worker::where('id', $scheduled->id_worker)->first();
        $emailBody = "A claim has been assigned to you.\n" . "A claim  has been assigned on ".$scheduled->date ." between (".$scheduled->est_time_from ." - ".$scheduled->est_time_to .")\n Click on link to view claim\n " . env('APP_URL'). "/job/".$jobId."/worker/view";
        return $emailBody;
    }

}
