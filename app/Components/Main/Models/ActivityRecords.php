<?php

namespace App\Components\Main\Models;

trait  ActivityRecords
{

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function createActivityRecord($type)
    {

        if($type === 'updated'){
            $changed = json_encode($this->changedFields());
        }else{
            $changed = json_encode(['title'=>(isset($this->name)) ? $this->name : $this->title]);
        }
            $this->activity()->create([
                'user_id' => auth()->id(),
                'type' => $type,
                'subject_name'=> $this->getActivityType(),
                'changed' => $changed
            ]);

    }

    /**
     * @param $changed
     * @return mixed
     */
    protected function changedFields()
    {
        $changed =[];

        $original = $this->getOriginal();

        $attrs = $this->getAttributes();

        $fields = $this->getTriggerChangedField();

        foreach ($attrs as $field => $value) {
            if (in_array($field, $fields) && $original[$field] != $value) {
                $changed[$field] = $value;
            }
        }
        return $changed;
    }

    public function getTriggerChangedField()
    {
        return $this->triggerChangedField;
    }

    protected function getActivityType()
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return $type;
    }


}