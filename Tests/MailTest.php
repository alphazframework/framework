<?php
namespace Framework\Tests;

use Zest\Mail\Mail;
use PHPUnit\Framework\TestCase;

class MailTest extends TestCase
{

    /**
     * @test
     */
    public function create_something()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    /*public function can_send_email_with_user_selected_driver()
    {

        $file = __DIR__.'/../phpunit-book.pdf';
		
		$mail = new Mail;
        //Set subject.
        $mail->setSubject('Example mail');
        //Sender, like support@example.com
        $mail->setSender('noreply@zestframework.xyz');
        //Set the plain content of the mail.
        $mail->setContentPlain('Example plain-content!');
        //Add a receiver of the mail (you can add more than one receiver too).
        $mail->addReceiver('lablnet01@gmail.com');		
		$mail->addAttachment($file);

		if ($mail->send()) {
			$this->assertSame('Queued. Thank you.');
		} else {
			$this->assertSame('Sorry, mail not send');
		}

    }*/

}