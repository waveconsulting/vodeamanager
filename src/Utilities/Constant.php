<?php

namespace Vodeamanager\Core\Utilities;

class Constant
{
    const DAYS = [
        'SUNDAY' => 'Sunday',
        'MONDAY' => 'Monday',
        'TUESDAY' => 'Tuesday',
        'WEDNESDAY' => 'Wednesday',
        'THURSDAY' => 'Thursday',
        'FRIDAY' => 'Friday',
        'SATURDAY' => 'Saturday',
    ];

    const RELIGIONS = [
        'BUDDHA' => 'Buddha',
        'CATHOLIC' => 'Catholic',
        'CRISTIAN' => 'Christian',
        'CONFUCIUS' => 'Confucius',
        'HINDU' => 'Hindu',
        'ISLAM' => 'Islam',
    ];

    const GENDERS = [
        'MALE' => 'Male',
        'FEMALE' => 'Female',
        'OTHER' => 'Other'
    ];

    const MARITAL_STATUS_OPTIONS = [
        'SINGLE' => 'Single',
        'MARRIED' => 'Married',
        'WIDOW' => 'Widow',
        'WIDOWER' => 'Widower',
        'OTHER' => 'Other'
    ];

    const BLOOD_TYPE_OPTIONS = ['A', 'B', 'AB', 'O'];

    const RELATIONSHIP_TYPE_SPOUSE = 'SPOUSE';
    const RELATIONSHIP_TYPE_PARENT = 'PARENT';
    const RELATIONSHIP_TYPE_CHILD = 'CHILD';
    const RELATIONSHIP_TYPE_SIBLING = 'SIBLING';

    const RELATIONSHIP_TYPE_OPTIONS = [
        self::RELATIONSHIP_TYPE_SPOUSE => 'Spouse',
        self::RELATIONSHIP_TYPE_PARENT => 'Parent',
        self::RELATIONSHIP_TYPE_CHILD => 'Child',
        self::RELATIONSHIP_TYPE_SIBLING => 'Sibling',
    ];

    const NUMBER_SETTING_RESET_TYPE_DAILY = 'DAILY';
    const NUMBER_SETTING_RESET_TYPE_MONTHLY = 'MONTHLY';
    const NUMBER_SETTING_RESET_TYPE_YEAR = 'YEAR';

    const NUMBER_SETTING_RESET_TYPE_OPTIONS = [
        self::NUMBER_SETTING_RESET_TYPE_DAILY => 'Daily',
        self::NUMBER_SETTING_RESET_TYPE_MONTHLY => 'Monthly',
        self::NUMBER_SETTING_RESET_TYPE_YEAR => 'Year',
    ];

    const NUMBER_SETTING_COMPONENT_TYPE_TYPE = 'TEXT';
    const NUMBER_SETTING_COMPONENT_TYPE_YEAR = 'YEAR';
    const NUMBER_SETTING_COMPONENT_TYPE_MONTH = 'MONTH';
    const NUMBER_SETTING_COMPONENT_TYPE_DAY = 'DAY';
    const NUMBER_SETTING_COMPONENT_TYPE_COUNTER = 'COUNTER';

    const NUMBER_SETTING_COMPONENT_TYPE_OPTIONS = [
        self::NUMBER_SETTING_COMPONENT_TYPE_TYPE => 'Text',
        self::NUMBER_SETTING_COMPONENT_TYPE_YEAR => 'Year',
        self::NUMBER_SETTING_COMPONENT_TYPE_MONTH => 'Month',
        self::NUMBER_SETTING_COMPONENT_TYPE_DAY => 'Day',
        self::NUMBER_SETTING_COMPONENT_TYPE_COUNTER => 'Counter',
    ];

}
