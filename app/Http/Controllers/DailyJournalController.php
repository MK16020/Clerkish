<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyJournal;

class DailyJournalController extends Controller
{
  
    public function index()
    {
        $journal = Journal::all();

        return parent::getPaginatedResopnse(
            __('dailyJournalMessages.index'),
            $journal
        );
    }

    public function insert(Request $request)
    { 
        $request->validate([
            'number' => 'required',
            'type' => [
                'required',
                Rule::in(['PURCHASE','purchase','SALES','sales','CASH RECEIPT',
                'cash receipt','CASH PAYMENT','cash payment','CASH DISBURSEMENT',
                 'cash dibursement','PURCHASE RETURN','purchase return','SALES RETURN',
                 'sale return','GENERAL','general']),
                ],
            'date' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $journal = new journal;

        $journal->name = $request->name;
        $journal->number = $request->number;
        $journal->type = $request->type;
        $journal->date = $request->date;
        $journal->statment = $request->statment;

        if (!$journal->save()) {
            return parent::getResponse(
                __('dailyJournalMessages.notInserted', ['name' => $request->name]),
                304,
                $journal
            );
        }

        return parent::getResponse(
            __('dailyJournalMessages.inserted', ['name' => $journal->name]),
            201,
            $journal
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'journalID' => 'required',
            'number' => 'required',
            'type' => 'required',
            'date' => 'required',
        ]);

        if (!array_key_exists(env('FALLBACK_LOCALE'), $request->name)) {
            return parent::getResponse(
                __('LanguageMessages.mainLanguageNotAssigned'),
                422
            );
        }

        $journal = Journal::find($request->journalID);

        if (!$journal) {
            return parent::getResponse(
                __('dailyJournalMessages.notFound'),
                404
            );
        }

        $isDirty = false;

        foreach ($request->name as $key => $localName) {
            if (
                !$journal->name_j->offsetExists($key) ||
                $localName != $journal->name_j[$key]
            ) {
                $journal->name_j[$key] = $localName;
                $isDirty = true;
            }
        }

        if (!$isDirty) {
            return parent::getResponse(
                __('dailyJournalMessages.noUpdates', ['name' => $journal->name]),
                200
            );
        }

        if (!$journal->save()) {
            return parent::getResponse(
                __('dailyJournalMessages.notUpdated', ['name' => $request->name]),
                304,
                $journal
            );
        }

        return parent::getResponse(
            __('dailyJournalMessages.updated', ['name' => $journal->name]),
            200,
            $journal
        );
    }

    public function show($journalID)
    {
        $journal = Journal::find($journalID);

        if (!$journal) {
            return parent::getResponse(
                __('journalMessages.notFound'),
                404
            );
        }

        return parent::getResponse(
            __('journalMessages.show'),
            200,
            $journal
        );
    }

    public function delete($journalID)
    {
        $journal = Journal::find($journalID);

        if (!$journal) {
            return parent::getResponse(
                __('dailyJournalMessages.notFound'),
                404
            );
        }

        if (!$journal->delete()) {
            return parent::getResponse(
                __('dailyJournalMessages.notDeleted', ['name' => $journal->name]),
                304
            );
        }

        return parent::getResponse(
            __('dailyJournalMessages.deleted'),
            200
        );
    }


    public function updateCache(Request $request)
    {
        if (!$request->date) {
            $companies = Journal::all();
        } else {
            $companies = Journal::withTrashed()
                ->where('created_at', '>=', $request->date)
                ->orWhere('updated_at', '>=', $request->date)
                ->orWhere('deleted_at', '>=', $request->date)->get();
        }

        $companies = GeneralCacheResource::collection($companies);

        return parent::getResponseWithOutMessage(
            200,
            $companies
        );
    }
}
