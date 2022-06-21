<?php 
/**
 * Plugin Name: Webduel Windcave Payment Gateway
 * Plugin URI: https://webduel.co.nz
 * Description: Windcave payment gateway plugin developed by webduel 
 * Author: Gurpreet Singh Dhoat
 * Author URI: http://www.webduel.co.nz/
 * Version: 1.0.2
 * Text Domain: webduel-windcave-payment-gateway
 *
 * Copyright: (c) 2022 Webduel Limited 
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   WC-Gateway-Offline
 * @author    Gurpreet
 * @category  Admin
 * @copyright (c) 2022 Webduel Limited 
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 * 
 */
 
defined( 'ABSPATH' ) or exit;


// Make sure WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}


/**
 * Add the gateway to WC Available Gateways
 * 
 * @since 1.0.0
 * @param array $gateways all available WC gateways
 * @return array $gateways all WC gateways + offline gateway
 */
function wc_offline_add_to_gateways( $gateways ) {
	$gateways[] = 'WD_Windcave_Gateway';
	return $gateways;
}
add_filter( 'woocommerce_payment_gateways', 'wc_offline_add_to_gateways' );


/**
 * Adds plugin page links
 * 
 * @since 1.0.0
 * @param array $links all plugin links
 * @return array $links all plugin links + our custom links (i.e., "Settings")
 */
