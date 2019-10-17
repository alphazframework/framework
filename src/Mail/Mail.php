<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.9.0
 *
 * @license MIT
 */

namespace Zest\Mail;

class Mail
{
    /**
     * Additional parameters for sending the mail.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $addparams = '';

    /**
     * Collection of all attachments.
     *
     * @since 1.9.0
     *
     * @var array
     */
    private $attachments = [];
    /**
     * Collection of all BCC (Blind Copy Carbon) mail-addresses.
     *
     * @since 1.9.0
     *
     * @var array
     */
    private $bcc = [];
    /**
     * Collection of all CC (Copy Carbon) mail-addresses.
     *
     * @since 1.9.0
     *
     * @var array
     */
    private $cc = [];
    /**
     * The formatted content (HTML) of the mail.
     *
     * @since 1.9.0
     *
     * @var string|HTML
     */
    private $contentHTML = '';
    /**
     * The plain content (non HTML) content of the mail.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $contentPlain = '';
    /**
     * Collection of all receivers.
     *
     * @since 1.9.0
     *
     * @var array
     */
    private $receivers = [];
    /**
     * The mail-address on which should be answered.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $replyTo = '';
    /**
     * The sender of the mail.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $sender = '';
    /**
     * The subject of the mail.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $subject = '';
    /**
     * Configuration for smtp.
     *
     * @since 1.9.0
     *
     * @var string
     */
    private $smtp = [];

    /**
     * For add attachment.
     *
     * @param resource $file
     *
     * @since 1.9.0
     *
     * @return void
     */
    public function addAttachment($file)
    {
        $this->attachments = $file;
    }

    /**
     * For add a new BCC.
     *
     * @param string $bcc
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function addBcc($bcc)
    {
        if ($this->isValidEmail($bcc) === true) {
            if (is_array($bcc, $this->bcc) === false) {
                $this->bcc[] = $bcc;
            }
        }

        return false;
    }

    /**
     * For adding a new cc.
     *
     * @param string $cc
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function addCc($cc)
    {
        if ($this->isValidEmail($cc) === true) {
            if (is_array($cc, $this->cc) === false) {
                $this->cc[] = $cc;
            }
        }

        return false;
    }

    /**
     * For adding a receiver.
     *
     * @param string $email
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function addReceiver($email)
    {
        if ($this->isValidEmail($email) === true) {
            if (@is_array($email, $this->receivers) === false) {
                $this->receivers[] = $email;
            }
        }

        return false;
    }

    /**
     * For preparing an attachment to send with mail.
     *
     * @since 1.9.0
     *
     * @return mix-data
     */
    public function prepareAttachment($attachment)
    {
        if ($this->isFile($attachment) !== true) {
            return false;
        }
        //http://php.net/manual/en/class.finfo.php
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileType = $fileInfo->file($attachment);
        $file = fopen($attachment, 'r');
        $fileContent = fread($file, filesize($attachment));
        $fileContent = chunk_split(base64_encode($fileContent));
        fclose($file);
        $msgContent = 'Content-Type: '.$fileType.'; name='.basename($attachment)."\r\n";
        $msgContent .= 'Content-Transfer-Encoding: base64'."\r\n";
        $msgContent .= 'Content-ID: <'.basename($attachment).'>'."\r\n";
        $msgContent .= "\r\n".$fileContent."\r\n\r\n";

        return $msgContent;
    }

