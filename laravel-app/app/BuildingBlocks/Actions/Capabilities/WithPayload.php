<?php

namespace App\BuildingBlocks\Actions\Capabilities;

/**
 * Trait WithPayload
 * @package App\BuildingBlocks\Actions\Capabilities
 *
 * Handle all user inputs from url segment, query and post body
 */
trait WithPayload
{
    private static ?iterable $computedPayload = null;

    public function computePayload(): array
    {
        $computedFields = self::getComputedFields();
        $segments = $this->getSegments();
        $payload = [];

        /** @var \App\BuildingBlocks\Actions\Fields\BaseField $config */
        foreach ($computedFields as $field => $config) {
            $alias = $config->alias();

            if (isset($segments[$alias])) {
                $payload[$field] = $config->applyPayloadModifications(
                    $segments[$alias]
                );
                continue;
            }

            if (isset($segments[$field])) {
                $payload[$field] = $config->applyPayloadModifications(
                    $segments[$field]
                );
                continue;
            }

            $value = $config->default();

            if ($config->hidden()) {
                continue;
            }

            $hasInput = $this->inputHas($alias);
            if (! $hasInput && $config->required()) {
                continue;
            }

            if ($hasInput) {
                $value = $this->input($alias);
            }

            $payload[$field] = $config->applyPayloadModifications($value);
        }

        return $payload;
    }

    public function setPayload(iterable $payload): void
    {
        self::$computedPayload = $payload;
    }

    /**
     * @inherited
     */
    public function getPayload(): array
    {
        return self::$computedPayload ?? $this->computePayload();
    }

    /**
     * Returns array of segments the key is the name of the segment
     * format: ['segment' => 'value', ....]
     * scenario:
     * given route is /api/users/{userId}
     * when user visited /api/users/1
     * then the segments will be ['userId' => 1]
     *
     * Note:
     *  - you should not use field alias in segment because they will be ignored here
     *
     * @return array<string, string>
     */
    private function getSegments(): array
    {
        return $this->getRequest()->route()?->parameters() ?? [];
    }
}
