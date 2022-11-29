<?php
    //include AWS SDK for S3 Doc storage
    require 'vendor/autoload.php';

    class S3Bucket {
        private $client;
        private $secret;
        private $region;
        private $s3;


        public function __construct(){
            $this->client = getenv('AWS_ID', false);
            $this->secret = getenv('AWS_SECRET', false);
            $this->region = 'us-east-2';
        }



        public function connect() {
            //connects to S3 Bucket
            $this->s3 = null;
            try {
                $this->s3 = new Aws\S3\S3Client([
                    'region' => $this->region,
                    'version' => 'latest',
                    'credentials' => [
                        'key' => $this->client,
                        'secret' => $this->secret,
                    ]
                ]);

            }
            catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
            return $this->s3;
        }
    }
?>