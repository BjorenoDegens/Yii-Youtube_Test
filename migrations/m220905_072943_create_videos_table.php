<?php

use yii\db\Migration;
/**
 * Handles the creation of table `{{%video}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220905_072943_create_videos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video}}', [
            'video_id' => $this->string(16)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'tags' => $this->string(512),
            'status' => $this->integer(1),
            'has_thumbnail' => $this->boolean(),
            'video_name' => $this->string(512),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'create_by' => $this->integer(11),
        ]);
    $this->addPrimaryKey('PK_videos_video_id','{{%video}}','video_id');
        // creates index for column `create_by`
        $this->createIndex(
            '{{%idx-videos-create_by}}',
            '{{%video}}',
            'create_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-videos-create_by}}',
            '{{%video}}',
            'create_by',
            '{{%users}}',
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
            '{{%fk-videos-create_by}}',
            '{{%video}}'
        );

        // drops index for column `create_by`
        $this->dropIndex(
            '{{%idx-videos-create_by}}',
            '{{%video}}'
        );

        $this->dropTable('{{%video}}');
    }
}
