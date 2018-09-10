<?php

namespace App\Components\Admin\Repositories;

use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Partner;
use App\Components\Admin\Transformers\PartnerTransformer;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Images;

class PartnerRepository extends BaseRepository
{

	protected $model;


	public function __construct(Partner $partner)
	{
		$this->model = $partner;

	}

	/**
	 * @return array
	 */
	public function getAllPartners($published = false): array
	{
		$query = $this->model;

		if($published) {
			$partners = $query->where('publish', true)->get();
		} else {
			$partners = $query->get();
		}

		return fractal()
			->collection($partners)
			->transformWith(new PartnerTransformer())
			->toArray();
	}

	/**
	 * @param $name
	 * @param $url
	 * @param $file
	 * @param $about
	 * @return bool
	 */
	public function store($name, $url, $file, $about): bool
	{
		try {
			$file_name = $this->moveFile($file);

			$this->model->create([
				'name' => $name,
				'url' => $url,
				'slug' => str_slug($name, '_'),
				'photo' => $file_name,
				'about' => $about
			]);
			return true;
		} catch (\Exception $exception) {
			return false;
		}

	}

	/**
	 * @param $image
	 * @return string
	 */
	protected function moveFile($image): string
	{
		$uuid = Str::uuid();

		$file_name = $uuid->toString();

		$explode = explode('.', $image->getClientOriginalName());

		$count = count($explode);

		$exp = $explode[$count - 1];

		$file_new_name = $file_name . "." . $exp;

		Images::make($image)
			->resize(250, 225)
			->encode($exp, 90)
			->save('uploads/partners/' . $file_new_name);

		return $file_new_name;
	}

	/**
	 * @param $slug
	 * @return bool
	 */
	public function getBySlug($slug)
	{
		try {
			$partner = $this->model->where('slug', $slug)->first();

			if ($partner) {
				return fractal()
					->item($partner)
					->transformWith(new PartnerTransformer())
					->toArray();
			}
			return false;

		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * @param $slug
	 * @return bool
	 */
	public function publish($slug): bool
	{
		try {
			$partner = $this->model->where('slug', $slug)->first();

			$partner->update(['publish' => !$partner->publish]);

			return true;

		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * @param $slug
	 * @param $request
	 * @return bool
	 */
	public function updatePartner($slug, $request): bool
	{
		try {
			$partner = $this->model->where('slug', $slug)->first();

			$partner->name = $request->name;
			$partner->url = $request->url;
			$partner->about = $request->about;

			if ($request->hasFile('photo')) {

				$file = $request->file('photo');

				$file_name = $this->moveFile($file);

				\File::delete('uploads/partners', $partner->photo);

				$partner->photo = $file_name;

			}

			$partner->save();

			return true;

		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * @param $slug
	 * @return bool
	 */
	public function delete($slug): bool
	{
		try {
			$partner = $this->model->where('slug', $slug)->first();

			$photo = $partner->photo;

			$partner->delete();

			\File::delete('uploads/partners/' . $photo);

			return true;

		} catch (\Exception $e) {
			return false;
		}

	}

	/**
	 * @param $request
	 * @return bool
	 */
	public function updatePartnersBlock($request): bool
	{
		$element_col = Settings::where('key', 'partners')->first();

		$element = $element_col->toArray();

		$element['element'] = json_decode($element['element'], true);

		$element['lang'] = json_decode($element['lang'], true);

		$title = $request->title;

		$heading = $request->heading;

		foreach ($title as $lang => $value) {
			$prepare[$lang] = [
				'title' => $value,
				'active' => $element['element']['wrap']['active'],
				'heading' => $heading[$lang],
			];
		}

		$element['element']['wrap'] = $prepare['en'];

		$element['lang']['ru']['wrap'] = $prepare['ru'];

		$element['lang']['ua']['wrap'] = $prepare['ua'];

		$element_col->element = json_encode($element['element']);

		$element_col->lang = json_encode($element['lang']);

		$element_col->save();

		return true;
	}

	/**
	 * @param $request
	 * @return bool
	 */
	public function updateCount($request): bool
	{
		$element_col = Settings::where('key', 'partners')->first();

		$element = $element_col->toArray();

		$element['element'] = json_decode($element['element'], true);

		$element['lang'] = json_decode($element['lang'], true);

		$count_slides = $request->count_slides;


		$element['element']['partners'] = [
			'count' => $count_slides,
			'active' => $element['element']['partners']['active'],

		];

		$element['lang']['ru']['partners'] = [
			'count' => $count_slides,
			'active' => $element['element']['partners']['active'],

		];

		$element['lang']['ua']['partners'] = [
			'count' => $count_slides,
			'active' => $element['element']['partners']['active'],

		];

		$element_col->element = json_encode($element['element']);

		$element_col->lang = json_encode($element['lang']);

		$element_col->save();

		return true;
	}
}