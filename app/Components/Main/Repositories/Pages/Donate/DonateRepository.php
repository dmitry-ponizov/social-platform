<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Category;
use App\Components\Main\Models\Statement;

use App\Components\Main\Models\Settings;
use Httpful\Request;
use Carbon\Carbon;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;

class DonateRepository extends BaseRepository
{

    protected $statement_model;
    protected $categories_model;
    protected $settings_model;

    public function __construct(
        Statement $statement,
        Category $category,
        Settings $settings
    )
    {
        $this->statement_model = $statement;
        $this->categories_model = $category;
        $this->settings_model = $settings;
    }

    public function getStatements()
    {
        $statements = $this->statement_model
            ->where([
                ['status', '!=', 'closed'],
                ['published', 1],
            ])
            ->whereNotNull('sum')
            ->with('user', 'category', 'images')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $result = [];
        foreach ($statements as $statement) {
            $result[$statement->id] = [
                'id' => $statement->id,
                'uuid' => $statement->uuid,
                'title' => $statement->title,
                'sum' => $statement->sum,
                'raised' => $statement->raised,
                'description' => $statement->description,
                'created_at' => Carbon::parse($statement->created_at)->format('Y.m.d h:i:s'),
            ];

            foreach ($statement->images as $image) {
                if ($image->main) {
                    $result[$statement->id]['image'] = '/uploads/statements/small/' . $image->name;
                }
            }
        }
        return $result;
    }

    public function getCategories()
    {
        $categories = $this->categories_model->get();

        $local = \App::getlocale();

        $result = [];
        foreach ($categories as $category) {
            $lang = json_decode($category->lang);

            $result [$category->id] = [
                'title' => $lang->$local
            ];

        }

        return $result;
    }


    public function getStatement($id)
    {
        return $this->statement_model->where('uuid', $id)->first();
    }

    public function updateSettings($request)
    {
        $element_col = $this->settings_model->where('key', 'quick_donate')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $heading = $request->heading;

        $title_1 = $request->title_1;

        $title_2 = $request->title_2;

        $title_3 = $request->title_3;

        $title_4 = $request->title_4;

        $link_title = $request->link_title;

        $link_url = $request->link_url;

        if ($request->hasFile('background')) {

            $background = $request->background;

            $background_new_name = time() . $background->getClientOriginalName();

            $background->move('uploads/page/backgrounds/', $background_new_name);

            $background = '/uploads/page/backgrounds/' . $background_new_name;

        }
        if ($request->hasFile('payment_img')) {

            $background = $request->payment_img;

            $payment_img_new_name = time() . $background->getClientOriginalName();

            $background->move('uploads/page/backgrounds/', $payment_img_new_name);

            $payment_img = '/uploads/page/backgrounds/' . $payment_img_new_name;

        }
        $prepare = [];

        foreach ($heading as $lang => $value) {
            $prepare[$lang] = [
                'heading' => $value,
                'active' => $element['element']['main']['active'],
                'title_1' => $title_1[$lang],
                'title_2' => $title_2[$lang],
                'title_3' => $title_3[$lang],
                'title_4' => $title_4[$lang],
                'link_title' => $link_title[$lang],
                'link_url' => $link_url,
                'background' => (isset($background)) ? $background : $element['element']['main']['background'],
                'payment_img' => (isset($payment_img)) ? $payment_img : $element['element']['main']['payment_img'],
            ];
        }


        $element['element']['main'] = $prepare['en'];

        $element['lang']['ru']['main'] = $prepare['ru'];

        $element['lang']['ua']['main'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }
}