@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2>Customer Accounts</h2>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Orders</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->orders_count }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No customers yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
