<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\EquipmentCopy;
use App\Repository\EquipmentCopyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test', description: 'Hello PhpStorm')]
class TestCommand extends Command
{
    public function __construct(
       private EntityManagerInterface $manager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $eq = (new EquipmentCopy())
            ->setName('dawdd')
            ->setType('dadwdwad')
            ->setEmployee(null)
            ->setModel('dadawd')
            ->setQuality('dawdwad')
            ->setStatus('dawddwa')
            ->setDatebuy(new \DateTimeImmutable())
            ->setSerialnum('3123123dawdad');
        $this->manager->persist($eq);
        $this->manager->flush();
        return Command::SUCCESS;
    }
}
