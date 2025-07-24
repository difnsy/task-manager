@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Edit Task</h2>
        
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
                <input type="text" name="title" value="{{ $task->title }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ $task->description }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
                <input type="datetime-local" name="deadline" value="{{ $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '' }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_completed" value="1" {{ $task->is_completed ? 'checked' : '' }} class="mr-2">
                    <span class="text-gray-700">Mark as completed</span>
                </label>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
