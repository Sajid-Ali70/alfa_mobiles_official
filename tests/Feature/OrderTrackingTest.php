<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class OrderTrackingTest extends TestCase
{
    private array $testProofPaths = [];

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('cnic');
            $table->string('mobile_number');
            $table->text('address')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('wallet_service')->nullable();
            $table->string('proof_image')->nullable();
            $table->decimal('available_balance', 12, 2)->nullable();
            $table->unsignedBigInteger('mobile_id')->nullable();
            $table->string('color')->nullable();
            $table->string('storage')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('status')->nullable();
            $table->string('tenure')->nullable();
            $table->string('monthly_emi')->nullable();
            $table->string('total_price')->nullable();
            $table->string('rider_name')->nullable();
            $table->string('rider_phone')->nullable();
            $table->timestamps();
        });

        Schema::create('mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_icon')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
        });

        DB::table('app_settings')->insert(['id' => 1, 'app_name' => 'Alfa Mobiles']);
        DB::table('mobiles')->insert(['id' => 1, 'name' => 'Test Phone']);
    }

    public function test_mobile_number_lookup_lists_every_matching_order(): void
    {
        $this->insertOrder('AM-260101-1001');
        $this->insertOrder('AM-260102-1002');

        $this->post(route('track.status'), [
            'lookup_type' => 'mobile_number',
            'mobile_number' => '0300-1234567',
        ])
            ->assertOk()
            ->assertViewIs('frontend.track_results')
            ->assertSee('AM-260101-1001')
            ->assertSee('AM-260102-1002');
    }

    public function test_cnic_lookup_lists_every_matching_order(): void
    {
        $this->insertOrder('AM-260101-1001');
        $this->insertOrder('AM-260102-1002');

        $this->post(route('track.status'), [
            'lookup_type' => 'cnic',
            'cnic' => '42101-1234567-8',
        ])
            ->assertOk()
            ->assertViewIs('frontend.track_results')
            ->assertSee('AM-260101-1001')
            ->assertSee('AM-260102-1002');
    }

    public function test_order_id_lookup_opens_the_matching_order_directly(): void
    {
        $this->insertOrder('AM-260101-1001');
        $this->insertOrder('AM-260102-1002');

        $this->post(route('track.status'), [
            'lookup_type' => 'order_id',
            'order_id' => 'am-260102-1002',
        ])
            ->assertOk()
            ->assertViewIs('frontend.track_result')
            ->assertSee('AM-260102-1002')
            ->assertDontSee('AM-260101-1001');
    }

    public function test_customer_can_place_multiple_orders_with_the_same_cnic_and_mobile_number(): void
    {
        $session = [
            'order_mobile_id' => 1,
            'order_customer' => [
                'full_name' => 'Test Customer',
                'email' => 'N/A',
                'cnic' => '4210112345678',
                'mobile_number' => '03001234567',
                'address' => 'Test address',
                'delivery_type' => 'Open Parcel via TCS Rider',
            ],
            'order_color' => 'Black',
            'order_storage' => '128GB',
            'order_tenure' => '12 Months',
            'order_emi' => 'Rs. 5,000',
            'order_total' => 'Rs. 60,000',
            'order_down_payment' => 0,
        ];

        $this->withSession($session)->post(route('order.submit'), [
            'payment_method' => 'Cash on Delivery',
            'available_balance' => '150000',
            'proof_image' => UploadedFile::fake()->image('proof-one.png'),
        ], ['Accept' => 'application/json'])
            ->assertOk()
            ->assertJsonPath('success', true);
        $this->testProofPaths[] = public_path('uploads/proofs/' . basename(
            DB::table('orders')->orderByDesc('id')->value('proof_image')
        ));
        $this->withSession($session)->post(route('order.submit'), [
            'payment_method' => 'Cash on Delivery',
            'available_balance' => '150000',
            'proof_image' => UploadedFile::fake()->image('proof-two.png'),
        ], ['Accept' => 'application/json'])
            ->assertOk()
            ->assertJsonPath('success', true);
        $this->testProofPaths[] = public_path('uploads/proofs/' . basename(
            DB::table('orders')->orderByDesc('id')->value('proof_image')
        ));

        $this->assertSame(2, DB::table('orders')
            ->where('cnic', '4210112345678')
            ->where('mobile_number', '03001234567')
            ->count());
        $this->assertEquals(150000, (float) DB::table('orders')->value('available_balance'));
        $this->assertNotSame(
            DB::table('orders')->orderBy('id')->value('proof_image'),
            DB::table('orders')->orderByDesc('id')->value('proof_image')
        );
    }

    protected function tearDown(): void
    {
        foreach ($this->testProofPaths as $proofPath) {
            if (is_file($proofPath)) {
                unlink($proofPath);
            }
        }

        parent::tearDown();
    }

    private function insertOrder(string $orderNumber): void
    {
        DB::table('orders')->insert([
            'order_number' => $orderNumber,
            'cnic' => '4210112345678',
            'mobile_number' => '03001234567',
            'mobile_id' => 1,
            'status' => 'Waiting for Approval',
            'tenure' => '12 Months',
            'monthly_emi' => 'Rs. 5,000',
            'payment_method' => 'Cash on Delivery',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
