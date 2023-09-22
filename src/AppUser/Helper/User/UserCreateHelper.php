<?php


namespace App\AppUser\Helper\User;


use App\AppUser\Domain\User\UserRepository;
use App\AppUtils\Data\DataValidator;
use App\AppUser\Application\Command\UserCreate\UserCreateCommand;
use App\AppUser\Application\Command\UserCreate\UserCreateCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserCreateHelper
{
    private UserRepository $_userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository =  $userRepository;
    }
    public function create(array $postData, DataValidator $dataValidator, UserPasswordHasher $passwordHasher): JsonResponse
    {
        $email = $postData['email'];
        $password = $postData['password'];
        $lang = $postData['lang'];

        //$translator->setLocale($lang);

        $violations = array();
        if (!$dataValidator->isValid(
            array(
                'email' => [
                    new Email(),
                    new NotBlank()
                ],
                'password' => new NotBlank(),
                'lang' => new NotBlank()
            )
        )
        ) {
            $violations = $dataValidator->getViolations();
        }

        if (\count($violations) > 0) {
            return new JsonResponse(
                array(
                    "violations" => $violations
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        $userCreateCommand = new UserCreateCommand($email, $password, $lang);
        $handler = new UserCreateCommandHandler($this->_userRepository, $passwordHasher);

        if ($handler->dispatch($userCreateCommand)) {
            return new JsonResponse(
                array(
                    "uuid" => $handler->getUuid()
                ),
                Response::HTTP_OK
            );
        }

        return new JsonResponse(
            array(
            ),
            Response::HTTP_BAD_REQUEST
        );
    }
}