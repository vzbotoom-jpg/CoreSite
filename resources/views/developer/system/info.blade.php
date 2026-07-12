{{-- resources/views/developer/system/info.blade.php --}}
@extends('layouts.developer')

@section('title', 'System Information')
@section('page-title', 'System Information')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Informasi lengkap tentang sistem dan server</p>
        </div>
        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Server Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Server Information</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Server Software</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Server Name</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SERVER_NAME'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Server Port</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SERVER_PORT'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Server Protocol</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SERVER_PROTOCOL'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Server IP</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SERVER_ADDR'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Document Root</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Script Filename</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['SCRIPT_FILENAME'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Request URI</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['REQUEST_URI'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Request Method</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $_SERVER['REQUEST_METHOD'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">User Agent</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary text-sm">{{ $_SERVER['HTTP_USER_AGENT'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- PHP Info -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">PHP Information</h3>
            <a href="{{ route('developer.phpinfo') }}" target="_blank" class="btn btn-ghost btn-sm">
                View Full PHP Info →
            </a>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">PHP Version</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ phpversion() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">PHP Extension</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ php_sapi_name() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Memory Limit</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ ini_get('memory_limit') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Max Execution Time</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ ini_get('max_execution_time') }} seconds</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Upload Max Filesize</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ ini_get('upload_max_filesize') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Post Max Size</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ ini_get('post_max_size') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Max Input Vars</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ ini_get('max_input_vars') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Zend Version</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ zend_version() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Display Errors</span>
                    <span class="font-medium" :class="'{{ ini_get('display_errors') }}' ? 'text-error' : 'text-success'">
                        {{ ini_get('display_errors') ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Error Reporting</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ error_reporting() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Laravel Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Laravel Information</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Laravel Version</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Environment</span>
                    <span class="font-medium" :class="'{{ app()->environment() }}' === 'production' ? 'text-success' : 'text-warning'">
                        {{ app()->environment() }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Debug Mode</span>
                    <span class="font-medium" :class="'{{ config('app.debug') }}' ? 'text-error' : 'text-success'">
                        {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Timezone</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('app.timezone') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Locale</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('app.locale') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Fallback Locale</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('app.fallback_locale') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">URL</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('app.url') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Asset URL</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('app.asset_url') ?: config('app.url') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Database Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Database Information</h3>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Type</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.default') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Name</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.connections.mysql.database') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Host</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.connections.mysql.host') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Port</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.connections.mysql.port') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Username</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.connections.mysql.username') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-light-border dark:border-dark-border">
                    <span class="text-text-secondary">Database Prefix</span>
                    <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ config('database.connections.mysql.prefix') ?: 'None' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Installed Packages -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Installed Packages</h3>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border dark:border-dark-border">
                            <th class="text-left px-4 py-2 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Package</th>
                            <th class="text-left px-4 py-2 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Version</th>
                            <th class="text-left px-4 py-2 text-sm font-medium text-text-secondary dark:text-text-dark-secondary">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages ?? [] as $package)
                        <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition">
                            <td class="px-4 py-2 text-text-primary dark:text-text-dark-primary">{{ $package['name'] ?? '-' }}</td>
                            <td class="px-4 py-2 text-text-secondary dark:text-text-dark-secondary">{{ $package['version'] ?? '-' }}</td>
                            <td class="px-4 py-2 text-text-secondary dark:text-text-dark-secondary">{{ $package['description'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection