<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductionReadinessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // RefreshDatabase wipes the database. Only ever run against phpunit.xml's
        // throwaway in-memory SQLite, never against Neon.
        if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            $this->markTestSkipped('Destructive test: runs only on the in-memory SQLite test database.');
        }
    }

    public static function adminOnlyGetRoutes(): array
    {
        return [
            'admin orders' => ['/admin/orders'],
            'coupon list' => ['/coupons'],
            'coupon create' => ['/coupons/create'],
            'coupon history' => ['/coupons/history'],
        ];
    }

    #[DataProvider('adminOnlyGetRoutes')]
    public function test_customers_cannot_open_admin_pages(string $uri): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get($uri)->assertForbidden();
    }

    #[DataProvider('adminOnlyGetRoutes')]
    public function test_admins_can_open_admin_pages(string $uri): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get($uri)->assertOk();
    }

    public function test_customers_cannot_create_coupons_or_process_orders(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)
            ->post('/coupons', ['code' => 'FREE', 'type' => 'percent', 'value' => 100])
            ->assertForbidden();
        $this->assertDatabaseMissing('coupons', ['code' => 'FREE']);

        $this->actingAs($customer)->post('/admin/orders/process/1')->assertForbidden();
    }

    public function test_guests_are_sent_to_login_for_admin_pages(): void
    {
        $this->get('/admin/orders')->assertRedirect('/login');
    }

    public function test_category_products_page_renders(): void
    {
        $category = Category::create(['name' => 'Pens', 'description' => 'Ink']);

        $this->get("/categories/{$category->id}/products")->assertOk()->assertSee('Pens');
    }

    public function test_product_image_url_supports_cloudinary_and_legacy_paths(): void
    {
        $cloud = new Product(['image' => 'https://res.cloudinary.com/demo/image/upload/v1/products/a.jpg']);
        $legacy = new Product(['image' => 'products/a.jpg']);
        $none = new Product(['image' => null]);

        $this->assertSame('https://res.cloudinary.com/demo/image/upload/v1/products/a.jpg', $cloud->image_url);
        $this->assertStringEndsWith('/storage/products/a.jpg', $legacy->image_url);
        $this->assertNull($none->image_url);
    }

    public function test_health_check_is_up(): void
    {
        $this->get('/up')->assertOk();
    }
}
