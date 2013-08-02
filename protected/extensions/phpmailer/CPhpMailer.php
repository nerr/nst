<?php
require_once(Yii::getPathOfAlias('application.extensions.phpmailer.PHPMailer').DIRECTORY_SEPARATOR.'class.phpmailer.php');

class CPhpMailer
{
    function __construct()
    {
        $this->_mailer = new PHPMailer();
        $this->_mailer->CharSet = "utf-8";
        $this->_mailer->IsSMTP();
        $this->_mailer->SMTPAuth = true;
        //$this->_mailer->SMTPKeepAlive = true;
        //$this->_mailer->SMTPSecure = 'tls';
        $this->_mailer->AltBody = "text/html";
        $this->_mailer->IsHTML(true);
    }

    function init()
    {
        $this->_mailer->Host = $this->host;
        $this->_mailer->Port = $this->port;
        $this->_mailer->SMTPSecure = $this->smtpsecure;
        $this->_mailer->Username = $this->user;
        $this->_mailer->Password = $this->pass;
        $this->_mailer->From = $this->from;
        $this->_mailer->FromName = $this->fromName;
    }
}