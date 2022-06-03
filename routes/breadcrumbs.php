<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for ('dashboard', function ($trail) {
    $trail->push(trans('validation.attributes.dashboard'), route('admin.dashboard.index'));
});

Breadcrumbs::for ('profile', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.profile'));
});
Breadcrumbs::for ('attendance', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.attendance'));
});

// Dashboard / Setting
Breadcrumbs::for ('setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.settings'));
});

// Dashboard / Email Setting
Breadcrumbs::for ('sms-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.sms_settings'));
});

// Dashboard / Email Setting
Breadcrumbs::for ('emailsetting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.emailsettings'));
});

// Dashboard / SMS Setting
Breadcrumbs::for ('smssetting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.smssetting'));
});

// Dashboard / SMS Setting
Breadcrumbs::for ('notificationsetting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.notificationsetting'));
});

// Dashboard / Departments
Breadcrumbs::for ('departments', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.departments'), route('admin.departments.index'));
});

// Dashboard / Departments / Add
Breadcrumbs::for ('departments/add', function ($trail) {
    $trail->parent('departments');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Departments / Edit
Breadcrumbs::for ('departments/edit', function ($trail) {
    $trail->parent('departments');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Designations
Breadcrumbs::for ('designations', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.designations'), route('admin.designations.index'));
});

// Dashboard / Departments / Add
Breadcrumbs::for ('designations/add', function ($trail) {
    $trail->parent('designations');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Departments / Edit
Breadcrumbs::for ('designations/edit', function ($trail) {
    $trail->parent('designations');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Employees
Breadcrumbs::for ('employees', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.employees'), route('admin.employees.index'));
});

// Dashboard / employees / Add
Breadcrumbs::for ('employees/add', function ($trail) {
    $trail->parent('employees');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / employees / Edit
Breadcrumbs::for ('employees/edit', function ($trail) {
    $trail->parent('employees');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / employees / Show
Breadcrumbs::for ('employees/show', function ($trail) {
    $trail->parent('employees');
    $trail->push(trans('validation.attributes.view'));
});


// Dashboard / pre-registers
Breadcrumbs::for ('pre-registers', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.pre-registers'), route('admin.pre-registers.index'));
});

// Dashboard / pre-registers / Add
Breadcrumbs::for ('pre-registers/add', function ($trail) {
    $trail->parent('pre-registers');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / pre-registers / Edit
Breadcrumbs::for ('pre-registers/edit', function ($trail) {
    $trail->parent('pre-registers');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / pre-registers / Show
Breadcrumbs::for ('pre-registers/show', function ($trail) {
    $trail->parent('pre-registers');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / visitors
Breadcrumbs::for ('visitors', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.visitors'), route('admin.visitors.index'));
});

// Dashboard / pre-registers / Add
Breadcrumbs::for ('visitors/add', function ($trail) {
    $trail->parent('visitors');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / visitors / Edit
Breadcrumbs::for ('visitors/edit', function ($trail) {
    $trail->parent('visitors');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / visitors / Show
Breadcrumbs::for ('visitors/show', function ($trail) {
    $trail->parent('visitors');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Administrators
Breadcrumbs::for ('administrators', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.administrators'), route('admin.adminusers.index'));
});

// Dashboard / Administrators / Edit
Breadcrumbs::for ('administrators/add', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Administrators / Edit
Breadcrumbs::for ('administrators/edit', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Administrators / Edit
Breadcrumbs::for ('administrators/view', function ($trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Role
Breadcrumbs::for ('roles', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.roles'), route('admin.role.index'));
});

// Dashboard / Role / Add
Breadcrumbs::for ('role/add', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Role / Edit
Breadcrumbs::for ('role/edit', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Role / View
Breadcrumbs::for ('role/view', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.view'));
});

// Setting Module
Breadcrumbs::for ('site-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.site_settings'));
});

// Setting Module
Breadcrumbs::for ('email-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.email_settings'));
});
// Setting Module
Breadcrumbs::for ('email-template-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.email-template-setting'));
});

// Setting Module
Breadcrumbs::for ('notification-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.notification_settings'));
});

// Setting Module
Breadcrumbs::for ('front-end-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.front-end_settings'));
});

// Language Module
Breadcrumbs::for ('language', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.language'),route('admin.language.index'));
});

// Dashboard / Language / Add
Breadcrumbs::for ('language/add', function ($trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Language / Edit
Breadcrumbs::for ('language/edit', function ($trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / addons
Breadcrumbs::for ('addons', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.addons'), route('admin.addons.index'));
});

// Dashboard / addons / Add
Breadcrumbs::for ('addons/add', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / addons / Edit
Breadcrumbs::for ('addons/edit', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / addons / View
Breadcrumbs::for ('addons/view', function ($trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.view'));
});
