<?php

namespace Derhub\Laravel\Database;

use Barryvdh\Debugbar\DataCollector\QueryCollector;
use Barryvdh\Debugbar\DataFormatter\QueryFormatter;
use Barryvdh\Debugbar\LaravelDebugbar;
use DebugBar\DataCollector\TimeDataCollector;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;

class LaravelDoctrineDebugBar extends QueryCollector
{
    private SQLLogger $debugStack;
    private null|\Doctrine\DBAL\Driver\Connection|\PDO $pdo;
    private \Doctrine\DBAL\Connection $connection;
    protected $backtraceExcludePaths = [
        '/vendor/laravel/framework/src/Illuminate/Support/HigherOrderTapProxy',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        '/vendor/barryvdh/laravel-debugbar',
        '/vendor/doctrine',
        '/vendor/maximebf',
        '/vendor/laravel',
        '/vendor/fruitcake',
        '/vendor/fideloper',
        'app/LaravelDoctrineDebugBar',
        '/app/DoctrineLoggerWithSource',
        '/Doctrine/DoctrineQueryRepository',
    ];

    public function __construct(
        SQLLogger $debugStack,
        EntityManagerInterface $entityManager,
        TimeDataCollector $timeCollector = null,
    ) {
        parent::__construct($timeCollector);

        $this->connection = $entityManager->getConnection();

        $this->pdo =
            $this->connection->getWrappedConnection();

        $this->debugStack = $debugStack;
    }

    public static function create(
        LaravelDebugbar $debugbar,
        SQLLogger $debugStack,
        EntityManagerInterface $entityManager,
        TimeDataCollector $timeCollector = null
    ): self {
        $app = app();
        $queryCollector = new self($debugStack, $entityManager, $timeCollector);
        $queryCollector->setDataFormatter(new QueryFormatter());

        if ($app['config']->get('debugbar.options.db.with_params')) {
            $queryCollector->setRenderSqlWithParams(true);
        }

        if ($app['config']->get('debugbar.options.db.backtrace')) {
            $queryCollector->setFindSource(
                true,
                $app['router']->getMiddleware()
            );
        }

        if ($app['config']->get(
            'debugbar.options.db.backtrace_exclude_paths'
        )) {
            $excludePaths = $app['config']->get(
                'debugbar.options.db.backtrace_exclude_paths'
            );
            $queryCollector->mergeBacktraceExcludePaths($excludePaths);
        }

        if ($app['config']->get('debugbar.options.db.explain.enabled')) {
            $types = $app['config']->get('debugbar.options.db.explain.types');
            $queryCollector->setExplainSource(true, $types);
        }

        if ($app['config']->get('debugbar.options.db.hints', true)) {
            $queryCollector->setShowHints(true);
        }

        if ($app['config']->get('debugbar.options.db.show_copy', false)) {
            $queryCollector->setShowCopyButton(true);
        }

        $queryCollector->timeCollector = $debugbar;

        return $queryCollector;
    }

    public function getName(): string
    {
        return 'doctrine-queries';
    }

    public function getWidgets(): array
    {
        return [
            "database" => [
                "widget" => "PhpDebugBar.Widgets.SQLQueriesWidget",
                "map" => $this->getName(),
                "default" => "[]",
            ],
            "database:badge" => [
                "map" => $this->getName().".nb_statements",
                "default" => 0,
            ],
        ];
    }

