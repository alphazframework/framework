<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Softhub99\Zest_Framework\Auth;

use Config\Auth;
use Config\Email;
use Softhub99\Zest_Framework\Mail\Mail;

class EmailHandler
{
    /**
     * Send the email msg.
     *
     * @param $subject , subject of email
     *        $html , body of email
     *        $email , user email
     * 
     * @return void
     */    
    public function __construct($subject, $html, $email)
    {
        $mail = new Mail();
        $mail->setSubject($subject);
        $mail->setSender(Email::SITE_EMAIL);
        $mail->setContentHTML($html);
        $mail->addReceiver($email);
        if (Auth::IS_SMTP) {
            $mail->isSMTP(true);
        }
        $mail->send();
    }
}
