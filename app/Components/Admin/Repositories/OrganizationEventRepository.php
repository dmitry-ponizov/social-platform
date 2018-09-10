<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\OrganizationEvent;
use App\Components\Admin\Transformers\OrganizationEventTransformer;
use App\Components\Admin\Transformers\OrganizationTransformer;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationEventRepository extends BaseRepository
{

    /**
     * @param $request
     * @param $organization
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function createEvent($request, $organization)
    {
        $files = $request->file('photo_report');

        try {
            $event = new OrganizationEvent;

            $event->body = $request->body;

            $event->organization()->associate($organization);

            $files_names = $this->createPhotoReport($files);

            $event->photo_report = $files_names;

            $event->save();

            return response('ok', 200);

        } catch (\Exception $e) {

            abort(400, $e->getMessage());
        }

    }

    /**
     * @param $files
     * @param $new_file_path
     * @return array
     */
    protected function createPhotoReport($files): array
    {
        $new_file_path = [];

        foreach ($files as $key => $file) {

            $uuid = Str::uuid();

            $file_name = $uuid->toString();

            $explode = explode('.', $file->getClientOriginalName());

            $count = count($explode);

            $exp = $explode[$count - 1];

            $file_new_name = $file_name . "." . $exp;

            $file->move('uploads/organization/events', $file_new_name);

            $new_file_path[] = $file_new_name;
        }
        return $new_file_path;
    }

    /**
     * @return mixed
     */
    public function getAllEvents()
    {
        try {
            $events = OrganizationEvent::latest()->paginate(10);

        } catch (\Exception $e) {

            abort(400, $e->getMessage());
        }

       $fractal = fractal()
            ->collection($events)
            ->parseIncludes(['organization'])
            ->transformWith(new OrganizationEventTransformer())
            ->toArray();

        $pagination = [
            'data' => $fractal['data'],
            'pagination' => $events
        ];

        return $pagination;

    }

    /**
     * @param $organization
     * @return mixed
     */
    public function getOrganizationEvents($organization)
    {
        return fractal()
            ->item($organization)
            ->parseIncludes(['events.organization'])
            ->transformWith(new OrganizationTransformer())
            ->toArray();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteEvent($id)
    {
        try {

            $event = OrganizationEvent::find($id);

            foreach ($event->photo_report as $photo) {

                \File::delete('uploads/organization/events/' . $photo);
            }

            $event->delete();

            return true;

        } catch (\Exception $e) {

            abort(400, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEventById($id)
    {
        $event = OrganizationEvent::find($id);

        return fractal()
            ->item($event)
            ->parseIncludes(['organization'])
            ->transformWith(new OrganizationEventTransformer())
            ->toArray();
    }

    /**
     * @param $image
     * @param $event_id
     * @param $image_index
     * @return boolean
     */
    public function updateEventImage($image, $event_id, $image_index): array
    {
        $event = OrganizationEvent::find($event_id);

        $photo_report = $event->photo_report;

        $file_new_name = $this->moveFile($image);

        \File::delete('uploads/organization/events/' . $photo_report[$image_index]);

        $photo_report[$image_index] = $file_new_name;

        $event->update(['photo_report' => $photo_report]);

        return fractal()
            ->item($event)
            ->parseIncludes(['organization'])
            ->transformWith(new OrganizationEventTransformer())
            ->toArray();
    }

    /**
     * @param $image
     * @param $id
     * @return mixed
     */
    public function addEventImage($image, $id)
    {
        $event = OrganizationEvent::find($id);

        $photo_report = $event->photo_report;

        $file_new_name = $this->moveFile($image);

        $photo_report[] = $file_new_name;

        $event->update(['photo_report' => $photo_report]);

        return fractal()
            ->item($event)
            ->parseIncludes(['organization'])
            ->transformWith(new OrganizationEventTransformer())
            ->toArray();
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

        $image->move('uploads/organization/events', $file_new_name);

        return $file_new_name;
    }

    /**
     * @param $body
     * @param $id
     * @return mixed
     */
    public function updateEventBody($body, $id)
    {
        $event = OrganizationEvent::find($id);

        $event->update(['body' => $body]);

        return fractal()
            ->item($event)
            ->parseIncludes(['organization'])
            ->transformWith(new OrganizationEventTransformer())
            ->toArray();
    }

}