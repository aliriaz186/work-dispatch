<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class AuthController extends Controller
{
    //Displaying Auth Page
    public function index()
    {
        if (Session::has('userId')) {
            return redirect('dashboard');
        } else {
            return view('auth/login');
        }
    }

    //Login Authentication
    public function login(Request $request)
    {
        if (Technician::where('email', $request->email)->exists()) {
            $dbUser = Technician::where('email', $request->email)->first();
            if ($dbUser->password == md5($request->password)) {
                Session::put('userId', $dbUser->id);
                return json_encode(['status' => true, 'message' => 'Login Successfull!']);
            } else {
                return json_encode(['status' => false, 'message' => 'Invalid username or password!']);
            }
        } else {
            return json_encode(['status' => false, 'message' => 'Invalid username or password']);
        }
    }

    public function forgotPasswordRequest(Request $request)
    {
        $userEmail = $request->email;
        if (!Technician::where('email', $userEmail)->exists()) {
            return json_encode(['status' => false, 'message' => 'Email Not registered']);
        }
        $subject = new SendEmailService(new EmailSubject("Forgot Password Request. Click On link to change password"));
        $mailTo = new EmailAddress($userEmail);
        $emailBody = env('APP_URL') . "/set-password/" . $userEmail . "/get";
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf(env('MAIL_HOST'), env('MAIL_USERNAME'), env('MAIL_PASSWORD'))));
        $result = $sendEmail->send($emailMessage);
        return json_encode(['status' => $result, 'message' => 'Email sent successfully']);
    }

    public function setPasswordPage($email)
    {
        if (!Technician::where('email', $email)->exists()) {
            return json_encode("Access Denied");
        }
        return view('auth/set-password-view')->with(['email' => $email]);
    }

    public function changePassword(Request $request)
    {
        try {
            if (!Technician::where('email', $request->email)->exists()) {
                return json_encode(['status' => false, 'message' => 'Access Denied']);
            }
            $user = Technician::where('email', $request->email)->first();
            $user->password = md5($request->password);
            return json_encode(['status' => $user->update(), 'message' => 'Password updated successfully!']);
        } catch (\Exception $exception) {
            return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function signout(Request $request){
        Session::flush();
        return json_encode(true);
    }
}