function wc_offline_gateway_plugin_links( $links ) {

	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=offline_gateway' ) . '">' . __( 'Configure', 'wc-gateway-offline' ) . '</a>'
	);

	return array_merge( $plugin_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_offline_gateway_plugin_links' );


/**
 * Offline Payment Gateway
 *
 * Provides an Offline Payment Gateway; mainly for testing purposes.
 * We load it later to ensure WC is loaded first since we're extending it.
 *
 * @class 		WD_Windcave_Gateway
 * @extends		WC_Payment_Gateway
 * @version		1.0.0
 * @package		WooCommerce/Classes/Payment
 * @author 		SkyVerge
 */
add_action( 'plugins_loaded', 'wc_offline_gateway_init', 11 );

function wc_offline_gateway_init() {

	class WD_Windcave_Gateway extends WC_Payment_Gateway {

		/**
		 * Constructor for the gateway.
		 */
		public function __construct() {
			$this->id                 = 'inspiry_windcave_gateway';
			$this->icon               = apply_filters( 'woocommerce_webduel_icon', plugins_url('/assets/icon.png', __FILE__ ) );
			$this->has_fields         = true;
			$this->method_title       = __( 'Windcave', 'wc-gateway-windcave' );
			$this->method_description = __( 'Allows Windcave payments.', 'wc-gateway-windcave' );
        	$this->sessionID = ''; 
			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();
		  
			// Define user set variables
			$this->title        = $this->get_option( 'title' );
			$this->description  = $this->get_option( 'description' );
			$this->instructions = $this->get_option( 'instructions', $this->description );
            
			// Actions
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
		  
			// Customer Emails
			add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );


            // We need custom JavaScript to obtain a token
            add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
	
		}
	
	
		/**
		 * Initialize Gateway Settings Form Fields
		 */
		public function init_form_fields() {
	  
			$this->form_fields = apply_filters( 'wc_offline_form_fields', array(
		  
				'enabled' => array(
					'title'   => __( 'Enable/Disable', 'wc-gateway-windcave' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable Windcave Payment', 'wc-gateway-windcave' ),
					'default' => 'yes'
				),
				
				'title' => array(
					'title'       => __( 'Title', 'wc-gateway-windcave' ),
					'type'        => 'text',
					'description' => __( 'This controls the title for the payment method the customer sees during checkout.', 'wc-gateway-windcave' ),
					'default'     => __( 'Windcave', 'wc-gateway-windcave' ),
					'desc_tip'    => true,
				),
				
				'description' => array(
					'title'       => __( 'Description', 'wc-gateway-windcave' ),
					'type'        => 'textarea',
					'description' => __( 'Payment method description that the customer will see on your checkout.', 'wc-gateway-windcave' ),
					'default'     => __( '', 'wc-gateway-windcave' ),
					'desc_tip'    => true,
				),
				
				'instructions' => array(
					'title'       => __( 'Instructions', 'wc-gateway-windcave' ),
					'type'        => 'textarea',
					'description' => __( 'Instructions that will be added to the thank you page and emails.', 'wc-gateway-windcave' ),
					'default'     => '',
					'desc_tip'    => true,
				),
			) );
		}
		
	
		/**
		 * Add content to the WC emails.
		 *
		 * @access public
		 * @param WC_Order $order
		 * @param bool $sent_to_admin
		 * @param bool $plain_text
		 */
		public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		
			if ( $this->instructions && ! $sent_to_admin && $this->id === $order->payment_method && $order->has_status( 'on-hold' ) ) {
				echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
			}
		}
	
        public function payment_scripts() {
            $actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     
            // we need JavaScript to process a token only on cart/checkout pages, right?
            if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) OR str_contains($actualLink, 'order-received') ) {
                return;
            }
			// if our payment gateway is disabled, we do not have to enqueue JS too
			if ( 'no' === $this->enabled ) {
				return;
			}
			

			// let's suppose it is our payment processor JavaScript that allows to obtain a token
			wp_enqueue_script( 'windcave_webduel_js', 'https://sec.windcave.com/js/windcavepayments-seamless-v1.js' );
			// and this is our custom JS in your plugin directory that works with token.js
			wp_register_script( 'woocommerce_webduel', plugins_url( 'misha-1.1.js', __FILE__ ), array( 'jquery', 'windcave_webduel_js' ), '1.0', true );

			// in most payment processors you have to use PUBLIC KEY to obtain a token
			wp_localize_script( 'woocommerce_webduel', 'webduel_params', array(
				"root_url" => get_site_url(),
      			"nonce" => wp_create_nonce("wp_rest")
			) );
			wp_enqueue_script( 'woocommerce_webduel' );
        }

		public function payment_fields(){ 
			?>
			<div class="windcave-description">Pay with your Credit or Debit Card via Windcave.</div>
			<input id="windcave_session_id" name="windcave_session_id" type="text" value="" hidden/> 
			<?php
		}
        /**
        * Output for the order received page.
        */
        public function thankyou_page() {
      
        }
      
		/**
		 * Process the payment and return the result
		 *
		 * @param int $order_id
		 * @return array
		 */
		public function process_payment( $order_id ) {
			// make an api call 
			$order = wc_get_order( $order_id );
				// get order details
				$orderTotal = $order->get_total(); 
							
				// setting up environment variables 
				$sessionUrl = ""; 
				$authKey = ""; 
				if(get_site_url() === "https://localhost" || get_site_url() === "https://inspiryacademy.com"){ 
					
					$sessionUrl = "https://uat.windcave.com/api/v1/sessions/"; 
					$authKey = "Basic SW5zcGlyeV9SZXN0OmI0NGFiMjZmOWFkNzIwNDQ4OTc0MGQ1YWM3NmE5YzE2ZDgzNDJmODUwYTRlYjQ1NTc1NmRiNDgyYjFiYWVjMjk="; 
				}
				else{ 
					$sessionUrl = "https://sec.windcave.com/api/v1/sessions/"; 
					$authKey = "Basic SW5zcGlyeUxQOmRkYzdhZDg2ZDQ0NDA3NDk3OTNkZWM1OWU5YTk1MmI4ODU3ODlkM2Q0OGE2MzliODMwZWI0OTJhNjAyYmNhNjM=";
				}
				// https request to windcave to create a session 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $sessionUrl);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);

				curl_setopt($ch, CURLOPT_POST, TRUE);

				curl_setopt($ch, CURLOPT_POSTFIELDS, "{
				\"type\": \"purchase\",
				\"methods\": [
				\"card\"
				],
				\"amount\": \"$orderTotal\",
				\"currency\": \"NZD\",
				\"callbackUrls\": {
				\"approved\": \"https://inspiry.co.nz/\",
				\"declined\": \"https://inspiry.co.nz/\"
				},
				\"notificationUrl\": \"https://inspiry.co.nz/wp-json/inspiry/v1/windcave-success\"
				}");

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Content-Type: application/json",
				"Authorization:".$authKey."" 
				));

				$response = curl_exec($ch);
				$obj = json_decode($response);
				$href=$obj->links[2]->href; 
				$sessionID = $obj->id; 
				$returnURL = $this->get_return_url( $order ); 
			return array(
				'result' => 'success',
				'redirect' => "#$href&$order_id&$sessionID&$orderTotal&$returnURL"
			);

		}
	
	
  } // end \WD_Windcave_Gateway class
}

// add to cart  Ajax -------------------------------------------------------------
add_action('wp_ajax_webduel_complete_order', 'webduel_complete_order');
add_action('wp_ajax_nopriv_webduel_complete_order', 'webduel_complete_order');
              
