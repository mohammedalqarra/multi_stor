<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'admin',
        'active' => 'dashboard'
    ],
    [
        'icon' => 'far fa-tags nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'admin.categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'far fa-box nav-icon',
        'route' => 'categories.index',
        'title' => 'Products',
        'active' => 'admin.products.*',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'far fa-receipt nav-icon',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active' => 'admin.orders.*',
        'ability' => 'orders.view',
    ],

    [
        'icon' => 'far fa-shield nav-icon',
        'route' => 'roles.index',
        'title' => 'Roles',
        'active' => 'admin.orders.*',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'far fa-users nav-icon',
        'route' => 'users.index',
        'title' => 'Users',
        'active' => 'admin.users.*',
        'ability' => 'users.view',
    ],
    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'dashboard.admins.index',
        'title' => 'Admins',
        'active' => 'admin.admins.*',
        'ability' => 'admin.view',
    ],
];
