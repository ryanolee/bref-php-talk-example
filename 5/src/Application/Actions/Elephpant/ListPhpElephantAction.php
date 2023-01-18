<?php

declare(strict_types=1);

namespace App\Application\Actions\Elephpant;


use Psr\Http\Message\ResponseInterface;

class ListPhpElephantAction extends ElephpantAction

{
    protected function action(): ResponseInterface
    {
        $elephpants = $this->elephpantRepository->findAll();

        $viewParameters = array_map(function ($elephpant) {
            return [
                'image' => $this->elephpantRepository->findElephpantImageOfId($elephpant->getId()),
                'name' => $elephpant->getName(),
                'description' => $elephpant->getDescription(),
            ];
        }, $elephpants);


        return $this->render('pages/homepage.html.twig', [
            'elephpants' => $viewParameters
        ]);
    }
}