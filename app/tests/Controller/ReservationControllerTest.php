<?php

namespace App\Tests\Controller;

use App\Controller\ReservationController;
use App\Entity\Terrain;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class ReservationControllerTest extends TestCase
{
    public function testReserverReturnsResponseWithTerrain()
    {
        $terrain = new Terrain();
        $reservations = [$this->createMock(Reservation::class)];

        // Mock du repository pour Terrain
        $terrainRepoMock = $this->createMock(EntityRepository::class);
        $terrainRepoMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($terrain);

        // Mock du repository pour Reservation
        $reservationRepoMock = $this->createMock(EntityRepository::class);
        $reservationRepoMock->expects($this->once())
            ->method('findBy')
            ->willReturn($reservations);

        // Mock EntityManager avec un callback pour getRepository
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturnCallback(function ($entityClass) use ($terrainRepoMock, $reservationRepoMock) {
            if ($entityClass === Terrain::class) {
                return $terrainRepoMock;
            } elseif ($entityClass === Reservation::class) {
                return $reservationRepoMock;
            }
            throw new \InvalidArgumentException("Unexpected repository requested: $entityClass");
        });

        $request = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET']);

        $userMock = $this->createMock(UserInterface::class);

        $controller = $this->getMockBuilder(ReservationController::class)
            ->onlyMethods(['denyAccessUnlessGranted', 'getUser', 'render'])
            ->getMock();

        $controller->expects($this->once())
            ->method('denyAccessUnlessGranted')
            ->with('IS_AUTHENTICATED_FULLY');

        $controller->method('getUser')->willReturn($userMock);

        $controller->expects($this->once())
            ->method('render')
            ->with(
                'reservation/reserver.html.twig',
                $this->callback(function ($params) use ($terrain, $reservations) {
                    return isset($params['terrain'], $params['reservations']) &&
                        $params['terrain'] === $terrain &&
                        $params['reservations'] === $reservations;
                })
            )
            ->willReturn(new Response());

        $response = $controller->reserver(1, $request, $em);

        $this->assertInstanceOf(Response::class, $response);
    }
}