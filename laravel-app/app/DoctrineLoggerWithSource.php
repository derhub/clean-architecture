<?php

namespace App;

use Doctrine\DBAL\Logging\DebugStack;

class DoctrineLoggerWithSource extends DebugStack
{
    public function startQuery(
        $sql,
        ?array $params = null,
        ?array $types = null
    ) {
        parent::startQuery(
            $sql,
            $params,
            $types
        );

        $this->queries[$this->currentQuery]['stack_trace'] =
            $this->findSource();

        $this->queries[$this->currentQuery]['start_time'] = $this->start;
    }

    protected function findSource(): array
    {
        $enable = config()->get('debugbar.options.db.backtrace');
        if (! $enable) {
            return [];
        }
        return debug_backtrace(
            DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT,
            app('config')->get('debugbar.debug_backtrace_limit', 50)
        );
    }

    public function stopQuery()
    {
        parent::stopQuery();
        $this->queries[$this->currentQuery]['end_time'] = microtime(true);
    }
}
