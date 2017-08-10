<?php

/**
 * Created by PhpStorm.
 * User: solomashenko
 * Date: 01.08.17
 * Time: 19:28
 */
namespace app\includes\widgets;

use app\includes\common\TPCurrencyUtils;
use app\includes\TPPlugin;
use WP_Widget;

class TPFlightsTablesWidget extends WP_Widget{
	public function __construct()
	{
		parent::__construct(
			'travelpayouts_flights_tables', // Base ID
			__('Travelpayouts – Flights Tables', TPOPlUGIN_TEXTDOMAIN), // Name
			array(
				'description' => __('Travelpayouts – Flights Tables', TPOPlUGIN_TEXTDOMAIN)
			) // Args
		);
	}

	/**
	 * @param $args
	 * @param $instance
	 */
	public function widget( $args, $instance ) {
		$select = isset( $instance['flight_select'] ) ? esc_attr( $instance['flight_select'] ) : 'select';
		$title = isset( $instance['flight_title'] ) ? esc_attr( $instance['flight_title'] ) : '';
		$origin = isset( $instance['flight_origin'] ) ? esc_attr( $instance['flight_origin'] ) : '';
		$destination = isset( $instance['flight_destination'] ) ? esc_attr( $instance['flight_destination'] ) : '';
		$airline = isset( $instance['flight_airline'] ) ? esc_attr( $instance['flight_airline'] ) : '';
		$subid = isset( $instance['flight_subid'] ) ? esc_attr( $instance['flight_subid'] ) : '';
		$currency = isset( $instance['flight_currency'] ) ? esc_attr( $instance['flight_currency'] ) : TPPlugin::$options['local']['currency'];
		$paginate = isset( $instance['flight_paginate'] ) ? $instance['flight_paginate']  : true;
		$off_title = isset( $instance['flight_off_title'] ) ? $instance['flight_off_title']  : false;
		$transplant = isset( $instance['flight_transplant'] ) ? esc_attr( $instance['flight_transplant'] ) : 0;
		$filter_airline = isset( $instance['flight_filter_airline'] ) ? esc_attr( $instance['flight_filter_airline'] ) : '';
		$filter_flight_number = isset( $instance['flight_filter_flight_number'] ) ? esc_attr( $instance['flight_filter_flight_number'] ) : '';
		$limit = isset( $instance['flight_limit'] ) ? esc_attr( $instance['flight_limit'] ) : 100;
		$one_way = isset( $instance['flight_one_way'] ) ? $instance['flight_one_way']  : true;

		$originCode = '';
		if(isset($origin)){
			preg_match('/\[(.+)\]/', $origin, $originCode);
		}
		$destinationCode = '';
		if(isset($destination)){
			preg_match('/\[(.+)\]/', $destination, $destinationCode);
		}
		$airlineCode = '';
		if(isset($airline)){
			preg_match('/\[(.+)\]/', $airline, $airlineCode);
		}
		$filterAirlineCode = '';
		if(isset($filter_airline)){
			preg_match('/\[(.+)\]/', $filter_airline, $filterAirlineCode);
		}
		$originAttr = 'origin="'.$originCode[1].'"';
		$destinationAttr = 'destination="'.$destinationCode[1].'"';
		$airlineAttr = 'airline="'.$airlineCode[1].'"';
		$subidAttr = 'subid="'.$subid.'"';
		$currencyAttr = 'currency="'.$currency.'"';
		$paginateAttr = (isset($paginate))? 'paginate=true':'paginate=false';
		$offTitleAttr = (isset($off_title))? 'off_title=true':'';
		$oneWayAttr = (isset($one_way))? 'one_way=true':'one_way=false';
		$transplantAttr = 'stops='.$transplant;
		$filterAirlineAttr = 'filter_airline="'.$filter_airline[1].'"';
		$filterFlightNumberAttr = 'filter_flight_number="'.$filter_flight_number.'"';
		$limitAttr = 'limit='.$limit.'';
		$titleAttr = 'title='.$title.'';
		$shortcode = '';
		switch ($select){
			case 0:
				$shortcode = '[tp_price_calendar_month_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$transplantAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 1:
				$shortcode = '[tp_price_calendar_week_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 2:
				$shortcode = '[tp_cheapest_flights_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$filterAirlineAttr.' '
				             .$filterFlightNumberAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 3:
				$shortcode = '[tp_cheapest_ticket_each_day_month_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$transplantAttr.' '
				             .$filterAirlineAttr.' '
				             .$filterFlightNumberAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 4:
				$shortcode = '[tp_cheapest_tickets_each_month_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$filterAirlineAttr.' '
				             .$filterFlightNumberAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 5:
				$shortcode = '[tp_direct_flights_route_shortcodes '
				             .$originAttr.' '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$filterAirlineAttr.' '
				             .$filterFlightNumberAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$currencyAttr.']';
				break;
			case 6:
				$shortcode = '[tp_direct_flights_shortcodes '
				             .$originAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$filterAirlineAttr.' '
				             .$filterFlightNumberAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.' '
				             .$limitAttr.' '
				             .$currencyAttr.']';
				break;
			case 7:
				$shortcode = '[tp_popular_routes_from_city_shortcodes '
				             .$originAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$subidAttr.']';
				break;
			case 8:
				$shortcode = '[tp_popular_destinations_airlines_shortcodes '
				             .$airlineAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$limitAttr.' '
				             .$subidAttr.']';
				break;
			case 9:
				$shortcode = '[tp_our_site_search_shortcodes '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$limitAttr.' '
				             .$oneWayAttr.' '
				             .$currencyAttr.' '
				             .$transplantAttr.' '
				             .$subidAttr.']';
				break;
			case 10:
				$shortcode = '[tp_from_our_city_fly_shortcodes '
				             .$originAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$limitAttr.' '
				             .$oneWayAttr.' '
				             .$currencyAttr.' '
				             .$transplantAttr.' '
				             .$subidAttr.']';
				break;
			case 11:
				$shortcode = '[tp_in_our_city_fly_shortcodes '
				             .$destinationAttr.' '
				             .$titleAttr.' '
				             .$paginateAttr.' '
				             .$offTitleAttr.' '
				             .$limitAttr.' '
				             .$oneWayAttr.' '
				             .$currencyAttr.' '
				             .$transplantAttr.' '
				             .$subidAttr.']';
				break;
		}

		echo do_shortcode($shortcode);


	}

