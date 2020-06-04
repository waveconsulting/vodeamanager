<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class NumberSettingService
{
    public function generateNumber($entity, $date = null, $subjectId = null) {
        $numberSetting = config('vodeamanager.models.number_setting')::where('entity', $entity)->first();
        if (empty($numberSetting) && !$components = $numberSetting->components()->exists()) {
            return $this->generateDefaultNumber($entity);
        }

        if(!$date) $date = now();
        else $date = Carbon::parse($date);

        $components = $numberSetting->components()->orderBy('sequence')->get();

        $prefixDigit = 0;
        $digitBeforeCounter = 0;
        $generatedNumberArray = [];
        $queryNumber = '';

        foreach($components as $component){
            if(!in_array(null, $generatedNumberArray) && $component->type != 'counter') $digitBeforeCounter += strlen($component->format);
            switch ($component->type) {
                case 'text':
                    array_push($generatedNumberArray, $component->format);
                    $queryNumber .= str_replace('_', '\\_', $component->format);
                    break;
                case 'year':
                    $dateText = $date->format($component->format);
                    array_push($generatedNumberArray, $dateText);

                    if (!$numberSetting->reset_type) $dateText = str_repeat('_', strlen($dateText));
                    $queryNumber .= $dateText;
                    break;
                case 'month':
                    $dateText = $date->format($component->format);
                    array_push($generatedNumberArray, $dateText);

                    if (!$numberSetting->reset_type || $numberSetting->reset_type == 'yearly') $dateText = str_repeat('_', strlen($dateText));
                    $queryNumber .= $dateText;
                    break;
                case 'day':
                    $dateText = date($component->format, strtotime($date));
                    array_push($generatedNumberArray, $dateText);

                    if (!$numberSetting->reset_type || $numberSetting->reset_type == 'yearly' || $numberSetting->reset_type == 'monthly') $dateText = str_repeat('_', strlen($dateText));
                    $queryNumber .= $dateText;
                    break;
                case 'counter':
                    array_push($generatedNumberArray, null);
                    $queryNumber .= str_repeat('_', $component->format);
                    $prefixDigit = $component->format;
                    break;
            }
        }

        $dateColumn = Schema::hasColumn(app($entity)->getTable(), 'date') ? 'date' : 'created_at';
        $subjectNumbers = app($entity)
            ->where('number', 'like', $queryNumber)
            ->when($numberSetting->reset_type == 'yearly' || $numberSetting->reset_type == 'monthly',function ($q) use ($dateColumn, $date){
                $q->whereYear($dateColumn, $date->format('Y'));
            })->when($numberSetting->reset_type == 'monthly',function ($q) use ($dateColumn, $date){
                $q->whereMonth($dateColumn, $date->format('m'));
            })->when($subjectId, function($q) use ($subjectId){
                $q->where('id', '!=',$subjectId);
            })
            ->withTrashed()
            ->orderBy('number')
            ->pluck('number')
            ->get();

        $existingNumbers = array_map(function($subjectNo) use ($generatedNumberArray, $prefixDigit, $digitBeforeCounter){
            $counterIndex = array_search(null,$generatedNumberArray);
            if ($counterIndex == 0) return intval(substr($subjectNo,0,$prefixDigit));
            else if ($counterIndex+1 == count($generatedNumberArray)) return intval(substr($subjectNo,$prefixDigit*-1));

            return intval(substr($subjectNo,$digitBeforeCounter,$prefixDigit));
        }, $subjectNumbers);

        sort($existingNumbers);

        if (empty($existingNumbers)) $newCounter = 1;
        else {
            $idealNos = range($existingNumbers[0], $existingNumbers[count($existingNumbers)-1]);
            $suggestedNos = array_values(array_diff($idealNos, $existingNumbers));
            $newCounter = empty($suggestedNos) ? ($existingNumbers[(count($existingNumbers)-1)] + 1) : $suggestedNos[0];
        }

        $newCounter = str_pad($newCounter, $prefixDigit, "0", STR_PAD_LEFT);
        $generatedNumberArray[array_search(null, $generatedNumberArray)] = $newCounter;

        return implode('',$generatedNumberArray);
    }

    public function generateDefaultNumber($entity) {
        $tableName = Str::plural(Str::snake(Arr::last(explode('\\', $entity))), 2);
        return (DB::select("show table status like ${$tableName}"))[0]->Auto_increment;
    }
}