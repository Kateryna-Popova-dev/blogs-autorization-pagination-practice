<?php
/**
 * Function takes an array of fields and an array of rules, validates each field.
 * @param array $fields
 * @param array $rules
 * @return array|false
 */
function validate(array $fields, array $rules)
{
    $errors = [];
    if (!$rules) {
        return false;
    }
    $rulesArray = processingRules($rules);
    foreach ($rulesArray as $fieldName => $arrayRules) {
        foreach ($arrayRules as $rule) {
            preg_match("/\[(\d+)\]/", $rule, $matches);
            //REQUIRED RULE
            if ($rule === 'required') {
                if (!required($fields[$fieldName])) {
                    $errors[$fieldName][] = "Field $fieldName is required";
                }
            }
            //MIN LENGTH RULE
            if (mb_strpos($rule, 'min_length') !== false) {
                preg_match("/\[(\d+)\]/", $rule, $matches);
                $minLength = $matches[1];
                if (!minLength($fields[$fieldName], $minLength)) {
                    $errors[$fieldName][] = "Field $fieldName must be biggest than $minLength!";
                }
            }
            //MAX LENGTH RULE
            if (mb_strpos($rule, 'max_length') !== false) {
                preg_match("/\[(\d+)\]/", $rule, $matches);
                $maxLength = $matches[1];
                if (!maxLength($fields[$fieldName], $maxLength)) {
                    $errors[$fieldName][] = "Field $fieldName must not be less than $maxLength!";
                }
            }
            //EMAIL RULE
            if ($rule === 'email') {
                if (!emailValidator($fields[$fieldName])) {
                    $errors[$fieldName][] = "Invalid email!";
                }
            }
            //PASSWORD CONFIRM RULE
            if ($rule === 'password_confirm') {
                if (!passwordConfirmValidator($fields[$fieldName], $fields['password'])) {
                    $errors[$fieldName][] = "Password mismatch!";
                }
            }
            //AUTHOR_ID RULE

            if ($rule === 'title') {
                if (!required($fields[$fieldName])) {
                    $errors[$fieldName][] = "Field $fieldName is required";
                }
            }
            if ($rule === 'content') {
                if (!required($fields[$fieldName])) {
                    $errors[$fieldName][] = "Field $fieldName is required";
                }
            }
            if ($rule === 'author_id') {
                if (!required($fields[$fieldName])) {
                    $errors[$fieldName][] = "Field $fieldName is required";
                }
            }
            //IMAGE RULE
            if ($rule === 'image') {
                if (!$fields[$fieldName]['tmp_name']) {
                    $errors[$fieldName][] = "$fieldName can not be empty!";
                } else if (!exif_imagetype($fields[$fieldName]['tmp_name'])) {
                    $errors[$fieldName][] = "This $fieldName is not a picture!";
                }

            }
        }
    }
    return $errors;
}

/**
 * Function separates the rules.
 * @param array $rules
 * @return array
 */
function processingRules(array $rules): array
{
    $rulesArray = [];
    foreach ($rules as $fieldName => $rule) {
        $rulesArray[$fieldName] = explode('|', $rule);
    }
    return $rulesArray;
}

/**
 * Function checks for the existence of a value.
 * @param string $value
 * @return bool
 */
function required(string $value): bool
{
    return $value ?? false;
}

/**
 * Function checks the length of a string.
 * @param string $string
 * @param int $length
 * @return bool
 */
function minLength(string $string, int $length): bool
{
    return mb_strlen($string) > $length;
}

/**
 * Function checks the length of a string.
 * @param string $string
 * @param int $length
 * @return bool
 */
function maxLength(string $string, int $length): bool
{
    return mb_strlen($string) < $length;
}

/**
 * Function validates email.
 * @param string $email
 * @return bool
 */
function emailValidator(string $email): bool
{
    $re = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/m';
    preg_match($re, $email, $matches);
    return !!$matches;
}

/**
 * Function checks if the passwords are the same
 * @param string $passwordConfirm
 * @param string $password
 * @return bool
 */
function passwordConfirmValidator(string $passwordConfirm, string $password): bool
{
    return $passwordConfirm === $password;
}