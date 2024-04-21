<?php

namespace App\Http\Controllers;

use App\Models\FeedbackReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackReportController extends Controller
{
    public function index()
    {
        $feedback_reports = FeedbackReport::all();
        return view('admin.feedbacks.index', compact('feedback_reports'));
    }

    public function all()
    {
        $feedback_reports = FeedbackReport::all();
        return view('admin.feedbacks.ajax.list', compact('feedback_reports'))->render();
    }

    public function edit(Request $request)
    {
        $target = FeedbackReport::find($request->input('id'));
        if ($request->input('begin')) {
            $target->status = 'In Progress';
        } elseif ($request->input('pause')) {
            $target->status = 'Paused';
        } elseif ($request->input('resolve')) {
            $target->status = 'Resolved';
        }
        $target->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $target = FeedbackReport::find($request->input('id'));
        $target->delete();
        return response()->json(['success' => true]);
    }

    public function add_validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false]);
        } else {
            return response()->json(['success' => true]);
        }
    }

    public function submit(Request $request)
    {
        $feedback = new FeedbackReport();
        $feedback->name = $request->input('name');
        $feedback->message = $request->input('message');
        $feedback->save();
        return response()->json(['success' => true]);
    }
}
