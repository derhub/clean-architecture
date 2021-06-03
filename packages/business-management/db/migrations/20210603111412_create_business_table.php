<?php

declare(strict_types=1);

use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateBusinessTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table(
            SharedValues::TABLE_NAME, ['id' => false, 'primary_key' => ['id']]
        );

        $table->addColumn('id', Column::BINARYUUID, ['null' => false])
            ->addColumn('owner_id', Column::BINARYUUID, ['null' => true])
            ->addColumn(
                'onboard_status', Column::SMALLINTEGER,
                ['null' => true, 'default' => OnBoardStatus::none()->toInt()]
            )->addColumn(
                'status', Column::SMALLINTEGER,
                ['null' => true, 'default' => Status::disable()->toInt()]
            )
            ->addColumn(
                'slug', Column::STRING, ['null' => true, 'limit' => 100]
            )
            ->addColumn(
                'name', Column::STRING, ['null' => true, 'limit' => 100]
            )
            ->addColumn(
                'country', Column::STRING, ['null' => true, 'limit' => 6]
            )
            ->addColumn('created_at', Column::TIMESTAMP, ['null' => true])
            ->addColumn('updated_at', Column::TIMESTAMP, ['null' => true])
            ->addIndex(['owner_id'])
            ->addIndex(['onboard_status'])
            ->addIndex(['status'])
            ->create()
        ;
    }
}
