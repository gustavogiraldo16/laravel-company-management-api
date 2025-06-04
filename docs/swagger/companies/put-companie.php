<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Put(
 *     path="/companies/{nit}",
 *     operationId="updateCompany",
 *     tags={"Companies"},
 *     summary="Actualizar una empresa",
 *     description="Actualiza una empresa existente y la retorna.",
 *     @OA\Parameter(
 *         name="nit",
 *         in="path",
 *         description="NIT de la empresa a actualizar",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UpdateCompanyRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa actualizada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Company updated successfully"),
 *             @OA\Property(property="data", ref="#/components/schemas/Company")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Empresa no encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Company not found")
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
 *             @OA\Property(property="message", type="string", example="Error updating company")
 *         )
 *     )
 * )
 */
