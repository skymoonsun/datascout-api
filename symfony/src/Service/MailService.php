<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailService
{
//    public static string $EMAIL_INFO;
//    public static string $EMAIL_TECH;
    public static string $TEAM = 'DataScout';
    public static string $SENDER = "info@outplay.digital";

    private array $to = [];
    private array $cc = [];
    private array $bcc = [];
    private ?string $subject = null;
    private array $payload = [];
    private ?string $templateCode = null;
    private array $attachments = [];

    public function __construct(
        private MailerInterface $mailer,
        private Environment     $twig

    )
    {

//        self::$EMAIL_INFO = $_ENV['EMAIL_INFORM'];
//        self::$EMAIL_TECH = $_ENV['EMAIL_TECH'];
//        $env = $_ENV["APP_ENV"] ?? 'dev';
//        if ($env === "dev") {
//            self::$TEAM .= "(dev)";
//        }
//        if ($env === "staging") {
//            self::$TEAM .= "(Staging)";
//        }
    }


    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function addAttachment($attachment): static
    {
        $this->attachments[] = $attachment;
        return $this;
    }

    public function addTo(string $to): static
    {
        $this->to[] = $to;
        return $this;
    }

    public function setTo(array $to): static
    {
        $this->to = $to;
        return $this;
    }

    public function setCC(array $cc): static
    {
        $this->cc = $cc;
        return $this;
    }

    public function addCC(string $cc): static
    {
        $this->cc[] = $cc;
        return $this;
    }

    public function addBCC(string $bcc): static
    {
        $this->bcc[] = $bcc;
        return $this;
    }

    public function setBCC(array $bcc): static
    {
        $this->bcc = $bcc;
        return $this;
    }

    public function setTemplate(string $code): static
    {
        $this->templateCode = $code;
        return $this;
    }

    public function setPayload(array $payload): static
    {
        $this->payload = $payload;
        return $this;
    }

    public function setPayloadItem(string $key, string|array $value): static
    {
        $this->payload[$key] = $value;
        return $this;
    }

    protected function reset(): static
    {
        $this->to = [];
        $this->payload = [];
        $this->cc = [];
        $this->subject = null;
        return $this;
    }

    /**
     * @param bool $inBackground
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail(bool $inBackground = false)
    {
//        if ($this->subject && $_ENV["APP_ENV"] === "dev") {
//            $this->subject .= " (dev)";
//        }
//        if ($this->subject && $_ENV["APP_ENV"] === "staging") {
//            $this->subject .= " (Staging)";
//        }
//
//        if ($_ENV["APP_ENV"] !== "prod") {
//            $this->to = array_merge($this->to, explode(",",$_ENV["EMAIL_TEST"]));
//        }

//        $this->bcc[] = $_ENV["EMAIL_TECH"];

        $body = $this->twig->render("mail/" . $this->templateCode . ".html.twig",
            $this->payload);
        $email = $this->initTeamEmail()->subject($this->subject)->html($body)
            ->text(strip_tags($body));

        foreach ($this->to as $to){
            $email->addTo(new Address($to));
        }

        foreach ($this->cc as $cc){
            $email->addCc(new Address($cc));
        }

        foreach ($this->bcc as $bcc){
            $email->addBcc(new Address($bcc));
        }

        foreach ($this->attachments as $attachment) {

            $email->attachPart(new DataPart(fopen($attachment['filePath'], 'r'),
                $attachment['fileName'], $attachment['contentType']));
        }

        try {
            $this->mailer->send($email);
            $this->reset();

            return true;
        } catch (TransportExceptionInterface $e) {
            return $e->getMessage();
        }
//        $this->mailer->send($email);
//
//        $this->reset();
    }


    protected function initTeamEmail(): Email
    {
        return (new Email())
            ->from(new Address(self::$SENDER, self::$TEAM));
    }

    protected function attachTo($address): static
    {
        $emailList = str_replace(";", ",", $address);
        $emails = explode(",", $emailList);

        foreach ($emails as $seamail) {
            $this->addTo($seamail);
        }

        return $this;

    }






}
