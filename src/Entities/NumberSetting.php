<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Arr;
use Vodeamanager\Core\Rules\ValidEntity;
use Vodeamanager\Core\Utilities\Constant;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NumberSetting extends BaseEntity
{
    protected $fillable = [
        'name',
        'entity',
        'reset_type',
    ];

    protected $validationRules = [
        'name' => [
            'required',
            'string',
            'max:255',
        ],
    ];

    public function numberSettingComponents() {
        return $this->hasMany(NumberSettingComponent::class);
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['entity'] = [
            'required',
            new ValidEntity(),
        ];

        $this->validationRules['reset_type'] = [
            'required',
            'in:' . implode(array_keys(Constant::NUMBER_SETTING_RESET_TYPE_OPTIONS), ',')
        ];

        $this->validationRules['number_setting_components'] = ['array'];

        $this->validationRules['number_setting_components.*.sequence'] = [
            'required',
            'distinct',
            'integer',
            'min:1',
        ];

        $this->validationRules['number_setting_components.*.type'] = [
            'required',
            'in:' . implode(array_keys(Constant::NUMBER_SETTING_COMPONENT_TYPE_OPTIONS)),
        ];

        $numberSettingComponents = Arr::get($request, 'number_setting_components', []);
        if (is_array($numberSettingComponents)) {
            foreach ($numberSettingComponents as $index => $numberSettingComponent) {
                $rules = ['required'];
                switch($numberSettingComponent['type']) {
                    case Constant::NUMBER_SETTING_COMPONENT_YEAR:
                        $rules[] = 'in:y,Y';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_MONTH:
                        $rules[] = 'in:m,M,F,n';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_DAY:
                        $rules[] = 'in:d,D,j,l';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_COUNTER:
                        $rules[] = 'integer';
                        $rules[] = 'min:1';
                        break;
                }

                $this->validationRules["number_setting_components.{$index}.format"] = $rules;
            }
        }

        return $this;
    }

    public function setValidationMessages(array $request = [])
    {
        $this->validationMessages['reset_type.in'] = 'The selected :attribute must be in '
            . implode(array_values(Constant::NUMBER_SETTING_RESET_TYPE_OPTIONS), ', ');

        $this->validationMessages['number_setting_components.*.type.in'] = 'The selected :attribute must be in '
            . implode(array_values(Constant::NUMBER_SETTING_COMPONENT_TYPE_OPTIONS), ', ');

        return $this;
    }

}