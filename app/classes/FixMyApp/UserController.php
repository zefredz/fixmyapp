<?php

namespace FixMyApp\Controller

use Symfony\Component\HttpFoundation\JsonResponse;

class User
{
    protected $repo;

    public function __construct( $repo )
    {
        $this->repo = $repo;
    }

    public function indexJsonAction()
    {
        return new JsonResponse($this->repo->findAll());
    }
}