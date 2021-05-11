<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{ 
    public function index()
    {
        $account = Account::all();

        return parent::getResopnse(
            __('accountMessages.index'),
            $account
        );
    }

    public function insert(Request $request)
    { 
        $request->validate([
            'accountCode' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
            'main' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $account = new account;

        $account->name_j = $request->name;

        if (!$account->save()) {
            return parent::getResponse(
                __('accountMessages.notInserted', ['name' => $request->name]),
                304,
                $account
            );
        }

        return parent::getResponse(
            __('accountMessages.inserted', ['name' => $account->name]),
            201,
            $account
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'accountID' => 'required',
            'accountCode' => 'required',
            'name' => 'required',
            'type' => 'required|array',
            'main' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $account = Account::find($request->accountID);

        if (!$account) {
            return parent::getResponse(
                __('accountMessages.notFound'),
                404
            );
        }

        $isDirty = false;

        foreach ($request->name as $key => $localName) {
            if (
                !$account->name_j->offsetExists($key) ||
                $localName != $account->name_j[$key]
            ) {
                $account->name_j[$key] = $localName;
                $isDirty = true;
            }
        }

        if (!$isDirty) {
            return parent::getResponse(
                __('accountMessages.noUpdates'),
                200
            );
        }

        if (!$account->save()) {
            return parent::getResponse(
                __('accountMessages.notUpdated', ['name' => $request->name]),
                304,
                $account
            );
        }

        return parent::getResponse(
            __('accountMessages.updated', ['name' => $account->name]),
            200,
            $account
        );
    }

    public function show($accountID)
    {
        $account = Account::find($accountID);

        if (!$account) {
            return parent::getResponse(
                __('accountMessages.notFound'),
                404
            );
        }
        $account = ViewaccountResource::collection([$account]);

        return parent::getResponse(
            __('accountMessages.show'),
            200,
            $account[0]
        );
    }

    public function delete($accountID)
    {
        $account = Account::find($accountID);

        if (!$account) {
            return parent::getResponse(
                __('accountMessages.notFound'),
                404
            );
        }

        if (!$account->delete()) {
            return parent::getResponse(
                __('accountMessages.notDeleted'),
                304
            );
        }

        return parent::getResponse(
            __('accountMessages.deleted'),
            200
        );
    }

    public function updateCache(Request $request)
    {
        if (!$request->date) {
            $accounts = Account::all();
        } else {
            $accounts = Account::withTrashed()
                ->where('created_at', '>=', $request->date)
                ->orWhere('updated_at', '>=', $request->date)
                ->orWhere('deleted_at', '>=', $request->date)->get();
        }

        $accounts = GeneralCacheResource::collection($accounts);

        return parent::getResponseWithOutMessage(
            200,
            $accounts
        );
    }
}