	/**
	 * @param $new_instance
	 * @param $old_instance
	 * @return mixed
	 */
	public function update( $new_instance, $old_instance ) {
		// Save widget options
		//$new_instance['flight_select'] = (!empty( $new_instance['flight_select'])) ? $new_instance['flight_select'] : $old_instance['flight_select'];
		$new_instance['flight_title'] = (!empty( $new_instance['flight_title'] )) ? $new_instance['flight_title'] : $old_instance['flight_title'];
		$new_instance['flight_origin'] = (!empty( $new_instance['flight_origin'])) ? $new_instance['flight_origin'] : $old_instance['flight_origin'];
		$new_instance['flight_destination'] = (!empty( $new_instance['flight_destination'] ) ) ? $new_instance['flight_destination'] : $old_instance['flight_destination'];
		$new_instance['flight_airline'] = (!empty( $new_instance['flight_airline'])) ? $new_instance['flight_airline'] : $old_instance['flight_airline'];
		$new_instance['flight_subid'] = (!empty( $new_instance['flight_subid'])) ? $new_instance['flight_subid'] : $old_instance['flight_subid'];
		$new_instance['flight_currency'] = (!empty( $new_instance['flight_currency'])) ? $new_instance['flight_currency'] : $old_instance['flight_currency'];
		$new_instance['flight_paginate'] = (isset($new_instance['flight_paginate']))? true : false;
		$new_instance['flight_off_title'] = (isset($new_instance['flight_off_title']))? true : false;
		$new_instance['flight_transplant'] = (!empty( $new_instance['flight_transplant'])) ? $new_instance['flight_transplant'] : $old_instance['flight_transplant'];
		$new_instance['flight_filter_airline'] = (!empty( $new_instance['flight_filter_airline'])) ? $new_instance['flight_filter_airline'] : $old_instance['flight_filter_airline'];
		$new_instance['flight_filter_flight_number'] = (!empty( $new_instance['flight_filter_flight_number'])) ? $new_instance['flight_filter_flight_number'] : $old_instance['flight_filter_flight_number'];
		$new_instance['flight_limit'] = (!empty( $new_instance['flight_limit'])) ? $new_instance['flight_limit'] : $old_instance['flight_limit'];
		$new_instance['flight_one_way'] = (isset($new_instance['flight_one_way']))? true : false;
		return $new_instance;
	}

