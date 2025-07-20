{{-- SubscriptionController --}}




@extends('layouts.admin.app')

@section('header', 'Edit Subscription')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Subscription</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="doctor">Doctor</label>
                        <input type="text" class="form-control" value="{{ $subscription->doctor->name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="text" class="form-control" value="{{ $subscription->start_date->format('Y-m-d') }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               name="end_date" 
                               value="{{ old('end_date', $subscription->end_date->format('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('end_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ $subscription->status == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="canceled" {{ $subscription->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Subscription</button>
                        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 