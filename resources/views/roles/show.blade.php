@extends('layouts.app')

@section('title', 'Detail Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-eye"></i> Detail Role</h5>
                    <div>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama Role</th>
                                    <td>{{ $role->name }}</td>
                                </tr>
                                <tr>
                                    <th>Users dengan Role ini</th>
                                    <td>{{ $role->users()->count() }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Total Permissions</th>
                                    <td>{{ $role->permissions->count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h6 class="mt-4">Permissions</h6>
                    <div class="row">
                        @foreach($role->permissions->groupBy('group') as $group => $permissions)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0">{{ ucfirst($group) }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($permissions as $permission)
                                            <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
