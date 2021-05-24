<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountsJournal;
use App\Models\Account;
use App\Models\DailyJournal;

class AccountsJournalController extends Controller
{
    public function accountjournal($accountID){

        $account = Account::find($accountID);
        if (!$account) {
            return parent::getResponse(
                __('accountMessages.notFound'),
                404
            );
        }

        $journals = $account->journals;

        return parent::getResopnse(
            __('journalMessages.index'),
            $journals
        );
    }

    public function insert(Request $request)
    {
        $request->validate([
            'accountID' => 'required',
            'accountCode' => 'required',
            'journalID' => 'required',
            'amount' => 'required|numeric'
        ]);

        $account = account::find($request->accountID);

        if (!$account) {
            return parent::getResponse(
                __('accountMessages.notFound'),
                $account
            );
        }

        $journal = Journal::find($request->journalID);

        if (!$journal) {
            return parent::getResponse(
                __('journalMessages.notFound'),
                $journal
            );
        }

        $journalID = $journal->getBasejournalID();

        $stockjournal = $stock->journals()->wherePivot('journalID', $journalID)->first();

        if (!$stockjournal) {
            // TODO add message
            return parent::getResponse(
                __('journalMessages.notFound')
            );
        }

        return parent::getResponse(
            __('stockjournalsMessages.inserted'),
            $journal
        );
    }


    public function delete($accountID, $journalID)
    {
        $account = Account::find($accountID);

        if (!$account) {
            return parent::getResponse(
                __('$accountMessages.NotFound'),
                404
            );
        }

        if ($account->state != 'OPENED') {
            return parent::getResponse(
                __('$accountMessages.NotOpend'),
                405
            );
        }

        $journal = $account->journals()->where('id', $journalID)->first();

        if (!$journal) {
            return parent::getResponse(
                __('journalMessages.notFound'),
                404
            );
        }

        $account->journals()->detach(
            $journal->id
        );

        return parent::getResponse(
            __('accountJournalMessages.deleted'),
            200
        );
    }
}
