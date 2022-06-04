<?php

namespace core\forms;

use core\Session;

/**
 * Class Form
 *
 * This Form class is for all forms field, also based on Bootstrap 5.1.3 css style.
 *
 * @author Celio Natti <Celionatti@gmail.com>
 * @version 1.0.0
 * @copyright 2022 Laraton
 */

class Form
{
    /**
     * Input Field for form input: text, email, password ...
     *
     * @param $label
     * @param $id
     * @param $value
     * @param array $inputAttrs
     * @param array $wrapperAttrs
     * @param array $errors
     * @param string $disabled
     * @param string $required
     * @return string
     */
    public static function inputField($label, $id, $value, array $inputAttrs = [], array $wrapperAttrs = [], array $errors = [], string $disabled = '', string $required = ''): string
    {
        $wrapperStr = self::processAttrs($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttrs($inputAttrs);
        $errorMsg = array_key_exists($id, $errors) ? $errors[$id] : "";
        $html = "<div $wrapperStr>";
        $html .= "<label for='$id' class='form-label'>$label</label>";
        $html .= "<input id='$id' name='$id' value='$value' $inputAttrs $required $disabled />";
        $html .= "<div class='form-text invalid-feedback'>$errorMsg</div></div>";
        return $html;
    }

    /**
     * Select Field for form select input-with Options fields also.
     *
     * @param [type] $label
     * @param [type] $id
     * @param [type] $value
     * @param [type] $options
     * @param array $inputAttrs
     * @param array $wrapperAttrs
     * @param array $errors
     * @return string
     */
    public static function selectField($label, $id, $value, $options, array $inputAttrs = [], array $wrapperAttrs = [], array $errors = []): string
    {
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttrs($inputAttrs);
        $wrapperStr = self::processAttrs($wrapperAttrs);
        $errorMsg = array_key_exists($id, $errors) ? $errors[$id] : "";
        $html = "<div $wrapperStr>";
        $html .= "<label for='$id' class='form-label'>$label</label>";
        $html .= "<select id='$id' name='$id' $inputAttrs>";
        foreach ($options as $val => $display) {
            $selected = $val == $value ? ' selected ' : "";
            $html .= "<option value='$val'$selected>$display</option>";
        }
        $html .= "</select>";
        $html .= "<div class='form-text invalid-feedback'>$errorMsg</div></div>";
        return $html;
    }

    /**
     * Checkbox Field for form check input.
     *
     * @param [type] $label
     * @param [type] $id
     * @param string $checked
     * @param array $inputAttrs
     * @param array $wrapperAttrs
     * @param array $errors
     * @return string
     */
    public static function checkInput($label, $id, string $checked = '', array $inputAttrs = [], array $wrapperAttrs = [], array $errors = []): string
    {
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $wrapperStr = self::processAttrs($wrapperAttrs);
        $inputStr = self::processAttrs($inputAttrs);
        $checkedStr = $checked == 'on' ? "checked" : "";
        $html = "<div $wrapperStr>";
        $html .= "<input type=\"checkbox\" id=\"$id\" name=\"$id\" $inputStr $checkedStr>";
        $html .= "<label class=\"form-check-label\" for=\"$id\">$label</label></div>";
        return $html;
    }

    /**
     * form Textarea field.
     *
     * @param [type] $label
     * @param [type] $id
     * @param [type] $value
     * @param array $inputAttrs
     * @param array $wrapperAttrs
     * @param array $errors
     * @return string
     */
    public static function textareaField($label, $id, $value, array $inputAttrs = [], array $wrapperAttrs = [], array $errors = []): string
    {
        $wrapperStr = self::processAttrs($wrapperAttrs);
        $inputAttrs = self::appendErrors($id, $inputAttrs, $errors);
        $inputAttrs = self::processAttrs($inputAttrs);
        $errorMsg = array_key_exists($id, $errors) ? $errors[$id] : "";
        $html = "<div $wrapperStr>";
        $html .= "<label for='$id'>$label</label>";
        $html .= "<textarea id='$id' name='$id' value='$value' $inputAttrs>$value</textarea>";
        $html .= "<div class='form-text invalid-feedback'>$errorMsg</div></div>";
        return $html;
    }

    /**
     * form file input field.
     *
     * @param [type] $label
     * @param [type] $id
     * @param array $input
     * @param array $wrapper
     * @param array $errors
     * @return string
     */
    public static function fileInput($label, $id, array $input = [], array $wrapper = [], array $errors = []): string
    {
        $inputAttrs = self::appendErrors($id, $input, $errors);
        $wrapperStr = self::processAttrs($wrapper);
        $inputStr = self::processAttrs($inputAttrs);
        $errorMsg = array_key_exists($id, $errors) ? $errors[$id] : "";
        $html = "<div $wrapperStr>";
        $html .= "<label for=\"$id\">$label</label>";
        $html .= "<input type=\"file\" id=\"$id\" name=\"$id\" $inputStr/>";
        $html .= "<div class=\"form-text invalid-feedback\">$errorMsg</div></div>";
        return $html;
    }

    public static function appendErrors($key, $inputAttrs, $errors)
    {
        if (array_key_exists($key, $errors)) {
            if (array_key_exists('class', $inputAttrs)) {
                $inputAttrs['class'] .= ' is-invalid';
            } else {
                $inputAttrs['class'] = 'is-invalid';
            }
        }
        return $inputAttrs;
    }

    public static function processAttrs($attrs): string
    {
        $html = "";
        foreach ($attrs as $key => $value) {
            $html .= " $key='$value'";
        }
        return $html;
    }

    public static function csrfField(): string
    {
        $token = Session::createCsrfToken();
        return "<input type='hidden' value='$token' name='_token' />";
    }

    public static function hiddenField($name, $token): string
    {
        return "<input type='hidden' value='$token' name='$name' />";
    }
}