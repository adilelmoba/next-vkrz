<?php

namespace App\Command;

use App\Entity\Album;
use App\Entity\Comment;
use App\Entity\Photo;
use App\Entity\Post;

use App\Entity\Todo;
use Symfony\Component\HttpClient\HttpClient;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:fetch-api',
    description: 'Fetches data from external API to the project.',
)]
class FetchApiCommand extends Command
{
    use ContainerAwareTrait;
    protected  $container;
    private SerializerInterface $serializer;

    public function __construct(ContainerInterface $container, SerializerInterface $serializer)
    {
        $this->container = $container;
        $this->serializer = $serializer;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fetches data from external API to the project.');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Fetching data from JSONPlaceholder API');

        $endpoints = [
            'posts'    => Post::class,
            'comments' => Comment::class,
            'albums'   => Album::class,
            'photos'   => Photo::class,
            'todos'    => Todo::class,
        ];

        $em = $this->container->get('doctrine')->getManager();

        foreach ($endpoints as $endpoint => $entityClass) {
            $client = HttpClient::create();
            $response = $client->request('GET', "https://jsonplaceholder.typicode.com/$endpoint");
            $data = $response->getContent();
            $entities = $this->serializer->deserialize($data, $entityClass.'[]', 'json');

            foreach ($entities as $entity) {
                $em->persist($entity);
            }

            $em->flush();
            $io->success(count($entities).' '.$entityClass.' entities have been saved to the database');
        }

        return Command::SUCCESS;
    }
}
