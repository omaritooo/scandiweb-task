<?php

namespace App\Http\Controllers;

use App\Http\Request\ProductRequest;
use App\Models\Product;
use Infrastructure\Request\Request;
use Infrastructure\Response\JsonResponse;
use JsonException;

class ProductController
{
    /**
     * @throws JsonException
     */
    public static function index(): void
    {
        $products = Product::query()
            ->all(['sku', 'name', 'type', 'price', 'weight', 'size', 'length', 'width']);

        JsonResponse::make(
            $products,
        );
    }

    /**
     * @throws JsonException
     */
    public static function store(): void
    {
        ProductRequest::new()->validate();

        Product::query()
            ->create(
                Request::all()
            );

        JsonResponse::make();
    }

    /**
     * @throws JsonException
     */
    public static function delete(): void
    {
        $skus = Request::get('productsSku');

        Product::query()->delete(
            explode(',', $skus),
            'sku'
        );

        JsonResponse::make();
    }
}