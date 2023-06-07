<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @livewireStyles()
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    @yield('body')
</body>
@livewireScripts()
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
<script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    var editorOptions = {
        toolbar: [
            ['Bold', 'Italic', 'Strike'],
            ['Link', 'Unlink', 'Anchor'],
            ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'],
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
        ]
    };
    CKEDITOR.replace('description', editorOptions);
    CKEDITOR.replace('additionalInfo', editorOptions);
</script>
@yield('scripts')
@livewire('livewire-ui-modal')

</html>
