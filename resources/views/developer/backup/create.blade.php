{{-- resources/views/developer/backup/create.blade.php --}}
@extends('layouts.developer')

@section('title', 'Create Backup')
@section('page-title', 'Create Backup')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Create Backup</h3>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Buat backup database dan file</p>
            </div>
            <a href="{{ route('developer.backup.index') }}" class="btn btn-outline text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('developer.backup.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Backup Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="input" placeholder="Nama backup (opsional)">
                        <p class="text-xs text-text-secondary mt-1">Kosongkan untuk menggunakan timestamp</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Backup Type</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_database" value="1" checked class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Include Database</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_files" value="1" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Include Files</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_media" value="1" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm">Include Media</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Description</label>
                        <textarea name="description" rows="3" class="input" placeholder="Deskripsi backup">{{ old('description') }}</textarea>
                    </div>

                    <div class="p-4 bg-light-surface dark:bg-dark-surface rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-text-secondary">Backup akan disimpan di:</p>
                                <ul class="text-sm text-text-secondary mt-1 list-disc list-inside">
                                    <li>Database backup di storage/backups/database/</li>
                                    <li>File backup di storage/backups/files/</li>
                                    <li>Media backup di storage/backups/media/</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                    <a href="{{ route('developer.backup.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Create Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection