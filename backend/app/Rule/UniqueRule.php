<?php

namespace App\Rule;

use App\Models\Product;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value Already Exists";

    protected $fillableParams = ['table', 'column', 'except'];


    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except && $except === $value) {
            return true;
        }

        return Product::query()->exists($value, $table, $column);
    }
}