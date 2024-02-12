<?php

namespace App\Command;

use App\Factory\PriceListBuilder;
use App\Repository\PriceListRepository;
use App\Service\RouteService;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

#[AsCommand(name: 'fetch-price-list')]
class FetchPriceList extends Command
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly PriceListRepository $priceListRepository,
        private readonly PriceListBuilder    $priceListBuilder,
        private readonly LoggerInterface $logger,
        private readonly RouteService $routeService,
    ) {
        parent::__construct();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->fetchPriceList();
        if ($response === null) {
            return Command::FAILURE;
        }

        $responseValidUntil = new DateTimeImmutable($response['validUntil']);

        $priceList = $this->priceListRepository->findOneBy(['validUntil' => $responseValidUntil]);
        if ($priceList !== null) {
            return Command::SUCCESS;
        }

        $priceList = $this->priceListBuilder->createPriceList($response);
        $this->routeService->createRoutesForPriceList($priceList);

        $this->priceListRepository->deleteExceedingPriceLists();

        return Command::SUCCESS;
    }

    private function fetchPriceList(): ?array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices'
            );

            return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            $this->logger->error('An error occurred while fetching Travel Prices', [
                'exception' => get_class($exception),
                'message' => $exception->getMessage()
            ]);
        }

        return null;
    }

}