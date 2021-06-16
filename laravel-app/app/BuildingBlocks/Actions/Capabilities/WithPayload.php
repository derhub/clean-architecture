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
    private static ?array $computedPayload = null;

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
    abstract protected function getSegments(): array;

    public function computePayload(): array
    {
        $computedFields = self::getComputedFields();
        $segments = $this->getSegments();
        $requestBody = self::getRouteMethod() === 'get'
            ? $this->getRequestQueries()
            : $this->getRequestBody();

        $payload = [];

        /** @var \App\BuildingBlocks\Actions\Fields\BaseField $config */
        foreach ($computedFields as $field => $config) {
            $alias = $config->alias();

            if (isset($segments[$alias])) {
                $payload[$field] = $segments[$alias];
                continue;
            }

            if (isset($segments[$field])) {
                $payload[$field] = $segments[$field];
                continue;
            }

            $value = $config->default();

            if ($config->hidden()) {
                continue;
            }

            $hasInput = $this->requestBodyHas($requestBody, $alias);

            $aliasConfirm = $alias.'_confirmation';
            if ($this->requestBodyHas($requestBody, $aliasConfirm)) {
                $payload[$aliasConfirm] =
                    $this->requestBodyData($requestBody, $aliasConfirm);
            }

            if (! $hasInput && $config->required()) {
                continue;
            }

            if ($hasInput) {
                $value = $this->requestBodyData($requestBody, $alias);
            }

            $payload[$field] = $value;
        }

        return $payload;
    }

    public function setPayload(array $payload): void
    {
        self::$computedPayload = $payload;
    }


    private function requestBodyData(
        array $body,
        string $key,
        mixed $default = null
    ): mixed {
        return $body[$key] ?? $default;
    }

    private function requestBodyHas(array $body, string $key): bool
    {
        return isset($body[$key]);
    }

    public function getPayload(): array
    {
        return self::$computedPayload ?? $this->computePayload();
    }

}
