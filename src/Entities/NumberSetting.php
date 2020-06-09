<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Arr;
use Symfony\Component\Mime\Test\Constraint\EmailHeaderSame;
use Vodeamanager\Core\Rules\ValidEntity;
use Vodeamanager\Core\Rules\ValidInConstant;
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
            'nullable',
            new ValidInConstant(Constant::NUMBER_SETTING_RESET_TYPE_OPTIONS),
        ];

        $this->validationRules['number_setting_components'] = 'array';
        $this->validationRules['number_setting_components.*.sequence'] = 'required|distinct|integer|min:1';
        $this->validationRules['number_setting_components.*.type'] = [
            'required',
            new ValidInConstant(Constant::NUMBER_SETTING_COMPONENT_TYPE_OPTIONS),
        ];

        $numberSettingComponents = Arr::get($request, 'number_setting_components', []);
        if (is_array($numberSettingComponents)) {
            foreach ($numberSettingComponents as $index => $numberSettingComponent) {
                $rules = ['required'];
                switch($numberSettingComponent['type']) {
                    case Constant::NUMBER_SETTING_COMPONENT_TYPE_YEAR:
                        $rules[] = 'in:y,Y';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_TYPE_MONTH:
                        $rules[] = 'in:m,M,F,n';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_TYPE_DAY:
                        $rules[] = 'in:d,D,j,l';
                        break;
                    case Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER:
                        $rules[] = 'integer';
                        $rules[] = 'min:1';
                        break;
                }

                $this->validationRules["number_setting_components.{$index}.format"] = $rules;
            }
        }

        return $this;
    }

}