<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountsJournal;
use App\Models\Account;
use App\Models\DailyJournal;

class AccountsJournalController extends Controller
{
    public function index()
    {
        //
    }

    public function insert(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function show($ID)
    {
        //
    }

    public function delete($ID)
    {
        //
    }
}
/*

    public function index()
    {
        $accountsJournal = AccountsJournal::all();

        return parent::getResopnse(
            __('accountsJournalMessages.index'),
            $accountsJournal
        );
    }


    public function list()
    {
        $accountsJournal = AccountsJournal::all();
        return parent::getResponseWithOutMessage(
            200,
            $accountsJournal
        );
    }

    public function insert(Request $request)
    {
        $request->validate([
            'stockID' => 'required',
            'supplierID' => 'required',
            'VATP' => 'required',
            'receivedDate' => 'required'
        ]);

        $stock = Stock::find($request->stockID);

        if (!$stock) {
            return parent::getResponse(
                __('stockMessages.notFound'),
                404
            );
        }

        $supplier = Supplier::find($request->supplierID);

        if (!$supplier) {
            return parent::getResponse(
                __('supplierMessages.notFound'),
                404
            );
        }

        if (!auth()->user()->branch->isSupplyNumberingValied()) {
            return parent::getResponse(
                __('registryMessages.noValiedNumbers'),
                405
            );
        }

        $accountsJournal = new accountsJournal;
        $accountsJournal->stockID = $request->stockID;
        $accountsJournal->supplierID = $request->supplierID;
        $accountsJournal->VATP = $request->VATP;
        $accountsJournal->receivedDate = $request->receivedDate;
        $accountsJournal->setSupplyNumber();

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.NotInserted'),
                304,
                $accountsJournal
            );
        }

        return parent::getResponse(
            __('accountsJournalMessages.Inserted'),
            201,
            $accountsJournal
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'accountsJournalID' => 'required',
            'stockID' => 'required',
            'supplierID' => 'required',
            'VATP' => 'required',
            'receivedDate' => 'required'

        ]);

        $stock = Stock::find($request->stockID);

        if (!$stock) {
            return parent::getResponse(
                __('stockMessages.notFound'),
                404
            );
        }

        $supplier = Supplier::find($request->supplierID);

        if (!$supplier) {
            return parent::getResponse(
                __('supplierMessages.NotFound'),
                404
            );
        }

        $accountsJournal = AccountsJournal::find($request->accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.NotFound'),
                404
            );
        }

        if ($accountsJournal->state != 'OPENED') {
            return parent::getResponse(
                __('accountsJournalMessages.notAllowed'),
                405
            );
        }

        $accountsJournal->supplierID = $request->supplierID;
        $accountsJournal->VATP = $request->VATP;
        $accountsJournal->receivedDate = $request->receivedDate;

        $isDirty = $accountsJournal->isDirty();

        if (!$isDirty) {
            return parent::getResponse(
                __('accountsJournalMessages.NoUpdates'),
                200
            );
        }

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.NotUpdated'),
                304,
                $accountsJournal
            );
        }

        return parent::getResponse(
            __('accountsJournalMessages.Updated'),
            200,
            $accountsJournal
        );
    }

    public function show($accountsJournalID)
    {
        $accountsJournal = AccountsJournal::find($accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.NotFound'),
                404
            );
        }
        $accountsJournal = ViewaccountsJournalResource::collection([$accountsJournal]);

        return parent::getResponse(
            __('accountsJournalMessages.show'),
            200,
            $accountsJournal[0]
        );
    }

    public function suspendSupply($accountsJournalID)
    {
        $accountsJournal = AccountsJournal::find($accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.notFound'),
                404
            );
        }

        $accountsJournal->state = 'SUSPENDED';

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.notSuspended'),
                304
            );
        }

        return parent::getResponse(
            __('accountsJournalMessages.suspended'),
            200,
            $accountsJournal
        );
    }

    public function unsuspendSupply($accountsJournalID)
    {
        $accountsJournal = AccountsJournal::find($accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.notFound'),
                404
            );
        }

        if ($accountsJournal->state != 'SUSPENDED') {
            return parent::getResponse(
                __('accountsJournalMessages.cantUnSuspend'),
                401
            );
        }

        $accountsJournal->state = 'OPENED';

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.notSuspended'),
                304
            );
        }

        return parent::getResponse(
            __('accountsJournalMessages.opend'),
            200,
            $accountsJournal
        );
    }

    public function recived($accountsJournalID)
    {
        $accountsJournal = AccountsJournal::find($accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.notFound'),
                404
            );
        }

        if (
            $accountsJournal->state != 'OPENED' &&
            $accountsJournal->state != 'PAID'
        ) {
            return parent::getResponse(
                __('accountsJournalMessages.notAllowed'),
                405
            );
        }

        $accountsJournal->state =
            $accountsJournal->state == 'PAID'
                ? 'COMPLETED' : 'RECEIVED';

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.NotUpdated'),
                304
            );
        }

        $stock = Stock::find($accountsJournal->stockID);
        foreach ($accountsJournal->items as $item) {
            $linkedItem = $stock->items()->where('id', $item->getBaseItemID())->first();

            if ($linkedItem) {
                $stock->items()->updateExistingPivot($item->getBaseItemID(), [
                    'quantity' => ($item->pivot->quantity * $item->getBaseItemQuantity()) +
                        $linkedItem->pivot->quantity
                ]);
            } else {

                $stock->items()->attach($item->getBaseItemID(), [
                    'quantity' => $item->pivot->quantity * $item->getBaseItemQuantity()
                ]);
            }
        }

        return parent::getResponse(
            __('accountsJournalMessages.updated'),
            200,
            $accountsJournal
        );
    }

    public function cancel($accountsJournalID)
    {
        $accountsJournal = AccountsJournal::find($accountsJournalID);

        if (!$accountsJournal) {
            return parent::getResponse(
                __('accountsJournalMessages.NotFound'),
                404
            );
        }

        if ($accountsJournal->state != 'OPENED') {
            return parent::getResponse(
                __('accountsJournalMessages.notAllowed'),
                405
            );
        }

        $accountsJournal->state = 'CANCELED';

        if (!$accountsJournal->save()) {
            return parent::getResponse(
                __('accountsJournalMessages.NotCanceled'),
                304
            );
        }

        return parent::getResponse(
            __('accountsJournalMessages.canceled'),
            200
        );
    }
*/