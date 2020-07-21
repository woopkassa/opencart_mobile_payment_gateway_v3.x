<?php

class ModelExtensionPaymentWooppayMobile extends Model
{
	public function getMethod($address, $total)
	{
		$this->load->language('extension/payment/wooppayMobile');

		if ($this->config->get('payment_wooppayMobile_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('wooppayMobile_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get('wooppayMobile_geo_zone_id')) {
				$status = TRUE;
			} elseif ($query->num_rows) {
				$status = TRUE;
			} else {
				$status = FALSE;
			}
		} else {
			$status = FALSE;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code' => 'wooppayMobile',
				'title' => $this->language->get('text_title'),
				'terms' => '',
				'sort_order' => $this->config->get('wooppayMobile_sort_order')
			);
		}
		return $method_data;
	}

	public function addTransaction($transaction_data)
	{
		$this->db->query("INSERT INTO `" . DB_PREFIX . "wooppay_mobile_order_transaction` SET
			`order_id` = '" . (int)$transaction_data['order_id'] . "',
			`wooppay_transaction_id` = '" . $this->db->escape($transaction_data['wooppay_transaction_id']) . "'");
	}

	public function getTransactionRow($order_id)
	{
		$qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "wooppay_mobile_order_transaction` `pt`  WHERE `pt`.`order_id` = '" . $this->db->escape($order_id) . "' LIMIT 1");

		if ($qry->num_rows > 0) {
			return $qry->row;
		} else {
			return false;
		}
	}
}

?>