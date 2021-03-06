<?php
namespace CNP;

/**
 * SchemaAddress.
 *
 * Returns an address block that includes Schema tags.
 *
 * @since 0.3.0
 */
class SchemaAddress extends AtomTemplate {

	public function __construct( $data ) {

		parent::__construct( $data );

		$this->tag = 'div';

		if ( ! isset( $data['address_data'] ) ) {
			return;
		}

		$address_pieces = array();

		if ( isset( $data['address_data']['street_address'] ) && ! empty( $data['address_data']['street_address'] ) ) {
			$address_pieces[] = '<span itemprop="streetAddress">' . $data['address_data']['street_address'] . '</span>';
		}

		if ( isset( $data['address_data']['city'] ) && ! empty( $data['address_data']['city'] ) ) {
			$address_pieces[] = '<span itemprop="addressLocality">' . $data['address_data']['city'] . '</span>';
		}

		if ( isset( $data['address_data']['state'] ) && ! empty( $data['address_data']['state'] ) ) {
			$address_pieces[] = ', <span itemprop="addressRegion">' . $data['address_data']['state'] . '</span>';
		}

		if ( isset( $data['address_data']['zip_code'] ) && ! empty( $data['address_data']['zip_code'] ) ) {
			$address_pieces[] = ' <span itemprop="postalCode">' . $data['address_data']['zip_code'] . '</span>';
		}

		if ( isset( $data['address_data']['country'] ) && ! empty( $data['address_data']['country'] ) ) {
			$address_pieces[] = ', <span itemprop="addressCountry">' . $data['address_data']['country'] . '</span>';
		}

		$address = '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">' . implode( '', $address_pieces ) . '</div>';

		$this->content = $address;

	}
}