    public function parseQuery(array $doctrineQuery): array
    {
        [
            'sql' => $query,
            'params' => $params,
            'executionMS' => $time,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'types' => $types,
            'stack_trace' => $stackTrace,
        ] = $doctrineQuery;

        $explainResults = [];
        $bindings = [];

        $hints = $this->performQueryAnalysis($query);

        $pdo = $this->pdo;

        foreach ($params as $typeIndex => $value) {
            $bindings[] = $this->connection->quote($value, $types[$typeIndex]);
        }


        // Run EXPLAIN on this query (if needed)
        if ($this->explainQuery
            && $pdo
            && preg_match(
                '/^\s*('.implode('|', $this->explainTypes).') /i',
                $query
            )) {
            $statement = $pdo->prepare('EXPLAIN '.$query);
            $statement->execute($params);
            $explainResults = $statement->fetchAll(\PDO::FETCH_CLASS);
        }

        $bindings = $this->getDataFormatter()->checkBindings($bindings);
        if (! empty($bindings) && $this->renderSqlWithParams) {
            foreach ($bindings as $key => $binding) {
                $regex = is_numeric($key)
                    ? "/(?<!\?)\?(?=(?:[^'\\\']*'[^'\\']*')*[^'\\\']*$)(?!\?)/"
                    : "/:{$key}(?=(?:[^'\\\']*'[^'\\\']*')*[^'\\\']*$)/";
                if (! is_int($binding) && ! is_float($binding)) {
                    if ($pdo) {
                        $binding = $pdo->quote($binding);
                    } else {
                        $binding = $this->emulateQuote($binding);
                    }
                }

                $query = preg_replace($regex, $binding, $query, 1);
            }
        }

        $source = [];

        if ($this->findSource) {
            try {
                $traces = [];
                foreach ($stackTrace as $index => $trace) {
                    $traces[] = $this->parseTrace($index, $trace);
                }
                $source = array_slice(array_filter($traces), 0, 5);
            } catch (\Exception $e) {
            }
        }

        $quoteBinding = $this->getDataFormatter()->escapeBindings($bindings);
        $data = [
            'query' => $query,
            'type' => 'query',
            'bindings' => $quoteBinding,
            'params' => $quoteBinding,
            'time' => $time,
            'source' => $source,
            'explain' => $explainResults,
            'connection' => $this->connection->getDatabase(),
            'hints' => $this->showHints ? $hints : null,
            'show_copy' => $this->showCopyButton,
        ];

        if ($this->timeCollector !== null) {
            $this->timeCollector->addMeasure(
                \Str::limit($query, 100),
                $startTime,
                $endTime
            );
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        $totalTime = 0;
        $doctrineQueries = $this->debugStack->queries;

        $statements = [];
        foreach ($doctrineQueries as $doctrineQuery) {
            $query = $this->parseQuery($doctrineQuery);
            $totalTime += $query['time'];

            $statements[] = [
                'sql' => $this->getDataFormatter()->formatSql($query['query']),
                'type' => $query['type'],
                'params' => [],
                'bindings' => $query['bindings'],
                'hints' => $query['hints'],
                'show_copy' => $query['show_copy'],
                'backtrace' => array_values($query['source']),
                'duration' => $query['time'],
                'duration_str' => ($query['type'] === 'transaction') ? ''
                    : $this->formatDuration($query['time']),
                'stmt_id' => $this->getDataFormatter()->formatSource(
                    reset($query['source'])
                ),
                'connection' => $query['connection'],
            ];

            // Add the results from the explain as new rows
            foreach ($query['explain'] as $explain) {
                $statements[] = [
                    'sql' => " - EXPLAIN # {$explain->id}: `{$explain->table}` ({$explain->select_type})",
                    'type' => 'explain',
                    'params' => $explain,
                    'row_count' => $explain->rows,
                    'stmt_id' => $explain->id,
                ];
            }
        }

        if ($totalTime > 0) {
            // For showing background measure on Queries tab
            $start_percent = 0;

            foreach ($statements as $i => $statement) {
                if (! isset($statement['duration'])) {
                    continue;
                }

                $width_percent = $statement['duration'] / $totalTime * 100;

                $statements[$i] = array_merge(
                    $statement,
                    [
                        'start_percent' => round($start_percent, 3),
                        'width_percent' => round($width_percent, 3),
                    ]
                );

                $start_percent += $width_percent;
            }
        }

        $data = [
            'nb_statements' => count($doctrineQueries),
            'nb_failed_statements' => 0,
            'accumulated_duration' => $totalTime,
            'accumulated_duration_str' => $this->formatDuration($totalTime),
            'statements' => $statements,
        ];

        return $data;
    }
}
