<?php

namespace ChewBoots\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Aws\S3\S3Client;
use Symfony\Component\Console\Input\InputOption;

class UploadS3Command extends Command
{
    /**
     * @var S3Client
     */
    private $awsClient;

    public function __construct(S3Client $client = null)
    {
        $this->awsClient = $client ?? new S3Client([
            'region' => 'us-east-1',
            'version' => '2006-03-01',
            'signature_version' => 'v4'
        ]);
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('chew-boots:s3:upload')
            ->setDescription('Upload txt file to S3.')
            ->setHelp('This command allows to upload a file to S3.')
            ->addArgument('content', InputArgument::REQUIRED, 'Content of the file')
            ->addOption('bucket', null, InputOption::VALUE_REQUIRED, 'Name of the bucket', 'chew-boots')
            ->addOption('filename', null, InputOption::VALUE_REQUIRED, 'Name of the file', date('YmdHis').'.txt');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this
            ->awsClient
            ->putObject(array(
                'Bucket' => $input->getOption('bucket'),
                'Key'    => $input->getOption('filename'),
                'Body'   => $input->getArgument('content')
            ));

        $output->writeln($result['ObjectURL']);
    }
}
