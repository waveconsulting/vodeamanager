<?php

namespace Vodeamanager\Core\Utilities\Services;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Vodeamanager\Core\Models\BookedNumber;
use Vodeamanager\Core\Utilities\Constant;

class NumberSettingService
{
    /**
     * Number generator transaction
     *
     * @param string $entity
     * @param null $date
     * @param null $subjectId
     * @param int $startCounter
     * @return string
     */
    public function generateNumber(string $entity, $date = null, $subjectId = null, int $startCounter = 0)
    {
        $tableName = app($entity)->getTable();
        $numberSetting = config('vodeamanager.models.number_setting')::where('entity', $entity)->first();

        if (is_null($numberSetting) || !$numberSetting->numberSettingComponents()->exists()) {
            return (DB::select("show table status like '{$tableName}'"))[0]->Auto_increment;
        }

        $date = is_null($date) ? Carbon::now() : Carbon::parse($date);

        $prefixDigit = 0;
        $digitBeforeCounter = 0;
        $generatedNumberArray = [];
        $queryNumber = '';

        $components = $numberSetting->numberSettingComponents()->orderBy('sequence')->get();
        foreach($components as $index => $component){
            if (!in_array(null, $generatedNumberArray) && $component->type != Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER) {
                $digitBeforeCounter += strlen($component->format);
            }

            switch ($component->type) {
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_TEXT:
                    array_push($generatedNumberArray, $component->format);
                    $queryNumber .= str_replace('_', '\\_', $component->format);
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_YEAR:
                    $dateText = $date->format($component->format);
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($numberSetting->reset_type)) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_MONTH:
                    $dateText = $date->format($component->format);
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($numberSetting->reset_type) || $numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_DAY:
                    $dateText = date($component->format, strtotime($date));
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($numberSetting->reset_type) || $numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY || $numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER:
                    array_push($generatedNumberArray, null);
                    $queryNumber .= str_repeat('_', $component->format);
                    $prefixDigit = $component->format;
                    break;
            }
        }

        $dateColumn = Schema::hasColumn($tableName, 'date') ? 'date' : 'created_at';

        $subjectNumbers = app($entity)
            ->withoutGlobalScopes()
            ->where('number', 'like', $queryNumber)
            ->when($numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY || $numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY, function ($query) use ($dateColumn, $date){
                $query->whereYear($dateColumn, $date->format('Y'));
            })->when($numberSetting->reset_type == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY, function ($query) use ($dateColumn, $date){
                $query->whereMonth($dateColumn, $date->format('m'));
            })->when($subjectId, function($query) use ($subjectId){
                $query->where('id', '!=', $subjectId);
            })
            ->withTrashed()
            ->orderBy('number')
            ->pluck('number')
            ->toArray();

        $existingNumbers = array_map(function ($subjectNo) use ($generatedNumberArray, $prefixDigit, $digitBeforeCounter) {
            $counterIndex = array_search(null,$generatedNumberArray);
            if ($counterIndex == 0) {
                return intval(substr($subjectNo,0,$prefixDigit));
            } else if ($counterIndex+1 == count($generatedNumberArray)) {
                return intval(substr($subjectNo,$prefixDigit*-1));
            }

            return intval(substr($subjectNo,$digitBeforeCounter,$prefixDigit));
        }, $subjectNumbers);

        sort($existingNumbers);

        if (empty($existingNumbers)) {
            $newCounter = 1;
        } else {
            $idealNos = range($existingNumbers[0], $existingNumbers[count($existingNumbers)-1]);
            $suggestedNos = array_values(array_diff($idealNos, $existingNumbers));
            $newCounter = empty($suggestedNos) ? ($existingNumbers[(count($existingNumbers)-1)] + 1) : $suggestedNos[0];
        }

        $newCounter += $startCounter;
        $generatedNumberArray[array_search(null, $generatedNumberArray)] = str_pad($newCounter, $prefixDigit, "0", STR_PAD_LEFT);
        $number = implode('',$generatedNumberArray);

