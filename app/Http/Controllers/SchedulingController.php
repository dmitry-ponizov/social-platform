<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Session;
use App\Components\Main\Models\Statement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class SchedulingController extends Controller
{
    public function check_statement_to_create()
    {
        $repeat_statements = Statement::where('repeat', true)
            ->where('status', '!=', 'closed')
            ->whereDate('execution_date', Carbon::now()->toDateString())
            ->get();

        foreach ($repeat_statements as $statement) {
            $day = json_decode($statement->days);

            $execution_date = new Carbon("next $day->day");

            $execution_date->setTime($day->time->HH, $day->time->mm);

            $prepare[] = [
                'uuid' => Str::uuid(),
                'category_id' => $statement->category_id,
                'title' => 'Create crone ' . new Carbon($execution_date),
                'repeat' => $statement->repeat,
                'status' => 'sent',
                'parent_id' => $statement->parent_id,
                'description' => $statement->description,
                'user_id' => $statement->user_id,
                'organization_id' => $statement->organization_id,
                'execution_date' => new Carbon($execution_date),
                'days' => $statement->days,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()

            ];
        }
        Statement::insert($prepare);
    }

    public function check_statement_not_done()
    {
        Statement::where('parent_id', '!=', 0)
            ->where('status', '!=', 'closed')
            ->where('status', '!=', 'no_done')
            ->where('repeat', true)
            ->where('execution_date', '<', Carbon::now())
            ->update(['status' => 'no_done']);
    }

}


