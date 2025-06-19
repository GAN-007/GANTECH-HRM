<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\traits\ENVFilePutContent;
use App\Models\FinanceBankCash;
use App\Models\GeneralSetting;
use App\Models\LeaveType;
use App\Notifications\EmployeeLeaveNotification;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Dotenv;

use function config;
use ZipArchive;


class GeneralSettingController extends Controller
{
    use ENVFilePutContent;

	public function index()
	{
		if (auth()->user()->can('view-general-setting'))
		{
			$general_settings_data = GeneralSetting::latest()->first();
			$accounts = FinanceBankCash::all('id', 'account_name');
			$zones_array = array();
			$timestamp = time();


			foreach (timezone_identifiers_list() as $key => $zone)
			{
				date_default_timezone_set($zone);
				$zones_array[$key]['zone'] = $zone;
				$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
			}

			return view('settings.general_settings.index', compact('general_settings_data', 'zones_array', 'accounts'));
		}

		return abort('403', __('You are not authorized'));
	}

    protected function test()
    {
        // Notification::route('mail', 'irfanchowdhury80@gmail.com')
        // ->notify(new EmployeeLeaveNotification(
        //     'Irfan Chowdhury',
        //     '12',
        //     '2023-04-19',
        //     '2023-04-24',
        //     'Test',
        // ));
        // return 'ok';
    }


	public function update(Request $request, $id)
	{
        // return $this->test();

		if (auth()->user()->can('store-general-setting'))
		{
			if(!env('USER_VERIFIED'))
			{
                $this->setErrorMessage('This feature is disabled for demo!');
                return redirect()->back();
			}

			$this->validate($request, [
				'site_logo' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
			]);

			$data = $request->all();

			//writting timezone info in .env file
            $this->dataWriteInENVFile('APP_TIMEZONE',$request->timezone);
            $this->dataWriteInENVFile('Date_Format',$request->date_format);
			$js_format = config('date_format_conversion.' . $request->date_format);
            $this->dataWriteInENVFile('Date_Format_JS',$js_format);
            $this->dataWriteInENVFile('RTL_LAYOUT',$request->input('rtl_layout', NULL));
            $this->dataWriteInENVFile('ENABLE_CLOCKIN_CLOCKOUT',$request->input('enable_clockin_clockout', NULL));
            $this->dataWriteInENVFile('ENABLE_EARLY_CLOCKIN',$request->input('enable_early_clockin', NULL));
            $this->dataWriteInENVFile('ATTENDANCE_DEVICE_DATE_FORMAT',$request->Attendance_Device_date_format ? $request->Attendance_Device_date_format : 'm/d/Y');

			$path = base_path('config/variable.php');

			$searchArray = array(
				config('variable.currency'),
				config('variable.currency_format'), config('variable.account_id'));

			$replaceArray = array($request->currency, $request->currency_format, $request->account_id);

			file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));


			$general_setting = GeneralSetting::findOrFail($id);
			$general_setting->id = 1;
			$general_setting->site_title = $data['site_title'];
			$general_setting->time_zone = $data['timezone'];
			$general_setting->currency = $data['currency'];
			$general_setting->currency_format = $data['currency_format'];
			$general_setting->date_format = $data['date_format'];
			$general_setting->default_payment_bank = $data['account_id'];
			$general_setting->footer = $request->footer;
			$general_setting->footer_link = $request->footer_link;

			$logo = $request->site_logo;


			if ($logo)
			{
				$file_path = $general_setting->site_logo;

				if ($file_path)
				{
					$file_path = public_path('images/logo/' . $file_path);

					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}

				$ext = pathinfo($logo->getClientOriginalName(), PATHINFO_EXTENSION);
				$logoName = 'logo.' . $ext;
				$logo->move(public_path('images/logo'), $logoName);
				$general_setting->site_logo = $logoName;

			}
			$general_setting->save();

