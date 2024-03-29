<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Auth;

use alphaz\Mail\Mail;

class EmailHandler
{
    /**
     * Send the email msg.
     *
     * @param (string) $subject subject of email
     * @param (mixeds) $html    body of email
     * @param (mixed)  $email   user email
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct($subject, $html, $email)
    {
        $mail = new Mail();
        $mail->setSubject($subject);
        $mail->setSender(__config()->email->site_email);
        $mail->setContentHTML($html);
        $mail->addReceiver($email);
        if (__config()->auth->is_smtp) {
            $mail->isSMTP(true);
        }
        $mail->send();
    }
}
