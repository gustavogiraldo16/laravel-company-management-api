<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Delete(
 *     path="/companies/{nit}",
 *     operationId="deleteCompany",
 *     tags={"Companies"},
 *     summary="Eliminar una empresa (solo si está inactiva)",
 *     description="Elimina una empresa por su NIT, solo si su estado es 'inactive'.",
 *     @OA\Parameter(
 *         name="nit",
 *         in="path",
 *         description="NIT de la empresa a eliminar",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa eliminada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Company deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="No autorizado para eliminar empresa activa",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Only companies with \"inactive\" status can be deleted")
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
 *         response=500,
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Error deleting company")
 *         )
 *     )
 * )
 */