function webduel_complete_order() {
	$orderID = sanitize_text_field($_POST['orderID']);
	$windcaveSessionID = sanitize_text_field($_POST['windcaveSessionID']);
					// setting up environment variables 
					$sessionUrl = ""; 
					$authKey = ""; 
					if(get_site_url() === "https://localhost" || get_site_url() === "https://inspiryacademy.com"){ 
						$sessionUrl = "https://uat.windcave.com/api/v1/sessions/"; 
						$authKey = "Basic SW5zcGlyeV9SZXN0OmI0NGFiMjZmOWFkNzIwNDQ4OTc0MGQ1YWM3NmE5YzE2ZDgzNDJmODUwYTRlYjQ1NTc1NmRiNDgyYjFiYWVjMjk="; 
					}
					else{ 
						$sessionUrl = "https://sec.windcave.com/api/v1/sessions/"; 
						$authKey = "Basic SW5zcGlyeUxQOmRkYzdhZDg2ZDQ0NDA3NDk3OTNkZWM1OWU5YTk1MmI4ODU3ODlkM2Q0OGE2MzliODMwZWI0OTJhNjAyYmNhNjM=";
					}
				
					
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
					CURLOPT_URL =>$sessionUrl.$windcaveSessionID,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					"Authorization:".$authKey."" 
					),
				));
				
				$response = curl_exec($curl);
				
				curl_close($curl);
			
				$sessionObj = json_decode($response);
				if($sessionObj->transactions[0]->authorised){ 

						// we need it to get any order detailes
						$order = wc_get_order( $orderID );

							// Mark as on-hold (we're awaiting the payment)
							$order->update_status( 'processing', __( 'Payment Received', 'wc-gateway-windcave' ) );
						
							// Remove cart
							WC()->cart->empty_cart();
							// and this is our custom JS in your plugin directory that works with token.js
							// Redirect to the thank you page
						
							
							$dataArray = array(
								'code'=>  200, 
								'data'=> $sessionObj->transactions[0]->authorised
							);
							echo wp_send_json($dataArray);
				}
				else {
					
					wc_add_notice(  $sessionObj->transactions[0]->responseText, 'error' );

					$dataArray = array(
						'code'=>  404, 
						'data'=> $sessionObj->transactions[0]->responseText
					);
					echo wp_send_json($dataArray);
				}
}

// add modal in theme footer

add_action('wp_footer', 'webduel_footer_windcave_container', 10);
 function webduel_footer_windcave_container(){ 
?>
<style>

#windcave-custom-container {
  position: fixed;
  z-index: 1000;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  width: 100%;
  max-width: 400px;
  height: auto;
  border: 1px solid var(--lightGrey);
  padding: 20px 10px;
  display: none;

  
  
 
}
#windcave-custom-container  .primary-button {
    background: var(--red);
    margin: 0 auto;
    display: block;
    border: 1px solid var(--red);
  }
#windcave-iframe-container {
    margin: 20px 0;
  }
#windcave-custom-container .close-icon {
    position: absolute;
    right: 20px;
    top: 20px;
    cursor: pointer;
  }
  #windcave-custom-container .logo-box img {
      display: block;
      margin: 0 auto;
  }

</style>
<div class="windcave-custom-container" id="windcave-custom-container">
<svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path id="Path_28" data-name="Path 28" d="M13.4,12l6.3-6.3a.99.99,0,1,0-1.4-1.4L12,10.6,5.7,4.3A.99.99,0,0,0,4.3,5.7L10.6,12,4.3,18.3A.908.908,0,0,0,4,19a.945.945,0,0,0,1,1,.908.908,0,0,0,.7-.3L12,13.4l6.3,6.3a.967.967,0,0,0,1.4,0,.967.967,0,0,0,0-1.4Z" transform="translate(-4 -4)" fill="#474747"></path>
                </svg>
                <div class="white-overlay"></div>
    <div class="logo-box">
        <?php
                $argsWindcave = array(
                    'pagename' => 'contact'
                );
             
                $queryWindcave = new WP_Query($argsWindcave);
                while ($queryWindcave->have_posts()) {
                    $queryWindcave->the_post();
                    // get images 
                    if (have_rows('payment_option_images')) {

                        while (have_rows('payment_option_images')) {
                            the_row();
                            $image = get_sub_field('image')['sizes']['medium'];
                           if(get_sub_field('title')==="Windcave"){ 
                       ?>
                       <img src="<?php echo $image; ?>" alt="<?php echo get_sub_field('title'); ?>" width="200px">
                       <?php 
                           }
             
                        }
                    }
                    ?>

                <?php
                }
                wp_reset_postdata();

                ?>
    </div>
    <div id="windcave-iframe-container"></div>
    <button class="primary-button windcave-submit-button">Submit</button>
</div>

<?php 
 }