        return $this->isBooked($entity, $number)
            ? $this->generateNumber($entity, $date, $subjectId, $newCounter)
            : $number;
    }

    /**
     * @param string $entity
     * @param null $date
     * @param null $subjectId
     * @return BookedNumber
     * @throws Exception
     */
    public function bookNumber(string $entity, $date = null, $subjectId = null)
    {
        $numberSetting = config('vodeamanager.models.number_setting')::where('entity', $entity)->first();
        if (empty($numberSetting)) {
            throw new Exception("The number setting is invalid.");
        }

        return BookedNumber::create([
            'entity' => $entity,
            'number' => $this->generateNumber($entity, $date, $subjectId),
        ]);
    }

    /**
     * @return bool
     */
    protected function isBooked($entity, $number)
    {
        return BookedNumber::query()
            ->where('entity', $entity)
            ->where('number', $number)
            ->exists();
    }

    /**
     * @param array $components
     * @param string $resetType
     * @param string $entity
     * @param null $date
     * @param null $subjectId
     * @return string
     * @throws Exception
     */
    public function generateNumberManual(array $components, string $resetType, string $entity, $date = null, $subjectId = null)
    {
        $tableName = app($entity)->getTable();
        $date = is_null($date) ? Carbon::now() : Carbon::parse($date);
        $prefixDigit = 0;
        $digitBeforeCounter = 0;
        $generatedNumberArray = [];
        $queryNumber = '';

        foreach($components as $index => $component){
            if (empty($component['type']) || empty($component['format'])) {
                throw new Exception("Invalid component format.");
            }

            if (!in_array(null, $generatedNumberArray) && $component['type'] != Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER) {
                $digitBeforeCounter += strlen($component['format']);
            }

            switch ($component['type']) {
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_TEXT:
                    array_push($generatedNumberArray, $component['format']);
                    $queryNumber .= str_replace('_', '\\_', $component['format']);
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_YEAR:
                    $dateText = $date->format($component['format']);
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($resetType)) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_MONTH:
                    $dateText = $date->format($component['format']);
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($resetType) || $resetType == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_DAY:
                    $dateText = date($component['format'], strtotime($date));
                    array_push($generatedNumberArray, $dateText);

                    if (is_null($resetType) || $resetType == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY || $resetType == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY) {
                        $dateText = str_repeat('_', strlen($dateText));
                    }

                    $queryNumber .= $dateText;
                    break;
                case Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER:
                    array_push($generatedNumberArray, null);
                    $queryNumber .= str_repeat('_', $component['format']);
                    $prefixDigit = $component['format'];
                    break;
            }
        }

        $dateColumn = Schema::hasColumn($tableName, 'date') ? 'date' : 'created_at';

        $subjectNumbers = app($entity)
            ->withoutGlobalScopes()
            ->where('number', 'like', $queryNumber)
            ->when($resetType == Constant::NUMBER_SETTING_RESET_TYPE_YEARLY || $resetType == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY, function ($query) use ($dateColumn, $date){
                $query->whereYear($dateColumn, $date->format('Y'));
            })->when($resetType == Constant::NUMBER_SETTING_RESET_TYPE_MONTHLY, function ($query) use ($dateColumn, $date){
                $query->whereMonth($dateColumn, $date->format('m'));
            })->when($subjectId, function($query) use ($subjectId){
                $query->where('id', '!=', $subjectId);
            })
            ->withTrashed()
            ->orderBy('number')
            ->pluck('number')
            ->toArray();

        $existingNumbers = array_map(function ($subjectNo) use ($generatedNumberArray, $prefixDigit, $digitBeforeCounter) {
            $counterIndex = array_search(null,$generatedNumberArray);
            if ($counterIndex == 0) {
                return intval(substr($subjectNo,0,$prefixDigit));
            } else if ($counterIndex+1 == count($generatedNumberArray)) {
                return intval(substr($subjectNo,$prefixDigit*-1));
            }

            return intval(substr($subjectNo,$digitBeforeCounter,$prefixDigit));
        }, $subjectNumbers);

        sort($existingNumbers);

        if (empty($existingNumbers)) {
            $newCounter = 1;
        } else {
            $idealNos = range($existingNumbers[0], $existingNumbers[count($existingNumbers)-1]);
            $suggestedNos = array_values(array_diff($idealNos, $existingNumbers));
            $newCounter = empty($suggestedNos) ? ($existingNumbers[(count($existingNumbers)-1)] + 1) : $suggestedNos[0];
        }

        $newCounter = str_pad($newCounter, $prefixDigit, "0", STR_PAD_LEFT);
        $generatedNumberArray[array_search(null, $generatedNumberArray)] = $newCounter;

        return implode('',$generatedNumberArray);
    }
}
