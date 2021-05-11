<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Pagination;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Resolves a {@link Pagination} object by extracting its components from request query params.
 * It also resolves the perPage value from the request attributes if not present in the query,
 * allowing to define a default value per controller by setting a default value for this attribute.
 */
class PaginationValueResolver implements ArgumentValueResolverInterface
{
    public const PER_PAGE_PARAM = 'perPage';
    public const PAGE_PARAM = 'page';

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Pagination::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield new Pagination(
            $request->query->getInt(self::PAGE_PARAM, 1),
            $request->query->get(self::PER_PAGE_PARAM) ?? $request->attributes->get(self::PER_PAGE_PARAM)
        );
    }
}
