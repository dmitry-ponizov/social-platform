<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('roles')->where('name', 'admin')->exists();
        if (!$role) {
            DB::table('roles')->insert(
                [
                    'name' => 'admin',
                    'lang' => json_encode([
                        'ru' => 'Администратор',
                        'ua' => 'Администратор',
                        'en' => 'Administrator'
                    ])
                ]);
        }

        $categories = DB::table('categories')
            ->whereIn('name',
                [
                    'Job',
                    'Service',
                    'Clothes',
                    'House recovering',
                    'House ware',
                    'Medical care',
                    'Other',
                    'Admin',
                    'Volunteer'
                ])
            ->exists();

        if (!$categories) {
            DB::table('categories')->insert([
                [
                    'name' => 'Job',
                    'lang' => json_encode([
                        'ru' => 'В работе',
                        'ua' => 'В роботі',
                        'en' => 'Job'
                    ])

                ],
                [
                    'name' => 'Service',
                    'lang' => json_encode([
                        'ru' => 'В услугах',
                        'ua' => 'В послугах',
                        'en' => 'Service'
                    ])

                ],
                [
                    'name' => 'Clothes',
                    'lang' => json_encode([
                        'ru' => 'В одежде',
                        'ua' => 'З одягом',
                        'en' => 'Clothes'
                    ])

                ],
                [
                    'name' => 'House recovering',
                    'lang' => json_encode([
                        'ru' => 'В восстановлении',
                        'ua' => 'У відновленні',
                        'en' => 'House recovering'
                    ])

                ],
                [
                    'name' => 'House ware',
                    'lang' => json_encode([
                        'ru' => 'В предметах быта',
                        'ua' => 'В предметах побуту',
                        'en' => 'House ware'
                    ])

                ],
                [
                    'name' => 'Medical care',
                    'lang' => json_encode([
                        'ru' => 'В медицине',
                        'ua' => 'В медицині',
                        'en' => 'Medical care'
                    ])

                ],
                [
                    'name' => 'Other',
                    'lang' => json_encode([
                        'ru' => 'Другое',
                        'ua' => 'Інше',
                        'en' => 'Other'
                    ])

                ],
                [
                    'name' => 'Admin',
                    'lang' => json_encode([
                        'ru' => 'Администратор',
                        'ua' => 'Администратор',
                        'en' => 'Admin'
                    ])
                ],
                [
                    'name' => 'Volunteer',
                    'lang' => json_encode([
                        'ru' => 'Волонтер',
                        'ua' => 'Волонтер',
                        'en' => 'volunteer'
                    ])
                ],
            ]);
        }

        $permissions = DB::table('permissions')
            ->whereIn('slug',
                [
                    'view_admin',
                    'create_user',
                    'edit_user',
                    'view_user',
                    'delete_user',
                    'block_user',
                    'edit_user_roles',
                    'show_user_detail',
                    'edit_user_permissions',
                    'edit_role_users',
                    'edit_role_permissions',
                    'edit_role',
                    'view_role',
                    'create_role',
                    'delete_role',
                    'edit_permission_roles',
                    'edit_permission_users',
                    'view_permission',
                    'create_permission',
                    'edit_permission',
                    'delete_permission',
                    'view_category',
                    'create_category',
                    'edit_category',
                    'delete_category',
                    'edit_category_statement',
                    'edit_rules_category',
                    'view_offers_list',
                    'edit_offer',
                    'delete_offer',
                    'view_offer',
                    'publish_offer',
                    'edit_offer',
                    'accept_offer',
                    'close_offer',
                    'view_rules_list',
                    'show_user_rules',
                    'create_rule',
                    'edit_rule',
                    'delete_rule',
                    'edit_categories_rule',
                    'view_global_settings',
                    'edit_global_settings',
                    'view_sliders',
                    'edit_slider',
                    'create_slider',
                    'edit_rule',
                    'delete_slider',
                    'view_statements_list',
                    'edit_statement',
                    'delete_statement',
                    'view_statement',
                    'publish_statement',
                    'accept_statement',
                    'close_statement',
                    'view_rules_statement'

                ])
            ->exists();

        if (!$permissions) {
            DB::table('permissions')->insert([
                [
                    'label' => 'view admin',
                    'slug' => 'view_admin',
                    'lang' => json_encode([
                        'ru' => 'Показазывать админку',
                        'ua' => 'Показувати админку',
                        'en' => 'View admin'
                    ])

                ],
                [
                    'label' => 'create user',
                    'slug' => 'create_user',
                    'lang' => json_encode([
                        'ru' => 'Создать пользователя',
                        'ua' => 'Створити користувача',
                        'en' => 'Create user'
                    ])

                ],
                [
                    'label' => 'edit user',
                    'slug' => 'edit_user',
                    'lang' => json_encode([
                        'ru' => 'Редактировать пользователя',
                        'ua' => 'Редагувати користувача',
                        'en' => 'Edit user'
                    ])

                ],
                [
                    'label' => 'view user',
                    'slug' => 'view_user',
                    'lang' => json_encode([
                        'ru' => 'Показазывать пользователя',
                        'ua' => 'Показувати користувача',
                        'en' => 'View user'
                    ])

                ],
                [
                    'label' => 'delete user',
                    'slug' => 'delete_user',
                    'lang' => json_encode([
                        'ru' => 'Удалить пользователя',
                        'ua' => 'Видалити користувача',
                        'en' => 'Delete user'
                    ])

                ],
                [
                    'label' => 'block user',
                    'slug' => 'block_user',
                    'lang' => json_encode([
                        'ru' => 'Заблокировать пользователя',
                        'ua' => 'Заблокувати користувача',
                        'en' => 'Block user'
                    ])

                ],
                [
                    'label' => 'edit user roles',
                    'slug' => 'edit_user_roles',
                    'lang' => json_encode([
                        'ru' => 'Редактировать роли пользователя',
                        'ua' => 'Редагувати ролі користувача',
                        'en' => 'Edit user roles'
                    ])

                ],
                [
                    'label' => 'show user detail',
                    'slug' => 'show_user_detail',
                    'lang' => json_encode([
                        'ru' => 'Показывать данные пользователя',
                        'ua' => 'Показывать дані користувача',
                        'en' => 'Show user detail'
                    ])

                ],
                [
                    'label' => 'edit user permissions',
                    'slug' => 'edit_user_permissions',
                    'lang' => json_encode([
                        'ru' => 'Редактировать разрешения пользователя',
                        'ua' => 'Редагувати дозволи користувача',
                        'en' => 'Edit user permissions'
                    ])

                ],
                [
                    'label' => 'edit role users',
                    'slug' => 'edit_role_users',
                    'lang' => json_encode([
                        'ru' => 'Редактировать пользователей роли',
                        'ua' => 'Редагувати користувачив роли',
                        'en' => 'Edit role users'
                    ])

                ],
                [
                    'label' => 'edit role permissions',
                    'slug' => 'edit_role_permissions',
                    'lang' => json_encode([
                        'ru' => 'Редактировать разрешения роли',
                        'ua' => 'Редагувати дозвили роли',
                        'en' => 'Edit role permissions'
                    ])

                ],
                [
                    'label' => 'edit role',
                    'slug' => 'edit_role',
                    'lang' => json_encode([
                        'ru' => 'Редактировать роль',
                        'ua' => 'Редагувати роль',
                        'en' => 'Edit role'
                    ])

                ],
                [
                    'label' => 'view role',
                    'slug' => 'view_role',
                    'lang' => json_encode([
                        'ru' => 'Показазывать роль',
                        'ua' => 'Показувати роль',
                        'en' => 'View role'
                    ])

                ],
                [
                    'label' => 'create role',
                    'slug' => 'create_role',
                    'lang' => json_encode([
                        'ru' => 'Создать роль',
                        'ua' => 'Створити роль',
                        'en' => 'Create role'
                    ])

                ],
                [
                    'label' => 'delete role',
                    'slug' => 'delete_role',
                    'lang' => json_encode([
                        'ru' => 'Удалить роль',
                        'ua' => 'Видалити роль',
                        'en' => 'Delete role'
                    ])

                ],
                [
                    'label' => 'edit permission roles',
                    'slug' => 'edit_permission_roles',
                    'lang' => json_encode([
                        'ru' => 'Редактировать роли разрешения',
                        'ua' => 'Редагувати роли дозволу',
                        'en' => 'Edit permission roles'
                    ])

                ],
                [
                    'label' => 'edit permission users',
                    'slug' => 'edit_permission_users',
                    'lang' => json_encode([
                        'ru' => 'Редактировать пользователей разрешения',
                        'ua' => 'Редагувати користувачив дозволу',
                        'en' => 'Edit permission users'
                    ])

                ],
                [
                    'label' => 'view permission',
                    'slug' => 'view_permission',
                    'lang' => json_encode([
                        'ru' => 'Показывать разрешение',
                        'ua' => 'Показувати дозвил',
                        'en' => 'View permission'
                    ])

                ],
                [
                    'label' => 'create permission',
                    'slug' => 'create_permission',
                    'lang' => json_encode([
                        'ru' => 'Создать разрешение',
                        'ua' => 'Створити дозвил',
                        'en' => 'Create permission'
                    ])

                ],
                [
                    'label' => 'edit permission',
                    'slug' => 'edit_permission',
                    'lang' => json_encode([
                        'ru' => 'Редактировать разрешение',
                        'ua' => 'Редагувати дозвил',
                        'en' => 'Edit permission'
                    ])

                ],
                [
                    'label' => 'delete permission',
                    'slug' => 'delete_permission',
                    'lang' => json_encode([
                        'ru' => 'Удалить разрешение',
                        'ua' => 'Видалити дозвил',
                        'en' => 'Delete permission'
                    ])

                ],
                [
                    'label' => 'view category',
                    'slug' => 'view_category',
                    'lang' => json_encode([
                        'ru' => 'Показазывать категории',
                        'ua' => 'Показувати категорію',
                        'en' => 'View category'
                    ])

                ],
                [
                    'label' => 'create category',
                    'slug' => 'create_category',
                    'lang' => json_encode([
                        'ru' => 'Создать категорию',
                        'ua' => 'Створити категорію',
                        'en' => 'Create category'
                    ])

                ],
                [
                    'label' => 'edit category',
                    'slug' => 'edit_category',
                    'lang' => json_encode([
                        'ru' => 'Редактировать категорию',
                        'ua' => 'Редагувати категорію',
                        'en' => 'Edit category'
                    ])

                ],
                [
                    'label' => 'delete category',
                    'slug' => 'delete_category',
                    'lang' => json_encode([
                        'ru' => 'Удалить категорию',
                        'ua' => 'Удалить категорію',
                        'en' => 'Delete category'
                    ])

                ],
                [
                    'label' => 'edit category statement',
                    'slug' => 'edit_category_statement',
                    'lang' => json_encode([
                        'ru' => 'Редактировать заявки категории',
                        'ua' => 'Редагувати заявки категорії',
                        'en' => 'Edit category statement'
                    ])

                ],
                [
                    'label' => 'edit rules category',
                    'slug' => 'edit_rules_category',
                    'lang' => json_encode([
                        'ru' => 'Редактировать  правила категории',
                        'ua' => 'Редагувати правила катагорії',
                        'en' => 'Edit category rules'
                    ])

                ],
                [
                    'label' => 'view offer list',
                    'slug' => 'view_offers_list',
                    'lang' => json_encode([
                        'ru' => 'Показывать список предложений',
                        'ua' => 'Показувати лист пропозицiй',
                        'en' => 'View offer list'
                    ])

                ],
                [
                    'label' => 'edit offer',
                    'slug' => 'edit_offer',
                    'lang' => json_encode([
                        'ru' => 'Редактировать предложение',
                        'ua' => 'Редагувати пропозицію',
                        'en' => 'Edit offer'
                    ])

                ],
                [
                    'label' => 'delete offer',
                    'slug' => 'delete_offer',
                    'lang' => json_encode([
                        'ru' => 'Удалить предложение',
                        'ua' => 'Видалити пропозицію',
                        'en' => 'Delete offer'
                    ])

                ],
                [
                    'label' => 'view offer',
                    'slug' => 'view_offer',
                    'lang' => json_encode([
                        'ru' => 'Просмотреть предложение',
                        'ua' => 'Подивитись пропозицію',
                        'en' => 'View offer'
                    ])

                ],
                [
                    'label' => 'publish offer',
                    'slug' => 'publish_offer',
                    'lang' => json_encode([
                        'ru' => 'Опубликовать предложение',
                        'ua' => 'Опублікувати пропозицію',
                        'en' => 'Publish order'
                    ])

                ],
                [
                    'label' => 'accept offer',
                    'slug' => 'accept_offer',
                    'lang' => json_encode([
                        'ru' => 'Принять предложение',
                        'ua' => 'Прийняти пропозицію',
                        'en' => 'Take order'
                    ])

                ],
                [
                    'label' => 'close offer',
                    'slug' => 'close_offer',
                    'lang' => json_encode([
                        'ru' => 'Закрыть предложение',
                        'ua' => 'Закрити пропозицію',
                        'en' => 'Close order'
                    ])

                ],
                [
                    'label' => 'view rules list',
                    'slug' => 'view_rules_list',
                    'lang' => json_encode([
                        'ru' => 'Показывать список правил',
                        'ua' => 'Показувати лист правил',
                        'en' => 'View rules list'
                    ])

                ],
                [
                    'label' => 'show user rules',
                    'slug' => 'show_user_rules',
                    'lang' => json_encode([
                        'ru' => 'Показать правила пользователя',
                        'ua' => 'Показувати правила користувача',
                        'en' => 'Show user rules'
                    ])

                ],
                [
                    'label' => 'create rule',
                    'slug' => 'create_rule',
                    'lang' => json_encode([
                        'ru' => 'Создать правило',
                        'ua' => 'Додати правило',
                        'en' => 'Create rule'
                    ])

                ],
                [
                    'label' => 'edit rule',
                    'slug' => 'edit_rule',
                    'lang' => json_encode([
                        'ru' => 'Редактировать правило',
                        'ua' => 'Редагувати правило',
                        'en' => 'Edit rule'
                    ])

                ],
                [
                    'label' => 'delete rule',
                    'slug' => 'delete_rule',
                    'lang' => json_encode([
                        'ru' => 'Удалить правило',
                        'ua' => 'Видалити правило',
                        'en' => 'Delete rule'
                    ])

                ],
                [
                    'label' => 'edit categories rule',
                    'slug' => 'edit_categories_rule',
                    'lang' => json_encode([
                        'ru' => 'Редактировать категории правила',
                        'ua' => 'Редагувати катагорії правила',
                        'en' => 'Edit categories rule'
                    ])

                ],
                [
                    'label' => 'view global settings',
                    'slug' => 'view_global_settings',
                    'lang' => json_encode([
                        'ru' => 'Показывать глобальные настройки',
                        'ua' => 'Показувати глобальні налаштування',
                        'en' => 'View global settings'
                    ])

                ],
                [
                    'label' => 'edit global settings',
                    'slug' => 'edit_global_settings',
                    'lang' => json_encode([
                        'ru' => 'Редактировать глобальные настройки',
                        'ua' => 'Редагувати глобальні налаштування',
                        'en' => 'Edit global settings'
                    ])

                ],
                [
                    'label' => 'view sliders',
                    'slug' => 'view_sliders',
                    'lang' => json_encode([
                        'ru' => 'Просмотреть слайдеры',
                        'ua' => 'Продивитись слайдери',
                        'en' => 'View sliders'
                    ])

                ],
                [
                    'label' => 'edit slider',
                    'slug' => 'edit_slider',
                    'lang' => json_encode([
                        'ru' => 'Редактировать слайдер',
                        'ua' => 'Редагувати слайдер',
                        'en' => 'Edit slider'
                    ])

                ],
                [
                    'label' => 'create slider',
                    'slug' => 'create_slider',
                    'lang' => json_encode([
                        'ru' => 'Добавить слайдер',
                        'ua' => 'Додати слайдер',
                        'en' => 'Create slider'
                    ])

                ],
                [
                    'label' => 'delete slider',
                    'slug' => 'delete_slider',
                    'lang' => json_encode([
                        'ru' => 'Удалить слайдер',
                        'ua' => 'Видалити слайдер',
                        'en' => 'Delete slider'
                    ])

                ],
                [
                    'label' => 'view statement list',
                    'slug' => 'view_statements_list',
                    'lang' => json_encode([
                        'ru' => 'Показывать список заявок',
                        'ua' => 'Показувати лист заявкок',
                        'en' => 'View statements list'
                    ])

                ],
                [
                    'label' => 'edit statement',
                    'slug' => 'edit_statement',
                    'lang' => json_encode([
                        'ru' => 'Редактировать заявку',
                        'ua' => 'Редагувати заявку',
                        'en' => 'Edit statement'
                    ])

                ],
                [
                    'label' => 'delete statement',
                    'slug' => 'delete_statement',
                    'lang' => json_encode([
                        'ru' => 'Удалить заявку',
                        'ua' => 'Видалити заявку',
                        'en' => 'Delete statement'
                    ])

                ],
                [
                    'label' => 'view statement',
                    'slug' => 'view_statement',
                    'lang' => json_encode([
                        'ru' => 'Просмотреть заявку',
                        'ua' => 'Подивитись заявку',
                        'en' => 'View statement'
                    ])

                ],
                [
                    'label' => 'publish statement',
                    'slug' => 'publish_statement',
                    'lang' => json_encode([
                        'ru' => 'Опубликовать заявку',
                        'ua' => 'Опублікувати заявку',
                        'en' => 'Publish statement'
                    ])

                ],
                [
                    'label' => 'accept statement',
                    'slug' => 'accept_statement',
                    'lang' => json_encode([
                        'ru' => 'Принять заявку',
                        'ua' => 'Прийняти заявку',
                        'en' => 'Take statement'
                    ])

                ],
                [
                    'label' => 'close statement',
                    'slug' => 'close_statement',
                    'lang' => json_encode([
                        'ru' => 'Закрыть заявку',
                        'ua' => 'Закрити заявку',
                        'en' => 'Close statement'
                    ])

                ],
                [
                    'label' => 'view rules statement',
                    'slug' => 'view_rules_statement',
                    'lang' => json_encode([
                        'ru' => 'Просмотреть правила заявки',
                        'ua' => 'Просмотреть правила заявки',
                        'en' => 'View rules statement'
                    ])

                ],
            ]);

        }

        $groups = DB::table('groups')
            ->whereIn('slug',
                [
                    'profile',
                    'documents',
                    'general_info',
                    'contact_info',
                    'place_of_residence',
                ])
            ->exists();

        if (!$groups) {
            DB::table('groups')->insert([

                [
                    'label' => 'profile',
                    'slug' => 'profile',
                    'parent_id' => 0,
                    'lang' => json_encode([
                        'ru' => 'Профиль',
                        'ua' => 'Профіль',
                        'en' => 'Profile'
                    ])
                ],
                [
                    'label' => 'documents',
                    'slug' => 'documents',
                    'parent_id' => 0,
                    'lang' => json_encode([
                        'ru' => 'Документы',
                        'ua' => 'Документи',
                        'en' => 'Documents'
                    ])
                ],
                [
                    'label' => 'general info',
                    'slug' => 'general_info',
                    'parent_id' => 1,
                    'lang' => json_encode([
                        'ru' => 'Общая информация',
                        'ua' => 'Загальна інформація',
                        'en' => 'General info'
                    ])
                ],
                [
                    'label' => 'contact info',
                    'slug' => 'contact_info',
                    'parent_id' => 1,
                    'lang' => json_encode([
                        'ru' => 'Контактная информация',
                        'ua' => "Контактна інформація",
                        'en' => 'Contact info'
                    ])
                ],
                [
                    'label' => 'place of residence',
                    'slug' => 'place_of_residence',
                    'parent_id' => 1,
                    'lang' => json_encode([
                        'ru' => 'Место проживания',
                        'ua' => "Місце проживання",
                        'en' => 'Place of residence'
                    ])
                ],
                [
                    'label' => 'documents',
                    'slug' => 'documents',
                    'parent_id' => 2,
                    'lang' => json_encode([
                        'ru' => 'Документы',
                        'ua' => 'Документи',
                        'en' => 'Documents'
                    ])
                ],
            ]);
        }

        $rules = DB::table('rules')
            ->whereIn('slug',
                [
                    'surname',
                    'name',
                    'patronymic',
                    'birthday',
                    'identification_number',
                    'gender',
                    'place_of_registration',
                    'region',
                    'city',
                    'area',
                    'street',
                    'house',
                    'apartment',
                    'mobile_phone',
                    'home_phone',
                    'email',
                    'about',
                    'skype',
                    'facebook',
                    'google',
                    'twitter',
                    'about',
                    'skype',
                    'facebook',

                ])
            ->exists();
        if (!$rules) {
            DB::table('rules')->insert([

                [
                    'label' => 'surname',
                    'slug' => 'surname',
                    'type' => 'text',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Фамилия',
                        'ua' => 'Призвище',
                        'en' => 'Surname'
                    ])
                ],
                [
                    'label' => 'name',
                    'slug' => 'name',
                    'type' => 'text',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Имя',
                        'ua' => "Ім'я",
                        'en' => 'Name'
                    ])
                ],
                [
                    'label' => 'patronymic',
                    'slug' => 'patronymic',
                    'type' => 'text',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Отчество',
                        'ua' => 'По батькові',
                        'en' => 'Patronymic'
                    ])
                ],
                [
                    'label' => 'birthday',
                    'slug' => 'birthday',
                    'type' => 'date',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'День рождения',
                        'ua' => 'День народження',
                        'en' => 'Birthday'
                    ])
                ],
                [
                    'label' => 'Identification number',
                    'slug' => 'identification_number',
                    'type' => 'text',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Индентификационный номер',
                        'ua' => 'Ідентифікаційний номер',
                        'en' => 'Identification number'
                    ])
                ],
                [
                    'label' => 'Gender',
                    'slug' => 'gender',
                    'type' => 'text',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Пол',
                        'ua' => 'Стать',
                        'en' => 'Gender'
                    ])
                ],
                [
                    'label' => 'place of registration',
                    'slug' => 'place_of_registration',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Место регистрации',
                        'ua' => 'Місце реєстрації',
                        'en' => 'Place of registration'
                    ])
                ],
                [
                    'label' => 'region',
                    'slug' => 'region',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Область',
                        'ua' => 'Область',
                        'en' => 'Region'
                    ])
                ],
                [
                    'label' => 'area',
                    'slug' => 'area',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Район',
                        'ua' => 'Район',
                        'en' => 'Area'
                    ])
                ],
                [
                    'label' => 'city',
                    'slug' => 'city',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Город',
                        'ua' => 'Місто',
                        'en' => 'Сity'
                    ])
                ],
                [
                    'label' => 'street',
                    'slug' => 'street',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Улица',
                        'ua' => 'Вулиця',
                        'en' => 'Street'
                    ])
                ],
                [
                    'label' => 'house',
                    'slug' => 'house',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Дом',
                        'ua' => 'Будинок',
                        'en' => 'House'
                    ])
                ],
                [
                    'label' => 'apartment',
                    'slug' => 'apartment',
                    'type' => 'text',
                    'group_id' => 5,
                    'lang' => json_encode([
                        'ru' => 'Квартира',
                        'ua' => 'Квартира',
                        'en' => 'Apartment'
                    ])
                ],
                [
                    'label' => 'mobile phone',
                    'slug' => 'mobile_phone',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Мобильный телефон',
                        'ua' => 'Мобільний телефон',
                        'en' => 'Mobile phone'
                    ])
                ],
                [
                    'label' => 'home phone',
                    'slug' => 'home_phone',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Домашний телефон',
                        'ua' => 'Домашній телефон',
                        'en' => 'Home phone'
                    ])
                ],
                [
                    'label' => 'email',
                    'slug' => 'email',
                    'type' => 'email',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Электронный адресс',
                        'ua' => 'Електронна адреса',
                        'en' => 'Email'
                    ])
                ],
                [
                    'label' => 'about_me',
                    'slug' => 'about',
                    'type' => 'description',
                    'group_id' => 3,
                    'lang' => json_encode([
                        'ru' => 'Обо мне',
                        'ua' => 'Про мене',
                        'en' => 'About me'
                    ])
                ],
                [
                    'label' => 'skype',
                    'slug' => 'skype',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Skype',
                        'ua' => 'Skype',
                        'en' => 'Skype'
                    ])
                ],
                [
                    'label' => 'facebook',
                    'slug' => 'facebook',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Facebook',
                        'ua' => 'Facebook',
                        'en' => 'Facebook'
                    ])
                ],
                [
                    'label' => 'google',
                    'slug' => 'google',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'Google+',
                        'ua' => 'Google+',
                        'en' => 'Google+'
                    ])
                ],
                [
                    'label' => 'twitter',
                    'slug' => 'twitter',
                    'type' => 'text',
                    'group_id' => 4,
                    'lang' => json_encode([
                        'ru' => 'twitter',
                        'ua' => 'twitter',
                        'en' => 'twitter'
                    ])
                ],

            ]);
        }


        $user = DB::table('users')
            ->where('types', 'admin')
            ->exists();


        if (!$user) {
            DB::table('users')->insert([
                'name' => 'admin',
                'surname' => 'admin',
                'phone' => '+38(050)-1234567',
                'types' => 'admin',
                'avatar' => '/uploads/avatars/no_avatar.jpeg',
                'uuid' => Str::uuid(),
                'password' =>  Hash::make('111111'),
                'created_at' => Carbon::now()
            ]);

            $prepare = [];

            $permissions = DB::table('permissions')->get();

            foreach ($permissions as $permission) {
                $prepare[] = [
                    'user_id' => 1,
                    'permission_id' => $permission->id,
                    'created_at' => Carbon::now()
                ];
            }

            DB::table('user_permissions')->insert($prepare);

        }

        $roles = DB::table('roles')
            ->whereIn('name',
                [
                    'chief',
                    'operator'
                ])
            ->exists();

        if (!$roles) {
            DB::table('roles')->insert([
                [
                    'name' => 'chief',
                    'lang' => json_encode([
                        'ru' => 'Руководитель',
                        'ua' => 'Керівник',
                        'en' => 'Chief'
                    ])
                ],
                [
                    'name' => 'operator',
                    'lang' => json_encode([
                        'ru' => 'Оператор',
                        'ua' => 'Оператор',
                        'en' => 'Operator'
                    ])
                ],

            ]);
        }

    }
}
