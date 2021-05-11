<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::all();

        return parent::getResopnse(
            __('voucherMessages.index'),
            $voucher
        );
    }

    public function insert(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'type' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'relatedPerson' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $voucher = new voucher;

        $voucher->name_j = $request->name;

        if (!$voucher->save()) {
            return parent::getResponse(
                __('voucherMessages.notInserted', ['name' => $request->name]),
                304,
                $voucher
            );
        }

        return parent::getResponse(
            __('voucherMessages.inserted', ['name' => $voucher->name]),
            201,
            $voucher
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'voucherID' => 'required',
            'number' => 'required',
            'type' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'relatedPerson' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $voucher = Voucher::find($request->voucherID);

        if (!$voucher) {
            return parent::getResponse(
                __('voucherMessages.notFound'),
                404
            );
        }

        $isDirty = false;

        foreach ($request->name as $key => $localName) {
            if (
                !$voucher->name_j->offsetExists($key) ||
                $localName != $voucher->name_j[$key]
            ) {
                $voucher->name_j[$key] = $localName;
                $isDirty = true;
            }
        }

        if (!$isDirty) {
            return parent::getResponse(
                __('voucherMessages.noUpdates'),
                200
            );
        }

        if (!$voucher->save()) {
            return parent::getResponse(
                __('voucherMessages.notUpdated', ['name' => $request->name]),
                304,
                $voucher
            );
        }

        return parent::getResponse(
            __('voucherMessages.updated', ['name' => $voucher->name]),
            200,
            $voucher
        );
    }

    public function show($voucherID)
    {
        $voucher = Voucher::find($voucherID);

        if (!$voucher) {
            return parent::getResponse(
                __('voucherMessages.notFound'),
                404
            );
        }
        $voucher = ViewvoucherResource::collection([$voucher]);

        return parent::getResponse(
            __('voucherMessages.show'),
            200,
            $voucher[0]
        );
    }

    public function delete($voucherID)
    {
        $voucher = Voucher::find($voucherID);

        if (!$voucher) {
            return parent::getResponse(
                __('voucherMessages.notFound'),
                404
            );
        }

        if (!$voucher->delete()) {
            return parent::getResponse(
                __('voucherMessages.notDeleted'),
                304
            );
        }

        return parent::getResponse(
            __('voucherMessages.deleted'),
            200
        );
    }


    public function updateCache(Request $request)
    {
        if (!$request->date) {
            $vouchers = Voucher::all();
        } else {
            $vouchers = Voucher::withTrashed()
                ->where('created_at', '>=', $request->date)
                ->orWhere('updated_at', '>=', $request->date)
                ->orWhere('deleted_at', '>=', $request->date)->get();
        }

        $vouchers = GeneralCacheResource::collection($vouchers);

        return parent::getResponseWithOutMessage(
            200,
            $vouchers
        );
    }
}
