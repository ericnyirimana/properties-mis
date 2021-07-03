<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PropertyService;
use Illuminate\Http\Client\Response;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class pushProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushProperties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch properties and push them into the DB';

    /**
     * Total property records to save
     *
     */
    protected $maximumPropertiesRecords = 300;

    /**
     * Total properties per page
     *
     */
    protected $propertiesRecordPerPage = 30;

    /**
     * This is for fetching calling and accessing the fetch property API .
     *
     */
    protected $fetchProperties;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PropertyService $fetchProperties)
    {
        parent::__construct();
        $this->fetchProperties = $fetchProperties;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $totalPages = $this->maximumPropertiesRecords / $this->propertiesRecordPerPage;
        try {
            echo '...';
            DB::beginTransaction();
            for($i = 1; $i <= $totalPages; $i++){
                $pageNumber = $i;
                $response = $this->fetchProperties->getPropertiesPerPage($pageNumber, $this->propertiesRecordPerPage);
                if($response->status() === 200){
                    $responeToJson = json_decode($response->body(), true);
                    foreach($responeToJson['data'] as $data){
                        PropertyType::firstOrCreate(
                            [
                                'id' => $data['property_type_id']
                            ],
                            [
                                'title' => $data['property_type']['title'],
                                'description' => $data['property_type']['description'],
                                'created_at' => $data['property_type']['created_at'],
                                'updated_at' => $data['property_type']['updated_at'],
                            ]
                        );
                        
                        Property::firstOrCreate(
                            [
                                'uuid' => $data['uuid']
                            ],
                            [
                                'uuid' => $data['uuid'],
                                'property_type_id' => $data['property_type_id'],
                                'county' => $data['county'],
                                'country' => $data['country'],
                                'town' => $data['town'],
                                'description' => $data['description'],
                                'address' => $data['address'],
                                'image_full' => $data['image_full'],
                                'image_thumbnail' => $data['image_thumbnail'],
                                'latitude' => $data['latitude'],
                                'longitude' => $data['longitude'],
                                'num_bedrooms' => $data['num_bedrooms'],
                                'num_bathrooms' => $data['num_bathrooms'],
                                'price' => $data['price'],
                                'type' => $data['type'],
                                'created_at' => $data['created_at'],
                                'updated_at' => $data['updated_at'],
                            ]
                        );
                    }
                }
                else{
                    return $this->error("Oops, something went wrong, comeback later");
                }
                if($pageNumber === $totalPages){
                    $this->info("Operation done successfully!");
                }
            DB::commit();
            }
        } catch (\Throwable $e) {
            Log::error('An error occurred when pushing properties : {' . $e->getMessage() . '})');
            $this->error("Oops, something went wrong, comeback later");
            DB::rollback();
            return 1;
        }
        return 0;
    }
}
