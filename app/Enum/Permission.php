<?php

namespace App\Enum;

enum Permission: string
{
    case category_view = 'category view';
    case category_add = 'category add';
    case category_edit = 'category edit';
    case category_delete = 'category delete';
    case subcategory_view = 'subcategory view';
    case subcategory_add = 'subcategory add';
    case subcategory_edit = 'subcategory edit';
    case subcategory_delete = 'subcategory delete';
    case product_view = 'product view';
    case product_add = 'product add';
    case product_edit = 'product edit';
    case product_delete = 'product delete';
    case size_view = 'size view';
    case size_add = 'size add';
    case size_edit = 'size edit';
    case size_delete = 'size delete';
    case color_view = 'color view';
    case color_add = 'color add';
    case color_edit = 'color edit';
    case color_delete = 'color delete';
    case coupon_view = 'coupon view';
    case coupon_add = 'coupon add';
    case coupon_edit = 'coupon edit';
    case coupon_delete = 'coupon delete';
    case assign_user = 'assign user';
    case customer_dashboard_access = 'customer dashboard access';
}
