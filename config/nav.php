<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard'
    ],
    [
        'icon' => 'far fa-tags nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'far fa-box nav-icon',
        'route' => 'categories.index',
        'title' => 'Products',
        'active' => 'products.*',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'far fa-receipt nav-icon',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active' => 'orders.*',
        'ability' => 'orders.view',
    ],

    [
        'icon' => 'far fa-shield nav-icon',
        'route' => 'roles.index',
        'title' => 'Roles',
        'active' => 'orders.*',
        'ability' => 'roles.view',
    ],
];
