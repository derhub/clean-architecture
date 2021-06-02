<?php

namespace Derhub\Template\AggregateExample\Model;

use Derhub\Shared\Model\AggregateRepository;

/**
 * @template-extends AggregateRepository<\Derhub\Template\AggregateExample\Model\Business>
 */
interface TemplateRepository extends AggregateRepository
{
}
