@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('title', 'Dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">My Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
        <i class="fas fa-plus mr-2"></i>Add Task
    </a>
</div>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
<div class="grid gap-4">
    @forelse($tasks as $task)
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 {{ $task->is_completed ? 'border-green-500' : ($task->is_overdue ? 'border-red-500' : 'border-blue-500') }}">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold {{ $task->is_completed ? 'line-through text-gray-500' : 'text-gray-900' }}">
                        {{ $task->title }}
                    </h3>
                    @if($task->description)
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                    @endif
                    
                    <div class="mt-3 flex items-center space-x-4 text-sm">
                        @if($task->deadline)
                            <span class="flex items-center {{ $task->is_overdue ? 'text-red-600' : 'text-gray-500' }}">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $task->deadline->format('M d, Y H:i') }}
                                @if($task->days_until_deadline !== null)
                                    ({{ $task->days_until_deadline >= 0 ? $task->days_until_deadline . ' days left' : abs($task->days_until_deadline) . ' days overdue' }})
                                @endif
                            </span>
                        @endif
                        
                        <span class="flex items-center">
                            <i class="fas fa-circle mr-1 {{ $task->is_completed ? 'text-green-500' : 'text-gray-400' }}"></i>
                            {{ $task->is_completed ? 'Completed' : 'Pending' }}
                        </span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-tasks text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No tasks yet</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first task!</p>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Create Task
            </a>
        </div>
    @endforelse
</div>
@endsection