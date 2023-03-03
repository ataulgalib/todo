<style>

     /* Paste this css to your style sheet file or under head tag */
     /* This only works with JavaScript,
     if it's not present, don't show loader */
     .no-js #loader { display: none;  }
     .js #loader { display: block; position: absolute; left: 100px; top: 0; }
     .page-loader {
          position: fixed;
          left: 0px;
          top: 0px;
          width: 100%;
          height: 100%;
          z-index: 9999;
          opacity: 0.5;
          background: url( {{ asset('admin/loader/gears.gif') }} ) center no-repeat #fff;
   
     }
     .ajax-loader {
          position: fixed;
          left: 0px;
          top: 0px;
          width: 100%;
          height: 100%;
          z-index: 9999;
          opacity: 0.5;
          background: url( {{ asset('admin/loader/gears.gif') }} ) center no-repeat #fff;
        
     }
     .error-text{
          color: red;
          font-size: 11px;
     }
     .d-none{
          display: none;
     }
     
</style>