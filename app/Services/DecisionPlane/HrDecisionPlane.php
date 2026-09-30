<?php

namespace App\Services\DecisionPlane;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class HrDecisionPlane
{
    public function classify(array $state): ?array
    {
        $mode = strtolower((string) config('system_one.mode', 'off'));
        if ($mode === 'off') {
            return null;
        }

        $baseUrl = rtrim((string) config('system_one.base_url', ''), '/');
        if ($baseUrl === '') {
            return null;
        }

        $questions = [
            'hr_domain' => [
                'type' => 'choice',
                'instructions' => 'Which HR/operations domain best describes this request?',
                'criteria' => [
                    'leave' => 'Leave request, holiday, time off or absence',
                    'payroll' => 'Payroll, payslip, salary, allowance, deduction, tax or compensation',
                    'attendance' => 'Attendance, clock-in, shifts, lateness or office presence',
                    'recruitment_admin' => 'Recruitment administration, interview scheduling or candidate records; never autonomous hiring/rejection',
                    'performance' => 'Goals, appraisal, performance indicators or training',
                    'finance_admin' => 'Expense, deposit, invoice, payer, payee or internal finance administration',
                    'employee_relations' => 'Complaint, warning, transfer, promotion, resignation or employee relations',
                    'support' => 'Support ticket, system issue or operational request',
                    'document' => 'Employee document, policy, official file or records request',
                    'other' => 'None of the listed domains',
                ],
            ],
            'urgency' => [
                'type' => 'score',
                'instructions' => 'How urgent is this request?',
                'criteria' => [
                    'routine',
                    'needs attention soon',
                    'blocking an employee or business workflow',
                    'time-critical escalation',
                ],
            ],
            'needs_human_review' => [
                'type' => 'noul',
                'instructions' => 'Should an authorized HR or management user review this before a consequential action?',
            ],
            'contains_sensitive_data' => [
                'type' => 'noul',
                'instructions' => 'Does this request appear to contain sensitive employee, payroll, identity or disciplinary information?',
            ],
            'needs_reply' => [
                'type' => 'noul',
                'instructions' => 'Does the requester appear to expect a response?',
            ],
        ];

        $payload = [
            'state' => [
                'request' => $state,
                'policy' => [
                    'advisory_only' => true,
                    'no_autonomous_hiring_or_rejection' => true,
                    'existing_permissions_and_workflows_remain_authoritative' => true,
                ],
            ],
            'questions' => $questions,
        ];

        $started = microtime(true);

        try {
            $request = Http::acceptJson()
                ->asJson()
                ->timeout(max(0.1, (float) config('system_one.timeout_seconds', 1.5)))
                ->connectTimeout(1.0);
            $apiKey = trim((string) config('system_one.api_key', ''));
            if ($apiKey !== '') {
                $request = $request->withToken($apiKey);
            }
            $response = $request->post($baseUrl.'/v1/systemone', $payload);
            if (! $response->successful()) {
                Log::notice('HRM System-One unavailable; incumbent workflow continues.', [
                    'status' => $response->status(),
                ]);
                return null;
            }
            $body = $response->json();
            if (! is_array($body) || ! is_array($body['answers'] ?? null)) {
                return null;
            }

            return [
                'provider' => 'laya',
                'mode' => $mode,
                'advisory_only' => true,
                'answers' => $body['answers'],
                'routing' => $body['routing'] ?? null,
                'usage' => is_array($body['usage'] ?? null) ? $body['usage'] : null,
                'latency_ms' => (int) round((microtime(true) - $started) * 1000),
            ];
        } catch (ConnectionException $exception) {
            Log::notice('HRM System-One connection failed open.', ['message' => $exception->getMessage()]);
            return null;
        } catch (Throwable $exception) {
            Log::warning('HRM System-One failed open.', [
                'type' => $exception::class,
                'message' => $exception->getMessage(),
            ]);
            return null;
        }
    }
}
