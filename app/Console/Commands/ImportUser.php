<?php

namespace App\Console\Commands;

use App\Enums\UserStatus;
use App\Models\Company;
use App\Models\Department;
use App\Models\Traits\CompanyToken;
use App\Models\User;
use App\Services\ResourceService\Interfaces\ResourceServiceInterface;
use Illuminate\Console\Command;

class ImportUser extends Command
{
    use CompanyToken;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {organization_name}';

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
        $this->url = config('yandex.connect.directory_api.endpoint') . '/users';
    }

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $company = Company::where('name', $this->argument('organization_name'))->firstOrFail();
        $token = $this->getCompanyToken($company->id);

        $resourceService = app()->make(ResourceServiceInterface::class, ['url' => $this->url, 'token' => $token]);

        $requestOptions = [
            'page' => 1,
            'fields' => 'name,department_id,position,email,nickname,is_dismissed'
        ];

        $this->info('Starting the import....');

        while (true){
            $response = $resourceService->get($requestOptions);
            $result = $response->json();

            if ($response->clientError() || !$result['result']) {
                $this->info('Import finished');
                break;
            }

            foreach ($result['result'] as $importedUser) {

                $user = User::where('import_id', $importedUser['id'])->first() ?? new User;

                $department = Department::where('import_id', $importedUser['department_id'])->first();

                $user->fill([
                    'import_id' => $importedUser['id'],
                    'department_id' => $department ? $department->id : null,
                    'name' => $importedUser['name']['first'],
                    'surname' => $importedUser['name']['last'],
                    'position' => $importedUser['position'],
                    'email' => $importedUser['email'],
                    'nickname' => $importedUser['nickname'],
                    'status' => $importedUser['is_dismissed'] === false ? UserStatus::ACTIVE : UserStatus::DISMISSED
                ]);

                $user->saveQuietly();
            }

            $requestOptions['page']++;
        }
    }
}
