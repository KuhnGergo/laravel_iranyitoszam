
<div class="toolbar">
    @if($isAuthenticated)
        <a href="{{ $routes['create'] ?? '#' }}" class="btn">
            <i class="fa fa-plus"></i> Új
        </a>
    @endif

    <a href="{{ $routes['csv'] ?? '#' }}" class="btn">
        <i class="fa fa-file-csv"></i> CSV
    </a>

    <a href="{{ $routes['pdf'] ?? '#' }}" class="btn">
        <i class="fa fa-file-pdf"></i> PDF
    </a>

    <a href="{{ $routes['mail'] ?? '#' }}" class="btn">
        <i class="fa fa-envelope"></i> Mail
    </a>
</div>