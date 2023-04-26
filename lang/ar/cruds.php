<?php

return [

    'playlist' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'قوائم التشغيل',
        'order_num' => 'رقم الأوردر',
        'description' => 'الوصف',
        'search' => 'بحث',
        'design' => 'الديزاين',
        'manufacturing' => 'تصنيع',
        'prepare' => 'تجهيز',
        'send_to_delivery' => 'الأرسال للشحن',

        'send_to_playlist_date' => 'تاريخ المرحلة',
        'created_at' => 'تاريخ الأضافة',

        'info' => 'الفاتورة',
        'description' => 'الوصف',
        'note' => 'الملاحظات',
        'quickly' => 'أستعجال'
    ],

    'receipt_product' => [
        'receipt_product_social' => 'منتجات  فواتير السوشيال',
        'receipt_product_client' => 'منتجات  فواتير الشركات',
        'receipts' => 'الفواتير',
        'fields' => [
            'name' => 'أسم المنتج',
            'price' => 'السعر',
            'commission' => 'نسبة الربح',
        ]
    ],

    // employee managment
    'user' => [
        'navigation_group' => 'أدارة الموظفين',
        'navigation_label' => 'الموظفين',
        'fields' => [
            'roles' => 'الصلاحيات',

            'name' => 'الأسم',
            'email' => 'البريد الألكتروني',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'address' => 'العنوان',
            'photo' => 'الصورة',
            'phone_number' => 'رقم الهاتف',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'borrow_user' => [
        'navigation_group' => 'أدارة الموظفين',
        'navigation_label' => 'مستخدمين السلف والخصومات',
        'button' => 'المستخدمين',
        'fields' => [
            'name' => 'الأسم',
            'email' => 'البريد الألكتروني',
            'phone_number' => 'رقم الهاتف',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'borrow' => [
        'navigation_group' => 'أدارة الموظفين',
        'navigation_label' => 'السلف',
        'fields' => [
            'borrow_user_id' => 'المستخدم',
            'amount' => 'السلفة',
            'status' => 'السداد',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'subtract' => [
        'navigation_group' => 'أدارة الموظفين',
        'navigation_label' => 'الخصومات',
        'fields' => [
            'subtract_user_id' => 'المستخدم',
            'amount' => 'الخصم',
            'reason' => 'السبب',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],

    // receipts
    'order' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'الطلبات',
        'fields' => [
            'order_details' => [
                'photo' => 'صورة المنتج',
                'product' => 'المنتج',
                'quantity' => 'الكمية',
                'price' => 'السعر',
            ],

            'shipping' => 'الشحن',
            'total' => 'الأجمالي',
            'phone' => 'رقم الهاتف',
            'date' => 'نوع التاريخ',

            'user' => 'المستخدم',
            'shipping_country_name' => 'المحافطة',
            'shipping_country_cost' => 'تكلفة الشحن',
            'shipping_cost_by_seller' => 'تكلفة الشحن من البائع',
            'calling' => 'الأتصال',
            'sent_to_wasla' => 'الأرسال لواصلة',
            'printing_times' => 'عدد مرات الطباعة',
            'supplied' => 'التوريد',
            'total_cost_by_seller' => 'التكلفة من البائع',
            'total_cost' => 'أجمال التكلفة',
            'deposit_amount' => 'العربون',
            'commission' => 'نسبة ربح',
            'extra_commission' => 'نسبة ربح أضافية',
            'discount_code' => 'كود الخصم',
            'discount' => 'الخصم',
            'payment_status' => 'حالة السداد',
            'delivery_status' => 'حالة الشحن',
            'payment_type' => 'نوع السداد',
            'order_type' => 'نوع الطلب',
            'client_name' => 'أسم العميل',
            'order_num' => 'كود الطلب',
            'shipping_address' => 'عنوان الشحن',
            'phone_number' => 'رقم هاتف 1',
            'phone_number2' => 'رقم هاتف 2',
            'date_of_receiving_order' => 'تاريخ أستلام الطلب',
            'excepected_deliverd_date' => 'التاريخ المتوقع للتوصيل',
            'cancel_reason' => 'سبب الألغاء',
            'delay_reason' => 'سبب التأجيل',
            'note' => 'الملاحظة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'receipt_client' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'فواتير شركات',
        'products' => [
            'product_name' => 'أسم المنتج',
            'cost' => 'السعر',
            'quantity' => 'الكمية',
            'total' => 'الأجمالي',
        ],
        'fields' => [
            'date' => 'نوع التاريخ',

            'client_name' => 'أسم العميل',
            'phone_number' => 'رقم الهاتف',
            'order_num' => 'كود الفاتورة',
            'staff_id' => 'الموظف',
            'total_cost' => 'أجمال التكلفة',
            'note' => 'الملاحظة',
            'done' => 'التسليم',
            'deposit' => 'العربون',
            'discount' => 'الخصم',
            'printing_times' => 'عدد مرات الطباعة',
            'quickly' => 'الأستعجال',
            'date_of_receiving_order' => 'تاريخ أستلام الفاتورة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'receipt_company' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'فواتير أبتكار',
        'fieldset' => [
            'client_info' => 'معلومات العميل',
            'shipping_address' => 'معلومات الشحن',
            'receipt_info' => 'معلومات الفاتورة',
            'product' => 'المنتج',
            'photos' => 'الصور',
        ],
        'fields' => [
            'phone' => 'رقم هاتف',
            'date' => 'نوع التاريخ',

            'order_num' => 'كود الفاتورة',
            'client_name' => 'أسم العميل',
            'phone_number' => 'رقم هاتف 1',
            'phone_number2' => 'رقم هاتف 2',
            'deliver_date' => 'تاريخ التسليم',
            'shipping_address' => 'عنوان الشخن',
            'total_cost' => 'أجمالي التكلفة',
            'shipping_country_cost' => 'تكلفة الشحن',
            'deposit' => 'العربون',
            'description' => 'الوصف',
            'staff_id' => 'الموظف',
            'note' => 'الملاحظة',
            'delivery_status' => 'حالة التوصيل',
            'payment_status' => 'حالة السداد',
            'shipping_country_name' => 'المحافظة',
            'cancel_reason' => 'سبب الألغاء',
            'delay_reason' => 'سبب التأجيل',
            'calling' => 'الأتصال',
            'date_of_receiving_order' => 'تاريخ أستلام الفاتورة',
            'printing_times' => 'عدد مرات الطباعة',
            'type' => 'نوع الفاتورة',
            'quickly' => 'الأستعجال',
            'done' => 'التسليم',
            'no_answer' => 'لم يتم الرد',
            'sent_to_wasla_date' => 'تاريخ الأرسال لواصلة',
            'done_time' => 'وقت التسليم',
            'photos' => 'الصور',
            'supplied' => 'التوريد',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'receipt_outgoing' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'فواتير مصروفات',
        'products' => [
            'product_name' => 'أسم المنتج',
            'cost' => 'السعر',
            'quantity' => 'الكمية',
            'total' => 'الأجمالي',
        ],
        'fields' => [
            'date' => 'نوع التاريخ',

            'client_name' => 'أسم العميل',
            'phone_number' => 'رقم الهاتف',
            'order_num' => 'كود الفاتورة',
            'staff_id' => 'الموظف',
            'total_cost' => 'أجمالي التكلفة',
            'note' => 'الملاحظة',
            'done' => 'التسليم',
            'printing_times' => 'عدد مرات الطباعة',
            'date_of_receiving_order' => 'تاريخ أستلام الفاتورة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'receipt_price_view' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'فواتير عرض سعر',
        'products' => [
            'product_name' => 'أسم المنتج',
            'cost' => 'السعر',
            'quantity' => 'الكمية',
            'total' => 'الأجمالي',
        ],
        'fields' => [
            'date' => 'نوع التاريخ',

            'client_name' => 'أسم العميل',
            'phone_number' => 'رقم الهاتف',
            'order_num' => 'كود الفاتورة',
            'staff_id' => 'الموظف',
            'total_cost' => 'أجمالي التكلفة',
            'place' => 'مكان التسليم',
            'relate_duration' => 'وقت الأرتباط',
            'supply_duration' => 'وقت التوريد',
            'payment' => 'الدفع',
            'added_value' => 'الضريبة',
            'printing_times' => 'عدد مرات الطباعة',
            'date_of_receiving_order' => 'تاريخ أستلام الفاتورة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'receipt_social' => [
        'navigation_group' => 'الفواتير',
        'navigation_label' => 'فواتير سوشيال',
        'products' => [
            'product_name' => 'المنتج',
            'description' => 'الوصف',
            'price' => 'السعر',
            'commission' => 'الربح',
            'extra' => 'ربح زيادة',
            'quantity' => 'الكمية',
            'total' => 'الأجمالي',
            'images' => 'الصور',
            'note' => 'ملحوظة',
        ],
        'fieldset' => [
            'client_info' => 'معلومات العميل',
            'shipping_address' => 'معلومات الشحن',
            'receipt_info' => 'معلومات الفاتورة',
            'product' => 'المنتج',
            'photos' => 'الصور',
        ],
        'fields' => [

            'shipping' => 'الشحن',
            'total' => 'الأجمالي',
            'phone' => 'رقم الهاتف',
            'date' => 'نوع التاريخ',

            'socials' => 'السوشيال',
            'description' => 'الوصف',

            'order_num' => 'كود الفاتورة',
            'type' => 'نوع العميل',
            'client_name' => 'أسم العميل',
            'phone_number' => 'رقم هاتف 1',
            'phone_number2' => 'رقم هاتف 2',
            'deposit' => 'العربون',
            'discount' => 'الخصم',
            'commission' => 'نسبة الربح',
            'extra_commission' => 'نسبة ربح زيادة',
            'total_cost' => 'أجمالي التكلفة',
            'done' => 'التسليم',
            'printing_times' => 'عدد مرات الطباعة',
            'quickly' => 'الأستعجال',
            'confirm' => 'التأكيد',
            'returned' => 'أسترجاع',
            'supplied' => 'التوريد',
            'date_of_receiving_order' => 'تاريخ أستلام الفاتورة',
            'deliver_date' => 'تاريخ التسليم المتوقع',
            'sent_to_wasla_date' => 'تاريخ الأرسال لواصلة',
            'done_time' => 'تاريخ التسليم',
            'delivery_status' => 'حالة التسليم',
            'payment_status' => 'حالة السداد',
            'shipping_country_id' => 'المحافطة',
            'shipping_country_cost' => 'تكلفة الشحن',
            'shipping_address' => 'عنوان الشحن',
            'cancel_reason' => 'سبب الألغاء',
            'delay_reason' => 'سبب التأجيل',
            'playlist_status' => 'حالات التشغيل',
            'note' => 'الملاحظة',
            'staff_id' => 'الموظف',
            'delivery_man_id' => 'مندوب الشحن',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],


    // products
    'attribute' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'السمات',
        'fields' => [
            'name' => 'السمة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'brand' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'العلامات التجارية',
        'fields' => [
            'name' => 'الأسم',
            'logo' => 'الصورة',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'product' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'المنتجات',
        'tabs' => [
            'product_information' => 'معلومات المنتج',
            'images' => 'الصور',
            'videos' => 'الفيديوهات',
            'pricing' => 'السعر',
            'attributes' => 'السمات',
            'description' => 'الوصف',
            'seo' => 'SEO Meta Tags',
        ],
        'fields' => [
            'choice_options' => 'القيم للسمات',
            'product_stock' => 'السمات للمنتج',
            'attribute' => 'السمة',

            'name' => 'أسم المنتج',
            'user' => 'عن طريق',
            'category' => 'الفئة',
            'brand' => 'العلامة التجارية',
            'subcategory' => 'الفئة الفرعية',
            'subsubcategory' => 'فئة فرعية لفئة فرعية',
            'unit_price' => 'السعر',
            'current_stock' => 'الكمية',
            'purchase_price' => 'السعر كجملة',
            'attributes' => 'السمات',
            'colors' => 'الألوان',
            'tags' => 'العلامات',
            'video_provider' => 'موفر الفيديو',
            'video_link' => 'رابط الفيديو',
            'description' => 'الوصف',
            'unit' => 'الوحدة',
            'photos' => 'صور المنتج',
            'pdf' => 'Pdf',
            'discount' => 'الخصم',
            'published' => 'نشر',
            'featured' => 'مميز',
            'todays_deal' => 'صفقة اليوم',
            'flash_deal' => 'فلاش',
            'discount_type' => 'نوع الخصم',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'flash_deal' => 'فلاش',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'category' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'الفئة',
        'fields' => [
            'name' => 'الفئة',
            'banner' => 'بانر',
            'icon' => 'icon',
            'featured' => 'مميز',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'subcategory' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'فئة فرعية',
        'fields' => [
            'name' => 'الأسم',
            'category' => 'الفئة',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'subsubcategory' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'فئة فرعية لفئة فرعية',
        'fields' => [
            'name' => 'الأسم',
            'category' => 'الفئة',
            'subcategory' => 'الفئة الفرعية',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'review' => [
        'navigation_group' => 'المنتجات',
        'navigation_label' => 'تقييمات المنتجات',
        'fields' => [
            'product' => 'المنتج',
            'user' => 'المستخدم',
            'rating' => 'التقييم',
            'comment' => 'التعليق',
            'status' => 'الحالة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],

    // settings
    'banned_phone' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'الأرقام المحظورة',
        'banned' => 'الرقم محظور',
        'fields' => [
            'phone_number' => 'رقم الهاتف',
            'reason' => 'السبب',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'banner' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'البانرز',
        'fields' => [
            'photo' => 'البانر',
            'url' => 'الرابط',
            'position' => 'المكان',
            'published' => 'نشر',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'country' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'توصيل المحافظات',
        'fields' => [
            'name' => 'الأسم',
            'cost' => 'التكلفة',
            'code' => 'الكود',
            'code_cost' => 'السعر للكود',
            'type' => 'النوع',
            'status' => 'الحالة',
            'website' => 'الصفحة الرئيسية',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'policy' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'صفحات السياسة',
        'fields' => [
            'name' => 'السياسة',
            'content' => 'المحتوي',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'generalsetting' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'الأعدادت العامة',
        'fields' => [
            'logo' => 'اللوجو',
            'site_name' => 'أسم الموقع',
            'address' => 'العنوان',
            'description' => 'الوصف',
            'phone_number' => 'رقم الهاتف',
            'email' => 'البريد الألكتروني',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'telegram' => 'Telegram',
            'linkedin' => 'Linkedin',
            'whatsapp' => 'Whatsapp',
            'youtube' => 'Youtube',
            'google_plus' => 'Google Plus',
            'welcome_message' => 'رسالة ترحيب',
            'photos' => 'أراء العملاء',
            'video_instructions' => 'لينك فيديو شرح تسجيل الموقع',
            'delivery_system' => 'سيستم الشحن',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'homecategory' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'الفئات الرئيسية',
        'fields' => [
            'category' => 'الفئة',
            'published' => 'نشر',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'quality_responsible' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'مسؤل الجودة',
        'fields' => [
            'photo' => 'الصورة',
            'name' => 'الأسم',
            'phone_number' => 'رقم الهاتف',
            'wts_phone' => 'رقم الواتس',
            'country_code' => 'كود البلد',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'seosetting' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'أعدادت تحسين محركات البحث',
        'fields' => [
            'keyword' => 'الكلمة الأساسية',
            'author' => 'المالك',
            'revisit' => 'إعادة النظر بعد',
            'sitemap_link' => 'رابط خريطة الموقع',
            'description' => 'وصف',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'slider' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'سلايدر',
        'fields' => [
            'photo' => 'الصورة',
            'url' => 'الرابط',
            'published' => 'نشر',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'social' => [
        'navigation_group' => 'الأعدادات العامة',
        'navigation_label' => 'سوشيال',
        'fields' => [
            'name' => 'الأسم',
            'photo' => 'الصورة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],

    //seller
    'common_question' => [
        'navigation_group' => 'البائعون',
        'navigation_label' => 'الأسئلة الشائعة',
        'fields' => [
            'question' => 'السؤال',
            'answer' => 'الأجابة',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],
    'seller' => [
        'navigation_group' => 'البائعون',
        'navigation_label' => 'البائعون',
        'orders' => 'فواتير البائعين',
        'fields' => [
            'name' => 'الأسم',
            'email' => 'البريد الألكتروني',
            'phone_number' => 'رقم الهاتف',
            'address' => 'العنوان',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'type' => 'type',
            'seller_code' => 'كود البائع',
            'verification_status' => 'القبول',
            'social_name' => 'اسم البيدج او الجروب',
            'social_link' => 'لينك البيدج او الجروب',
            'qualification' => 'المؤهل',
            'order_out_website' => 'عدد الطلبات خارج الموقع',
            'identity_front' => 'صورة البطاقة من الامام',
            'identity_back' => 'صورة البطاقة من الخلف',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],


    'customer' => [
        'navigation_group' => '#',
        'navigation_label' => 'المستخدمون',
        'orders' => 'فواتير الموقع',
        'fields' => [
            'name' => 'الأسم',
            'email' => 'البريد الألكتروني',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'address' => 'العنوان',
            'photo' => 'الصورة',
            'phone_number' => 'رقم الهاتف',
            'created_at' => 'تاريخ الأضافة',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ]
    ],



];
