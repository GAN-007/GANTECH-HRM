<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    // php artisan db:seed --class=PermissionsSeeder

    public function run()
    {
		DB::table('permissions')->delete();

		$permissions = array(
			array(
				'id' => 1,
				'guard_name' => 'web',
				'name' => 'user'
			),
			array(
				'id' => 2,
				'guard_name' => 'web',
				'name' => 'view-user'
			),
			array(
				'id' => 3,
				'guard_name' => 'web',
				'name' => 'edit-user'
			),
			array(
				'id' => 4,
				'guard_name' => 'web',
				'name' => 'delete-user'
			),
			array(
				'id' => 5,
				'guard_name' => 'web',
				'name' => 'last-login-user'
			),
			array(
				'id' => 6,
				'guard_name' => 'web',
				'name' => 'role-access-user'
			),
			array(
				'id' => 7,
				'guard_name' => 'web',
				'name' => 'details-employee'
			),
			array(
				'id' => 8,
				'guard_name' => 'web',
				'name' => 'view-details-employee'
			),
			array(
				'id' => 9,
				'guard_name' => 'web',
				'name' => 'store-details-employee'
			),
			array(
				'id' => 10,
				'guard_name' => 'web',
				'name' => 'modify-details-employee'
			),
			array(
				'id' => 11,
				'guard_name' => 'web',
				'name' => 'customize-setting'
			),
			array(
				'id' => 12,
				'guard_name' => 'web',
				'name' => 'role-access'
			),
			array(
				'id' => 13,
				'guard_name' => 'web',
				'name' => 'general-setting'
			),
			array(
				'id' => 14,
				'guard_name' => 'web',
				'name' => 'view-general-setting'
			),
			array(
				'id' => 15,
				'guard_name' => 'web',
				'name' => 'store-general-setting'
			),
			array(
				'id' => 16,
				'guard_name' => 'web',
				'name' => 'mail-setting'
			),
			array(
				'id' => 17,
				'guard_name' => 'web',
				'name' => 'view-mail-setting'
			),
			array(
				'id' => 18,
				'guard_name' => 'web',
				'name' => 'store-mail-setting'
			),
			array(
				'id' => 19,
				'guard_name' => 'web',
				'name' => 'language-setting'
			),
			array(
				'id' => 20,
				'guard_name' => 'web',
				'name' => 'core_hr'
			),
			array(
				'id' => 21,
				'guard_name' => 'web',
				'name' => 'view-calendar'
			),
			array(
				'id' => 22,
				'guard_name' => 'web',
				'name' => 'promotion'
			),
			array(
				'id' => 23,
				'guard_name' => 'web',
				'name' => 'view-promotion'
			),
			array(
				'id' => 24,
				'guard_name' => 'web',
				'name' => 'store-promotion'
			),
			array(
				'id' => 25,
				'guard_name' => 'web',
				'name' => 'edit-promotion'
			),
			array(
				'id' => 26,
				'guard_name' => 'web',
				'name' => 'delete-promotion'
			),
			array(
				'id' => 27,
				'guard_name' => 'web',
				'name' => 'award'
			),
			array(
				'id' => 28,
				'guard_name' => 'web',
				'name' => 'view-award'
			),
			array(
				'id' => 29,
				'guard_name' => 'web',
				'name' => 'store-award'
			),
			array(
				'id' => 30,
				'guard_name' => 'web',
				'name' => 'edit-award'
			),
			array(
				'id' => 31,
				'guard_name' => 'web',
				'name' => 'delete-award'
			),
			array(
				'id' => 32,
				'guard_name' => 'web',
				'name' => 'transfer'
			),
			array(
				'id' => 33,
				'guard_name' => 'web',
				'name' => 'view-transfer'
			),
			array(
				'id' => 34,
				'guard_name' => 'web',
				'name' => 'store-transfer'
			),
			array(
				'id' => 35,
				'guard_name' => 'web',
				'name' => 'edit-transfer'
			),
			array(
				'id' => 36,
				'guard_name' => 'web',
				'name' => 'delete-transfer'
			),
			array(
				'id' => 37,
				'guard_name' => 'web',
				'name' => 'travel'
			),
			array(
				'id' => 38,
				'guard_name' => 'web',
				'name' => 'view-travel'
			),
			array(
				'id' => 39,
				'guard_name' => 'web',
				'name' => 'store-travel'
			),
			array(
				'id' => 40,
				'guard_name' => 'web',
				'name' => 'edit-travel'
			),
			array(
				'id' => 41,
				'guard_name' => 'web',
				'name' => 'delete-travel'
			),
			array(
				'id' => 42,
				'guard_name' => 'web',
				'name' => 'resignation'
			),
			array(
				'id' => 43,
				'guard_name' => 'web',
				'name' => 'view-resignation'
			),
			array(
				'id' => 44,
				'guard_name' => 'web',
				'name' => 'store-resignation'
			),
			array(
				'id' => 45,
				'guard_name' => 'web',
				'name' => 'edit-resignation'
			),
			array(
				'id' => 46,
				'guard_name' => 'web',
				'name' => 'delete-resignation'
			),
			array(
				'id' => 47,
				'guard_name' => 'web',
				'name' => 'complaint'
			),
			array(
				'id' => 48,
				'guard_name' => 'web',
				'name' => 'view-complaint'
			),
			array(
				'id' => 49,
				'guard_name' => 'web',
				'name' => 'store-complaint'
			),
			array(
				'id' => 50,
				'guard_name' => 'web',
				'name' => 'edit-complaint'
			),
			array(
				'id' => 51,
				'guard_name' => 'web',
				'name' => 'delete-complaint'
			),
			array(
				'id' => 52,
				'guard_name' => 'web',
				'name' => 'warning'
			),
			array(
				'id' => 53,
				'guard_name' => 'web',
				'name' => 'view-warning'
			),
			array(
				'id' => 54,
				'guard_name' => 'web',
				'name' => 'store-warning'
			),
			array(
				'id' => 55,
				'guard_name' => 'web',
				'name' => 'edit-warning'
			),
			array(
				'id' => 56,
				'guard_name' => 'web',
				'name' => 'delete-warning'
			),
			array(
				'id' => 57,
				'guard_name' => 'web',
				'name' => 'termination'
			),
			array(
				'id' => 58,
				'guard_name' => 'web',
				'name' => 'view-termination'
			),
			array(
				'id' => 59,
				'guard_name' => 'web',
				'name' => 'store-termination'
			),
			array(
				'id' => 60,
				'guard_name' => 'web',
				'name' => 'edit-termination'
			),
			array(
				'id' => 61,
				'guard_name' => 'web',
				'name' => 'delete-termination'
			),
			array(
				'id' => 62,
				'guard_name' => 'web',
				'name' => 'timesheet'
			),
			array(
				'id' => 63,
				'guard_name' => 'web',
				'name' => 'attendance'
			),
			array(
				'id' => 64,
				'guard_name' => 'web',
				'name' => 'view-attendance'
			),
			array(
				'id' => 65,
				'guard_name' => 'web',
				'name' => 'edit-attendance'
			),
			array(
				'id' => 66,
				'guard_name' => 'web',
				'name' => 'office_shift'
			),
			array(
				'id' => 67,
				'guard_name' => 'web',
				'name' => 'view-office_shift'
			),
			array(
				'id' => 68,
				'guard_name' => 'web',
				'name' => 'store-office_shift'
			),
			array(
				'id' => 69,
				'guard_name' => 'web',
				'name' => 'edit-office_shift'
			),
			array(
				'id' => 70,
				'guard_name' => 'web',
				'name' => 'delete-office_shift'
			),
			array(
				'id' => 71,
				'guard_name' => 'web',
				'name' => 'holiday'
			),
			array(
				'id' => 72,
				'guard_name' => 'web',
				'name' => 'view-holiday'
			),
			array(
				'id' => 73,
				'guard_name' => 'web',
				'name' => 'store-holiday'
			),
			array(
				'id' => 74,
				'guard_name' => 'web',
				'name' => 'edit-holiday'
			),
			array(
				'id' => 75,
				'guard_name' => 'web',
				'name' => 'delete-holiday'
			),
			array(
				'id' => 76,
				'guard_name' => 'web',
				'name' => 'leave'
			),
			array(
				'id' => 77,
				'guard_name' => 'web',
				'name' => 'view-holiday'
			),
			array(
				'id' => 78,
				'guard_name' => 'web',
				'name' => 'store-holiday'
			),
			array(
				'id' => 79,
				'guard_name' => 'web',
				'name' => 'edit-holiday'
			),
			array(
				'id' => 80,
				'guard_name' => 'web',
				'name' => 'delete-holiday'
			),
			array(
				'id' => 81,
				'guard_name' => 'web',
				'name' => 'payment-module'
			),
			array(
				'id' => 82,
				'guard_name' => 'web',
				'name' => 'view-payslip'
			),
			array(
				'id' => 83,
				'guard_name' => 'web',
				'name' => 'make-payment'
			),
			array(
				'id' => 84,
				'guard_name' => 'web',
				'name' => 'make-bulk_payment'
			),
			array(
				'id' => 85,
				'guard_name' => 'web',
				'name' => 'view-paylist'
			),
			array(
				'id' => 86,
				'guard_name' => 'web',
				'name' => 'set-salary'
			),
			array(
				'id' => 87,
				'guard_name' => 'web',
				'name' => 'hr_report'
			),
			array(
				'id' => 88,
				'guard_name' => 'web',
				'name' => 'report-payslip'
			),
			array(
				'id' => 89,
				'guard_name' => 'web',
				'name' => 'report-attendance'
			),
			array(
				'id' => 90,
				'guard_name' => 'web',
				'name' => 'report-training'
			),
			array(
				'id' => 91,
				'guard_name' => 'web',
				'name' => 'report-project'
			),
			array(
				'id' => 92,
				'guard_name' => 'web',
				'name' => 'report-task'
			),
			array(
				'id' => 93,
				'guard_name' => 'web',
				'name' => 'report-employee'
			),
			array(
				'id' => 94,
				'guard_name' => 'web',
				'name' => 'report-account'
			),
			array(
				'id' => 95,
				'guard_name' => 'web',
				'name' => 'report-deposit'
			),
			array(
				'id' => 96,
				'guard_name' => 'web',
				'name' => 'report-expense'
			),
			array(
				'id' => 97,
				'guard_name' => 'web',
				'name' => 'report-transaction'
			),
			array(
				'id' => 98,
				'guard_name' => 'web',
				'name' => 'recruitment'
			),
			array(
				'id' => 99,
				'guard_name' => 'web',
				'name' => 'job_employer'
			),
			array(
				'id' => 100,
				'guard_name' => 'web',
				'name' => 'view-job_employer'
			),
			array(
				'id' => 101,
				'guard_name' => 'web',
				'name' => 'store-job_employer'
			),
			array(
				'id' => 102,
				'guard_name' => 'web',
				'name' => 'edit-job_employer'
			),
			array(
				'id' => 103,
				'guard_name' => 'web',
				'name' => 'delete-job_employer'
			),
			array(
				'id' => 104,
				'guard_name' => 'web',
				'name' => 'job_post'
			),
			array(
				'id' => 105,
				'guard_name' => 'web',
				'name' => 'view-job_post'
			),
			array(
				'id' => 106,
				'guard_name' => 'web',
				'name' => 'store-job_post'
			),
			array(
				'id' => 107,
				'guard_name' => 'web',
				'name' => 'edit-job_post'
			),
			array(
				'id' => 108,
				'guard_name' => 'web',
				'name' => 'delete-job_post'
			),
			array(
				'id' => 109,
				'guard_name' => 'web',
				'name' => 'job_candidate'
			),
			array(
				'id' => 110,
				'guard_name' => 'web',
				'name' => 'view-job_candidate'
			),
			array(
				'id' => 111,
				'guard_name' => 'web',
				'name' => 'store-job_candidate'
			),
			array(
				'id' => 112,
				'guard_name' => 'web',
				'name' => 'delete-job_candidate'
			),
			array(
				'id' => 113,
				'guard_name' => 'web',
				'name' => 'job_interview'
			),
			array(
				'id' => 114,
				'guard_name' => 'web',
				'name' => 'view-job_interview'
			),
			array(
				'id' => 115,
				'guard_name' => 'web',
				'name' => 'store-job_interview'
			),
			array(
				'id' => 116,
				'guard_name' => 'web',
				'name' => 'delete-job_interview'
			),
			array(
				'id' => 117,
				'guard_name' => 'web',
				'name' => 'project-management'
			),
			array(
				'id' => 118,
				'guard_name' => 'web',
				'name' => 'project'
			),
			array(
				'id' => 119,
				'guard_name' => 'web',
				'name' => 'view-project'
			),
			array(
				'id' => 120,
				'guard_name' => 'web',
				'name' => 'store-project'
			),
			array(
				'id' => 121,
				'guard_name' => 'web',
				'name' => 'edit-project'
			),
			array(
				'id' => 122,
				'guard_name' => 'web',
				'name' => 'delete-project'
			),
			array(
				'id' => 123,
				'guard_name' => 'web',
				'name' => 'task'
			),
			array(
				'id' => 124,
				'guard_name' => 'web',
				'name' => 'view-task'
			),
			array(
				'id' => 125,
				'guard_name' => 'web',
				'name' => 'store-task'
			),
			array(
				'id' => 126,
				'guard_name' => 'web',
				'name' => 'edit-task'
			),
			array(
				'id' => 127,
				'guard_name' => 'web',
				'name' => 'delete-task'
			),
			array(
				'id' => 128,
				'guard_name' => 'web',
				'name' => 'client'
			),
			array(
				'id' => 129,
				'guard_name' => 'web',
				'name' => 'view-client'
			),
			array(
				'id' => 130,
				'guard_name' => 'web',
				'name' => 'store-client'
			),
			array(
				'id' => 131,
				'guard_name' => 'web',
				'name' => 'edit-client'
			),
			array(
				'id' => 132,
				'guard_name' => 'web',
				'name' => 'delete-client'
			),
			array(
				'id' => 133,
				'guard_name' => 'web',
				'name' => 'invoice'
			),
			array(
				'id' => 134,
				'guard_name' => 'web',
				'name' => 'view-invoice'
			),
			array(
				'id' => 135,
				'guard_name' => 'web',
				'name' => 'store-invoice'
			),
			array(
				'id' => 136,
				'guard_name' => 'web',
				'name' => 'edit-invoice'
			),
			array(
				'id' => 137,
				'guard_name' => 'web',
				'name' => 'delete-invoice'
			),
			array(
				'id' => 138,
				'guard_name' => 'web',
				'name' => 'ticket'
			),
			array(
				'id' => 139,
				'guard_name' => 'web',
				'name' => 'view-ticket'
			),
			array(
				'id' => 140,
				'guard_name' => 'web',
				'name' => 'store-ticket'
			),
			array(
				'id' => 141,
				'guard_name' => 'web',
				'name' => 'edit-ticket'
			),
			array(
				'id' => 142,
				'guard_name' => 'web',
				'name' => 'delete-ticket'
			),
			array(
				'id' => 143,
				'guard_name' => 'web',
				'name' => 'import-module'
			),
			array(
				'id' => 144,
				'guard_name' => 'web',
				'name' => 'import-attendance'
			),
			array(
				'id' => 145,
				'guard_name' => 'web',
				'name' => 'import-employee'
			),
			array(
				'id' => 146,
				'guard_name' => 'web',
				'name' => 'file_module'
			),
			array(
				'id' => 147,
				'guard_name' => 'web',
				'name' => 'file_manager'
			),
			array(
				'id' => 148,
				'guard_name' => 'web',
				'name' => 'view-file_manager'
			),
			array(
				'id' => 149,
				'guard_name' => 'web',
				'name' => 'store-file_manager'
			),
			array(
				'id' => 150,
				'guard_name' => 'web',
				'name' => 'edit-file_manager'
			),
			array(
				'id' => 151,
				'guard_name' => 'web',
				'name' => 'delete-file_manager'
			),
			array(
				'id' => 152,
				'guard_name' => 'web',
				'name' => 'view-file_config'
			),
			array(
				'id' => 153,
				'guard_name' => 'web',
				'name' => 'official_document'
			),
			array(
				'id' => 154,
				'guard_name' => 'web',
				'name' => 'view-official_document'
			),
			array(
				'id' => 155,
				'guard_name' => 'web',
				'name' => 'store-official_document'
			),
			array(
				'id' => 156,
				'guard_name' => 'web',
				'name' => 'edit-official_document'
			),
			array(
				'id' => 157,
				'guard_name' => 'web',
				'name' => 'delete-official_document'
			),
			array(
				'id' => 158,
				'guard_name' => 'web',
				'name' => 'event-meeting'
			),
			array(
				'id' => 159,
				'guard_name' => 'web',
				'name' => 'meeting'
			),
			array(
				'id' => 160,
				'guard_name' => 'web',
				'name' => 'view-meeting'
			),
			array(
				'id' => 161,
				'guard_name' => 'web',
				'name' => 'store-meeting'
			),
			array(
				'id' => 162,
				'guard_name' => 'web',
				'name' => 'edit-meeting'
			),
			array(
				'id' => 163,
				'guard_name' => 'web',
				'name' => 'delete-meeting'
			),
			array(
				'id' => 164,
				'guard_name' => 'web',
				'name' => 'event'
			),
			array(
				'id' => 165,
				'guard_name' => 'web',
				'name' => 'view-event'
			),
			array(
				'id' => 166,
				'guard_name' => 'web',
				'name' => 'store-event'
			),
			array(
				'id' => 167,
				'guard_name' => 'web',
				'name' => 'edit-event'
			),
			array(
				'id' => 168,
				'guard_name' => 'web',
				'name' => 'delete-event'
			),
			array(
				'id' => 169,
				'guard_name' => 'web',
				'name' => 'role'
			),
			array(
				'id' => 170,
				'guard_name' => 'web',
				'name' => 'view-role'
			),
			array(
				'id' => 171,
				'guard_name' => 'web',
				'name' => 'store-role'
			),
			array(
				'id' => 172,
				'guard_name' => 'web',
				'name' => 'edit-role'
			),
			array(
				'id' => 173,
				'guard_name' => 'web',
				'name' => 'delete-role'
			),
			array(
				'id' => 174,
				'guard_name' => 'web',
				'name' => 'assign-module'
			),
			array(
				'id' => 175,
				'guard_name' => 'web',
				'name' => 'assign-role'
			),
			array(
				'id' => 176,
				'guard_name' => 'web',
				'name' => 'assign-ticket'
			),
			array(
				'id' => 177,
				'guard_name' => 'web',
				'name' => 'assign-project'
			),
			array(
				'id' => 178,
				'guard_name' => 'web',
				'name' => 'assign-task'
			),
			array(
				'id' => 179,
				'guard_name' => 'web',
				'name' => 'finance'
			),
			array(
				'id' => 180,
				'guard_name' => 'web',
				'name' => 'account'
			),
			array(
				'id' => 181,
				'guard_name' => 'web',
				'name' => 'view-account'
			),
			array(
				'id' => 182,
				'guard_name' => 'web',
				'name' => 'store-account'
			),
			array(
				'id' => 183,
				'guard_name' => 'web',
				'name' => 'edit-account'
			),
			array(
				'id' => 184,
				'guard_name' => 'web',
				'name' => 'delete-account'
			),
			array(
				'id' => 185,
				'guard_name' => 'web',
				'name' => 'view-transaction'
			),
			array(
				'id' => 186,
				'guard_name' => 'web',
				'name' => 'view-balance_transfer'
			),
			array(
				'id' => 187,
				'guard_name' => 'web',
				'name' => 'store-balance_transfer'
			),
			array(
				'id' => 188,
				'guard_name' => 'web',
				'name' => 'expense'
			),
			array(
				'id' => 189,
				'guard_name' => 'web',
				'name' => 'view-expense'
			),
			array(
				'id' => 190,
				'guard_name' => 'web',
				'name' => 'store-expense'
			),
			array(
				'id' => 191,
				'guard_name' => 'web',
				'name' => 'edit-expense'
			),
			array(
				'id' => 192,
				'guard_name' => 'web',
				'name' => 'delete-expense'
			),
			array(
				'id' => 193,
				'guard_name' => 'web',
				'name' => 'deposit'
			),
			array(
				'id' => 194,
				'guard_name' => 'web',
				'name' => 'view-deposit'
			),
			array(
				'id' => 195,
				'guard_name' => 'web',
				'name' => 'store-deposit'
			),
			array(
				'id' => 196,
				'guard_name' => 'web',
				'name' => 'edit-deposit'
			),
			array(
				'id' => 197,
				'guard_name' => 'web',
				'name' => 'delete-deposit'
			),
			array(
				'id' => 198,
				'guard_name' => 'web',
				'name' => 'payer'
			),
			array(
				'id' => 199,
				'guard_name' => 'web',
				'name' => 'view-payer'
			),
			array(
				'id' => 200,
				'guard_name' => 'web',
				'name' => 'store-payer'
			),
			array(
				'id' => 201,
				'guard_name' => 'web',
				'name' => 'edit-payer'
			),
			array(
				'id' => 202,
				'guard_name' => 'web',
				'name' => 'delete-payer'
			),
			array(
				'id' => 203,
				'guard_name' => 'web',
				'name' => 'payee'
			),
			array(
				'id' => 204,
				'guard_name' => 'web',
				'name' => 'view-payee'
			),
			array(
				'id' => 205,
				'guard_name' => 'web',
				'name' => 'store-payee'
			),
			array(
				'id' => 206,
				'guard_name' => 'web',
				'name' => 'edit-payee'
			),
			array(
				'id' => 207,
				'guard_name' => 'web',
				'name' => 'delete-payee'
			),
			array(
				'id' => 208,
				'guard_name' => 'web',
				'name' => 'training_module'
			),
			array(
				'id' => 209,
				'guard_name' => 'web',
				'name' => 'trainer'
			),
			array(
				'id' => 210,
				'guard_name' => 'web',
				'name' => 'view-trainer'
			),
			array(
				'id' => 211,
				'guard_name' => 'web',
				'name' => 'store-trainer'
			),
			array(
				'id' => 212,
				'guard_name' => 'web',
				'name' => 'edit-trainer'
			),
			array(
				'id' => 213,
				'guard_name' => 'web',
				'name' => 'delete-trainer'
			),
			array(
				'id' => 214,
				'guard_name' => 'web',
				'name' => 'training'
			),
			array(
				'id' => 215,
				'guard_name' => 'web',
				'name' => 'view-training'
			),
			array(
				'id' => 216,
				'guard_name' => 'web',
				'name' => 'store-training'
			),
			array(
				'id' => 217,
				'guard_name' => 'web',
				'name' => 'edit-training'
			),
			array(
				'id' => 218,
				'guard_name' => 'web',
				'name' => 'delete-training'
			),
			array(
				'id' => 219,
				'guard_name' => 'web',
				'name' => 'access-module'
			),
			array(
				'id' => 220,
				'guard_name' => 'web',
				'name' => 'access-variable_type'
			),
			array(
				'id' => 221,
				'guard_name' => 'web',
				'name' => 'access-variable_method'
			),
			array(
				'id' => 222,
				'guard_name' => 'web',
				'name' => 'access-language'
			),
			array(
				'id' => 223,
				'guard_name' => 'web',
				'name' => 'announcement'
			),
			array(
				'id' => 224,
				'guard_name' => 'web',
				'name' => 'store-announcement'
			),
			array(
				'id' => 225,
				'guard_name' => 'web',
				'name' => 'edit-announcement'
			),
			array(
				'id' => 226,
				'guard_name' => 'web',
				'name' => 'delete-announcement'
			),
			array(
				'id' => 227,
				'guard_name' => 'web',
				'name' => 'company'
			),
			array(
				'id' => 228,
				'guard_name' => 'web',
				'name' => 'view-company'
			),
			array(
				'id' => 229,
				'guard_name' => 'web',
				'name' => 'store-company'
			),
			array(
				'id' => 230,
				'guard_name' => 'web',
				'name' => 'edit-company'
			),
			array(
				'id' => 231,
				'guard_name' => 'web',
				'name' => 'delete-company'
			),
			array(
				'id' => 232,
				'guard_name' => 'web',
				'name' => 'department'
			),
			array(
				'id' => 233,
				'guard_name' => 'web',
				'name' => 'view-department'
			),
			array(
				'id' => 234,
				'guard_name' => 'web',
				'name' => 'store-department'
			),
			array(
				'id' => 235,
				'guard_name' => 'web',
				'name' => 'edit-department'
			),
			array(
				'id' => 236,
				'guard_name' => 'web',
				'name' => 'delete-department'
			),
			array(
				'id' => 237,
				'guard_name' => 'web',
				'name' => 'designation'
			),
			array(
				'id' => 238,
				'guard_name' => 'web',
				'name' => 'view-designation'
			),
			array(
				'id' => 239,
				'guard_name' => 'web',
				'name' => 'store-designation'
			),
			array(
				'id' => 240,
				'guard_name' => 'web',
				'name' => 'edit-designation'
			),
			array(
				'id' => 241,
				'guard_name' => 'web',
				'name' => 'delete-designation'
			),
			array(
				'id' => 242,
				'guard_name' => 'web',
				'name' => 'location'
			),
			array(
				'id' => 243,
				'guard_name' => 'web',
				'name' => 'view-location'
			),
			array(
				'id' => 244,
				'guard_name' => 'web',
				'name' => 'store-location'
			),
			array(
				'id' => 245,
				'guard_name' => 'web',
				'name' => 'edit-location'
			),
			array(
				'id' => 246,
				'guard_name' => 'web',
				'name' => 'delete-location'
			),
			array(
				'id' => 247,
				'guard_name' => 'web',
				'name' => 'policy'
			),
			array(
				'id' => 248,
				'guard_name' => 'web',
				'name' => 'store-policy'
			),
			array(
				'id' => 249,
				'guard_name' => 'web',
				'name' => 'edit-policy'
			),
			array(
				'id' => 250,
				'guard_name' => 'web',
				'name' => 'delete-policy'
			),
			array(
				'id' => 251,
				'guard_name' => 'web',
				'name' => 'view-cms'
			),
			array(
				'id' => 252,
				'guard_name' => 'web',
				'name' => 'store-cms'
			),
			array(
				'id' => 253,
				'guard_name' => 'web',
				'name' => 'store-user'
			),
			array(
				'id' => 254,
				'guard_name' => 'web',
				'name' => 'delete-attendance'
			),
			array(
				'id' => 255,
				'guard_name' => 'web',
				'name' => 'view-leave'
			),
			array(
				'id' => 256,
				'guard_name' => 'web',
				'name' => 'store-leave'
			),
			array(
				'id' => 257,
				'guard_name' => 'web',
				'name' => 'edit-leave'
			),
			array(
				'id' => 258,
				'guard_name' => 'web',
				'name' => 'delete-leave'
			),
			array(
				'id' => 259,
				'guard_name' => 'web',
				'name' => 'cms'
			),

            //Performance
            array(
				'id' => 260,
				'guard_name' => 'web',
				'name' => 'performance'
			),
            array(
				'id' => 261,
				'guard_name' => 'web',
				'name' => 'goal-type'
			),
            array(
				'id' => 262,
				'guard_name' => 'web',
				'name' => 'view-goal-type'
			),
            array(
				'id' => 263,
				'guard_name' => 'web',
				'name' => 'store-goal-type'
			),
            array(
				'id' => 264,
				'guard_name' => 'web',
				'name' => 'edit-goal-type'
			),
            array(
				'id' => 265,
				'guard_name' => 'web',
				'name' => 'delete-goal-type'
			),
            array(
				'id' => 266,
				'guard_name' => 'web',
				'name' => 'goal-tracking'
			),
            array(
				'id' => 267,
				'guard_name' => 'web',
				'name' => 'view-goal-tracking'
			),
            array(
				'id' => 268,
				'guard_name' => 'web',
				'name' => 'store-goal-tracking'
			),
            array(
				'id' => 269,
				'guard_name' => 'web',
				'name' => 'edit-goal-tracking'
			),
            array(
				'id' => 270,
				'guard_name' => 'web',
				'name' => 'delete-goal-tracking'
			),
            array(
				'id' => 271,
				'guard_name' => 'web',
				'name' => 'indicator'
			),
            array(
				'id' => 272,
				'guard_name' => 'web',
				'name' => 'view-indicator'
			),
            array(
				'id' => 273,
				'guard_name' => 'web',
				'name' => 'store-indicator'
			),
            array(
				'id' => 274,
				'guard_name' => 'web',
				'name' => 'edit-indicator'
			),
            array(
				'id' => 275,
				'guard_name' => 'web',
				'name' => 'delete-indicator'
			),
            array(
				'id' => 276,
				'guard_name' => 'web',
				'name' => 'appraisal'
			),
            array(
				'id' => 277,
				'guard_name' => 'web',
				'name' => 'view-appraisal'
			),
            array(
				'id' => 278,
				'guard_name' => 'web',
				'name' => 'store-appraisal'
			),
            array(
				'id' => 279,
				'guard_name' => 'web',
				'name' => 'edit-appraisal'
			),
            array(
				'id' => 280,
				'guard_name' => 'web',
				'name' => 'delete-appraisal'
			),

			//assetes and category
			array(
				'id' => 281,
				'guard_name' => 'web',
				'name' => 'assets-and-category'
			),
			array(
				'id' => 282,
				'guard_name' => 'web',
				'name' => 'category'
			),
			array(
				'id' => 283,
				'guard_name' => 'web',
				'name' => 'view-assets-category'
			),
			array(
				'id' => 284,
				'guard_name' => 'web',
				'name' => 'store-assets-category'
			),
			array(
				'id' => 285,
				'guard_name' => 'web',
				'name' => 'edit-assets-category'
			),
			array(
				'id' => 286,
				'guard_name' => 'web',
				'name' => 'delete-assets-category'
			),
			array(
				'id' => 287,
				'guard_name' => 'web',
				'name' => 'assets'
			),
			array(
				'id' => 288,
				'guard_name' => 'web',
				'name' => 'view-assets'
			),
			array(
				'id' => 289,
				'guard_name' => 'web',
				'name' => 'store-assets'
			),
			array(
				'id' => 290,
				'guard_name' => 'web',
				'name' => 'edit-assets'
			),
			array(
				'id' => 291,
				'guard_name' => 'web',
				'name' => 'delete-assets'
			),
            array(
				'id' => 292,
				'guard_name' => 'web',
				'name' => 'daily-attendances'
			),
            array(
				'id' => 293,
				'guard_name' => 'web',
				'name' => 'date-wise-attendances'
			),
            array(
				'id' => 294,
				'guard_name' => 'web',
				'name' => 'monthly-attendances'
			),
            // New Added
            array(
				'id' => 295,
				'guard_name' => 'web',
				'name' => 'set-permission'
			),
            array(
				'id' => 296,
				'guard_name' => 'web',
				'name' => 'get-leave-notification'
			),
            array(
				'id' => 297,
				'guard_name' => 'web',
				'name' => 'report-pension'
			),
		);
		DB::table('permissions')->insert($permissions);
    }
}



