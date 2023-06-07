<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\UserMeController;
use App\Controller\UserRegisterController;
use App\Helper\ResponseGroups;
use App\Helper\ValidationGroups;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(operations: [
    new Get(
        name: 'me',
        uriTemplate: '/me',
        controller: UserMeController::class
    ),
    new Post(
        name: 'register',
        uriTemplate: '/register',
        controller: UserRegisterController::class
    )
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLES = [
        self::ROLE_USER => 1,
        self::ROLE_ADMIN => 2,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        ResponseGroups::GROUP_USER_VIEW
    ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups([ResponseGroups::GROUP_USER_VIEW, ResponseGroups::GROUP_USER_WRITE])]
    #[Assert\NotBlank(message: "Email.empty",groups: [ValidationGroups::VALIDATE_USER])]
    #[Assert\Email(groups: [ValidationGroups::VALIDATE_USER])]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    #[Groups([ResponseGroups::GROUP_USER_VIEW, ResponseGroups::GROUP_USER_WRITE])]
    #[Assert\NotBlank(message: 'roles.empty', groups: [ValidationGroups::VALIDATE_USER])]
    private array $roles = [];

    #[Groups([ResponseGroups::GROUP_USER_VIEW])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'name.empty', groups: [ValidationGroups::VALIDATE_USER])]
    private $name;

    #[Groups([ResponseGroups::GROUP_USER_VIEW])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:'surname.empty' ,groups: [ValidationGroups::VALIDATE_USER])]
    private $surname;



    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups([ResponseGroups::GROUP_USER_VIEW, ResponseGroups::GROUP_USER_WRITE])]
    private ?string $password = null;

    #[Groups([ResponseGroups::GROUP_USER_VIEW, ResponseGroups::GROUP_USER_WRITE])]
    private $token;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        /** WHY add this? this broken iam update roles api*/
        // $roles[] = "ROLE_USER";

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole(string $checkRole): bool
    {
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            if ($checkRole === $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surnam): self
    {
        $this->surname = $surnam;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}
