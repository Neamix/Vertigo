<?php 

namespace App\Http\Helpers;

use App\Mail\DefaultEmail;
use Illuminate\Support\Facades\Mail;

trait Mailers {

    public function changePassword($token,$verify = false)
    {
        $data['name'] = $this->name;
        $data['token'] = $token;
        $data['email'] = $this->email;
        $data['type'] = (!$this->email_verified_at) ? "Verify" : "Reset";
        $data['url']   = "reset?email=$this->email&token=$token&type=".$data['type'];
        $data['view'] = 'emails.forgetpassword';
        self::sendEmail($data);
    }

    public function test()
    {
        $data['name'] = 'abdalrhman';
        $data['token'] = 'toekn';
        $data['email'] = 'abdalrhmanhussin@gmail.com';
        $data['type'] = 'verify';
        $data['url']   = "reset?email=email&token=token&type=".$data['type'];
        $data['view'] = 'emails.forgetpassword';
        self::sendEmail($data);
    }

    static function sendEmail($data) {
        Mail::to($data['email'])->queue(new DefaultEmail($data));
    }

}
