@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bell"></i> Notifications</h5>
                    <div>
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="bi bi-check-all"></i> Mark All Read
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if($unreadCount > 0)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> {{ $unreadCount }} unread notification(s)
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notification)
                                    <tr class="{{ $notification->read_status === 'unread' ? 'table-primary' : '' }}">
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ Str::limit($notification->message, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : ($notification->type === 'warning' ? 'warning' : 'info')) }}">
                                                {{ ucfirst($notification->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $notification->category ?? '-' }}</td>
                                        <td>{{ $notification->user ? $notification->user->name : 'All' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $notification->read_status === 'unread' ? 'primary' : 'secondary' }}">
                                                {{ ucfirst($notification->read_status) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('notifications.show', $notification) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if($notification->read_status === 'unread')
                                                    <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada notifikasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
