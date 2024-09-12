<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Invoice;
use Inertia\Response;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function createCustomer(): RedirectResponse
    {
        $user = auth()->user();

        // Check if the user already has a Stripe customer ID
        if ($user->stripe_customer_id) {
            session()->flash('error', 'Customer already exists.');
            return redirect('stripe.subscription');
        }

        // Create a Stripe customer
        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->name,
        ]);

        // Save the Stripe customer ID in the user record
        $user->stripe_customer_id = $customer->id;
        $user->save();

        session()->flash('success', 'Stripe customer created successfully.');
        return redirect('stripe.subscription');
    }

    public function showSubscription(): Response
    {
        $user = auth()->user();

        // Retrieve the user's Stripe customer ID from the database
        $customerId = $user->stripe_customer_id; // Make sure this column exists
        if(is_null($customerId)) {
            // If no customer ID, return with isConnected set to false
            return inertia('Stripe/Index', [
                'isConnected' => false,
            ]);
        }

        try {
            // Fetch the customer and their subscriptions in a single request
            $customer = Customer::retrieve($customerId, ['expand' => ['subscriptions', 'invoices']]);
            $subscriptions = Subscription::all(['customer' => $customerId]);
            $invoices = Invoice::all(['customer' => $customerId]);
            return inertia('Stripe/Index', [
                'subscriptions' => $subscriptions->data,
                'invoices' => $invoices->data,
                'isConnected' => true,
            ]);
        } catch (\Exception $e) {
            // Handle errors (e.g., customer not found, network issues)
            return inertia('Stripe/Index', [
                'error' => 'Failed to retrieve subscription details. Please try again later.',
                'isConnected' => true,
            ]);
        }
    }
}
