@props([
    'security_level'
])

@php
    $securityLevels = ['secured','no_loan_registration','normal'];
    $securityLevels = array_combine($securityLevels, array_map(fn($level) => __("admin.product_edit.security.${level}"), $securityLevels));
@endphp
<x-form.dropdown name="security" :options="$securityLevels" :selected="$security_level"/>
