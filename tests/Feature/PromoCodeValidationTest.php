<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PromoCode;
use App\Services\PromoCodeService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $promoCodeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->promoCodeService = app(PromoCodeService::class);
    }

    /** @test */
    public function it_validates_valid_promo_code()
    {
        // Créer un code promo valide
        $promoCode = PromoCode::factory()->create([
            'code' => 'VALID2024',
            'is_active' => true,
            'valid_from' => Carbon::now()->subDay(),
            'valid_until' => Carbon::now()->addDay(),
            'usage_limit' => 10,
            'used_count' => 5,
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'min_amount' => 10
        ]);

        $result = $this->promoCodeService->validateCode('VALID2024', 50);

        $this->assertTrue($result['valid']);
        $this->assertEquals('success', $result['type']);
        $this->assertEquals(10, $result['discount_amount']); // 20% de 50€ = 10€
    }

    /** @test */
    public function it_rejects_invalid_promo_code()
    {
        $result = $this->promoCodeService->validateCode('INVALID', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('error', $result['type']);
        $this->assertStringContainsString('invalide', $result['message']);
    }

    /** @test */
    public function it_rejects_inactive_promo_code()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'INACTIVE',
            'is_active' => false
        ]);

        $result = $this->promoCodeService->validateCode('INACTIVE', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('error', $result['type']);
        $this->assertStringContainsString('plus actif', $result['message']);
    }

    /** @test */
    public function it_rejects_expired_promo_code()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'EXPIRED',
            'is_active' => true,
            'valid_until' => Carbon::now()->subDay()
        ]);

        $result = $this->promoCodeService->validateCode('EXPIRED', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('error', $result['type']);
        $this->assertStringContainsString('expiré', $result['message']);
    }

    /** @test */
    public function it_rejects_future_promo_code()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'FUTURE',
            'is_active' => true,
            'valid_from' => Carbon::now()->addDay()
        ]);

        $result = $this->promoCodeService->validateCode('FUTURE', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('warning', $result['type']);
        $this->assertStringContainsString('pas encore valide', $result['message']);
    }

    /** @test */
    public function it_rejects_exhausted_promo_code()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'EXHAUSTED',
            'is_active' => true,
            'usage_limit' => 5,
            'used_count' => 5
        ]);

        $result = $this->promoCodeService->validateCode('EXHAUSTED', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('error', $result['type']);
        $this->assertStringContainsString('limite d\'utilisation', $result['message']);
    }

    /** @test */
    public function it_rejects_promo_code_with_minimum_amount_not_met()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'MINAMOUNT',
            'is_active' => true,
            'min_amount' => 100
        ]);

        $result = $this->promoCodeService->validateCode('MINAMOUNT', 50);

        $this->assertFalse($result['valid']);
        $this->assertEquals('warning', $result['type']);
        $this->assertStringContainsString('montant minimum', $result['message']);
    }

    /** @test */
    public function it_calculates_percentage_discount_correctly()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'PERCENT20',
            'is_active' => true,
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'max_discount' => 15
        ]);

        $result = $this->promoCodeService->validateCode('PERCENT20', 100);

        $this->assertTrue($result['valid']);
        $this->assertEquals(15, $result['discount_amount']); // Limité par max_discount
    }

    /** @test */
    public function it_calculates_fixed_discount_correctly()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'FIXED10',
            'is_active' => true,
            'discount_type' => 'fixed',
            'discount_value' => 10
        ]);

        $result = $this->promoCodeService->validateCode('FIXED10', 50);

        $this->assertTrue($result['valid']);
        $this->assertEquals(10, $result['discount_amount']);
    }

    /** @test */
    public function it_prevents_discount_exceeding_subtotal()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'BIGDISCOUNT',
            'is_active' => true,
            'discount_type' => 'fixed',
            'discount_value' => 100
        ]);

        $result = $this->promoCodeService->validateCode('BIGDISCOUNT', 50);

        $this->assertTrue($result['valid']);
        $this->assertEquals(50, $result['discount_amount']); // Limité au sous-total
    }

    /** @test */
    public function it_applies_and_removes_promo_code_from_session()
    {
        $promoCode = PromoCode::factory()->create([
            'code' => 'TESTCODE',
            'is_active' => true,
            'discount_type' => 'percentage',
            'discount_value' => 10
        ]);

        // Appliquer le code
        $result = $this->promoCodeService->applyCode('TESTCODE', 100);
        $this->assertTrue($result['valid']);

        // Vérifier qu'il est dans la session
        $appliedCode = $this->promoCodeService->getAppliedCode();
        $this->assertNotNull($appliedCode);
        $this->assertEquals('TESTCODE', $appliedCode['code']);

        // Supprimer le code
        $removeResult = $this->promoCodeService->removeCode();
        $this->assertTrue($removeResult['valid']);

        // Vérifier qu'il n'est plus dans la session
        $appliedCode = $this->promoCodeService->getAppliedCode();
        $this->assertNull($appliedCode);
    }
} 