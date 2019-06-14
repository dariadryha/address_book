<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190613_122449_create_user_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'first_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'phone_number' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'user_photo' => $this->string()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_info-user_id}}',
            '{{%user_info}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_info-user_id}}',
            '{{%user_info}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_info-user_id}}',
            '{{%user_info}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_info-user_id}}',
            '{{%user_info}}'
        );

        $this->dropTable('{{%user_info}}');
    }
}
