<?php

declare(strict_types=1);

use Derhub\IdentityAccess\Account\Shared\UserAccountValues;
use Derhub\IdentityAccess\Account\Shared\UserStatusTypes;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateUserAccountTable extends AbstractMigration
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
            UserAccountValues::TABLE_NAME,
            ['id' => false, 'primary_key' => ['id']]
        );

        $table->addColumn('id', Column::BINARYUUID, ['null' => false])
            ->addColumn(
                'email', Column::STRING,
                ['null' => true, 'limit' => 255, 'unique' => true]
            )
            ->addColumn(
                'username', Column::STRING,
                ['null' => true, 'limit' => 255, 'unique' => true]
            )
            ->addColumn(
                'status', Column::SMALLINTEGER,
                ['null' => true, 'default' => UserStatusTypes::ACTIVATED]
            )
            ->addColumn(
                'password', Column::STRING, ['null' => true, 'limit' => 255]
            )
            ->addColumn('created_at', Column::TIMESTAMP, ['null' => true])
            ->addColumn('updated_at', Column::TIMESTAMP, ['null' => true])
            ->addIndex(['status'])
            ->addIndex(['email'])
            ->addIndex(['username'])
            ->create()
        ;
    }
}
