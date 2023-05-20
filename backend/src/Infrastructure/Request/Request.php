<?php

namespace Infrastructure\Request;

use App\Rule\UniqueRule;
use Infrastructure\Response\JsonResponse;
use Rakit\Validation\Validator;

abstract class Request
{
    public static function all(): array
    {
        $result = [];

        foreach ($_REQUEST as $key => $value) {
            if (is_string($value)) {
                $result[$key] = htmlspecialchars(stripslashes($value));
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    abstract public function rules(): array;

    public static function new()
    {
        return new static();
    }

    public function validate(): void
    {
        $validator = new Validator;

        $validator->addValidator('unique', new UniqueRule);

        $validation = $validator->validate(
            static::all(),
            $this->rules()
        );

        $validationResult = $validation->errors()->firstOfAll();

        if (! empty($validationResult)) {

            JsonResponse::make(
                [],
                422,
                false,
                $validationResult
            );

            die();
        }
    }

    public static function get(string $key)
    {
        $all = static::all();

        return $all[$key];
    }
}