@extends('layouts.app')

@section('title', 'Holidays')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>Holiday Calendar
                        </h4>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('holidays.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Holiday
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Holiday Name</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            @if(Auth::user()->role === 'admin')
                                <th>Actions</th>
                            @endif
                         </thead>
                    <tbody>
                        @forelse($holidays as $holiday)
                        <tr>
                            <td>{{ $holiday->name }} </td>
                            <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M Y') }} </td>
                            <td>
                                @if($holiday->type == 'public')
                                    <span class="badge bg-success">Public</span>
                                @elseif($holiday->type == 'company')
                                    <span class="badge bg-primary">Company</span>
                                @else
                                    <span class="badge bg-info">Religious</span>
                                @endif
                             </td>
                            <td>{{ $holiday->description ?? '-' }} </td>
                            @if(Auth::user()->role === 'admin')
                                <td>
                                    <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this holiday?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                         </tr>
                        @empty
                         <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No Holidays Found</h5>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('holidays.create') }}" class="btn btn-primary mt-3">Add Holiday</a>
                                @endif
                             </td>
                         </tr>
                        @endforelse
                    </tbody>
                 </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $holidays->links() }}
        </div>
    </div>
</div>
@endsection