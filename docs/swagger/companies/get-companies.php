<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/companies",
 *     operationId="getCompaniesList",
 *     tags={"Companies"},
 *     summary="Obtener listado de empresas",
 *     description="Retorna una lista paginada de empresas.",
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Número de elementos por página",
 *         required=false,
 *         @OA\Schema(type="integer", default=15)
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Número de página",
 *         required=false,
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Companies retrieved successfully"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Company")),
 *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/v1/companies?page=1"),
 *                 @OA\Property(property="from", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=1),
 *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/v1/companies?page=1"),
 *                 @OA\Property(property="next_page_url", type="string", example=null),
 *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/v1/companies"),
 *                 @OA\Property(property="per_page", type="integer", example=15),
 *                 @OA\Property(property="prev_page_url", type="string", example=null),
 *                 @OA\Property(property="to", type="integer", example=5),
 *                 @OA\Property(property="total", type="integer", example=5)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Failed to retrieve companies")
 *         )
 *     )
 * )
 */
