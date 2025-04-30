<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    const LIMIT = 5;

    public function __construct(private readonly ImageRepository $imageRepository)
    {
    }

    #[Route('/', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('images/index.html.twig');
    }

    #[Route('/pictures/show', name: 'show_pictures', methods: ['GET'])]
    public function showList(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->imageRepository->createQueryBuilder('i')
            ->orderBy('i.id', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->render('images/picture_gallery.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}