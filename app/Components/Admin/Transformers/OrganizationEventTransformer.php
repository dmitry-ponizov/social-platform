<?php

namespace App\Components\Admin\Transformers;

use App\Components\Admin\Models\OrganizationEvent;
use League\Fractal\TransformerAbstract;

class OrganizationEventTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['organization'];


    public function transform(OrganizationEvent $event)
    {
        return [
            'id' => $event->id,
            'body' => $event->body,
            'photo_report' => array_map(function($photo){
                return  '/uploads/organization/events/' . $photo;
            },$event->photo_report),
            'created_at' => $event->created_at->toDateTimeString(),
            'created_at_human' => $event->created_at->diffForHumans()
        ];
    }


    public function includeOrganization(OrganizationEvent $event)
    {
        return $this->item($event->organization, new OrganizationTransformer());
    }



}