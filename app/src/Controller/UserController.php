<?php

namespace App\Controller;

use App\Repository\UserRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(userRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("user", name="add_user")
     * @Method("POST")
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $username = $data['username'];
        $password = $data['password'];
        $roles = $data['roles'];

        if (empty($name) || empty($username) || empty($password) || empty($roles)) {
            throw new BadRequestHttpException('Expecting mandatory parameters!');
        }

        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (empty($user)) {
            $this->userRepository->saveUser($name, $username, $password, $roles);
        } else {
            throw new ConflictHttpException('User already exists!');
        }

        return new JsonResponse(['status' => 'User created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("user/{id}", name="get_one_user")
     * @Method("GET")
     */
    public function get($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (empty($user)) {
            throw new NotFoundHttpException('User not found!');
        }

        $data = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'roles' => $user->getRoles(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("users", name="get_all_users")
     * @Method("GET")
     */
    public function getAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'roles' => $user->getRoles(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("user/{id}", name="update_user")
     * @Method("PUT")
     */
    public function update($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        
        if (empty($user)) {
            throw new NotFoundHttpException('User not found!');
        }

        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $user->setName($data['name']);
        empty($data['username']) ? true : $user->setUsername($data['username']);
        empty($data['password']) ? true : $user->setPassword(
            $this->userRepository->generateHashedPassword($user, $data['password'])
        );
        empty($data['roles']) ? true : $user->setRoles($data['roles']);

        $updatedUser = $this->userRepository->updateUser($user);
        
        return new JsonResponse(['status' => 'User updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("user/{id}", name="delete_user")
     * @Method("DELETE")
     */
    public function delete($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (empty($user)) {
            throw new NotFoundHttpException('User not found!');
        }

        $this->userRepository->removeUser($user);

        return new JsonResponse(['status' => 'User deleted'], Response::HTTP_OK);
    }
}
