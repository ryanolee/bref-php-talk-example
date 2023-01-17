<?php

declare(strict_types=1);

namespace App\Application\Actions\Elephpant;


use Psr\Http\Message\ResponseInterface;

class ListPhpElephantAction extends ElephpantAction

{
    protected function action(): ResponseInterface
    {
        $elephpants = $this->elephpantRepository->findAll();

        return $this->render('pages/homepage.html.twig', [
            'elephpants' => $elephpants
        ]);
    }
}