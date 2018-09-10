<?php

namespace App\Components\Admin\Transformers;

use App\Components\Admin\Models\Partner;
use League\Fractal\TransformerAbstract;

class PartnerTransformer extends TransformerAbstract
{


	public function transform(Partner $partner)
	{

		return [
			'id' => $partner->id,
			'slug' => $partner->slug,
			'name' => $partner->name,
			'url' => $partner->url,
			'publish' => $partner->publish,
			'photo' => '/uploads/partners/' . $partner->photo,
			'created_at' => $partner->created_at->toDateTimeString(),
			'about' => $partner->about,

		];
	}

}