<?php

namespace App\Console\Commands;

use App\Coordinate;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\ClientException;

class StartDroid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'droid:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the droid';

    /**
     * Guzzle client to be instantiated
     *
     * @var null
     */
    protected $client = null;
    protected $map = null;
    protected $path = 'f';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // New guzzle client
        $this->client = new Client();

        $this->map = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        $this->info('Dispatching droid');
 
        $response = $this->sendApiRequest();

        // Done!
        $this->info('Done');
    }

    /**
     * sendApiRequest
     *
     * @return void
     */
    protected function sendApiRequest () 
    {
        $this->info('Trying path');
        $done = false;

        while (!$done) {
            
            $done = $this->tryPath();

            if ($done) {
                break;
            }
        }
    }

    public function tryPath () 
    {
        $this->info('Trying path ' . $this->path);

        try {

            $response = $this->client->request('GET', 'http://deathstar.victoriaplum.com/alliance.php', [
                'query' => [
                    'name' => 'becca',
                    'path' => $this->path,
                ]
            ]);

        } catch (ClientException $e) {
            // Get a picture of the map
            $responseObj = json_decode($e->getResponse()->getBody());

            $this->setMap($responseObj->map);

            $this->info($e->getResponse()->getBody());
            // If crash go again but try different value for path
            if ($e->getResponse()->getStatusCode() == 417) {
                $this->info('Droid has crashed');
                $this->setNewPath($responseObj->message);
            } elseif ($e->getResponse()->getStatusCode() == 410) {
                // Empty space, add this to our model
                $this->info('Droid has found empty space');

                // Keep going forward if we have hit empty space
                $this->path .= 'f';
                $this->tryPath();
            }
        }

        return true;
    }

    public function setMap ($map) 
    {
        $mapArray = [];
        $rows = explode('\n', $map);

        foreach ($rows as $index => $row) {
            $mapArray[$index] = str_split($row);
        }

        $this->map = $mapArray;

        $this->info(print_r($this->map));
    }

    public function setNewPath ($message)
    {
        // Get the current position we are at
        preg_match_all('/(\d*)(?:,)(\d*)/m', $message, $coords, PREG_SET_ORDER, 0);

        if (!empty($coords)) {
            // Go to current X row in array
            $currentRow = $this->map[$coords[0]];
            // Check if a space next to us on either side is empty, if so set the direction to the empty space

            foreach ($currentRow as $index => $column) {
                // Check if the closest space is greater than or less than the current index on the Y axis
                
            }
        }
        
    }
}
