<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="dark" />
    @vite('resources/css/app.css')
    <title>{{ $title }}</title>
  </head>

  <body class="bg-pxl-dark text-pxl-light flex sm:h-dvh gap-8 xl:gap-16 sm:overflow-clip px-4">
    {{ $slot }}
  </body>
</html>