    /**
     * For send the mail.
     *
     * @since 1.9.0
     *
     * @return boolean.
     */
    public function send()
    {
        //Check if a sender is available.
        if (empty(trim($this->sender))) {
            return false;
        }
        if ((is_array($this->receivers) === false) || (count($this->receivers) < 1)) {
            return false;
        }
        $receivers = implode(',', $this->receivers);
        if (!empty(trim($this->replyTo))) {
            $headers[] = 'Reply-To: '.$this->replyTo;
        } else {
            $headers[] = 'Reply-To: '.$this->sender;
        }
        if ((is_array($this->bcc) === true) && (count($this->bcc) > 0)) {
            $headers[] = 'Bcc: '.implode(',', $this->bcc);
        }
        if ((is_array($this->cc) === true) && (count($this->cc) > 0)) {
            $headers[] = 'Cc: '.implode(',', $this->cc);
        }
        //Generate boundaries for mail content areas.
        $boundaryMessage = md5(rand().'message');
        $boundaryContent = md5(rand().'content');
        //Set the header informations of the mail.
        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'X-Mailer: PHP/'.phpversion();
        $headers[] = 'Date: '.date('r', $_SERVER['REQUEST_TIME']);
        $headers[] = 'X-Originating-IP: '.$_SERVER['SERVER_ADDR'];
        $headers[] = 'Content-Type: multipart/related;boundary='.$boundaryMessage;
        $headers[] = 'Content-Transfer-Encoding: 8bit';
        $headers[] = 'From: '.$this->sender;
        $headers[] = 'Return-Path: '.$this->sender;
        //Start to generate the content of the mail.
        $msgContent = "\r\n".'--'.$boundaryMessage."\r\n";
        $msgContent .= 'Content-Type: multipart/alternative; boundary='.$boundaryContent."\r\n";
        if (!empty(trim($this->contentPlain))) {
            $msgContent .= "\r\n".'--'.$boundaryContent."\r\n";
            $msgContent .= 'Content-Type: text/plain; charset=ISO-8859-1'."\r\n";
            $msgContent .= "\r\n".$this->contentPlain."\r\n";
        }
        if (!empty(trim($this->contentHTML))) {
            $msgContent .= "\r\n".'--'.$boundaryContent."\r\n";
            $msgContent .= 'Content-Type: text/html; charset=ISO-8859-1'."\r\n";
            $msgContent .= "\r\n".$this->contentHTML."\r\n";
        }
        //Close the message area of the mail.
        $msgContent .= "\r\n".'--'.$boundaryContent.'--'."\r\n";
        foreach ($this->attachments as $attachment) {
            $attachmentContent = $this->prepareAttachment($attachment);
            if ($attachmentContent !== false) {
                $msgContent .= "\r\n".'--'.$boundaryMessage."\r\n";
                $msgContent .= $attachmentContent;
            }
        }
        //Close the area of the whole mail content.
        $msgContent .= "\r\n".'--'.$boundaryMessage.'--'."\r\n";
        if (!isset($this->smtp['status']) || $this->smtp['status'] === false) {
            $return = mail($receivers, $this->subject, $msgContent, implode("\r\n", $headers), $this->addparams);
        } else {
            $return = $this->sendSMTP($receivers, $this->sender, $msgContent);
        }

        return $return;
    }

    /**
     * Check is email is valid.
     *
     * @param string $email
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function isValidEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        }
        if (filter_var($email, FILTER_SANITIZE_EMAIL) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set SMPT status.
     *
     * @param $status
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function isSMTP(bool $status = false)
    {
        if ($status === true) {
            $this->smtp['status'] = $status;
        } else {
            $this->smtp['status'] = $status;
        }
    }

    /**
     * Send mail over SMTP.
     *
     * @param $to sender email
     *        $from from email
     *        $message message to be send
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function sendSMTP($to, $from, $message)
    {
        $host = __config()->email->smtp_host;
        $user = __config()->email->smtp_user;
        $pass = __config()->email->smtp_pass;
        $port = __config()->email->smtp_port;
        if ($h = fsockopen($host, $port)) {
            $data = [
                0,
                "EHLO $host",
                'AUTH LOGIN',
                base64_encode($user),
                base64_encode($pass),
                "MAIL FROM: <$from>",
                "RCPT TO: <$to>",
                'DATA',
                $message,
            ];
            foreach ($data as $c) {
                $c && fwrite($h, "$c\r\n");
                while (substr(fgets($h, 256), 3, 1) != ' ') {
                }
            }
            fwrite($h, "QUIT\r\n");

            return fclose($h);
        }
    }

    /**
     * For set additional parameter for the mail function (4th parameter).
     *
     * @param string $parameter
     *
     * @since 1.9.0
     *
     * @return void
     */
    public function setaddParams($params)
    {
        $this->addparams = $params;
    }

    /**
     * For the formatted content (HTML) of the mail.
     *
     * @param string $content
     *
     * @since 1.9.0
     *
     * @return void
     */
    public function setContentHTML($content)
    {
        $content = wordwrap($content, 60, "\n");
        $this->contentHTML = $content;
    }

    /**
     * For set the plain content of the mail.
     *
     * @param string $content
     *
     * @since 1.9.0
     *
     * @return void
     */
    public function setContentPlain($content)
    {
        $content = wordwrap($content, 60, "\n");
        $this->contentPlain = $content;
    }

    /**
     * For set reply_to in mail.
     *
     * @param string $subject The subject of the mail.
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function setReplyTo($email)
    {
        if ($this->isValidEmail($email) === true) {
            $this->reply_to = $email;
        } else {
            return false;
        }
    }

    /**
     * For set sender in mail.
     *
     * @param string $subject The subject of the mail.
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function setSender($email)
    {
        if ($this->isValidEmail($email) === true) {
            $this->sender = $email;
        } else {
            return false;
        }
    }

    /**
     * For set subject in mail.
     *
     * @param string $subject The subject of the mail.
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Check file exists or not.
     *
     * @param resource $file
     *
     * @since 1.9.0
     *
     * @return bool
     */
    public function isFile()
    {
        return file_exists($this->file);
    }

    /**
     * Clear all the information.
     *
     * @since 1.9.0
     *
     * @return void
     */
    public function clear()
    {
        unset($this->cc);
        unset($this->bcc);
        unset($this->receivers);
        unset($this->attachments);
        unset($this->contentHTML);
        unset($this->contentPlain);
    }
}
