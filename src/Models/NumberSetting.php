<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Config;
use Vodeamanager\Core\Rules\ValidEntity;
use Vodeamanager\Core\Rules\ValidInConstant;
use Vodeamanager\Core\Rules\ValidNumberSettingComponent;
use Vodeamanager\Core\Rules\ValidUnique;
use Vodeamanager\Core\Utilities\Constant;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class NumberSetting extends Model
{
    use BaseEntity;

    protected $fillable = [
        'name',
        'entity',
        'reset_type',
    ];

    protected $validationRules = [
        'name' => 'required|string|max:255',
        'number_setting_components.*.sequence' => 'required|distinct|integer|min:1',
    ];

    public function numberSettingComponents()
    {
        return $this->hasMany(config('vodeamanager.models.number_setting_component'));
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['entity'] = [
            'required',
            new ValidUnique($this, $id),
            new ValidEntity(),
        ];

        $this->validationRules['reset_type'] = [
            'nullable',
            new ValidInConstant(Constant::NUMBER_SETTING_RESET_TYPE_OPTIONS),
        ];

        $this->validationRules['number_setting_components'] = [
            'required',
            'array',
            'min:1',
            new ValidNumberSettingComponent()
        ];

        $this->validationRules['number_setting_components.*.type'] = [
            'required',
            new ValidInConstant(Constant::NUMBER_SETTING_COMPONENT_TYPE_OPTIONS),
        ];

        $numberSettingComponents = @$request['number_setting_components'] ?? [];
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
