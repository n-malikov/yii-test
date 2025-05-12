<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url_logs}}`.
 */
class m250512_083326_create_url_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%url_logs}}', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->notNull(),  // Ссылка на id из таблицы url
            'ip' => $this->string(45)->notNull(),  // IP-адрес (для IPv4 и IPv6)
            'created_at'   => $this->dateTime()->notNull(),
        ]);

        // Создаем внешний ключ, который ссылается на id таблицы url
        $this->addForeignKey(
            'fk-url_logs-url_id',
            'url_logs',
            'url_id',
            'url',
            'id',
            'CASCADE'
        );

        // Создание индекса для ускорения поиска по url_id
        $this->createIndex(
            'idx-url_logs-url_id',
            'url_logs',
            'url_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-url_logs-url_id', 'url_logs');
        $this->dropTable('{{%url_logs}}');
    }
}
