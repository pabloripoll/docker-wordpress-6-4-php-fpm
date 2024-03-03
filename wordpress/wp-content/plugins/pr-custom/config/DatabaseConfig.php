<?php

namespace Plugin\Config;

class DatabaseConfig
{
    /**
	 * Table prefix
	 *
	 * @var string
	 */
	public $prefix = 'api_custom_';

    /**
     * Instances
     *
     */
	public function migrate()
    {
        $this->createTableExample();
    }

    public function rollback()
    {
        $this->deleteTableExample();
    }

    /**
	 * Install methods
	 *
	 */
    protected function createTableExample()
    {
        global $wpdb;

        $sql = [];
        $tableName = $this->prefix.'example';
        $charsetCollate = $wpdb->get_charset_collate();

        $sql[] = "CREATE TABLE IF NOT EXISTS `$tableName` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(64) NOT NULL,
            `endpoint` VARCHAR(255) NOT NULL,
            `apikey` VARCHAR(64) NOT NULL,
            `user` INT(11) NOT NULL DEFAULT \"0\",
            `warehouse` INT(11) NOT NULL DEFAULT \"0\",
            `wp_ref` VARCHAR(32) NOT NULL,
            `cg_ref` VARCHAR(32) NOT NULL,
            `wp_adj` INT(1) NOT NULL,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) $charsetCollate";
        $sql[] = "INSERT INTO `$tableName` (`name`, `endpoint`, `apikey`, `user`, `updated_at`) VALUES ('', '', '', '', '".date('Y-m-d H:i:s')."');";

        foreach ($sql as $statement) ! empty($statement) ? $wpdb->query($statement) : null;
    }

    /**
	 * Uninstall methods
	 *
	 */

    protected function deleteTableExample()
    {
        global $wpdb;

        $sql = [];
        $tableName = $this->prefix.'example';
        $sql[] = "DROP TABLE IF EXISTS `$tableName`";

        foreach ($sql as $statement) ! empty($statement) ? $wpdb->query($statement) : null;
    }

}
