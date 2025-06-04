<?php

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *     request="StoreCompanyRequest",
 *     required=true,
 *     description="Datos para crear una nueva empresa",
 *     @OA\JsonContent(
 *         required={"nit", "name"},
 *         @OA\Property(property="nit", type="string", example="987654321-1", description="NIT único de la empresa"),
 *         @OA\Property(property="name", type="string", example="Nueva Compañía Ltda.", description="Nombre de la empresa"),
 *         @OA\Property(property="address", type="string", nullable=true, example="Av. Siempre Viva 742", description="Dirección de la empresa"),
 *         @OA\Property(property="phone", type="string", nullable=true, example="3109876543", description="Número de teléfono de la empresa"),
 *         @OA\Property(property="status", type="string", enum={"active", "inactive"}, default="active", description="Estado de la empresa (activo por defecto en la creación si no se especifica)")
 *     )
 * )
 */
