@extends('layouts.app')

@section('title', 'Detail Audit Log')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-eye"></i> Detail Audit Log</h5>
                    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $auditLog->id }}</td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>{{ $auditLog->user ? $auditLog->user->name : 'System' }}</td>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <td>
                                        <span class="badge bg-{{ $auditLog->action === 'delete' ? 'danger' : ($auditLog->action === 'create' ? 'success' : 'primary') }}">
                                            {{ ucfirst($auditLog->action) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Module</th>
                                    <td>{{ ucfirst($auditLog->module) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">IP Address</th>
                                    <td>{{ $auditLog->ip_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>User Agent</th>
                                    <td>{{ $auditLog->user_agent ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ \Carbon\Carbon::parse($auditLog->created_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if($auditLog->description)
                        <div class="mt-4">
                            <h6>Description</h6>
                            <div class="card">
                                <div class="card-body">
                                    {{ $auditLog->description }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($auditLog->old_data)
                        <div class="mt-4">
                            <h6>Old Data</h6>
                            <div class="card">
                                <div class="card-body">
                                    <pre>{{ json_encode($auditLog->old_data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($auditLog->new_data)
                        <div class="mt-4">
                            <h6>New Data</h6>
                            <div class="card">
                                <div class="card-body">
                                    <pre>{{ json_encode($auditLog->new_data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
