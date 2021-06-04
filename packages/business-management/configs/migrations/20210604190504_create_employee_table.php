<?php

declare(strict_types=1);

use Derhub\BusinessManagement\Employee\Model\Values\Status;
use Derhub\BusinessManagement\Employee\Shared\EmployeeValues;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateEmployeeTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table(
            EmployeeValues::TABLE_NAME, ['id' => false, 'primary_key' => ['id']]
        );

        $table->addColumn('id', Column::BINARYUUID, ['null' => false])
            ->addColumn('employer_id', Column::BINARYUUID, ['null' => true])
            ->addColumn('position_id', Column::BINARYUUID, ['null' => true])
            ->addColumn('status_id', Column::BINARYUUID, ['null' => true])
            ->addColumn(
                'name', Column::STRING, ['null' => true, 'limit' => 100]
            )
            ->addColumn(
                'initial', Column::STRING, ['null' => true, 'limit' => 5]
            )
            ->addColumn(
                'email', Column::STRING, ['null' => true, 'limit' => 100]
            )
            ->addColumn('birthday', Column::DATETIME, ['null' => true])
            ->addColumn('created_at', Column::TIMESTAMP, ['null' => true])
            ->addColumn('updated_at', Column::TIMESTAMP, ['null' => true])
            ->addColumn('deleted_at', Column::TIMESTAMP, ['null' => true])
            ->addIndex(['employer_id'])
            ->addIndex(['status_id'])
            ->addIndex(['position_id'])
            ->addIndex(['email'])
            ->create()
        ;
    }
}
