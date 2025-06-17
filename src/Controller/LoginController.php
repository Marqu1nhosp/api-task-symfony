<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function loginCheck(
        Request $request,
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent());

        //Verifica se não estão nulos
        $email = $data->email ?? null;
        $password = $data->password ?? null;

        if (!$email || !$password) {
            return $this->json(['error' => 'E-mail e senha são obrigatórios'], 400);
        }

        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $email]);

        // Transforma a senha em Hash(MD5)
        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return $this->json(['error' => 'Credenciais inválidas'], 401);
        }

        // Cria um token de acesso
        $token = $jwtManager->create($user);

        // Retorno to Token e dados do usuário
        return $this->json([
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'role' => $user->getRoles(),
            ],
        ]);
    }
}
