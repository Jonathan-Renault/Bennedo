<?php


namespace App\Service;

use App\Entity\ConsumerHasBin;
use App\Entity\Consumer;
use App\Entity\Bin;
use App\Entity\Report;


class ConsumerActionsService
{
    public function createConsumerAction($id_report, $id_bin, $id_consumer, $action, $entityManager)
    {
        $consumerAction = new ConsumerHasBin();
        $consumerAction->setIdBin($id_bin)
            ->setIdConsumer($id_consumer)
            ->setIdReport($id_report)
            ->setAction($action);

        $entityManager->persist($consumerAction);
        $entityManager->flush();
    }
}