<?php
/**
* 
*/
require_once APPPATH.'/libraries/stripe/init.php';
class StripePay
{
	function __construct($foo = null)
	{
		$this->foo = $foo;
	}
	
	function pay()
	{
		try {
			\Stripe\Stripe::setApiKey(config_item('stripe_private_key'));


			$invoice_id = $invoice->inv_id;
			$invoice_ref = $invoice->reference_no;
			$currency = $invoice->currency;
			$paid_by = $invoice->client;
			$amount = $this->input->post('amount',true)*100;
			$payer_email = $this->applib->company_details($paid_by,'company_email');

			$metadata = array(
			                     'invoice_id' => $invoice_id,
			                     'payer' => $this->tank_auth->get_username(),
			                     'payer_email' => $payer_email,
			                     'invoice_ref' => $invoice_ref
			                     );

			// Charge the order:
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount, // amount in cents
				"currency" => $currency,
				"card" => $token,
				"metadata" => $metadata,
				"description" => "Payment for Invoice ".$invoice_ref
				)
			);

			// Check that it was paid:
			if ($charge->paid == true) {
				$metadata = $charge->metadata;
				$transaction = array(
				                     'invoice' => $metadata->invoice_id,
				                     'paid_by' => $paid_by,
				                     'currency' => strtoupper($charge->currency),
				                     'payer_email' => $metadata->payer_email,
				                     'payment_method' => '1',
				                     'notes' => $charge->description,
				                     'amount' => $charge->amount/100,
				                     'trans_id' => $charge->balance_transaction,
				                     'month_paid' => date('m'),
									 'year_paid' => date('Y'),
									 'payment_date' => date('d-m-Y')
				                     );	
				// Store the order in the database.
			
		} catch (Stripe_CardError $e) {
		    // Card was declined.
			$e_json = $e->getJsonBody();
			$err = $e_json['error'];
			$errors['stripe'] = $err['message'];
		} catch (Stripe_ApiConnectionError $e) {
		    // Network problem, perhaps try again.
		} catch (Stripe_InvalidRequestError $e) {
		    // You screwed up in your programming. Shouldn't happen!
		} catch (Stripe_ApiError $e) {
		    // Stripe's servers are down!
		} catch (Stripe_CardError $e) {
		    // Something else that's not the customer's fault.
		}

		} // A user form submission error occurred, handled below.

	
	} // Form submission.
	}
}

