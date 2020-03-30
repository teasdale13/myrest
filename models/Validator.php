<?php

namespace Models;
/**
 * Created by PhpStorm - 2020-03-29
 * @author kevinteasdaledube
 */
class Validator {

    private const model_folder = 'models';

    /**
     * Validate if the model the user want is accessible.
     * @param $model string The "model" to check.
     * @return bool true if model exist and false if doesn't.
     */
    public static function validate( $model ) {
        return file_exists( self::model_folder
            . DIRECTORY_SEPARATOR . 'AccessibleModels'
            .  DIRECTORY_SEPARATOR . ucfirst($model)
            . '.php'
        );
    }

}
