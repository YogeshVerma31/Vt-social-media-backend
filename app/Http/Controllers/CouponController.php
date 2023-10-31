<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        return view("admin/coupon/createCoupon");
    }

    public function createCoupon(Request $request)
    {

        try {

            $couponModel = new Coupon();
            $couponModel->name = $request->name;
            $couponModel->discount = $request->discount;
            $couponModel->validity = $request->validity;
            $couponModel->save();

            Session::flash('success', 'Coupon created successfully');
            return  redirect()->intended('/coupons');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/coupons');
        }
    }

    public function viewCoupon(Request $request)
    {

        try {

            $couponList = Coupon::all();
            return view("admin/coupon/viewCoupon", ['couponList' => $couponList]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/category');
        }
    }

    public function editCoupon(Request $request, $id)
    {
        $videoModel = Coupon::find($id);
        return view("admin/coupon/editCoupon", ['coupon' => $videoModel]);
    }

    public function updateCoupon(Request $request, $id)
    {


        try {
                Coupon::where('id', '=', $id)
                    ->update([
                        'name' => $request->name,
                        'discount' => $request->discount,
                        'validity' => $request->validity,
                    ]);


            Session::flash('success', 'Coupon updated successfully');
            return redirect()->intended('/coupons');

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/coupons');

        }
    }

    public function deleteCoupon(Request $request, $id)
    {
        try {
            $videoModel = Coupon::find($id);
            $videoModel->delete();
            Session::flash('success', 'Coupon deleted successfully');
            return redirect()->intended("coupons");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("coupons");
        }
    }

    public function updateStatusCoupon(Request $request, $id)
    {


        try {

            $chapterModel = Coupon::find($id);
            // print_r($chapterModel);die;

            if (!$chapterModel) {
                Session::flash('error', 'coupon not found');
                return view("admin/coupon/viewCoupon");
            }

            $chapterModel->update(['status' => !$chapterModel->status]);

            Session::flash('success', 'coupon status updated successfully');
            return redirect()->intended("/coupons");

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/coupons");
            // print_r($e->getMessage());die;

        }
    }

}
