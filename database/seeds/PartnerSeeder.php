<?php

use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $settings = DB::table('settings')
		    ->whereIn('key', [
			    'partners',
		    ])->exists();

	    if (!$settings) {
		    DB::table('settings')->insert([
			    [
				    'page_slug' => 'main',
				    'key' => 'partners',
				    'element' => json_encode([
					    'wrap' => [
						    'title' => 'OUR Partners',
						    'active' => 'true',
						    'heading' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem voluptatem obcaecati!',
					    ],
					    'partners' => [
						    'active' => 'true',
						    'count' => 5
					    ]
				    ]),
				    'lang' => json_encode([
					    'ru' => [
						    'wrap' => [
							    'title' => 'Наши партнеры',
							    'active' => 'true',
							    'heading' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
						    ],
						    'partners' => [
							    'active' => 'true',
							    'count' => 5
						    ]
					    ],
					    'ua' => [
						    'wrap' => [
							    'title' => 'Наші партнери',
							    'active' => 'true',
							    'heading' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',

						    ],
						    'partners' => [
							    'active' => 'true',
							    'count' => 5
						    ]
					    ]
				    ])
			    ],
		    ]);
	    }
    }
}
