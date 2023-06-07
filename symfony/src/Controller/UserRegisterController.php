<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class UserRegisterController extends AbstractController
{
    private $om;

    private $client;

    public function __construct(EntityManagerInterface $om)
    {
        $this->om = $om;
    }

    public function __invoke(Request $request, User $data, UserPasswordHasherInterface $passwordHasher)
    {

        $d = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $password = $d['password'] ?? null;
        $confirmPassword = $d['confirmPassword'] ?? null;

        if($password !== $confirmPassword){
            throw new BadRequestHttpException("password must be same");
        }

        $fullName = $d['name'] . ' ' . $d['surname'];
        $email = $d['email'];

        $hashedPassword = $passwordHasher->hashPassword(
            $data,
            $d['password']
        );

        $data->setRoles(['ROLE_USER'])
            ->setName($fullName)
            ->setPassword($hashedPassword)
            ->setEmail($email);


        $data->setEmail($email)
            ->setName($d['name'])
            ->setSurname($d['surname']);

        return $data;
    }

}