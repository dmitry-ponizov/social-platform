<?php

namespace App\Components\Main\Repositories;

use App\Components\Admin\Models\User;
use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Activity;
use App\Components\Main\Models\Statement;
use App\Components\Main\Models\Category;
use Illuminate\Support\Facades\Lang;
use App\Components\Admin\Models\Rule;


class ActivityRepository extends BaseRepository
{


    protected $model;


    public function __construct(Activity $model)
    {
        $this->model = $model;

    }

    public function getHistory()
    {
        list($field, $id) = $this->checkType();

        $activities = Activity::with(['user' => function ($query) use ($field, $id) {
            $query->where($field, $id);
        }])
            ->with('subject')
            ->latest()
            ->paginate(20);


        return $activities;
    }

    public function getStatistic()
    {
        $activities = Activity::where('subject_name', 'statement')
            ->whereHas('user', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            })
            ->with('subject')
            ->get();

        $response = [
            'statements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ],
            'substatements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ]
        ];
        foreach ($activities as $activity) {
            $changes = json_decode($activity->changed, true);
            foreach ($changes as $field => $change) {
                if ($field == 'status') {
                    if ($activity->subject->parent_id == 0) {
                        $response['statements'][$change] += 1;
                    } else {
                        $response['substatements'][$change] += 1;
                    }

                }
            }
            if ($activity->type === 'created') {

                if ($activity->subject->parent_id == 0) {
                    $response['statements']['sent'] += 1;
                } else {
                    $response['substatements']['sent'] += 1;
                }

            }

        }
        $response['amount']['volunteers'] = User::where('organization_id', auth()->user()->organization_id)->count();

        return $response;
    }

    /**
     * @return array
     */
    protected function checkType(): array
    {
        if (auth()->user()->types === 'organization') {
            $field = 'organization_id';
            $id = auth()->user()->organization_id;
        } else {
            $field = 'social_service_id';
            $id = auth()->user()->social_service_id;
        }
        return array($field, $id);
    }


    public function getSocialStatistic()
    {

        $activities = Activity::where('subject_name', 'statement')
            ->whereHas('user', function ($query) {
                $query->where('social_service_id', auth()->user()->social_service_id);
            })
            ->with('subject')
            ->get();

        $response = [
            'statements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ],
            'substatements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ]
        ];
        foreach ($activities as $activity) {
            $changes = json_decode($activity->changed, true);
            foreach ($changes as $field => $change) {
                if ($field == 'status') {
                    if ($activity->subject->parent_id == 0) {
                        $response['statements'][$change] += 1;
                    } else {
                        $response['substatements'][$change] += 1;
                    }

                }
            }
            if ($activity->type === 'created') {

                if ($activity->subject->parent_id == 0) {
                    $response['statements']['sent'] += 1;
                } else {
                    $response['substatements']['sent'] += 1;
                }

            }

        }

        $response['workers']['workers_count'] = User::where('social_service_id', auth()->user()->social_service_id)->count();


        return $response;
    }
}