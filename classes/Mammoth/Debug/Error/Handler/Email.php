<?php
/**
 * Mammoth\Debug\Error\Handler\Email
 *
 * @author David Neilsen <david@panmedia.co.nz>
 */
namespace Mammoth\Debug\Error\Handler;
use LogicException;
use Mammoth;
use Mammoth\Debug\Error\Handler;

class Email extends Handler\Debug {

    public $emailTo = [];
    public $emailFrom;
    public $emailSubject;

    public function __construct() {
        if (!class_exists('Mammoth\Email')) {
            throw new LogicException('Mammoth\Debug\Error\Handler\Email required Mammoth\Email');
        }
    }

    public function handleException($exception) {
        ob_start();
        $this->renderException($exception);
        $content = ob_get_clean();
        $this->sendEmail($content);
    }

    public function handleError($number, $message, $file, $line, $context) {
        ob_start();
        $this->renderError($number, $message, $file, $line, $context);
        $content = ob_get_clean();
        $this->sendEmail($content);
    }

    public function handleFatalError($error) {
        ob_start();
        $this->renderFatalError($error);
        $content = ob_get_clean();
        $this->sendEmail($content);
    }

    public function handleMessage($message) {
        ob_start();
        $this->renderMessage($message);
        $content = ob_get_clean();
        $this->sendEmail($content);
    }

    public function sendEmail($content) {
        if (!class_exists('Mammoth\Email')) {
            return;
        }
        $email = new Mammoth\Email();
        $email->setHTML($content);
        foreach ($this->getEmailTo() as $emailTo) {
            $email->addTo([$emailTo]);
        }
        $email->addFrom([$this->getEmailFrom()]);
        $email->setSubject($this->getEmailSubject());
        $email->send();
    }

    public function getEmailTo() {
        return $this->emailTo;
    }

    public function setEmailTo(array $emailTo) {
        $this->emailTo = $emailTo;
        return $this;
    }

    public function addEmailTo($emailTo) {
        $this->emailTo[] = $emailTo;
        return $this;
    }

    public function getEmailFrom() {
        return $this->emailFrom;
    }

    public function setEmailFrom($emailFrom) {
        $this->emailFrom = $emailFrom;
        return $this;
    }

    public function getEmailSubject() {
        return substr($this->emailSubject, 0, 200);
    }

    public function setEmailSubject($emailSubject) {
        $this->emailSubject = $emailSubject;
        return $this;
    }

}
