<?php

namespace App\Components\Admin\Transformers;

use App\Components\Admin\Models\Organization;
use League\Fractal\TransformerAbstract;

class OrganizationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['events'];

    public function transform(Organization $organization)
    {
        return [
            'id' => $organization->id,
            'slug' => $organization->slug,
            'name' => $organization->name,
            'code' => $organization->code,
            'city' => $organization->city,
            'street' => $organization->street,
            'house' => $organization->house,
            'office' => $organization->office,
            'phone' => $organization->phone,
            'email' => $organization->email,
            'logo' => '/uploads/organization/' . $organization->logo,
            'created_at' => $organization->created_at->toDateTimeString(),
            'created_at_human' => $organization->created_at->diffForHumans()
        ];
    }


    public function includeEvents(Organization $organization)
    {
        return $this->collection($organization->events, new OrganizationEventTransformer());
    }
}