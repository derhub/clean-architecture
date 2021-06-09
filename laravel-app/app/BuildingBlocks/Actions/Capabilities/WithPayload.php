<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use function request;

/**
 * Trait WithPayload
 * @package App\BuildingBlocks\Actions\Capabilities
 *
 * Handle all user inputs from url segment and queries
 */
trait WithPayload
{
    /**
     * Return combined result from segment, url query and post body
     * @return array
     */
    public function getPayload(): array
    {
        $segmentData = $this->withSegments();
        $queryData = $this->withQueries();
        if (empty($queryData)) {
            return $segmentData;
        }

        if (empty($segmentData)) {
            return $queryData;
        }

        return array_merge($queryData, $segmentData);
    }

    /**
     * Return all array of fields value
     * if field not required the default value is use
     * if field is required it will not include in the result
     * @return array
     */
    public function withQueries(): array
    {
        $results = [];
        foreach (static::fields([]) as $field => $config) {
            [
                'default' => $default,
                'required' => $isRequired,
                'alias' => $alias,
            ] = $config;

            $hidden = $config['hidden'] ?? false;
            if ($hidden) {
                $results[$field] = $config['default'];
                continue;
            }

            $hasField = $this->inputHas($field);
            $hasAlias = $this->inputHas($alias);
            if ($isRequired && ! $hasField && ! $hasAlias) {
                continue;
            }

            $results[$field] = $hasAlias
                ? $this->input($alias, $default)
                : $this->input($field, $default);
        }

        return $results;
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
     *  - you should not use field alias in segment
     *
     * @return array<string, string>
     */
    public function withSegments(): array
    {
        $segment = $this->getRequest()->route()?->parameters() ?? [];

        if (empty($segment)) {
            return [];
        }

        $fields = static::fields([]);
        $results = [];

        foreach ($segment as $key => $value) {
            if (isset($fields[$key])) {
                $results[$key] = $value;
            }
        }

        return $results;
    }
}
