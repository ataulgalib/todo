<?php

    $menu_genarate = [
        [
            'parent_menu' => 'DashBoard',
            'icon_class' => 'fa fa-dashboard',
            'route_name' => 'admin.dashboard',
            'child_menu' => [

            ],
            'permission_route' => [
                [
                    'display_name' => 'dashboard',
                    'route_name' => 'admin.dashboard',
                ],
            ],
        ],
        [
            'sidebar_header' => 'Access Control',
            'parent_menu' => 'Access Control',
            'icon_class' => 'fa fa-universal-access',
            'route_name' => '#',
            'child_menu' => [
                [
                    'parent_menu' => 'Role Management',
                    'icon_class' => 'fa fa-suitcase',
                    'route_name' => 'core.role.index',
                    'permission_route' =>[
                        [
                            'display_name' => 'Index',
                            'route_name' => 'core.role.index',
                        ],
                        [
                            'display_name' => 'Add User',
                            'route_name' => 'core.role.create',
                        ],
                        [
                            'display_name' => 'Edit User',
                            'route_name' => 'core.role.edit',
                        ],
                        [
                            'display_name' => 'Delete User',
                            'route_name' => 'core.role.destroy',
                        ],
                    ],
                ],
                [
                    'parent_menu' => 'Role Permission',
                    'icon_class' => 'fa fa-tags',
                    'route_name' => 'core.role.permission.create',
                    'permission_route' =>[
                        [
                            'display_name' => 'Add Role Permission',
                            'route_name' => 'core.role.permission.create',
                        ],
                        [
                            'display_name' => 'Store Role Permission',
                            'route_name' => 'core.role.permission.store',
                        ],
                    ],
                ],
                [
                    'parent_menu' => 'User Management',
                    'icon_class' => 'fa fa-users',
                    'route_name' => 'core.user.index',
                    'permission_route' =>[
                        [
                            'display_name' => 'Index',
                            'route_name' => 'core.user.index',
                        ],
                        [
                            'display_name' => 'Add User',
                            'route_name' => 'core.user.create',
                        ],
                        [
                            'display_name' => 'Store User',
                            'route_name' => 'core.user.store',
                        ],
                        [
                            'display_name' => 'Edit User',
                            'route_name' => 'core.user.edit',
                        ],
                        [
                            'display_name' => 'Update User',
                            'route_name' => 'core.user.update',
                        ],
                        [
                            'display_name' => 'Delete User',
                            'route_name' => 'core.user.destroy',
                        ],
                    ],
                ],
            ],
        ],
        [
            'sidebar_header' => 'To Do',
            'parent_menu' => 'To Do',
            'icon_class' => 'fa fa-tasks',
            'route_name' => '#',
            'child_menu' => [
                [
                    'parent_menu' => 'To Do List',
                    'icon_class' => 'fa fa-suitcase',
                    'route_name' => 'admin.todo.index',
                    'permission_route' =>[
                        [
                            'display_name' => 'To Do Index',
                            'route_name' => 'admin.todo.index',
                        ],
                        [
                            'display_name' => 'To Do Show',
                            'route_name' => 'admin.todo.show',
                        ],
                        [
                            'display_name' => 'To Do Create',
                            'route_name' => 'admin.todo.store',
                        ],
                        [
                            'display_name' => 'To Do User',
                            'route_name' => 'admin.todo.update',
                        ],
                        [
                            'display_name' => 'To Do User',
                            'route_name' => 'admin.todo.destroy',
                        ],
                    ],
                ],
            ],
        ],
        [
            'sidebar_header' => 'Logs',
            'parent_menu' => 'Logs',
            'icon_class' => 'fa fa-book',
            'route_name' => 'core.logs.index',
            'child_menu' => [

            ],
            'permission_route' =>[
                [
                    'display_name' => 'Index',
                    'route_name' => 'core.logs.index',
                ],
            ],
        ],
    ];

    return $menu_genarate;
