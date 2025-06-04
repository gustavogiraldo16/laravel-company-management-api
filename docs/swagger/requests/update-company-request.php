<?php

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *     request="UpdateCompanyRequest",
 *     description="Datos para actualizar una empresa",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"name", "status"},
 *         @OA\Property(property="name", type="string", example="Empresa Actualizada S.A.", description="Nombre actualizado de la empresa"),
 *         @OA\Property(property="address", type="string", nullable=true, example="Cra 5 #6-7", description="Dirección actualizada de la empresa"),
 *         @OA\Property(property="phone", type="string", nullable=true, example="3201112233", description="Teléfono actualizado de la empresa"),
 *         @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="inactive", description="Estado actualizado de la empresa"),
 *         @OA\Property(property="nit", type="string", nullable=true, description="NIT (Este campo se ignora en la actualización para mantener el original)", example="NIT_IGNORADO")
 *     )
 * )
 */
