<?php

namespace Vodeamanager\Core\Utilities;

class Constant
{
    const DAYS = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday'
    ];

    const GENDER_TYPE_MALE = 'M';
    const GENDER_TYPE_FEMALE = 'F';
    const GENDER_TYPE_OTHER = 'O';

    const GENDER_TYPE_OPTIONS = [
        self::GENDER_TYPE_MALE => 'Male',
        self::GENDER_TYPE_FEMALE => 'Female',
        self::GENDER_TYPE_OTHER => 'Others'
    ];

    const MARITAL_STATUS_SINGLE = 'SINGLE';
    const MARITAL_STATUS_MARRIED = 'MARRIED';
    const MARITAL_STATUS_WIDOW = 'WIDOW';
    const MARITAL_STATUS_WIDOWER = 'WIDOWER';
    const MARITAL_STATUS_OTHER = 'OTHER';

    const MARITAL_STATUS_OPTIONS = [
        self::MARITAL_STATUS_SINGLE => 'Single',
        self::MARITAL_STATUS_MARRIED => 'Married',
        self::MARITAL_STATUS_WIDOW => 'Widow',
        self::MARITAL_STATUS_WIDOWER => 'Widower',
        self::MARITAL_STATUS_OTHER => 'Others'
    ];

    const BLOOD_TYPE_A = 'A';
    const BLOOD_TYPE_B = 'B';
    const BLOOD_TYPE_AB = 'AB';
    const BLOOD_TYPE_O = 'O';

    const BLOOD_TYPE_OPTIONS = [
        self::BLOOD_TYPE_A,
        self::BLOOD_TYPE_B,
        self::BLOOD_TYPE_AB,
        self::BLOOD_TYPE_O,
    ];

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

    const NUMBER_SETTING_COMPONENT_TYPE = 'TEXT';
    const NUMBER_SETTING_COMPONENT_YEAR = 'YEAR';
    const NUMBER_SETTING_COMPONENT_MONTH = 'MONTH';
    const NUMBER_SETTING_COMPONENT_DAY = 'DAY';
    const NUMBER_SETTING_COMPONENT_COUNTER = 'COUNTER';

    const NUMBER_SETTING_COMPONENT_TYPE_OPTIONS = [
        self::NUMBER_SETTING_COMPONENT_TYPE => 'Text',
        self::NUMBER_SETTING_COMPONENT_YEAR => 'Year',
        self::NUMBER_SETTING_COMPONENT_MONTH => 'Month',
        self::NUMBER_SETTING_COMPONENT_DAY => 'Day',
        self::NUMBER_SETTING_COMPONENT_COUNTER => 'Counter',
    ];

}