	/**
	 * @param $instance
	 */
	public function form( $instance ) {
		$select = isset( $instance['flight_select'] ) ? esc_attr( $instance['flight_select'] ) : 'select';
		$title = isset( $instance['flight_title'] ) ? esc_attr( $instance['flight_title'] ) : '';
		$origin = isset( $instance['flight_origin'] ) ? esc_attr( $instance['flight_origin'] ) : '';
		$destination = isset( $instance['flight_destination'] ) ? esc_attr( $instance['flight_destination'] ) : '';
		$airline = isset( $instance['flight_airline'] ) ? esc_attr( $instance['flight_airline'] ) : '';
		$subid = isset( $instance['flight_subid'] ) ? esc_attr( $instance['flight_subid'] ) : '';
		$limit = isset( $instance['flight_limit'] ) ? esc_attr( $instance['flight_limit'] ) : 100;
		$currency = isset( $instance['flight_currency'] ) ? esc_attr( $instance['flight_currency'] ) : TPPlugin::$options['local']['currency'];
		$paginate = isset( $instance['flight_paginate'] ) ? $instance['flight_paginate']  : true;
		$one_way = isset( $instance['flight_one_way'] ) ? $instance['flight_one_way']  : true;
		$off_title = isset( $instance['flight_off_title'] ) ? $instance['flight_off_title']  : false;
		$transplant = isset( $instance['flight_transplant'] ) ? esc_attr( $instance['flight_transplant'] ) : 0;
		$filter_airline = isset( $instance['flight_filter_airline'] ) ? esc_attr( $instance['flight_filter_airline'] ) : '';
		$filter_flight_number = isset( $instance['flight_filter_flight_number'] ) ? esc_attr( $instance['flight_filter_flight_number'] ) : '';

		$shortcodeLabels = array(
			__('Flights from origin to destination, One Way (next month)', TPOPlUGIN_TEXTDOMAIN),
			__('Flights from Origin to Destination (next few days)', TPOPlUGIN_TEXTDOMAIN),
			__('Cheapest Flights from origin to destination, Round-trip', TPOPlUGIN_TEXTDOMAIN),
			__('Cheapest Flights from origin to destination (next month)', TPOPlUGIN_TEXTDOMAIN),
			__('Cheapest Flights from origin to destination (next year)', TPOPlUGIN_TEXTDOMAIN),
			__('Direct Flights from origin to destination', TPOPlUGIN_TEXTDOMAIN),
			__('Direct Flights from origin', TPOPlUGIN_TEXTDOMAIN),
			__('Popular Destinations from origin', TPOPlUGIN_TEXTDOMAIN),
			__('Most popular flights within this Airlines', TPOPlUGIN_TEXTDOMAIN),
			__('Searched on our website', TPOPlUGIN_TEXTDOMAIN),
			__('Cheap Flights from origin', TPOPlUGIN_TEXTDOMAIN),
			__('Cheap Flights to destination', TPOPlUGIN_TEXTDOMAIN),
		)

		?>

		<div class="tp-flights-tables-widget">
			<p class="tp-flights-tables-widget-select">
				<label for="<?php echo $this->get_field_id('flight_select'); ?>"
                       class="tp-flights-tables-widget-select-label">
					<?php _e('Select the table:', TPOPlUGIN_TEXTDOMAIN);?>
					<select class="tp-flights-tables-widget-select-shortcode widefat"
					        id="<?php echo $this->get_field_id('flight_select'); ?>"
					        name="<?php echo $this->get_field_name('flight_select'); ?>"
					        data-select_table="<?php echo $select; ?>">
						<option value="select" <?php selected( $select, 'select' ); ?>>
							<?php _e('Select the table', TPOPlUGIN_TEXTDOMAIN); ?>
						</option>
						<?php $item = 1; ?>
						<?php foreach ($shortcodeLabels as $key => $shortcodeLabel): ?>
							<?php
							if (TPPlugin::$options['local']['currency'] != TPCurrencyUtils::TP_CURRENCY_RUB
							    && $key == 7) {
								continue;
							}
							?>
							<option value="<?php echo $key; ?>" <?php selected( $select, $key ); ?>>
								<?php echo $item; ?>. <?php echo  $shortcodeLabel; ?>
							</option>
							<?php $item++; ?>
						<?php endforeach; ?>
					</select>
				</label>
			</p>
			<p class="tp-flights-tables-widget-title">
				<label for="<?php echo $this->get_field_id('flight_title'); ?>">
					<?php _e('Alternate title:', TPOPlUGIN_TEXTDOMAIN);?>
					<input class="widefat" id="<?php echo $this->get_field_id('flight_title'); ?>"
					       name="<?php echo $this->get_field_name('flight_title'); ?>" type="text"
					       value="<?php echo $title; ?>" />
				</label>
			</p>
			<p class="tp-flights-tables-widget-origin">
				<label for="<?php echo $this->get_field_id('flight_origin'); ?>">
					<?php _e('Origin:', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $origin; ?>" type="text"
					       id="<?php echo $this->get_field_id('flight_origin'); ?>"
					       name="<?php echo $this->get_field_name('flight_origin'); ?>"
					       class="constructorCityWidgetsAutocomplete widefat"/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-destination">
				<label for="<?php echo $this->get_field_id('flight_destination'); ?>">
					<?php _e('Destination:', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $destination; ?>" type="text"
					       id="<?php echo $this->get_field_id('flight_destination'); ?>"
					       name="<?php echo $this->get_field_name('flight_destination'); ?>"
					       class="constructorCityWidgetsAutocomplete widefat"/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-airline">
				<label for="<?php echo $this->get_field_id('flight_airline'); ?>">
					<?php _e('Airline:', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $airline; ?>" type="text"
					       id="<?php echo $this->get_field_id('flight_airline'); ?>"
					       name="<?php echo $this->get_field_name('flight_airline'); ?>"
					       class="constructorAirlineWidgetsAutocomplete widefat"/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-subid">
				<label for="<?php echo $this->get_field_id('flight_subid'); ?>">
					<?php _e('Subid:', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $subid; ?>" type="text"
					       id="<?php echo $this->get_field_id('flight_subid'); ?>"
					       name="<?php echo $this->get_field_name('flight_subid'); ?>"
					       class="widefat"/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-filter-airline">
				<label for="<?php echo $this->get_field_id('flight_filter_airline'); ?>">
					<?php _e('Filter by airline:', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $filter_airline; ?>" type="text"
					       id="<?php echo $this->get_field_id('filter_airline'); ?>"
					       name="<?php echo $this->get_field_name('filter_airline'); ?>"
					       class="constructorAirlineShortcodesAutocomplete widefat"
					       title="<?php _ex('Type aircompany name and chose the one you need. Only its flights will be shown.',
						       TPOPlUGIN_TEXTDOMAIN); ?>"
					/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-filter-flight-number">
				<label for="<?php echo $this->get_field_id('filter_flight_number'); ?>">
					<?php _e('Filter by flight # (enter manually):', TPOPlUGIN_TEXTDOMAIN);?>
					<input placeholder="<?php echo $filter_flight_number; ?>" type="text"
					       id="<?php echo $this->get_field_id('filter_flight_number'); ?>"
					       name="<?php echo $this->get_field_name('filter_flight_number'); ?>"
					       class="widefat"
					       title="<?php _ex('Use this filter only if you absolutely accurately know the route number',
						       TPOPlUGIN_TEXTDOMAIN); ?>"
					/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-limit">
				<label for="<?php echo $this->get_field_id('flight_limit'); ?>">
					<?php _e('Limit:', TPOPlUGIN_TEXTDOMAIN);?>
					<input value="<?php echo $limit; ?>" type="number"
					       id="<?php echo $this->get_field_id('flight_limit'); ?>"
					       name="<?php echo $this->get_field_name('flight_limit'); ?>"
					       class=""/>
				</label>
			</p>
			<p class="tp-flights-tables-widget-currency">
				<label for="<?php echo $this->get_field_id('flight_currency'); ?>">
					<?php _e('Currency:', TPOPlUGIN_TEXTDOMAIN);?>
					<select id="<?php echo $this->get_field_id('flight_currency'); ?>"
					        name="<?php echo $this->get_field_name('flight_currency'); ?>">
						<?php foreach(TPCurrencyUtils::getCurrencyAll() as $currency_item){ ?>
							<option
								<?php selected($currency, $currency_item); ?>
								value="<?php echo $currency_item ?>">
								<?php echo $currency_item; ?>
							</option>
						<?php } ?>

					</select>
				</label>
			</p>
			<p class="tp-flights-tables-widget-paginate">
				<label for="<?php echo $this->get_field_id('flight_paginate'); ?>">
					<input type="checkbox" id="<?php echo $this->get_field_id('flight_paginate'); ?>"
					       name="<?php echo $this->get_field_name('flight_paginate'); ?>"
					       value="1" <?php checked($paginate, true)?>>
					<?php _e('Paginate', TPOPlUGIN_TEXTDOMAIN);?>
				</label>
			</p>
			<p class="tp-flights-tables-widget-one-way">
				<label for="<?php echo $this->get_field_id('flight_one_way'); ?>">
					<input type="checkbox" id="<?php echo $this->get_field_id('flight_one_way'); ?>"
					       name="<?php echo $this->get_field_name('flight_one_way'); ?>"
					       value="1" <?php checked($one_way, true)?>>
					<?php _e('One Way', TPOPlUGIN_TEXTDOMAIN);?>
				</label>
			</p>
			<p class="tp-flights-tables-widget-off-title">
				<label for="<?php echo $this->get_field_id('flight_off_title'); ?>">
					<input type="checkbox" id="<?php echo $this->get_field_id('flight_off_title'); ?>"
					       name="<?php echo $this->get_field_name('flight_off_title'); ?>"
					       value="1" <?php checked($off_title, true)?>>
					<?php _e('No title', TPOPlUGIN_TEXTDOMAIN);?>
				</label>
			</p>
			<p class="tp-flights-tables-widget-transplant">
				<label for="<?php echo $this->get_field_id('flight_transplant'); ?>">
					<?php _e('Number of stops', TPOPlUGIN_TEXTDOMAIN); ?>:
					<select id="<?php echo $this->get_field_id('flight_transplant'); ?>"
					        name="<?php echo $this->get_field_name('flight_transplant'); ?>">
						<option value="0" <?php selected( $transplant, 0 ); ?>>
							<?php _e('All', TPOPlUGIN_TEXTDOMAIN ); ?></option>
						<option value="1" <?php selected( $transplant, 1 ); ?>>
							<?php _e('No more than one stop', TPOPlUGIN_TEXTDOMAIN ); ?></option>
						<option value="2" <?php selected( $transplant, 2 ); ?>>
							<?php  _e('Direct', TPOPlUGIN_TEXTDOMAIN ); ?></option>
					</select>
				</label>
			</p>

		</div>
		<?php
	}

}