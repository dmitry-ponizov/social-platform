<?php

namespace App\Http\Controllers;

use App\Components\Admin\Models\Organization;
use App\Components\Admin\Models\OrganizationEvent;
use App\Http\Requests\CreateOrganizationEventImage;
use App\Http\Requests\StoreOrganizationEventRequest;
use App\Components\Admin\Repositories\OrganizationEventRepository as Repository;
use App\Http\Requests\UpdateOrganizationEventBodyRequest;
use App\Http\Requests\UpdateOrganizationEventImageRequest;

class OrganizationEventController extends Controller
{

    /**
     * @param Repository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all(Repository $repository)
    {
        $events = $repository->getAllEvents();

        return view('admin.organizations.events.all', compact('events'));
    }

    /**
     * @param Repository $repository
     * @param Organization $organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Repository $repository, Organization $organization)
    {
        $events = $repository->getOrganizationEvents($organization);

        return view('admin.organizations.events.index', compact('events'));
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Organization $organization)
    {
        return view('admin.organizations.events.create', compact('organization'));
    }

    /**
     * @param StoreOrganizationEventRequest $request
     * @param Repository $repository
     * @param Organization $organization
     */
    public function store(StoreOrganizationEventRequest $request, Repository $repository, Organization $organization)
    {
        $result = $repository->createEvent($request, $organization);

        return $result ?: abort(400, 'Error');
    }

    /**
     * @param Organization $organization
     * @param $id
     * @param Repository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Organization $organization, $id, Repository $repository)
    {
        $event = $repository->getEventById($id);

        return view('admin.organizations.events.edit', compact('event'));
    }

    /**
     * @param Organization $organization
     * @param $id
     * @param Repository $repository
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Organization $organization, $id, Repository $repository)
    {
        $result = $repository->deleteEvent($id);

        return $result ? back() : abort(400, 'Error');
    }

    /**
     * @param UpdateOrganizationEventImageRequest $request
     * @param Repository $repository
     */
    public function updateImage(UpdateOrganizationEventImageRequest $request, Repository $repository)
    {
        $image = $request->file('image');

        $event_id = $request->id;

        $image_index = $request->index;

        $result = $repository->updateEventImage($image, $event_id, $image_index);

        return $result ?: abort(400, 'Error');
    }

    /**
     * @param CreateOrganizationEventImage $request
     * @param Repository $repository
     */
    public function addImage(CreateOrganizationEventImage $request, Repository $repository)
    {
        $image = $request->file('image');

        $event_id = $request->id;

        $result = $repository->addEventImage($image, $event_id);

        return $result ?: abort(400, 'Error');
    }

    /**
     * @param UpdateOrganizationEventBodyRequest $request
     * @param Repository $repository
     */
    public function updateBody(UpdateOrganizationEventBodyRequest $request, Repository $repository)
    {
        $body = $request->body;

        $id = $request->id;

        $result = $repository->updateEventBody($body, $id);

        return $result ?: abort(400, 'Error');
    }
}
