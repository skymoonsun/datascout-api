<?php

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\RegisterVerificationMail;
use App\Repository\UserRepository;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterVerificationMailHandler implements MessageHandlerInterface
{

    public function __construct(
        protected MailService $mService,
        protected EntityManagerInterface $om,
        protected UserRepository $userRespository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(RegisterVerificationMail $message)
    {

        $user = $this->om->getRepository(User::class)->find($message->user);

        $response = $this->mService
            ->addTo($user->getEmail())
            ->setSubject('Kayıt Onay | DataScout')
            ->setTemplate("register-verification")
            ->setPayload([
                "url" => "https://datascout.com",
                "cdnUrl" => "https://datascout.com",
                "logoUrl" => "https://datascout.com",
                "footerLogoUrl" => "https://datascout.com",
                "text1" => "Merhaba",
                "text2" => "Kaydınızı onaylamak için aşağıdaki butona tıklayın.",
                "buttonText" => "Onayla",
                "confirmationUrl" => "#",
                "footerText" => "DataScout",
                "footerText2" => "-",
                "footerUrl" => "#",
                "copyrightText" => "© 2023 DataScout. Tüm hakları saklıdır."
            ])->sendEmail();

//        if($response===true){
//            $member->setEmailSend(emailSend: true);
//            $this->om->persist($member);
//            $this->om->flush();
//        }

    }

}