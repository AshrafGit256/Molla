<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Call your seeder classes here
        $this->call(AdminSeeder::class);
        $this->call(SystemSettingSeeder::class);
        $this->call(HomeSettingSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductColorSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(ProductSizeSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(DiscountCodeSeeder::class);
        $this->call(ShippingChargeSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ProductWishlistSeeder::class);
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(BlogCommentSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(TopSliderSeeder::class);
        $this->call(BottomSliderSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(ProductReviewSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(SmtpSeeder::class);
        $this->call(EmployeeSeeder::class);

        Model::reguard();
    }
}
