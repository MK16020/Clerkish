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
