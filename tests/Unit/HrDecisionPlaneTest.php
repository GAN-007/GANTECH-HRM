<?php

namespace Tests\Unit;

use App\Services\DecisionPlane\HrDecisionPlane;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HrDecisionPlaneTest extends TestCase
{
    public function test_off_mode_does_not_call_provider(): void
    {
        config(['system_one.mode' => 'off']);
        Http::preventStrayRequests();

        $this->assertNull(app(HrDecisionPlane::class)->classify([
            'subject' => 'Annual leave',
            'description' => 'Requesting two days off.',
        ]));
    }

    public function test_advisory_mode_returns_typed_hr_triage(): void
    {
        config([
            'system_one.mode' => 'shadow',
            'system_one.base_url' => 'http://laya.test:8000',
            'system_one.api_key' => 'test-key',
            'system_one.timeout_seconds' => 1,
        ]);

        Http::fake([
            'http://laya.test:8000/v1/systemone' => Http::response([
                'answers' => [
                    'hr_domain' => [
                        'type' => 'choice',
                        'choice' => 'leave',
                        'confidence' => 0.95,
                        'probabilities' => ['leave' => 0.95, 'other' => 0.05],
                    ],
                    'needs_human_review' => ['type' => 'noul', 'noul' => 0.77, 'confidence' => 0.77],
                ],
                'routing' => ['model' => 'english'],
                'usage' => ['input_tokens' => 42, 'output_tokens' => 0],
            ], 200),
        ]);

        $result = app(HrDecisionPlane::class)->classify([
            'subject' => 'Annual leave request',
            'description' => 'Please approve two days of annual leave.',
        ]);

        $this->assertSame('leave', $result['answers']['hr_domain']['choice']);
        $this->assertTrue($result['advisory_only']);

        Http::assertSent(fn ($request) =>
            $request->url() === 'http://laya.test:8000/v1/systemone'
            && data_get($request->data(), 'state.policy.no_autonomous_hiring_or_rejection') === true
        );
    }

    public function test_provider_failure_fails_open(): void
    {
        config([
            'system_one.mode' => 'shadow',
            'system_one.base_url' => 'http://laya.test:8000',
        ]);
        Http::fake([
            'http://laya.test:8000/v1/systemone' => Http::response(['error' => 'down'], 503),
        ]);

        $this->assertNull(app(HrDecisionPlane::class)->classify(['subject' => 'Payroll question']));
    }
}
