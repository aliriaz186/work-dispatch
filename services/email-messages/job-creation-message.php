<?php

namespace services\email_messages;

class JobCreationMessage
{
    public function creationMessage(string $jobId)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Your claim has been created. You can track it by following this link.</div><br>

 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. env('TECHNICIAN_URL'). '/job/'.$jobId.'/track" style=" background-color: #1AAA55;
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

}
