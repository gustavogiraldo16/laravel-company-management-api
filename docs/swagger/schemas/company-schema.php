<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Company",
 *     title="Empresa",
 *     description="Modelo de una empresa",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nit",
 *         type="string",
 *         example="123456789-0"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Mi Empresa S.A.S."
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         nullable=true,
 *         example="Calle 1 #2-3"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         nullable=true,
 *         example="3001234567"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"active", "inactive"},
 *         example="active"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         readOnly=true,
 *         example="2023-10-27T10:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         readOnly=true,
 *         example="2023-10-27T10:00:00.000000Z"
 *     )
 * )
 */
