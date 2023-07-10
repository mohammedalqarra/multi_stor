<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard'
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Products',
        'active' => 'products.*',
        'ability' => 'products.view',

    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active' => 'orders.*',
        'ability' => 'orders.view',

    ],
];
