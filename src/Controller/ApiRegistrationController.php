<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiRegistrationController extends AbstractController
{
    #[Route('/api/registration', name: 'app_api_registration', methods: ['POST'])]
    public function index(
        ManagerRegistry $doctrine,
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): JsonResponse {
        $entityManager = $doctrine->getManager();
        $decoded = json_decode($request->getContent());

        //Verifica se não estão nulos
        $name = $decoded->name ?? null;
        $email = $decoded->email ?? null;
        $password = $decoded->password ?? null;
        $roles = $decoded->role ?? null;

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        // O código valida o objeto $user. Se encontrar erros, 
        // responde com um JSON contendo todos os erros organizados por campo, 
        // e o código HTTP 400 para indicar que os dados enviados pelo 
        // cliente estão inválidos.
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(['errors' => $errorMessages], 400);
        }

        // Hash e persistência
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Registrado com sucesso!']);
    }
}

