<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\CompanySetting;
use App\Models\Department;
use App\Models\Traits\CompanyToken;
use App\Services\ResourceService\Interfaces\ResourceServiceInterface;
use Illuminate\Console\Command;

class ImportDepartment extends Command
{
    use CompanyToken;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:departments {company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var string
     */
    private $url;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = config('yandex.connect.directory_api.endpoint') . '/departments';
    }

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function handle()
    {
        $company = Company::where('name', $this->argument('company'))->firstOrFail();
        $token = $this->getCompanyToken($company->id);

        $resourceService = app()->make(ResourceServiceInterface::class, ['url' => $this->url, 'token' => $token]);

        $requestOptions = [
            'page' => 1,
            'fields' => 'name,head,parent_id,removed'
        ];

        $this->info('Starting the import....');

        while (true){
            $response = $resourceService->get($requestOptions);
            $result = $response->json();


            if ($response->clientError() || !$result['result']) {
                $this->info('Import finished');
                break;
            }

            foreach ($result['result'] as $yandexDepartment) {

                $department = Department::where('import_id', $yandexDepartment['id'])->first() ?? new Department();

                $department->fill([
                    'company_id' => $company->id,
                    'import_id' => $yandexDepartment['id'],
                    'name' =>  $yandexDepartment['name'],
                    'head_id' => $yandexDepartment['head'] ? $yandexDepartment['head']['id'] : null,
                    'removed'=> (bool) $yandexDepartment['removed'],
                    'parent_id'=> $yandexDepartment['parent_id'],
                ]);

                $department->saveQuietly();
            }

            $requestOptions['page']++;
        }
    }
}
