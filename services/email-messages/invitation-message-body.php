<?php

namespace services\email_messages;

class InvitationMessageBody
{
    public function invitationMessageBody(string $password)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Please Login to start your business</div><br>
            <div style="padding-left: 50px;font-size: 18px;padding-right: 50px">Your Password is  : '.$password.'</div>
 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. env('TECHNICIAN_URL'). '" style=" background-color: #1AAA55;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">Login</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

}
