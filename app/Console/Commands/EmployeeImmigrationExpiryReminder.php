<?php

namespace App\Console\Commands;

use App\Models\department;
use App\Models\EmployeeImmigration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeImmigrationExpiryNotify;
use App\Notifications\EmployeeImmigrationExpiryNotifyToAdmin;

class EmployeeImmigrationExpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employeeImmigration:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any document is being expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seven     = now()->addDays(7)->format('Y-m-d');
		$fifteen   = now()->addDays(15)->format('Y-m-d');
        $one_month = now()->addDays(30)->format('Y-m-d');

        $employee_immigrations = EmployeeImmigration::with('employee','DocumentType')
                                ->whereIn('expiry_date',[$seven,$fifteen,$one_month])
                                ->get();
        $data = [];

		if($employee_immigrations->isNotEmpty())
		{
			foreach ($employee_immigrations as $key => $item)
			{
                $department = department::with('DepartmentHead:id,email')->where('id',$item->employee->department_id)->first();

                $data[$key]['document_number'] = $item->document_number;
                $data[$key]['document_type']   = $item->DocumentType->document_type;
                $data[$key]['expiry_date']     = $item->expiry_date;
                $data[$key]['department_head-email'] = $department->DepartmentHead->email;

				$when = now()->addSeconds(30);
				Notification::route('mail', $data[$key]['department_head-email'])
					->notify((new EmployeeImmigrationExpiryNotify(
						$data[$key]['document_number'],
                        $data[$key]['expiry_date'],
                        $data[$key]['document_type']))->delay(($when)));

                //New
                $notifiable = User::where('role_users_id',1)->get();
                foreach ($notifiable as $item) {
                    $item->notify(new EmployeeImmigrationExpiryNotifyToAdmin());
                }
			}
		}
		else
		{
			return '';
        }
        $this->info('Successfully sent.');
    }
}

//ImmigratinExpiry Notification send to Dept.Head through mail
//ImmigratinExpiry Notification send to Admin through the system default notification
// Command - php artisan employeeImmigration:expiry

/**
 *  let in database expiry data = 30.01.2022
 *
 *  $seven     = now()->addDays(7)->format('Y-m-d');
 *  if current date ($seven) is 23.01.23 Then it will give result
 *
 * https://www.positronx.io/laravel-cron-job-task-scheduling-tutorial-with-example/
 */
