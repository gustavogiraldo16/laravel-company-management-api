<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/companies/{nit}",
 *     operationId="getCompanyByNit",
 *     tags={"Companies"},
 *     summary="Obtener una empresa por NIT",
 *     description="Retorna una empresa específica.",
 *     @OA\Parameter(
 *         name="nit",
 *         in="path",
 *         description="NIT de la empresa a buscar",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Company retrieved successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Company")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Empresa no encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Company not found.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Failed to retrieve company")
 *         )
 *     )
 * )
 */
