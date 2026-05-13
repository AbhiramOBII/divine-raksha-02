<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories first
        $categories = [
            ['title' => 'Rudraksha', 'slug' => 'rudraksha', 'short_description' => 'Sacred Rudraksha beads for divine protection', 'status' => true, 'sort_order' => 1],
            ['title' => 'Gemstones', 'slug' => 'gemstones', 'short_description' => 'Natural certified gemstones for planetary balance', 'status' => true, 'sort_order' => 2],
            ['title' => 'Bracelets', 'slug' => 'bracelets', 'short_description' => 'Handcrafted spiritual bracelets', 'status' => true, 'sort_order' => 3],
            ['title' => 'Malas', 'slug' => 'malas', 'short_description' => 'Prayer and meditation malas', 'status' => true, 'sort_order' => 4],
            ['title' => 'Yantras', 'slug' => 'yantras', 'short_description' => 'Sacred geometric instruments for prosperity', 'status' => true, 'sort_order' => 5],
            ['title' => 'Kavach', 'slug' => 'kavach', 'short_description' => 'Divine protection amulets and kavach', 'status' => true, 'sort_order' => 6],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
            $categoryIds[$cat['slug']] = $category->id;
        }

        // Products
        $products = [
            // Rudraksha
            [
                'category_id' => $categoryIds['rudraksha'],
                'title' => '5 Mukhi Rudraksha',
                'short_description' => 'Original Nepali 5 Mukhi Rudraksha for health and peace of mind',
                'full_description' => 'The 5 Mukhi Rudraksha is ruled by Lord Kalagni Rudra and represents the Pancha Tattva (five elements). It is the most commonly available Rudraksha and is highly beneficial for maintaining blood pressure and calming the mind. This bead enhances awareness and memory, making it ideal for students and professionals alike.',
                'sku' => 'DR-RUD-001',
                'slug' => '5-mukhi-rudraksha',
                'featured' => true,
                'new_product' => false,
                'bestseller' => true,
                'cost_price' => 1500.00,
                'selling_price' => 999.00,
                'attributes' => ['Natural', 'Blessed'],
                'shop_purpose' => ['Health', 'Peace', 'Protection'],
                'shop_by_raashi' => ['Simha', 'Dhanu'],
                'shop_by_numerology' => ['1', '5'],
                'size' => ['Small', 'Medium', 'Large'],
                'material' => 'Natural Rudraksha Seed',
                'weight' => '3-5g',
                'brand_name' => 'Divine Raksha',
                'meta_title' => '5 Mukhi Rudraksha - Original Nepali | Divine Raksha',
                'meta_description' => 'Buy authentic 5 Mukhi Rudraksha online. Lab-certified, blessed by priests. Free shipping on all orders.',
                'status' => true,
            ],
            [
                'category_id' => $categoryIds['rudraksha'],
                'title' => '1 Mukhi Rudraksha',
                'short_description' => 'Rare Ek Mukhi Rudraksha - Symbol of Lord Shiva',
                'full_description' => 'The 1 Mukhi Rudraksha is the rarest and most powerful bead. Ruled by Lord Shiva himself, this Rudraksha blesses the wearer with supreme consciousness, enlightenment, and detachment from worldly pleasures. It brings immense power and luxury.',
                'sku' => 'DR-RUD-002',
                'slug' => '1-mukhi-rudraksha',
                'featured' => true,
                'new_product' => true,
                'bestseller' => false,
                'cost_price' => 25000.00,
                'selling_price' => 21000.00,
                'attributes' => ['Natural', 'Blessed', 'Organic'],
                'shop_purpose' => ['Wealth', 'Peace', 'Balance'],
                'shop_by_raashi' => ['Mesha', 'Simha', 'Dhanu'],
                'shop_by_numerology' => ['1'],
                'size' => null,
                'material' => 'Natural Rudraksha Seed',
                'weight' => '2-3g',
                'brand_name' => 'Divine Raksha',
                'meta_title' => '1 Mukhi Rudraksha - Rarest Bead | Divine Raksha',
                'meta_description' => 'Authentic 1 Mukhi Rudraksha with lab certification. Symbol of Lord Shiva for supreme consciousness.',
                'status' => true,
            ],
            [
                'category_id' => $categoryIds['rudraksha'],
                'title' => '7 Mukhi Rudraksha',
                'short_description' => 'Blessed by Goddess Lakshmi for wealth and prosperity',
                'full_description' => 'The 7 Mukhi Rudraksha is associated with Goddess Mahalakshmi and the planet Saturn. It brings good luck, wealth, and new opportunities. Ideal for those facing financial difficulties or seeking career advancement.',
                'sku' => 'DR-RUD-003',
                'slug' => '7-mukhi-rudraksha',
                'featured' => false,
                'new_product' => true,
                'bestseller' => false,
                'cost_price' => 3500.00,
                'selling_price' => 2799.00,
                'attributes' => ['Natural', 'Blessed'],
                'shop_purpose' => ['Wealth', 'Luck'],
                'shop_by_raashi' => ['Makara', 'Kumbha'],
                'shop_by_numerology' => ['7', '8'],
                'size' => ['Small', 'Medium'],
                'material' => 'Natural Rudraksha Seed',
                'weight' => '4-6g',
                'brand_name' => 'Divine Raksha',
                'meta_title' => '7 Mukhi Rudraksha for Wealth | Divine Raksha',
                'meta_description' => 'Buy 7 Mukhi Rudraksha blessed by Goddess Lakshmi. Attract wealth and prosperity.',
                'status' => true,
            ],

            // Gemstones
            [
                'category_id' => $categoryIds['gemstones'],
                'title' => 'Blue Sapphire (Neelam)',
                'short_description' => 'Natural certified Blue Sapphire for Saturn (Shani)',
                'full_description' => 'A premium quality natural Blue Sapphire (Neelam) stone, ideal for those whose Saturn is favourably placed. Known for rapid results, this stone can bring sudden wealth, career boost, and protection from enemies. Must be worn after proper astrological consultation.',
                'sku' => 'DR-GEM-001',
                'slug' => 'blue-sapphire-neelam',
                'featured' => true,
                'new_product' => false,
                'bestseller' => true,
                'cost_price' => 18000.00,
                'selling_price' => 14999.00,
                'attributes' => ['Natural'],
                'shop_purpose' => ['Wealth', 'Protection', 'Courage'],
                'shop_by_raashi' => ['Makara', 'Kumbha'],
                'shop_by_numerology' => ['8'],
                'size' => ['Small', 'Medium', 'Large'],
                'material' => 'Natural Blue Sapphire',
                'weight' => '4-6 carats',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Blue Sapphire Neelam Stone | Divine Raksha',
                'meta_description' => 'Certified natural Blue Sapphire for Shani. Lab-tested, energized stone with free consultation.',
                'status' => true,
            ],
            [
                'category_id' => $categoryIds['gemstones'],
                'title' => 'Yellow Sapphire (Pukhraj)',
                'short_description' => 'Natural Pukhraj for Jupiter (Guru) blessings',
                'full_description' => 'A lustrous natural Yellow Sapphire (Pukhraj) that channels the blessings of Jupiter. This stone is ideal for marriage, education, wisdom, and spiritual growth. It brings positivity and good fortune to the wearer.',
                'sku' => 'DR-GEM-002',
                'slug' => 'yellow-sapphire-pukhraj',
                'featured' => false,
                'new_product' => false,
                'bestseller' => true,
                'cost_price' => 12000.00,
                'selling_price' => 9499.00,
                'attributes' => ['Natural'],
                'shop_purpose' => ['Wealth', 'Love', 'Luck'],
                'shop_by_raashi' => ['Dhanu', 'Meena'],
                'shop_by_numerology' => ['3'],
                'size' => ['Small', 'Medium', 'Large'],
                'material' => 'Natural Yellow Sapphire',
                'weight' => '3-5 carats',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Yellow Sapphire Pukhraj Stone | Divine Raksha',
                'meta_description' => 'Buy certified natural Yellow Sapphire for Jupiter blessings. Ideal for wisdom and prosperity.',
                'status' => true,
            ],

            // Bracelets
            [
                'category_id' => $categoryIds['bracelets'],
                'title' => 'Tiger Eye Bracelet',
                'short_description' => 'Natural Tiger Eye crystal bracelet for courage and confidence',
                'full_description' => 'A stunning Tiger Eye bracelet crafted with premium 8mm natural beads. Tiger Eye is known as the stone of courage and confidence. It helps in decision-making, dispels fear, and attracts good luck. Perfect for daily wear.',
                'sku' => 'DR-BRC-001',
                'slug' => 'tiger-eye-bracelet',
                'featured' => false,
                'new_product' => true,
                'bestseller' => false,
                'cost_price' => 1200.00,
                'selling_price' => 799.00,
                'attributes' => ['Handcrafted', 'Natural'],
                'shop_purpose' => ['Courage', 'Luck', 'Protection'],
                'shop_by_raashi' => ['Simha', 'Mithuna'],
                'shop_by_numerology' => ['2', '5'],
                'size' => ['Small', 'Medium', 'Large', 'Extra Large'],
                'material' => 'Natural Tiger Eye Crystal',
                'weight' => '25g',
                'dimensions' => '8mm beads',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Tiger Eye Bracelet | Divine Raksha',
                'meta_description' => 'Handcrafted Tiger Eye crystal bracelet for courage and confidence. Free shipping.',
                'status' => true,
            ],
            [
                'category_id' => $categoryIds['bracelets'],
                'title' => 'Black Tourmaline Bracelet',
                'short_description' => 'Powerful protection bracelet against negative energies',
                'full_description' => 'This Black Tourmaline bracelet is a powerhouse of protection. It shields the wearer from negative energies, electromagnetic radiation, and psychic attacks. Made with premium 8mm natural Black Tourmaline beads, strung on a durable elastic cord.',
                'sku' => 'DR-BRC-002',
                'slug' => 'black-tourmaline-bracelet',
                'featured' => true,
                'new_product' => false,
                'bestseller' => true,
                'cost_price' => 1500.00,
                'selling_price' => 1099.00,
                'attributes' => ['Handcrafted', 'Natural', 'Blessed'],
                'shop_purpose' => ['Protection', 'Health', 'Balance'],
                'shop_by_raashi' => ['Vrischika', 'Makara'],
                'shop_by_numerology' => ['4', '8'],
                'size' => ['Small', 'Medium', 'Large', 'Extra Large'],
                'material' => 'Natural Black Tourmaline',
                'weight' => '28g',
                'dimensions' => '8mm beads',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Black Tourmaline Protection Bracelet | Divine Raksha',
                'meta_description' => 'Black Tourmaline bracelet for powerful protection against negative energies.',
                'status' => true,
            ],

            // Malas
            [
                'category_id' => $categoryIds['malas'],
                'title' => 'Rudraksha Mala 108+1 Beads',
                'short_description' => 'Traditional 108+1 bead Rudraksha mala for meditation',
                'full_description' => 'An authentic 108+1 bead Rudraksha mala made with carefully selected 5 Mukhi Rudraksha beads. Ideal for Japa meditation, chanting mantras, and spiritual practices. The mala is hand-knotted with silk thread for durability.',
                'sku' => 'DR-MAL-001',
                'slug' => 'rudraksha-mala-108-beads',
                'featured' => true,
                'new_product' => false,
                'bestseller' => true,
                'cost_price' => 3000.00,
                'selling_price' => 2199.00,
                'attributes' => ['Handcrafted', 'Natural', 'Blessed'],
                'shop_purpose' => ['Peace', 'Health', 'Balance'],
                'shop_by_raashi' => ['Simha', 'Dhanu', 'Mesha'],
                'shop_by_numerology' => ['1', '3', '9'],
                'size' => null,
                'material' => 'Natural 5 Mukhi Rudraksha',
                'weight' => '45g',
                'dimensions' => '108+1 beads, 8mm each',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Rudraksha Mala 108 Beads | Divine Raksha',
                'meta_description' => 'Authentic 108+1 Rudraksha Japa mala for meditation. Hand-knotted, blessed.',
                'status' => true,
            ],

            // Yantras
            [
                'category_id' => $categoryIds['yantras'],
                'title' => 'Shree Yantra (Gold Plated)',
                'short_description' => 'Sacred Shree Yantra for abundance and spiritual growth',
                'full_description' => 'A beautifully crafted gold-plated Shree Yantra, the most powerful yantra in Vedic traditions. It represents Goddess Lakshmi and the cosmic creation. Placing this in your home or office attracts wealth, removes obstacles, and creates a positive energy field.',
                'sku' => 'DR-YNT-001',
                'slug' => 'shree-yantra-gold-plated',
                'featured' => true,
                'new_product' => true,
                'bestseller' => false,
                'cost_price' => 5000.00,
                'selling_price' => 3999.00,
                'attributes' => ['Handcrafted', 'Blessed'],
                'shop_purpose' => ['Wealth', 'Luck', 'Balance'],
                'shop_by_raashi' => ['Vrishabha', 'Tula'],
                'shop_by_numerology' => ['6'],
                'size' => ['Small', 'Medium', 'Large'],
                'material' => 'Copper with Gold Plating',
                'weight' => '150g',
                'dimensions' => '4x4 inch',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Shree Yantra Gold Plated | Divine Raksha',
                'meta_description' => 'Gold-plated Shree Yantra for wealth and abundance. Energized and blessed.',
                'status' => true,
            ],

            // Kavach
            [
                'category_id' => $categoryIds['kavach'],
                'title' => 'Hanuman Kavach Locket',
                'short_description' => 'Powerful Hanuman Kavach for protection and strength',
                'full_description' => 'A divine Hanuman Kavach locket encased in a silver frame. Lord Hanuman is the embodiment of strength, devotion, and protection. Wearing this kavach shields the wearer from evil eyes, black magic, and all negative influences. Ideal for those facing fear and anxiety.',
                'sku' => 'DR-KVC-001',
                'slug' => 'hanuman-kavach-locket',
                'featured' => false,
                'new_product' => true,
                'bestseller' => true,
                'cost_price' => 2500.00,
                'selling_price' => 1799.00,
                'attributes' => ['Blessed', 'Handcrafted'],
                'shop_purpose' => ['Protection', 'Courage', 'Health'],
                'shop_by_raashi' => ['Mesha', 'Simha', 'Vrischika'],
                'shop_by_numerology' => ['3', '9'],
                'size' => null,
                'material' => 'Silver Frame with Sacred Yantra',
                'weight' => '15g',
                'brand_name' => 'Divine Raksha',
                'meta_title' => 'Hanuman Kavach Locket | Divine Raksha',
                'meta_description' => 'Blessed Hanuman Kavach locket in silver for powerful protection and courage.',
                'status' => true,
            ],
        ];

        $defaultImage = 'products/karungulai.jpg';

        foreach ($products as $productData) {
            $productData['featured_image'] = $defaultImage;

            $product = Product::firstOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );

            // Update image on existing products too
            if (!$product->wasRecentlyCreated && !$product->featured_image) {
                $product->update(['featured_image' => $defaultImage]);
            }

            // Seed stock entries for products with sizes
            if ($product->wasRecentlyCreated) {
                $sizes = $product->size ?? [null];
                foreach ($sizes as $size) {
                    ProductStock::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'quantity' => rand(5, 50),
                        'min_stock_alert' => 5,
                    ]);
                }
            }
        }
    }
}
