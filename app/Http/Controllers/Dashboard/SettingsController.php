<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Exception;

class SettingsController extends Controller
{
    public function editShippingMethods($type)
    {
        //Fre , inner , outer for shipping methods
        if ($type === 'free')
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

        elseif ($type === 'inner')
            $shippingMethod = Setting::where('key', 'local_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = Setting::where('key', 'outer_label')->first();

        else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

        return
            // $shippingMethod;
            view('dashboard.settings.shippings.edit', compact('shippingMethod'));
    }

    public function updateShippingMethods(ShippingsRequest $request, $id)
    {

        // validation
        // update db
        try {
            $shipping_method = Setting::find($id);
            DB::beginTransaction();
            $shipping_method->update([
                'plain_value' => $request->plain_value,
            ]);
            $shipping_method->value = $request->value;
            $shipping_method->save();
            DB::commit();
            return redirect()->back()->with([
                'success' => __('translation.success_massage'),
            ]);



        } catch (Exception $ex) {
            return redirect()->back()->with(['error'=> __('translation.failed_massage')]);
            DB::rollback();

        }
    }
}
