<?php


namespace App\AppUser\Controller;




use Nelmio\ApiDocBundle\Annotation\Security;
use App\AppUser\Helper\User\UserCreateHelper;
use App\AppUser\Infrastructure\Doctrine\User\UserDoctrineRepository;
use App\AppUtils\Data\DataValidator;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/createuser', name: 'app_create_user', methods: 'POST')]
    /**
     *
     * @OA\Response(
     *     response="200",
     *     description="Return uuid for new user",
     * @OA\JsonContent(type="array", @OA\Items())
     * )
     * @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="Email account",
     * @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="password",
     *     in="query",
     *     name="Password account",
     * @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="lang",
     *     in="query",
     *     description="Lang account (fr, en)",
     * @OA\Schema(type="string")
     * )
     *
     * @Security(name="bearer")
     */
    public function create(
        Request $request,
        UserPasswordHasher $passwordHasher,
        UserDoctrineRepository $userDoctrineRepository,
        ValidatorInterface $validator
    ): Response
    {
        $userCreateHelper = new UserCreateHelper($userDoctrineRepository);
        $dataValidator = new DataValidator($request, $validator);
        $postData = json_decode($request->getContent(), true);
        return $userCreateHelper->create($postData, $dataValidator, $passwordHasher);
    }
}