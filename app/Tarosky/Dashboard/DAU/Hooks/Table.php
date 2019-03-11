<?php
namespace Tarosky\Dashboard\DAU\Hooks;


use Tarosky\Dashboard\DAU\Pattern\AppBase;

/**
 * Table generator
 *
 * @package dau
 * @property string $table_name
 */
class Table extends AppBase {

	const LOG_TABLE = 'dau_logs';

	/**
	 * @var string Table version.
	 */
	private $table_version = '1.0.0';

	/**
	 * @var string Option name.
	 */
	private $option_name = 'dau_table_version';

	/**
	 * Constructor.
	 */
	protected function init() {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
	}

	/**
	 * Update table.
	 */
	public function admin_init() {
		// Do nothing on Ajax.
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		// If we should update table, do update.
		if ( $this->should_update_table() ) {
			$sql = $this->generate_sql();
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
			dbDelta( $sql );
			update_option( $this->option_name, $this->table_version );
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		}
	}

	/**
	 * Generate table SQL.
	 *
	 * @return string
	 */
	public function generate_sql() {
		$charset   = $this->db->get_charset_collate();
		return <<<SQL
			CREATE TABLE `{$this->table_name}` (
				log_id      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				`key`       VARCHAR(48) NOT NULL,
				`category`  VARCHAR(48) NOT NULL DEFAULT '',
				`date`      DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
				`value`     FLOAT SIGNED NOT NULL,
				`object_id` BIGINT UNSIGNED NOT NULL DEFAULT 0,
				PRIMARY KEY (log_id),
				INDEX key_date ( `key`, `date`, `category` ),
				INDEX parent   ( `key`, `object_id`, `date` )
			) {$charset}
SQL;
	}

	/**
	 * Display upgrade notice.
	 */
	public function admin_notices() {
		// translators: %s is table version number.
		printf( '<div class="error"><p>%s</p></div>', esc_html( sprintf( __( '[DAU] database is upgraded to %s.', 'dau' ), $this->table_version ) ) );
	}

	/**
	 * Detect if table should be updated.
	 *
	 * @return bool
	 */
	public function should_update_table() {
		return (bool) version_compare( get_option( $this->option_name, '0.0.0' ), $this->table_version, '<' );
	}

	/**
	 * Getter
	 *
	 * @param string $name Property name.
	 * @return mixed
	 */
	public function __get( $name ) {
		switch ( $name ) {
			case 'table_name':
				return sprintf( '%s%s', $this->db->prefix, self::LOG_TABLE );
			default:
				return parent::__get( $name );
		}
	}


}
