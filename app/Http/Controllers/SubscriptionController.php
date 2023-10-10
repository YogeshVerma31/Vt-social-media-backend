<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        return view("admin/subscription/createSubscription");
    }



    public function createSubscription(Request $request)
    {
        try {


            $subscriptionModel = new Subscription();
            $subscriptionModel->title = $request->title;
            $subscriptionModel->price = $request->price;
            $subscriptionModel->discounted_price = $request->discounted_price;
            $subscriptionModel->validity = $request->validity;
            $subscriptionModel->save();

            Session::flash('success', 'Subscription created successfully');
            return  redirect()->intended('/view-subscription');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/view-subscription');
        }
    }

    public function viewSubscription(Request $request)
    {

        try {


            $subscriptionModel = Subscription::all();
            return view("admin/subscription/viewSubscription", ['subscriptionList' => $subscriptionModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/view-subscription');
        }
    }

    public function editSubscription(Request $request, $id)
    {
        $videoModel = Subscription::find($id);
        return view("admin/subscription/editSubscription", ['subscription' => $videoModel]);
    }

    public function updateSubscription(Request $request, $id)
    {


        try {
                Subscription::where('id', '=', $id)
                    ->update([
                        'title' => $request->title,
                        'price' => $request->price,
                        'discounted_price' => $request->discounted_price,
                        'validity' => $request->validity,
                    ]);


            Session::flash('success', 'Subscription updated successfully');
            return redirect()->intended('/view-subscription');

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/view-subscription');

        }
    }

    public function deleteSubscription(Request $request, $id)
    {
        try {
            $videoModel = Subscription::find($id);
            $videoModel->delete();
            Session::flash('success', 'Subscription deleted successfully');
            return redirect()->intended("view-subscription");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("view-subscription");
        }
    }

}
