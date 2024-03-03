<?php

namespace Plugin\Model;

use Plugin\Config\DatabaseConfig;

class AdminModel
{
    /**
	 * Table prefix
	 *
	 * @var string
	 */
	protected $prefix;

	public function __construct()
	{
		$this->prefix = (new DatabaseConfig)->prefix;
	}

	/**
	 * Static access to self methods
	 * @return object
	 */
    public static function db()
	{
		return new self;
	}

	/**
     * SQL query helper
     *
     * @param array $config
     *
     * @return string
     */
    public function queryLimit($page, $listing)
    {
        $list_to    = $page * $listing;
        $list_from  = $list_to - $listing;

        return ($list_from <= 0 ? '0'.','.$listing : $list_from.','.$listing);
    }

    /**
	 * @return object
	 */
	public function getApiData()
	{
        global $wpdb;
        $statement = "SELECT * FROM `".$this->prefix."connection` WHERE id='1'";

		return $wpdb->get_results($statement)[0];
	}

    /**
	 * @return boolean
	 */
	public function setApiData($apiData)
	{
        global $wpdb;
        $statement = "UPDATE `".$this->prefix."connection` SET `name`='$apiData->Name',`endpoint`='$apiData->EndPoint',`apikey`='$apiData->Key',`user`='$apiData->User',`updated_at`='".date('Y-m-d H:i:s')."' WHERE id='1'";
		$sqlData = $wpdb->query($statement);

		$statement 	= "TRUNCATE `".$this->prefix."warehouses`";
		$wpdb->query($statement);

		foreach ($apiData->Warehouses as $value) {
			$id_almacen 	= $value['warehouse'];
			$descripcion 	= $value['name'];
			$statement 	= "INSERT INTO `".$this->prefix."warehouses` (`IdAlmacen`,`Descripcion`,`updated_at`) VALUES ('".$id_almacen."','".$descripcion."','".date('Y-m-d H:i:s')."');";
			$wpdb->query($statement);
		}

		return $sqlData;
	}

	/**
	 * @return object
	 */
	public function getWooCommerceKeys()
	{
        global $wpdb;
        $statement = "SELECT * FROM `wp_woocommerce_api_keys` WHERE `description`='PrCustom'";

		return $wpdb->get_results($statement)[0];
	}

	/**
	 * @return object
	 */
	public function getWarehouses()
	{
        global $wpdb;
        $statement = "SELECT * FROM `".$this->prefix."warehouses` ORDER BY IdAlmacen";

		return $wpdb->get_results($statement);
	}

	/**
	 * @return object
	 */
	public function getWarehouse($cgwh_id)
	{
        global $wpdb;
        $statement = "SELECT * FROM `".$this->prefix."warehouses` WHERE IdAlmacen='$cgwh_id'";

		return $wpdb->get_row($statement);
	}

	/**
	 * @return boolean
	 */
	public function setConnectionConfig($apiConfig)
	{
        global $wpdb;
		$statement = "UPDATE `".$this->prefix."connection` SET `warehouse`='$apiConfig->Stock',`wp_ref`='$apiConfig->WP_Ref',`cg_ref`='$apiConfig->Cg_Ref',`wp_adj`='$apiConfig->WP_Adj',`updated_at`='".date('Y-m-d H:i:s')."' WHERE id='1'";

		return $wpdb->query($statement);
	}

	/**
	 * @return object
	 */
	public function countActionsHistory()
	{
        global $wpdb;
        $statement 	= "SELECT COUNT(id) FROM `".$this->prefix."history`";
		$result = (array) $wpdb->get_results($statement)[0];

		return $result['COUNT(id)'];
	}

	/**
	 * @return object
	 */
	public function getActionsHistory($list='0,20')
	{
        global $wpdb;
        $statement = "SELECT * FROM `".$this->prefix."history` ORDER BY id DESC LIMIT $list";

		return $wpdb->get_results($statement);
	}

	/**
	 * @return object
	 */
	public function getHistoryActionById($id)
	{
        global $wpdb;
        $statement = "SELECT * FROM `".$this->prefix."history` WHERE id='$id'";

		return $wpdb->get_results($statement);
	}

    /**
	 * @return boolean
	 */
	public function setActionHistory($data)
	{
		global $wpdb;

		$reference		= !isset($data->reference) ? '' : $data->reference;
		$action			= !isset($data->action) ? '' : $data->action;
		$description	= !isset($data->description) ? '' : $data->description;
		$id_product 	= !isset($data->id_product) ? '' : $data->id_product;
		$name			= !isset($data->name) ? '' : $data->name;
		$stock			= !isset($data->stock) ? '' : $data->stock;
		$quantity		= !isset($data->quantity) ? '' : $data->quantity;
		$stock_update	= !isset($data->stock_update) ? '' : $data->stock_update;
		$updated_at		= date('Y-m-d H:i:s');
        $statement  = "INSERT INTO `".$this->prefix."history` ";
        $statement .= "(`reference`,`action`,`description`,`id_product`,`name`,`stock`,`quantity`,`stock_update`,`updated_at`) ";
        $statement .= "VALUES ";
        $statement .= "('$reference','$action','$description','$id_product','$name','$stock','$quantity','$stock_update','$updated_at');";
		$wpdb->query($statement);
	}

	/**
	 * WooCommerce
	 */
	public function getWooCommerceProducts($cols = [])
	{
		$cols = empty($cols) ? '*' : implode(',', $cols);

		global $wpdb;
		// do join wp_posts for more product data
		$statement = "SELECT $cols FROM `wp_wc_product_meta_lookup` ORDER By product_id DESC";

		return $wpdb->get_results($statement);
	}

	public function getWooCommerceProduct($product_id, $cols = [])
	{
		$cols = empty($cols) ? '*' : implode(',', $cols);

		global $wpdb;
		// do join wp_posts for more product data
		$statement = "SELECT * FROM `wp_wc_product_meta_lookup` WHERE product_id='$product_id'";

		return $wpdb->get_row($statement);
	}

	/**
	 * @return boolean
	 */
	public function updateProductStockFromPrCustom($product)
	{
		$product_id = $product['product_id'];
		$new_stock_quantity = $product['new_stock_quantity'];

        global $wpdb;
		$statement = "UPDATE `wp_postmeta` SET `meta_value`='$new_stock_quantity' WHERE `post_id`='$product_id' AND `meta_key`='_stock'";
		$wpdb->query($statement);

		$statement = "UPDATE `wp_wc_product_meta_lookup` SET `stock_quantity`='$new_stock_quantity' WHERE product_id='$product_id'";
		$wpdb->query($statement);

		return true;
	}

}