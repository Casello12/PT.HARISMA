@extends('layouts.app')

@section('title', 'Detail Notification')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-eye"></i> Detail Notification</h5>
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Title</th>
                                    <td>{{ $notification->title }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>
                                        <span class="badge bg-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : ($notification->type === 'warning' ? 'warning' : 'info')) }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $notification->category ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $notification->read_status === 'unread' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($notification->read_status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">User</th>
                                    <td>{{ $notification->user ? $notification->user->name : 'All Users' }}</td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td>{{ $notification->createdBy ? $notification->createdBy->name : 'System' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Read At</th>
                                    <td>{{ $notification->read_at ? \Carbon\Carbon::parse($notification->read_at)->format('d/m/Y H:i:s') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6>Message</h6>
                        <div class="card">
                            <div class="card-body">
                                {{ $notification->message }}
                            </div>
                        </div>
                    </div>
                    @if($notification->link)
                        <div class="mt-3">
                            <a href="{{ $notification->link }}" class="btn btn-primary" target="_blank">
                                <i class="bi bi-link"></i> Buka Link
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