            $this->setErrorMessage('Data updated successfully');
            return redirect()->back();
		}

		return abort('403', __('You are not authorized'));
	}


	public function mailSetting()
	{
		if (auth()->user()->can('view-mail-setting'))
		{
			return view('settings.mail_setting.mail');
		}
		return abort('403', __('You are not authorized'));
	}

	public function mailSettingStore(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return redirect()->back()->with('msg', 'This feature is disable for demo!');
		}

		if (auth()->user()->can('view-mail-setting'))
		{

            $this->dataWriteInENVFile('MAIL_HOST',$request->mail_host);
            $this->dataWriteInENVFile('MAIL_PORT',$request->port);
            $this->dataWriteInENVFile('MAIL_FROM_ADDRESS',$request->mail_address);
            $this->dataWriteInENVFile('MAIL_PASSWORD',$request->password);
            $this->dataWriteInENVFile('MAIL_FROM_NAME',".'$request->mail_name'.");
            $this->dataWriteInENVFile('MAIL_ENCRYPTION',$request->encryption);
			return redirect()->back()->with('message', 'Data updated successfully');


			//writting mail info in .env file
            // $data = $request->all();
			// $path = '.env';
			// $searchArray = array('MAIL_HOST="' . env('MAIL_HOST') . '"', 'MAIL_PORT=' . env('MAIL_PORT'), 'MAIL_FROM_ADDRESS="' . env('MAIL_FROM_ADDRESS') . '"', 'MAIL_FROM_NAME="' . env('MAIL_FROM_NAME') . '"', 'MAIL_USERNAME="' . env('MAIL_USERNAME') . '"', 'MAIL_PASSWORD="' . env('MAIL_PASSWORD') . '"', 'MAIL_ENCRYPTION="' . env('MAIL_ENCRYPTION') . '"');
			// // $searchArray = array('MAIL_HOST=' . env('MAIL_HOST'),'MAIL_PORT=' . env('MAIL_PORT'),'MAIL_FROM_ADDRESS=' . env('MAIL_FROM_ADDRESS'),'MAIL_FROM_NAME=' . env('MAIL_FROM_NAME'),'MAIL_USERNAME=' . env('MAIL_USERNAME'),'MAIL_PASSWORD=' . env('MAIL_PASSWORD'),'MAIL_ENCRYPTION=' . env('MAIL_ENCRYPTION'));
			// $replaceArray = array('MAIL_HOST="' . $data['mail_host'] . '"', 'MAIL_PORT=' . $data['port'], 'MAIL_FROM_ADDRESS="' . $data['mail_address'] . '"', 'MAIL_FROM_NAME="' . $data['mail_name'] . '"', 'MAIL_USERNAME="' . $data['mail_address'] . '"', 'MAIL_PASSWORD="' . $data['password'] . '"', 'MAIL_ENCRYPTION="' . $data['encryption'] . '"');
			// file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));
			// return redirect()->back()->with('message', 'Data updated successfully');
		}
		return abort('403', __('You are not authorized'));
	}

	public function emptyDatabase()
	{
		if(!env('USER_VERIFIED')) {
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}
		DB::statement("SET foreign_key_checks=0");
		$tables = DB::select('SHOW TABLES');
		$str = 'Tables_in_' . env('DB_DATABASE');

        $employeeIds =  Employee::get()->pluck('id');
        User::whereIn('id',$employeeIds)->delete();

		foreach ($tables as $table) {
			// if($table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'role_users' && $table->$str != 'general_settings'  && $table->$str != 'migrations' && $table->$str != 'password_resets' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users') {
			if($table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'general_settings'  && $table->$str != 'migrations' && $table->$str != 'password_resets' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users') {
				DB::table($table->$str)->truncate();
			}
		}
        LeaveType::create(['leave_type'=>'Others','allocated_day'=>0]);

		DB::statement("SET foreign_key_checks=1");

		return redirect()->back()->with('msg', 'Database cleared successfully');
	}

	public function exportDatabase()
	{
		if(!env('USER_VERIFIED'))
		{
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}
		// Database configuration
		$host = env('DB_HOST');
		$username = env('DB_USERNAME');
		$password = env('DB_PASSWORD');
		$database_name = env('DB_DATABASE');

		// Get connection object and set the charset
		$conn = mysqli_connect($host, $username, $password, $database_name);
		$conn->set_charset("utf8");


		// Get All Table Names From the Database
		$tables = array();
		$sql = "SHOW TABLES";
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}

		$sqlScript = "SET foreign_key_checks = 0;";

		foreach ($tables as $table) {
			// Prepare SQLscript for creating table structure
			$query = "SHOW CREATE TABLE $table";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_row($result);

			$sqlScript .= "\n\n" . $row[1] . ";\n\n";


			$query = "SELECT * FROM $table";
			$result = mysqli_query($conn, $query);

			$columnCount = mysqli_num_fields($result);

			// Prepare SQLscript for dumping data for each table
			for ($i = 0; $i < $columnCount; $i ++) {
				while ($row = mysqli_fetch_row($result)) {
					$sqlScript .= "INSERT INTO $table VALUES(";
					for ($j = 0; $j < $columnCount; $j ++) {
						if (isset($row[$j])) {
							$sqlScript .= "'" . addslashes($row[$j]) . "'";
						} else {
							$sqlScript .= "''";
						}
						if ($j < ($columnCount - 1)) {
							$sqlScript .= ',';
						}
					}
					$sqlScript .= ");\n";
				}
			}

			$sqlScript .= "\n";
		}
        $sqlScript .= "SET foreign_key_checks = 1;";

		if(!empty($sqlScript))
		{
			// Save the SQL script to a backup file
			$backup_file_name = public_path().'/'.$database_name . '_backup_' . time() . '.sql';
			//return $backup_file_name;
			$fileHandler = fopen($backup_file_name, 'w+');
			$number_of_lines = fwrite($fileHandler, $sqlScript);
			fclose($fileHandler);

			$zip = new ZipArchive();
			$zipFileName = $database_name . '_backup_' . time() . '.zip';
			$zip->open(public_path() . '/' . $zipFileName, ZipArchive::CREATE);
			$zip->addFile($backup_file_name, $database_name . '_backup_' . time() . '.sql');
			$zip->close();

			// Download the SQL backup file to the browser
			/*header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($backup_file_name));
			ob_clean();
			flush();
			readfile($backup_file_name);
			exec('rm ' . $backup_file_name); */
		}
		return redirect('/' . $zipFileName);
	}
}
