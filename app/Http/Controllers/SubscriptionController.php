<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Update expired subscriptions
        $this->updateExpiredSubscriptions();

        $query = Subscription::with('doctor');

        // Search by doctor name
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('doctor', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_range') && $request->date_range !== '') {
            $now = Carbon::now();
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }

        $subscriptions = $query->latest()->paginate(10);
        return view('admin.subscriptions', compact('subscriptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['active', 'expired', 'canceled'])],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('now')) {
                        $fail('The end date must be a future date.');
                    }
                },
            ],
        ]);

        try {
            $subscription->update([
                'status' => $validated['status'],
                'end_date' => Carbon::parse($validated['end_date'])->format('Y-m-d'),
            ]);

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'Subscription updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update subscription: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        try {
            $subscription->delete();
            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'Subscription deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.subscriptions.index')
                ->with('error', 'Failed to delete subscription: ' . $e->getMessage());
        }
    }

    /**
     * Update expired subscriptions
     */
    private function updateExpiredSubscriptions()
    {
        $now = Carbon::now();
        Subscription::where('status', 'active')
                   ->where('end_date', '<', $now)
                   ->update(['status' => 'expired']);
    }

    public function processSubscription(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'duration_months' => 'integer|in:1,3,6,12,24',
        ]);

        try {
            // Calculate dates
            $startDate = now();
            $endDate = $startDate->copy()->addMonths(intval($validated['duration_months']));
            
            // Create subscription record
            $subscription = Subscription::create([
                'doctor_id' => $validated['doctor_id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active'
            ]);

            return redirect()->route('doctor.dashboard')
                ->with('success', 'Subscription activated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: '.$e->getMessage());
        }
    }
}
