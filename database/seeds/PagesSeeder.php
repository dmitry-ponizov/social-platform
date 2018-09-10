<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders = DB::table('sliders')->whereIn('order', [0, 1, 2])->exists();
        if (!$sliders) {
            DB::table('sliders')->insert([
                [
                    'title' => json_encode([
                        'en' => 'help the poor',
                        'ru' => 'помочь бедным',
                        'ua' => 'допомогти бідним'
                    ]),

                    'heading' => json_encode([
                        'en' => 'for their better future',
                        'ru' => 'для их лучшего будущего',
                        'ua' => 'для їх кращого майбутнього'
                    ]),
                    'description' => json_encode([
                        'en' => 'Every day we bring hope to million`s of children in the world`s hardest places as a sign of God`s unconditional love',
                        'ru' => 'Каждый день мы приносим надежду миллионам детей в самых трудных местах мира как знак безусловной любви Бога',
                        'ua' => 'Кожен день ми приносимо надію мільйонним дітям у найважчих місцях світу як знак Божої безумовної любові'
                    ]),
                    'link_title' => json_encode([
                        'en' => 'Donate Now',
                        'ru' => 'Пожертвовать',
                        'ua' => 'Пожертвувати'
                    ]),
                    'image' => '/uploads/defaults/bg1.jpg',
                    'order' => 0

                ],
                [
                    'title' => json_encode([
                        'en' => 'help the poor',
                        'ru' => 'помочь бедным',
                        'ua' => 'допомогти бідним'
                    ]),

                    'heading' => json_encode([
                        'en' => 'for their better future',
                        'ru' => 'для их лучшего будущего',
                        'ua' => 'для їх кращого майбутнього'
                    ]),
                    'description' => json_encode([
                        'en' => 'Every day we bring hope to million`s of children in the world`s hardest places as a sign of God`s unconditional love',
                        'ru' => 'Каждый день мы приносим надежду миллионам детей в самых трудных местах мира как знак безусловной любви Бога',
                        'ua' => 'Кожен день ми приносимо надію мільйонним дітям у найважчих місцях світу як знак Божої безумовної любові'
                    ]),
                    'link_title' => json_encode([
                        'en' => 'Donate Now',
                        'ru' => 'Пожертвовать',
                        'ua' => 'Пожертвувати'
                    ]),
                    'image' => '/uploads/defaults/bg6.jpg',
                    'order' => 1

                ],
                [
                    'title' => json_encode([
                        'en' => 'help the poor',
                        'ru' => 'помочь бедным',
                        'ua' => 'допомогти бідним'
                    ]),

                    'heading' => json_encode([
                        'en' => 'for their better future',
                        'ru' => 'для их лучшего будущего',
                        'ua' => 'для їх кращого майбутнього'
                    ]),
                    'description' => json_encode([
                        'en' => 'Every day we bring hope to million`s of children in the world`s hardest places as a sign of God`s unconditional love',
                        'ru' => 'Каждый день мы приносим надежду миллионам детей в самых трудных местах мира как знак безусловной любви Бога',
                        'ua' => 'Кожен день ми приносимо надію мільйонним дітям у найважчих місцях світу як знак Божої безумовної любові'
                    ]),
                    'link_title' => json_encode([
                        'en' => 'Donate Now',
                        'ru' => 'Пожертвовать',
                        'ua' => 'Пожертвувати'
                    ]),
                    'image' => '/uploads/defaults/bg2.jpg',
                    'order' => 2

                ],

            ]);
        }

        $settings = DB::table('settings')
            ->whereIn('key', [
                'header',
                'banner_main',
                'welcome_block',
                'actions_block',
                'service',
                'statistics',
                'finance',
                'volunteers',
                'become_volunteer',
                'footer',
                'quick_donate'
            ])->exists();

        if (!$settings) {
            DB::table('settings')->insert([
                [
                    'page_slug' => 'main',
                    'key' => 'header',
                    'element' => json_encode([
                        'main' => [
                            'logo' => '/uploads/defaults/logo-wide.png',
                            'active' => 'true',
                            'phone' => '+380501234567',
                            'email' => 'hello@yourdomain.com',
                            'working_hours' => 'Mon-Fri 8:00 to 2:00',
                            'title_1' => 'FAQ',
                            'link_1' => '/',
                            'title_2' => 'Help Desk',
                            'link_2' => '/',
                            'title_3' => 'Support',
                            'link_3' => '/',

                        ],

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'main' => [
                                'logo' => '/uploads/defaults/logo-wide.png',
                                'active' => 'true',
                                'phone' => '+380501234567',
                                'email' => 'hello@yourdomain.com',
                                'working_hours' => 'Пн-Вс 8:00 to 23:00',
                                'title_1' => 'ЧаВо',
                                'link_1' => '/',
                                'title_2' => 'Служба поддержки',
                                'link_2' => '/',
                                'title_3' => 'Помощник',
                                'link_3' => '/',

                            ],
                        ],
                        'ua' => [
                            'main' => [
                                'logo' => '/uploads/defaults/logo-wide.png',
                                'active' => 'true',
                                'phone' => '+380501234567',
                                'email' => 'hello@yourdomain.com',
                                'working_hours' => 'Пн-Нд 8:00 to 23:00',
                                'title_1' => 'ЧоГо',
                                'link_1' => '/',
                                'title_2' => 'Служба піддтримки',
                                'link_2' => '/',
                                'title_3' => 'Помічник',
                                'link_3' => '/',

                            ],

                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'banner_main',
                    'element' => json_encode([
                        'left' => [
                            'title' => 'WANT TO HELP THE POOR?',
                            'active' => 'true',
                            'background' => '/uploads/defaults/bcg_banner1.jpg',
                            'icon_1' => '/uploads/defaults/icons/svg/house.svg',
                            'icon_2' => '/uploads/defaults/icons/svg/food.svg',
                            'heading_1' => 'Build House',
                            'heading_2' => 'Give Food',
                            'description_1' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum diam tortor, egestas varius erat aliquam.',
                            'description_2' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum diam tortor, egestas varius erat aliquam.'
                        ],
                        'right' => [
                            'title' => 'BUILD AN ORPHANAGE FOR POOR',
                            'active' => 'true',
                            'background' => '/uploads/defaults/bcg_banner2.jpg',
                            'description_1' => 'Lorem ipsum dolor sit amet, conse ctetur adipi sicing elit. Quas odit unde dolor adipisicing inventore autem.',
                            'raised' => '1890',
                            'goal' => '2500',
                            'link_title' => 'Donate Now'
                        ]

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'left' => [
                                'title' => 'Хотите помочь бедным?',
                                'active' => 'true',
                                'background' => '/uploads/defaults/bcg_banner1.jpg',
                                'heading_1' => 'Построить дом',
                                'heading_2' => 'Дать еду',
                                'icon_1' => '/uploads/defaults/icons/svg/house.svg',
                                'icon_2' => '/uploads/defaults/icons/svg/food.svg',
                                'description_1' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                                'description_2' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.'
                            ],
                            'right' => [
                                'title' => 'Оказать денежную помощь',
                                'active' => 'true',
                                'background' => '/uploads/defaults/bcg_banner2.jpg',
                                'description_1' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                                'raised' => '1890',
                                'goal' => '2500',
                                'link_title' => 'Пожертвовать'
                            ]
                        ],
                        'ua' => [
                            'left' => [
                                'title' => 'Хочете допомогти бідним?',
                                'active' => 'true',
                                'background' => '/uploads/defaults/bcg_banner1.jpg',
                                'heading_1' => 'Збудувати дім',
                                'heading_2' => 'Дати їжу',
                                'icon_1' => '/uploads/defaults/icons/svg/house.svg',
                                'icon_2' => '/uploads/defaults/icons/svg/food.svg',
                                'description_1' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'description_2' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                            ],
                            'right' => [
                                'title' => 'Надати грошову допомогу',
                                'active' => 'true',
                                'background' => '/uploads/defaults/bcg_banner2.jpg',
                                'description_1' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'raised' => '1890',
                                'goal' => '2500',
                                'link_title' => 'Пожертвувати'
                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'welcome_block',
                    'element' => json_encode([
                        'main' => [
                            'title' => 'WELCOME TO',
                            'site_title' => 'Not indifferent',
                            'active' => 'true',
                            'heading' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Quos dolo rem consequ untur, natus laudantium commodi.',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum sunt ut dolorem laboriosam culpa excepturi sed distinctio eius! Ut magnam numquam libero quia vero blanditiis fugit corporis quisquam, debitis.',
                            'link_1' => 'Fund Raising',
                            'link_2' => 'Child Adoption',
                            'link_3' => 'Group Work',
                            'link_4' => 'Tree Plantation',
                            'link_5' => 'Childhood Care',
                            'link_6' => 'Build Orphanage',
                            'link_1_url' => '/',
                            'link_2_url' => '/',
                            'link_3_url' => '/',
                            'link_4_url' => '/',
                            'link_5_url' => '/',
                            'link_6_url' => '/',
                            'button_title' => 'view details'
                        ]
                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'main' => [
                                'title' => 'ДОБРО ПОЖАЛОВАТЬ в',
                                'site_title' => 'неравнодушные',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                                'description' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Злых дорогу от всех продолжил, дороге рыбного журчит языкового жаренные парадигматическая семь. Подзаголовок точках решила составитель, большой страна? Свою, они, ее.',
                                'link_1' => 'Привлечение средств',
                                'link_2' => 'Принятие ребенка',
                                'link_3' => 'Групповая работа',
                                'link_4' => 'Плантация деревьев',
                                'link_5' => 'Уход за детьми',
                                'link_6' => 'Построить дом',
                                'link_1_url' => '/',
                                'link_2_url' => '/',
                                'link_3_url' => '/',
                                'link_4_url' => '/',
                                'link_5_url' => '/',
                                'link_6_url' => '/',
                                'button_title' => 'Подробнее'
                            ]
                        ],
                        'ua' => [
                            'main' => [
                                'title' => 'Ласкаво просимо до ',
                                'site_title' => 'небайдужі',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти. Злих дорогу від всіх продовжив, дорозі рибного дзюрчить мовного смажені парадигматичні сім. Підзаголовок точках вирішила укладач, великий країна? Свою, вони, її.',
                                'link_1' => 'Залучення коштів',
                                'link_2' => 'Ухвалення дитини',
                                'link_3' => 'Групова робота',
                                'link_4' => 'Плантація дерев',
                                'link_5' => 'Догляд за дітьми',
                                'link_6' => 'Побудувати будинок',
                                'link_1_url' => '/',
                                'link_2_url' => '/',
                                'link_3_url' => '/',
                                'link_4_url' => '/',
                                'link_5_url' => '/',
                                'link_6_url' => '/',
                                'button_title' => 'Детальніше'
                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'actions_block',
                    'element' => json_encode([
                        'one' => [
                            'title' => 'i need help',
                            'active' => 'true',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Quos dolo rem consequ untur, natus laudantium commodi.',
                            'link_url' => '/statement/create/',
                            'icon' => 'charity.svg',

                        ],
                        'two' => [
                            'title' => 'i want to help',
                            'active' => 'true',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum consectetur sit ullam perspiciatis, deserunt.',
                            'link_url' => '/offer/create/',
                            'icon' => 'dove-of-peace.svg',
                        ],
                        'three' => [
                            'title' => 'GIVE DONATION',
                            'active' => 'true',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum consectetur sit ullam perspiciatis, deserunt.',
                            'link_url' => '/',
                            'icon' => 'donation.svg',
                        ],
                        'four' => [
                            'title' => 'BECOME VOLENTEER',
                            'active' => 'true',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum consectetur sit ullam perspiciatis, deserunt.',
                            'link_url' => '/',
                            'icon' => 'volenteer.svg',
                        ],

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'one' => [
                                'title' => 'Нуждаюсь в помощи',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'link_url' => '/statement/create/',
                                'icon' => 'charity.svg',
                            ],
                            'two' => [
                                'title' => 'Хочу помочь',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'link_url' => '/offer/create/',
                                'icon' => 'dove-of-peace.svg',
                            ],
                            'three' => [
                                'title' => 'Пожертвовать',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'link_url' => '/donate',
                                'icon' => 'donation.svg',
                            ],
                            'four' => [
                                'title' => 'Стать волонтером',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'link_url' => '/',
                                'icon' => 'volenteer.svg',
                            ],

                        ],
                        'ua' => [
                            'one' => [
                                'title' => 'Потребую допомоги',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти.',
                                'link_url' => '/statement/create/',
                                'icon' => 'charity.svg',

                            ],
                            'two' => [
                                'title' => 'Хочу допомогти',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти.',
                                'link_url' => '/offer/create/',
                                'icon' => 'dove-of-peace.svg',

                            ],
                            'three' => [
                                'title' => 'пожертвувати',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти.',
                                'link_url' => '/',
                                'icon' => 'donation.svg',
                            ],
                            'four' => [
                                'title' => 'стати волонтером',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти.',
                                'link_url' => '/',
                                'icon' => 'volenteer.svg',
                            ],

                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'service',
                    'element' => json_encode([
                        'main' => [
                            'title' => 'How Can Help?',
                            'active' => 'true',
                            'heading' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem voluptatem obcaecati!',
                            'count_slides' => 4
                        ]
                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'main' => [
                                'title' => 'Хотите помочь?',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                                'count_slides' => 4
                            ]
                        ],
                        'ua' => [
                            'main' => [
                                'title' => 'Хочете допомогти?',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'count_slides' => 4

                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'statistics',
                    'element' => json_encode([
                        'one' => [
                            'title' => 'HAPPY DONATORS',
                            'active' => 'true',
                            'sum' => '754',
                            'icon' => 'smile.svg',

                        ],
                        'two' => [
                            'title' => 'SUCCESS MISSION',
                            'active' => 'true',
                            'sum' => '675',
                            'icon' => 'rocket.svg',
                        ],
                        'three' => [
                            'title' => 'VOLUNTEER REACHED',
                            'active' => 'true',
                            'sum' => '1,248',
                            'icon' => 'user.svg',
                        ],
                        'four' => [
                            'title' => 'GLOBALIZATION WORK',
                            'active' => 'true',
                            'sum' => '24',
                            'icon' => 'global.svg',
                        ],

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'one' => [
                                'title' => 'Счастливые нуждающиеся',
                                'active' => 'true',
                                'sum' => '754',
                                'icon' => 'smile.svg',
                            ],
                            'two' => [
                                'title' => 'Выполненные цели',
                                'active' => 'true',
                                'sum' => '675',
                                'icon' => 'rocket.svg',
                            ],
                            'three' => [
                                'title' => 'Количество волонтеров',
                                'active' => 'true',
                                'sum' => '1,248',
                                'icon' => 'user.svg',
                            ],
                            'four' => [
                                'title' => 'Глобальные работы',
                                'active' => 'true',
                                'sum' => '24',
                                'icon' => 'global.svg',
                            ],

                        ],
                        'ua' => [
                            'one' => [
                                'title' => 'Щасливі які потребують',
                                'active' => 'true',
                                'sum' => '754',
                                'icon' => 'smile.svg',

                            ],
                            'two' => [
                                'title' => 'Виконані цілі',
                                'active' => 'true',
                                'sum' => '675',
                                'icon' => 'rocket.svg',

                            ],
                            'three' => [
                                'title' => 'Кількість волонтерів',
                                'active' => 'true',
                                'sum' => '1,248',
                                'icon' => 'user.svg',
                            ],
                            'four' => [
                                'title' => 'Глобальні роботи',
                                'active' => 'true',
                                'sum' => '24',
                                'icon' => 'global.svg',
                            ],

                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'finance',
                    'element' => json_encode([
                        'wrap' => [
                            'title' => 'OUR CAUSES',
                            'active' => 'true',
                            'heading' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem voluptatem obcaecati!',
                        ],
                        'statement' => [
                            'active' => 'true',
                            'title_1' => 'Goal',
                            'title_2' => 'Raised',
                            'title_3' => 'Duration',
                            'link_title' => 'Donate',
                            'count_slides' => 3
                        ]
                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'wrap' => [
                                'title' => 'Нуждаются в помощи',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                            ],
                            'statement' => [
                                'active' => 'true',
                                'title_1' => 'Необходимо',
                                'title_2' => 'Собрано',
                                'title_3' => 'Добавлено',
                                'link_title' => 'Пожертвовать',
                                'count_slides' => 3
                            ]
                        ],
                        'ua' => [
                            'wrap' => [
                                'title' => 'Потребують допомоги',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',

                            ],
                            'statement' => [
                                'active' => 'true',
                                'title_1' => 'Необхідно',
                                'title_2' => 'Зібрано',
                                'title_3' => 'Додано',
                                'link_title' => 'Пожертвувати',
                                'count_slides' => 3
                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'volunteers',
                    'element' => json_encode([
                        'wrap' => [
                            'title' => 'OUR VOLUNTEERS',
                            'active' => 'true',
                            'heading' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem voluptatem obcaecati!',
                        ],
                        'volunteers' => [
                            'active' => 'true',
                            'count' => 3
                        ]
                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'wrap' => [
                                'title' => 'Наши волонтеры',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты.',
                            ],
                            'volunteers' => [
                                'active' => 'true',
                                'count' => 3
                            ]
                        ],
                        'ua' => [
                            'wrap' => [
                                'title' => 'Наші волонтери',
                                'active' => 'true',
                                'heading' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',

                            ],
                            'volunteers' => [
                                'active' => 'true',
                                'count' => 3
                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'become_volunteer',
                    'element' => json_encode([
                        'wrap' => [
                            'background' => '/uploads/defaults/bg1.jpg',
                            'active' => 'true',
                        ],
                        'left' => [
                            'active' => 'true',
                        ],
                        'right' => [
                            'active' => 'true',
                        ]
                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'wrap' => [
                                'background' => '/uploads/defaults/bg1.jpg',
                                'active' => 'true',
                            ],
                            'left' => [
                                'active' => 'true',
                            ],
                            'right' => [
                                'active' => 'true',
                            ]
                        ],
                        'ua' => [
                            'wrap' => [
                                'background' => '/uploads/defaults/bg1.jpg',
                                'active' => 'true',
                            ],
                            'left' => [
                                'active' => 'true',
                            ],
                            'right' => [
                                'active' => 'true',
                            ]
                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'footer',
                    'element' => json_encode([
                        'company' => [
                            'logo' => '/uploads/defaults/logo-wide.png',
                            'active' => 'true',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Quos dolo rem consequ untur, natus laudantium commodi.',
                            'link_url' => '/',
                            'link_title' => 'Read more',
                            'facebook' => '/',
                            'twitter' => '/',
                            'skype' => '/',
                            'google' => '/',
                            'youtube' => '/'

                        ],
                        'news' => [
                            'title' => 'Latest News',
                            'active' => 'true',
                        ],
                        'userful_links' => [
                            'title' => 'Useful Links',
                            'active' => 'true',
                            'link_1' => 'Privacy Policy',
                            'link_1_url' => '/',
                            'link_2' => 'Donor Privacy Policy',
                            'link_2_url' => '/',
                            'link_3' => 'Disclaimer',
                            'link_3_url' => '/',
                            'link_4' => 'Terms of Use',
                            'link_4_url' => '/',
                            'link_5' => 'Media Center',
                            'link_5_url' => '/',

                        ],
                        'contact' => [
                            'title' => 'Quick Contact',
                            'active' => 'true',
                            'phone' => '+380501234567',
                            'email' => 'hello@yourdomain.com',
                            'address' => '121 King Street, Melbourne Victoria 3000, Australia',
                        ],
                        'bottom' => [
                            'active' => 'true',
                            'copyright' => 'Copyright ©2018 HostZealot. All Rights Reserved',
                            'title_1' => 'FAQ',
                            'link_1' => '/',
                            'title_2' => 'Help Desk',
                            'link_2' => '/',
                            'title_3' => 'Support',
                            'link_3' => '/',
                        ]

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'company' => [
                                'logo' => '/uploads/defaults/logo-wide.png',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, відкритими та узгодженими живими рибними текстами.',
                                'link_url' => '/',
                                'link_title' => 'Подробнее',
                                'facebook' => '/',
                                'twitter' => '/',
                                'skype' => '/',
                                'google' => '/',
                                'youtube' => '/'
                            ],
                            'news' => [
                                'title' => 'Последние новости',
                                'active' => 'true',
                            ],
                            'userful_links' => [
                                'title' => 'Полезные ссылки',
                                'active' => 'true',
                                'link_1' => 'Политика конфиденциальности',
                                'link_1_url' => '/',
                                'link_2' => 'Политика конфиденциальности доноров',
                                'link_2_url' => '/',
                                'link_3' => 'Отказ',
                                'link_3_url' => '/',
                                'link_4' => 'Правила',
                                'link_4_url' => '/',
                                'link_5' => 'Медиа центр',
                                'link_5_url' => '/',

                            ],
                            'contact' => [
                                'title' => 'Контакты',
                                'active' => 'true',
                                'phone' => '+380501234567',
                                'email' => 'hello@yourdomain.com',
                                'address' => '121 King Street, Melbourne Victoria 3000, Australia',
                            ],
                            'bottom' => [
                                'active' => 'true',
                                'copyright' => 'Лучший европейский хостинг ©2018 HostZealot. Все права защищены',
                                'title_1' => 'ЧаВо',
                                'link_1' => '/',
                                'title_2' => 'Служба поддержки',
                                'link_2' => '/',
                                'title_3' => 'Помощник',
                                'link_3' => '/',
                            ]
                        ],
                        'ua' => [

                            'company' => [
                                'logo' => '/uploads/defaults/logo-wide.png',
                                'active' => 'true',
                                'description' => 'Далеко-далеко за словесними горами в країні, голосних і приголосних живуть рибні тексти.',
                                'link_url' => '/',
                                'link_title' => 'Детальніше',
                                'facebook' => '/',
                                'twitter' => '/',
                                'skype' => '/',
                                'google' => '/',
                                'youtube' => '/'
                            ],

                            'news' => [
                                'title' => 'Останні новини',
                                'active' => 'true',
                            ],
                            'userful_links' => [
                                'title' => 'Користні посилання',
                                'active' => 'true',
                                'link_1' => 'Політика конфіденційності',
                                'link_1_url' => '/',
                                'link_2' => 'Політика конфіденційності донорів',
                                'link_2_url' => '/',
                                'link_3' => 'Відмова',
                                'link_3_url' => '/',
                                'link_4' => 'Правила',
                                'link_4_url' => '/',
                                'link_5' => 'Медіа центр',
                                'link_5_url' => '/',

                            ],
                            'contact' => [
                                'title' => 'Контакти',
                                'active' => 'true',
                                'phone' => '+380501234567',
                                'email' => 'hello@yourdomain.com',
                                'address' => '121 King Street, Melbourne Victoria 3000, Australia',
                            ],
                            'bottom' => [
                                'active' => 'true',
                                'copyright' => 'Кращий європейський хостинг © 2018 HostZealot. Всі права захищені',
                                'title_1' => 'ЧоГо',
                                'link_1' => '/',
                                'title_2' => 'Служба піддтримки',
                                'link_2' => '/',
                                'title_3' => 'Помічник',
                                'link_3' => '/',
                            ]

                        ]
                    ])
                ],
                [
                    'page_slug' => 'main',
                    'key' => 'quick_donate',
                    'element' => json_encode([
                        'main' => [
                            'background' => '/uploads/defaults/bg1.jpg',
                            'payment_img' => '/uploads/defaults/payment-card-logo-sm.png',
                            'active' => 'true',
                            'heading' => 'Make a Donation Now!',
                            'title_1' => 'I Want to Donate for',
                            'title_2' => 'Statements',
                            'title_3' => 'Enter the amount',
                            'title_4' => 'Payment System',
                            'link_title' => 'Donate Now',
                            'link_url' => '/',
                        ],

                    ]),
                    'lang' => json_encode([
                        'ru' => [
                            'main' => [
                                'background' => '/uploads/defaults/bg1.jpg',
                                'payment_img' => '/uploads/defaults/payment-card-logo-sm.png',
                                'active' => 'true',
                                'heading' => 'Пожертвовать сейчас!',
                                'title_1' => 'Я хочу пожертвовать',
                                'title_2' => 'Заявки на помощь',
                                'title_3' => 'Укажите сумму',
                                'title_4' => 'Платежная система',
                                'link_title' => 'Пожертвовать',
                                'link_url' => '/',
                            ],

                        ],
                        'ua' => [
                            'main' => [
                                'background' => '/uploads/defaults/bg1.jpg',
                                'payment_img' => '/uploads/defaults/payment-card-logo-sm.png',
                                'active' => 'true',
                                'heading' => 'Пожертвувати зараз!',
                                'title_1' => 'Я хочу пожертвувати',
                                'title_2' => 'Заявки на допомогу',
                                'title_3' => 'Вказати суму',
                                'title_4' => 'Платежніжна система',
                                'link_title' => 'Пожертвувати',
                                'link_url' => '/',
                            ],

                        ]
                    ])
                ],

            ]);
        }

    }
}
