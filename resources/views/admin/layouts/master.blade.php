<!DOCTYPE html>
<html>
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title>{{ __(config('configuration.titel_bar_text')) }}</title>
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <!-- Tell the browser to be responsive to screen width -->
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

          @include('admin.layouts.css')

          @stack('styles')
     </head>
     <body class="hold-transition skin-blue sidebar-mini">
          <div class="wrapper">

               {{-- LOADER --}}
{{--               <div class="page-loader"></div>--}}
               <div id="ajax-loader"></div>

               <header class="main-header">

                    @include('admin.layouts.header')

               </header>
               <aside class="main-sidebar">

                    @include('admin.layouts.sidebar')

               </aside>

               <div class="content-wrapper">

                    @include('admin.layouts.flash_message')

                    <section class="content-header">

                         @include('admin.partials.breadcrum', [
                              'breadCrumList' => $breadCrumList ?? [],
                         ])

                    </section>

                    <section class="content">
                         @yield('content')
                    </section>
               </div>

               <footer class="main-footer">
                    @include('admin.layouts.footer')
               </footer>

               @include('admin.layouts.js')

               @stack('scripts')
          </div>
     </body>
</html>
