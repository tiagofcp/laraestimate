<?php
namespace Database\Seeders;

use App\Models\Estimate;
use App\Models\Item;
use App\Models\Section;
use Illuminate\Database\Seeder;

class EstimatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(app()->environment() == 'local') {
            Estimate::factory(24)->create()->each(function($estimate) {

                $textSectionData = Section::factory()->make()->toArray();
                unset($textSectionData['presentable_text']);
                $estimate->sections()->create($textSectionData);

                $pricesSectionData = Section::factory()->make([
                    'type' => 'prices'
                ])->toArray();
                unset($pricesSectionData['presentable_text']);

                $pricesSection = $estimate->sections()->create($pricesSectionData);

                for ($i=0; $i < 3; $i++) {
                    $itemData = Item::factory()->make()->toArray();
                    $pricesSection->items()->create($itemData);
                }

            });
        }
    }
}
