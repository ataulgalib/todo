@php
     $core_menu_list = core_genarated_menu();
     $permitted_route_list = [];
     if(auth()->check()){
          if(auth()->user()->role_id != config('configuration.super_admin_roles.role_id')){
               $permitted_route_list = getSession(\App\Services\Core\LoginProcessService::PERMISSION_ROUTE_SESSION_KEY.auth()->user()->id);
          }else{
               $permitted_route_list = permission_details();
          }
     }
     
     $permitted_route_list = collect($permitted_route_list);
@endphp

<section class="sidebar">
     <!-- Sidebar user panel -->
     <div class="user-panel">
          <div class="pull-left image">
               <img src="{{asset('admin')}}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
               <p>{{ auth()->user()->name }}</p>
               <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
     </div>
     <!-- search form -->
     <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
               <input type="text" name="q" class="form-control" placeholder="Search...">
               <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                    </button>
               </span>
          </div>
     </form>
     <!-- /.search form -->
     <!-- sidebar menu: : style can be found in sidebar.less -->
     <ul class="sidebar-menu" data-widget="tree">

          @if(!empty($core_menu_list) && count($core_menu_list) > 0)
               @foreach($core_menu_list as $key => $menu_details)

                    @php
                         $parent_menu_name = $menu_details->has('parent_menu') ? __($menu_details->get('parent_menu')) : '';
                         $parent_menu_icon = $menu_details->has('icon_class') ? $menu_details->get('icon_class') : '';
                         $parent_menu_route = $menu_details->has('route_name') ? $menu_details->get('route_name') : '';
                         $sidebar_header = $menu_details->has('sidebar_header') ? __($menu_details->get('sidebar_header')) : '';

                         $child_menus = $menu_details->has('route_name') ? $menu_details->get('child_menu') : [];
                    @endphp

                    @if($child_menus->isEmpty() && !empty($parent_menu_name) && !empty($parent_menu_route))
                         @if($permitted_route_list->contains($parent_menu_route))
                              @if(!empty($sidebar_header))
                                   <li class="header">{{ $sidebar_header }}</li>
                              @endif

                              <li class= "{{ active_menu([$parent_menu_route]) }}">
                                   <a href="{{ strContains($parent_menu_route, ['#','',null]) ? '#' : route($parent_menu_route) }}">
                                        <i class="{{ $parent_menu_icon }}"></i> <span>{{ __($parent_menu_name) }}</span>
                                   </a>
                              </li>
                         @endif
                    @else
                         @if(!empty($parent_menu_name))

                              @php
                                   $child_menus_route_list = permission_details($parent_menu_name);
                                   $diff_route_list = $child_menus_route_list->diff($permitted_route_list);
                              @endphp
                              @if(sizeof($child_menus_route_list) != sizeof($diff_route_list))

                                   @if(!empty($sidebar_header))
                                        <li class="header">{{ $sidebar_header }}</li>
                                   @endif
                                   <li class="treeview {{ active_menu($child_menus_route_list) }}">
                                        <a href="{{ strContains($parent_menu_route, ['#','',null]) ? '#' : route($parent_menu_route) }}">
                                             <i class="{{ $parent_menu_icon }}"></i>
                                                  <span>{{ __($parent_menu_name) }}</span>
                                                  <span class="pull-right-container">
                                                  <i class="fa fa-angle-left pull-right"></i>
                                             </span>
                                        </a>
                                        <ul class="treeview-menu">
                                             @if($child_menus->isNotEmpty())
                                                  @foreach($child_menus as $key => $child_menu)

                                                       @php
                                                            $child_menu_name = $child_menu->has('parent_menu') ? __($child_menu->get('parent_menu')) : '';
                                                            $child_menu_icon = $child_menu->has('icon_class') ? $child_menu->get('icon_class') : '';
                                                            $child_menu_route = $child_menu->has('route_name') ? $child_menu->get('route_name') : '';
                                                            $child_menu_route_list = permission_details($parent_menu_name, $child_menu_name);


                                                       @endphp

                                                       @if($permitted_route_list->contains($child_menu_route))

                                                            @if(!empty($child_menu_name) && !empty($child_menu_route))
                                                                 <li class= "{{ active_menu($child_menu_route_list) }}">
                                                                      <a href="{{ strContains($child_menu_route, ['#','',null])  ? '#' : route($child_menu_route) }}">
                                                                           <i class="{{ $child_menu_icon }}"></i> {{ __($child_menu_name) }}
                                                                      </a>
                                                                 </li>
                                                            @endif

                                                       @endif
                                                       
                                                  @endforeach
                                             @endif
                                        </ul>
                                   </li>

                              @endif
                         @endif
                    @endif
               @endforeach

          @endif


          {{-- @if(sizeof($core_parent_menu) > 0)
               @foreach($core_parent_menu as $key => $parent_menu)
                    @php
                         $child_menus = $core_menu_list->get($parent_menu);
                    @endphp                    

                    @if(!empty($child_menus) && !$child_menus->has('child_menu'))
                         <li class= "{{ active_menu([$child_menus->get('route_name')]) }}">
                              <a href="{{ ($child_menus->get('route_name') != '#' && $child_menus->get('route_name') != '') ? route($child_menus->get('route_name')) : '#'  }}">
                                   <i class="{{ $child_menus->get('icon_class') }}"></i> <span>{{ __($parent_menu) }}</span>
                              </a>
                         </li>
                    @else
                         {{ dd($child_menus->where('')) }}
                         @if(!empty($child_menus))
                              <li class="treeview">
                                   <a href="#">
                                        <i class="{{ $child_menus->get('icon_class') }}"></i>
                                             <span>{{ __($parent_menu) }}</span>
                                             <span class="pull-right-container">
                                             <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                   </a>
                                   <ul class="treeview-menu">
                                        @foreach($child_menus->get('child_menu') as $key => $child_menu)
                                             <li>
                                                  <a href="{{ ($child_menu->get('route_name') != '#' && $child_menu->get('route_name') != '') ? route($child_menu->get('route_name')) : '#'  }}">
                                                       <i class="{{ $child_menu->get('icon_class') }}"></i> {{ __($child_menu->get('parent')) }}
                                                  </a>
                                             </li>
                                        @endforeach
                                   </ul>
                              </li>
                         @endif
                    @endif

               @endforeach
          @endif --}}

               {{-- <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Layout Options</span>
                    <span class="pull-right-container">
                    <span class="label label-primary pull-right">4</span>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                    </ul>
               </li>
               <li>
                    <a href="pages/widgets.html">
                    <i class="fa fa-th"></i> <span>Widgets</span>
                    <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                    </span>
                    </a>
               </li>
               <li class="treeview">
                    <a href="#">
                         <i class="fa fa-pie-chart"></i>
                              <span>Charts</span>
                              <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                         </span>
                    </a>
                    <ul class="treeview-menu">
                         <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                         <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                         <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                         <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                    </ul>
               </li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>UI Elements</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                    <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                    <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                    <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                    <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                    <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                    </ul>
               </li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-edit"></i> <span>Forms</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                    </ul>
               </li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-table"></i> <span>Tables</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                    </ul>
               </li>
               <li>
                    <a href="pages/calendar.html">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <span class="pull-right-container">
                    <small class="label pull-right bg-red">3</small>
                    <small class="label pull-right bg-blue">17</small>
                    </span>
                    </a>
               </li>
               <li>
                    <a href="pages/mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">12</small>
                    <small class="label pull-right bg-green">16</small>
                    <small class="label pull-right bg-red">5</small>
                    </span>
                    </a>
               </li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i> <span>Examples</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                    <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                    <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                    <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                    <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                    <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                    <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                    <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                    <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                    </ul>
               </li>
               <li class="treeview">
                    <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Level One
                         <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                         </span>
                    </a>
                    <ul class="treeview-menu">
                         <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                         <li class="treeview">
                         <a href="#"><i class="fa fa-circle-o"></i> Level Two
                              <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              </span>
                         </a>
                         <ul class="treeview-menu">
                              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                         </ul>
                         </li>
                    </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    </ul>
               </li>
               <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
               <li class="header">LABELS</li>
               <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
               <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
               <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> --}}

     </ul>
</section>