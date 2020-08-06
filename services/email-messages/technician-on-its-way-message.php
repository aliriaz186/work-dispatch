<?php

namespace services\email_messages;

use App\ScheduledJob;
use App\Worker;

class TechnicianOnItsWayMessage
{
    public function message(string $jobId, string $scheduledId)
    {
        $scheduled = ScheduledJob::where('id', $scheduledId)->first();
        $worker = Worker::where('id', $scheduled->id_worker)->first();
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Technician is on its way to your location</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Technician ('.$worker->name .') will be at your location shortly.</div><br>

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
        $emailBody = "Technician is on its way to your location.\n" . "Technician (".$worker->name .") will be at your location shortly.\n Click on link to track job\n " . env('APP_URL'). "/job/".$jobId."/track";
        return $emailBody;
    }

}
