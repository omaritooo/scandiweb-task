<?php

namespace App\Http\Request;

use Infrastructure\Request\Request;

final class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'sku' => [
                'required',
                'unique:products,sku'
            ],
            'name' => [
                'required'
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'type' => [
                'required',
                'in:DVD,Book,Furniture'
            ],
            'size' => [
                'required_if:type,DVD',
                'numeric'
            ],
            'weight' => [
                'required_if:type,Book',
                'numeric'
            ],
            'height' => [
                'required_if:type,Furniture',
                'numeric'
            ],
            'width' => [
                'required_if:type,Furniture',
                'numeric'
            ],
            'length' => [
                'required_if:type,Furniture',
                'numeric'
            ],
        ];
    }
}
