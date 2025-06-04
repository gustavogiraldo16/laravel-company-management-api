<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/companies",
 *     operationId="storeCompany",
 *     tags={"Companies"},
 *     summary="Crear una nueva empresa",
 *     description="Crea una nueva empresa y la retorna.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/StoreCompanyRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Empresa creada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Company created successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Company")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Datos de entrada inválidos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\AdditionalProperties(
 *                     type="array",
 *                     @OA\Items(type="string")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Error creating company")
 *         )
 *     )
 * )
 */
