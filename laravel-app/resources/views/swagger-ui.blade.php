<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Api Docs</title>
    </head>
    <body>
    <div id="swagger-ui-root"></div>
    <script>
        var __SWAGGER_UI_API__ = "{{ route('api.docs-api') }}";
    </script>
    <script src="{{ mix('js/swagger-ui.js') }}"></script>
    </body>
</html>
