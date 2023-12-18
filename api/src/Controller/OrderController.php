<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(private OrderRepository $orderRepository)
    {

    }

    #[Route('/orders', methods: ['GET'])]
    public function index(Request $request)
    {
        $queryBuilder = $this->orderRepository->getAllWithManagersQueryBuilder();

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            10
        );

        $orders = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $orders[] = $result;
        }
        //dd($orders);
        return $this->render('order/index.html.twig', [
                'pager' => $pagerfanta,
                'orders' => $orders
            ]
        );
    }
}